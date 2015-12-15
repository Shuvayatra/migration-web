<?php
namespace App\Nrna\Services;

use App\Nrna\Models\Post;
use App\Nrna\Repositories\Post\PostRepositoryInterface;
use Illuminate\Database\DatabaseManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Illuminate\Filesystem\Filesystem;

/**
 * Class PostService
 * @package App\Nrna\Services
 */
class PostService
{
    /**
     * @var PostRepositoryInterface
     */
    private $post;

    /**
     * @var string
     */
    private $uploadPath;
    /**
     * @var TagService
     */
    private $tag;
    /**
     * @var DatabaseManager
     */
    private $database;
    /**
     * @var Filesystem
     */
    private $file;

    /**
     * constructor
     * @param PostRepositoryInterface $post
     * @param TagService              $tag
     * @param DatabaseManager         $database
     * @param Filesystem              $file
     */
    function __construct(PostRepositoryInterface $post, TagService $tag, DatabaseManager $database, Filesystem $file)
    {
        $this->uploadPath = public_path(Post::UPLOAD_PATH);
        $this->post       = $post;
        $this->tag        = $tag;
        $this->database   = $database;
        $this->file       = $file;
    }

    /**
     * @param $formData
     * @return Post|bool
     */
    public function save($formData)
    {
        $tags = [];

        if (isset($formData['tag'])) {
            $tags = $this->tag->createOrGet($formData['tag']);
        }
        $this->database->beginTransaction();
        try {
            if ($formData['metadata']['type'] === 'audio') {
                $formData['metadata']['data']['audio'] = $this->upload($formData['metadata']['data']['audio']);
            }
            $post = $this->post->save($formData);
            if (!$post) {
                return false;
            }
            $this->updateRelations($formData, $post);
            $post->tags()->sync($tags);
            $this->database->commit();

            return $post;

        } catch (\Exception $e) {
            $this->database->rollback();
        }
        $this->database->rollback();

        return false;
    }


    /**
     * @param int $limit
     * @return Collection
     */
    public function all($limit = 15)
    {
        return $this->post->getAll($limit);
    }

    /**
     * @param $id
     * @return Post
     */
    public function find($id)
    {
        try {
            return $this->post->find($id);
        } catch (\Exception $e) {
            return null;
        }

        return null;
    }

    /**
     * @param $id
     * @param $formData
     * @return bool
     */
    public function update($id, $formData)
    {
        $tags = [];
        if (isset($formData['tag'])) {
            $tags = $this->tag->createOrGet($formData['tag']);
        }
        $this->database->beginTransaction();
        try {
            $post = $this->find($id);
            if ($formData['metadata']['type'] === 'audio' && isset($formData['metadata']['data']['audio'])) {
                $formData['metadata']['data']['audio'] = $this->upload($formData['metadata']['data']['audio']);
                $this->file->delete(sprintf('%s/%s', $this->uploadPath, $post->audioName));
            }

            if (!$post->update($formData)) {
                return false;
            }
            $this->updateRelations($formData, $post);
            $post->tags()->sync($tags);
            $this->database->commit();

            return $post;
        } catch (\Exception $e) {
            $this->database->rollback();

            return false;
        }
        $this->database->rollback();

        return false;
    }

    /**
     * @param $id
     * @return bool
     */
    public function delete($id)
    {
        $post = $this->find($id);
        if ($this->post->delete($id)) {
            $this->file->delete(sprintf('%s/%s', $this->uploadPath, $post->audioName));

            return true;
        }

        return false;
    }

    /**
     * @param UploadedFile $file
     * @return string
     */
    public function upload(UploadedFile $file)
    {
        $fileName    = $file->getClientOriginalName();
        $file_type   = $file->getClientOriginalExtension();
        $newFileName = sprintf("%s.%s", sha1($fileName . time()), $file_type);
        if ($file->move($this->uploadPath, $newFileName)) {
            return $newFileName;
        }

        return null;
    }

    /**
     * @return array
     */
    public function latest()
    {
        $postArray = [];
        $posts     = $this->post->latest();
        foreach ($posts as $post) {
            $postArray[] = $this->buildPost($post);
        }

        return $postArray;
    }

    /**
     * @param Post $post
     * @return array
     */
    public function buildPost(Post $post)
    {
        $postArray['id']         = $post->id;
        $postArray['created_at'] = $post->created_at->timestamp;
        $postArray['updated_at'] = $post->updated_at->timestamp;
        $tags                    = [];
        foreach ($post->tags as $tag) {
            $tags[] = $tag->title;
        }
        $postArray['tags'] = $tags;

        $questions = [];
        foreach ($post->questions as $question) {
            $questions[] = $question->id;
        }
        $postArray['question_ids'] = $questions;

        return array_merge($postArray, (array) $post->metadata);
    }

    /**
     * @param $formData
     * @param $post
     */
    protected function updateRelations($formData, $post)
    {
        if (isset($formData['country'])) {
            $post->countries()->sync($formData['country']);
        }
        if (isset($formData['question'])) {
            $post->questions()->sync($formData['question']);
        }
    }

}