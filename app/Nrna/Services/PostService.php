<?php
namespace App\Nrna\Services;

use App\Nrna\Models\Post;
use App\Nrna\Repositories\Category\CategoryRepositoryInterface;
use App\Nrna\Repositories\Post\PostRepositoryInterface;
use Illuminate\Database\DatabaseManager;
use Illuminate\Contracts\Logging\Log;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Illuminate\Filesystem\Filesystem;

/**
 * Class PostService
 * @package App\Nrna\Services
 */
class PostService
{
    const LIKE = true;
    /**
     * @var PostRepositoryInterface
     */
    protected $post;

    /**
     * @var string
     */
    protected $uploadPath;
    /**
     * @var TagService
     */
    protected $tag;
    /**
     * @var DatabaseManager
     */
    protected $database;
    /**
     * @var Filesystem
     */
    protected $file;
    /**
     * @var YoutubeService
     */
    protected $youtube;
    /**
     * @var AudioService
     */
    protected $audio;
    /**
     * @var Log
     */
    protected $logger;
    /**
     * @var ImageService
     */
    protected $image;
    /**
     * @var FileUpload
     */
    protected $fileUpload;
    /**
     * @var CategoryService
     */
    protected $category;

    /**
     * constructor
     *
     * @param PostRepositoryInterface $post
     * @param TagService              $tag
     * @param DatabaseManager         $database
     * @param Filesystem              $file
     * @param YoutubeService          $youtube
     * @param AudioService            $audio
     * @param Log                     $logger
     * @param FileUpload              $fileUpload
     * @param ImageService            $image
     * @param CategoryService         $category
     */
    public function __construct(
        PostRepositoryInterface $post,
        TagService $tag,
        DatabaseManager $database,
        Filesystem $file,
        YoutubeService $youtube,
        AudioService $audio,
        Log $logger,
        FileUpload $fileUpload,
        ImageService $image,
        CategoryService $category

    ) {
        $this->uploadPath = public_path(Post::UPLOAD_PATH);
        $this->post       = $post;
        $this->tag        = $tag;
        $this->database   = $database;
        $this->file       = $file;
        $this->youtube    = $youtube;
        $this->audio      = $audio;
        $this->logger     = $logger;
        $this->image      = $image;
        $this->fileUpload = $fileUpload;
        $this->category   = $category;
    }

    /**
     * @param $formData
     *
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
            $formData['is_published'] = isset($formData['is_published']) ? true : false;
            if (isset($formData['metadata']['data']['phone'])) {
                $formData['metadata']['data']['phone'] = array_values($formData['metadata']['data']['phone']);
            }
            if ($formData['metadata']['type'] === 'text') {
                $formData = $this->formatTypeTextCreate($formData);
            }
            if ($formData['metadata']['type'] === 'audio') {
                $formData = $this->formatTypeAudioCreate($formData);
            }
            if ($formData['metadata']['type'] === 'video') {
                $formData = $this->getVideoData($formData);
            }
            if (isset($formData['metadata']['featured_image'])) {
                $formData['metadata']['featured_image'] = $this->upload($formData['metadata']['featured_image']);
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
            $this->logger->error($e);
            $this->database->rollback();
        }
        $this->database->rollback();

        return false;
    }

    /**
     * @param      $filter
     * @param  int $limit
     *
     * @return Collection
     */
    public function all($filter)
    {
        return $this->post->getAll($filter);
    }

    /**
     * @param $id
     *
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
     *
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
            $formData['is_published'] = isset($formData['is_published']) ? true : false;
            $post                     = $this->find($id);
            $post->created_at         = $formData['created_at'];
            if (isset($formData['metadata']['data']['phone'])) {
                $formData['metadata']['data']['phone'] = array_values($formData['metadata']['data']['phone']);
            }
            if ($formData['metadata']['type'] === 'text') {
                $formData = $this->formatTypeTextUpdate($post, $formData);
            }
            if ($formData['metadata']['type'] === 'audio') {
                $formData['metadata']['data'] = $this->formatTypeAudioUpdate($post, $formData);
            }

            if ($formData['metadata']['type'] === 'video') {
                $formData = $this->getVideoData($formData);
            }
            if (isset($formData['metadata']['featured_image'])) {
                $this->file->delete($this->uploadPath.'/'.$post->metadata->featured_image);
                $formData['metadata']['featured_image'] = $this->upload($formData['metadata']['featured_image']);
            } else {
                $formData['metadata']['featured_image'] = isset($post->metadata->featured_image) ? $post->metadata->featured_image : '';
            }

            if (!$post->update($formData)) {
                return false;
            }

            $this->updateRelations($formData, $post);
            $post->tags()->sync($tags);
            $this->database->commit();

            return $post;
        } catch (\Exception $e) {
            $this->logger->error($e);
            $this->database->rollback();

            return false;
        }
        $this->database->rollback();

        return false;
    }

    /**
     * @param $id
     *
     * @return bool
     */
    public function delete($id)
    {
        $post = $this->find($id);
        if ($post->metadata->type = 'audio' && isset($post->metadata->data->audio)) {
            $this->file->delete($this->uploadPath.'/'.$post->metadata->data->audio);
        }

        if (isset($post->metadata->featured_image)) {
            $this->file->delete($this->uploadPath.'/'.$post->metadata->featured_image);
        }
        if ($this->post->delete($id)) {
            return true;
        }

        return false;
    }

