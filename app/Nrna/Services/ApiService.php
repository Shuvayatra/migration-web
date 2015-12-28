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
     * @var AnswerService
     */
    private $answer;

    /**
     * @param PostService     $post
     * @param QuestionService $question
     * @param CountryService  $country
     * @param AnswerService   $answer
     */
    function __construct(PostService $post, QuestionService $question, CountryService $country, AnswerService $answer)
    {
        $this->post     = $post;
        $this->country  = $country;
        $this->question = $question;
        $this->answer   = $answer;
    }

    /**
     * gets latest posts,country,question
     * @param array $filter
     * @return array|bool
     */
    public function latest($filter = [])
    {
        try {
            if (isset($filter['last_updated'])) {
                $filter['updated_at'] = \Carbon::createFromTimestamp($filter['last_updated'])->toDateTimeString();
            }
            $data['posts']     = $this->post->latest($filter);
            $data['questions'] = $this->question->latest($filter);
            $data['countries'] = $this->country->latest();
            $data['answers']   = $this->answer->latest($filter);

            return $data;
        } catch (\Exception $e) {
            return false;
        }

        return false;
    }
}