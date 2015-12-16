<?php
namespace App\Nrna\Services;


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
     * @param array $filter
     * @return array|bool
     */
    public function latest($filter = [])
    {
        try {
            $data['posts']     = $this->post->latest($filter);
            $data['questions'] = $this->question->latest($filter);
            $data['countries'] = $this->country->latest();

            return $data;
        } catch (\Exception $e) {
            return false;
        }

        return false;
    }
}