    /**
     * @param  UploadedFile $file
     *
     * @return string
     */
    public function upload(UploadedFile $file)
    {
        if ($fileInfo = $this->fileUpload->handle($file, $this->uploadPath)) {
            return $fileInfo['filename'];
        }

        return null;
    }

    /**
     * @param $filter
     *
     * @return array
     */
    public function latest($filter)
    {
        $postArray = [];
        $posts     = $this->post->latest($filter);
        foreach ($posts as $post) {
            $postArray[] = $this->buildPost($post);
        }

        return $postArray;
    }

    /**
     * @param  Post $post
     * @param bool  $withCategoryTitle
     *
     * @return array
     *
     */
    public function buildPost(Post $post, $withCategoryTitle = false)
    {
        $post->load('categories');
        $postArray['id']          = $post->id;
        $postArray                = array_merge($postArray, (array) $post->apiMetadata);
        $postArray['like_count']  = $post->likes;
        $postArray['view_count']  = (int) $post->view_count;
        $postArray['share_count'] = (int) $post->share_count;
        $postArray['tags']        = $post->tags->lists('title')->toArray();
        if ($withCategoryTitle) {
            $postArray['categories'] = $post->categories->lists('title')->toArray();
        } else {
            $postArray['section_category'] = $post->categories->lists('id')->toArray();
        }
        $postArray['created_at'] = $post->created_at->timestamp;
        $postArray['updated_at'] = $post->updated_at->timestamp;

        return $postArray;
    }

    /**
     * @param $formData
     * @param $post
     */
    protected function updateRelations($formData, $post)
    {
        if (isset($formData['category_id'])) {
            $post->categories()->sync($formData['category_id']);
        }
        if (isset($formData['similar_posts'])) {
            $post->similar_posts()->sync($formData['similar_posts']);
        }
    }

    /**
     * @param $formData
     *
     * @return mixed
     */
    protected function getVideoData($formData)
    {
        $videoInformation             = $this->youtube->getVideoInfo(
            $formData['metadata']['data']['media_url']
        );
        $formData['metadata']['data'] = array_merge($formData['metadata']['data'], $videoInformation);

        return $formData;
    }

    /**
     * @param $fileName
     *
     * @return string
     */
    protected function getAudioFilePath($fileName)
    {
        return sprintf('%s/%s', $this->uploadPath, $fileName);
    }

    /**
     * @param $questions
     *
     * @return array
     */
    protected function getQuestionsData($questions)
    {
        $questionArray = [];
        foreach ($questions as $question => $answer) {
            if (!is_array($answer)) {
                $questionArray [] = $answer;
            }
        }

        return $questionArray;
    }

    /**
     * @param $questions
     *
     * @return array
     */
    protected function getAnswerData($questions)
    {
        $answerArray = [];
        foreach ($questions as $question => $answer) {
            if (is_array($answer)) {
                $answerArray [] = array_keys($answer['answer']);
            }
        }

        return array_flatten($answerArray);
    }

    /**
     * gets deleted posts
     *
     * @param $filter
     *
     * @return array
     */
    public function deleted($filter)
    {
        $posts = $this->post->deleted($filter);

        return $posts;
    }

    /**
     * @param $formData
     *
     * @return mixed
     */
    protected function formatTypeAudioCreate($formData)
    {
        $data['audio']        = '';
        $data['duration']     = '';
        $data['audio_url']    = '';
        $data['thumbnail']    = '';
        $data['photo_credit'] = $formData['metadata']['data']['photo_credit'];
        if (!is_null($formData['metadata']['data']['audio_url'])) {
            $data['audio']     = $formData['metadata']['data']['audio_url'];
            $data['audio_url'] = $formData['metadata']['data']['audio_url'];
        }
        if (isset($formData['metadata']['data']['audio'])) {
            $data['audio']    = $this->upload($formData['metadata']['data']['audio']);
            $data['duration'] = $this->audio->getDuration(
                $this->getAudioFilePath($data['audio'])
            );
        }
        if (isset($formData['metadata']['data']['thumbnail'])) {
            $data['thumbnail'] = $this->upload($formData['metadata']['data']['thumbnail']);
        }
        $formData['metadata']['data'] = $data;

        return $formData;
    }

    /**
     * @param $post
     * @param $formData
     *
     * @return mixed
     */
    protected function formatTypeAudioUpdate($post, $formData)
    {
        $data = (array) $post->metadata->data;
        $data = array_merge($data, $formData['metadata']['data']);
        if (!empty($formData['metadata']['data']['audio_url'])) {
            $data['audio']     = $formData['metadata']['data']['audio_url'];
            $data['audio_url'] = $formData['metadata']['data']['audio_url'];
        }
        if (!empty($formData['metadata']['data']['audio'])) {
            $data['audio']    = $this->upload($formData['metadata']['data']['audio']);
            $data['duration'] = $this->audio->getDuration(
                $this->getAudioFilePath($data['audio'])
            );
            $this->file->delete($post->audioPath);
        }
        if (!empty($formData['metadata']['data']['thumbnail'])) {
            $data['thumbnail'] = $this->upload($formData['metadata']['data']['thumbnail']);
        }

        return $data;
    }

