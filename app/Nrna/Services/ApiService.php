<?php
namespace App\Nrna\Services;

use App\Nrna\Repositories\Country\CountryRepositoryInterface;
use Illuminate\Contracts\Filesystem\Factory as Storage;
use Illuminate\Http\Request;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\HttpFoundation\File\UploadedFile;


/**
 * Class ApiService
 * @package App\Nrna\Services
 */
class ApiService
{
    /**
     * @var PostService
     */
    private $post;
    /**
     * @var CountryService
     */
    private $country;
    /**
     * @var QuestionService
     */
    private $question;

    /**
     * @param PostService     $post
     * @param QuestionService $question
     * @param CountryService  $country
     */
    function __construct(PostService $post, QuestionService $question, CountryService $country)
    {
        $this->post     = $post;
        $this->country  = $country;
        $this->question = $question;
    }

    /**
     * gets latest posts,country,question
     */
    public function latest()
    {
        try {
            $data['posts']     = $this->post->latest();
            $data['questions'] = $this->question->latest();
            //$data['countries'] = $this->country->all()->toArray();

            return $data;
        } catch (\Exception $e) {
            dd($e);

            return false;
        }

        return false;
    }
}