    /**
     * @param $formData
     *
     * @return mixed
     */
    protected function formatTypeTextCreate($formData)
    {
        $data['content'] = $formData['metadata']['data']['content'];
        $data['file']    = [];

        if (isset($formData['metadata']['data']['file'][0])) {

            $fileInfo['file_name']   = '';
            $fileInfo['description'] = '';
            $data['file'][]          = $fileInfo;
            foreach ($formData['metadata']['data']['file'] as $fileData) {
                unset($data['file'][0]);
                if (!is_null($fileData['file_name'])) {
                    $fileInfo['file_name']   = $this->upload($fileData['file_name']);
                    $fileInfo['description'] = $fileData['description'];
                    $data['file'][]          = $fileInfo;
                }
            }
        }

        $formData['metadata']['data'] = $data;

        return $formData;
    }

    /**
     * @param $post
     * @param $formData
     *
     * @return mixed
     */
    protected function formatTypeTextUpdate($post, $formData)
    {
        $data    = json_decode(json_encode($post->metadata->data), true);
        $fileNew = [];
        foreach ($formData['metadata']['data']['file'] as $key => $fileData) {
            if (!is_null($fileData['file_name'])) {
                $fileInfo['file_name']   = $data['file'][$key]['file_name'];
                $fileInfo['file_name']   = $this->upload($fileData['file_name']);
                $fileInfo['description'] = $fileData['description'];
                $fileNew[]               = $fileInfo;
            } else {
                $fileNew = $data['file'];
            }

        }
        $data['file']                 = $fileNew;
        $formData['metadata']['data'] = $data;

        return $formData;
    }

    /**
     * @param $likesData
     *
     * @return array|bool
     */
    function sync($likesData)
    {
        $ids = $this->postIdsExistsCheck($likesData);
        try {
            foreach ($likesData as $data) {
                if (in_array($data['id'], $ids['success'])) {
                    $this->SyncLikeData($data);
                }
            }
        } catch (\Exception $e) {
            $this->logger->error($e);

            return false;
        }

        return $ids;
    }

    /**
     * Increment or decrement likes
     *
     * @param $id
     * @param $status
     *
     * @return bool|null
     */
    public function modifyLikes($id, $status)
    {
        if (!$this->post->find($id)) {
            return false;
        }
        if ($status === 'increment') {
            $this->post->incrementLikes($id);
        }

        if ($status === 'decrement' && $this->post->getLikes($id)->likes > 0) {
            $this->post->decrementLikes($id);
        }

        return null;
    }

    /**
     * Check success and failure ids of post
     *
     * @param $likesData
     *
     * @return array
     */
    protected function postIdsExistsCheck($likesData)
    {
        $ids        = array_column($likesData, 'id');
        $successIds = array_column($this->post->postExistsCheck($ids)->toArray(), 'id');
        $failureIds = array_diff($ids, $successIds);

        return ['success' => $successIds, 'failure' => $failureIds];
    }

    /**
     * @param $query
     *
     * @return mixed
     */
    public function search($query)
    {
        return $this->post->search($query);
    }

    /**
     * @param $data
     */
    protected function syncLikeData($data)
    {
        $postId = $data['id'];
        if (isset($data['like']) && $data['like'] == self::LIKE) {
            $this->modifyLikes($postId, 'increment');
        }

        if (isset($data['like']) && $data['like'] != self::LIKE) {
            $this->modifyLikes($postId, 'decrement');
        }

        if (isset($data['share_count'])) {
            $this->increaseShareCount($postId, $data['share_count']);
        }
        if (isset($data['view_count'])) {
            $this->post->increaseView($postId, $data['view_count']);
        }
    }

    /**
     * @return mixed
     */
    public function getAllPosts()
    {
        return $this->post->getAllPosts();
    }

    /**
     * increase share count
     *
     * @param $postId
     * @param $count
     *
     * @return bool
     */
    public function increaseShareCount($postId, $count)
    {
        try {
            $this->post->increaseShare($postId, $count);

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function fullTextSearch($q)
    {
        return $this->post->fullTextSearch($q);
    }

    /**
     * increase view count
     *
     * @param $postId
     * @param $count
     *
     * @return bool
     */
    public function increaseViewCount($postId, $count)
    {
        try {
            $this->post->increaseView($postId, $count);

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function assignToAdmin($posts, $admin_id){

        $this->database->beginTransaction();

        try {
            foreach ($posts as $post) {

                $post->created_by = $admin_id;
                $post->updated_by = $admin_id;
                $post->update();
            }
        }catch (\Exception $e) {
            $this->logger->error($e);
            $this->database->rollback();

            return false;
        }
    }
}