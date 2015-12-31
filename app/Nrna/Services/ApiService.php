<?php
namespace App\Nrna\Services;

use Illuminate\Contracts\Logging\Log;

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
     * @param Log             $logger
     */
    public function __construct(
        PostService $post,
        QuestionService $question,
        CountryService $country,
        AnswerService $answer,
        Log $logger
    ) {
        $this->post     = $post;
        $this->country  = $country;
        $this->question = $question;
        $this->answer   = $answer;
        $this->logger   = $logger;
    }

    /**
     * gets latest posts,country,question
     * @param  array      $filter
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
            $this->logger->error($e);

            return false;
        }

        return false;
    }

    /**
     * gets deleted posts,question,answers
     * @param  array      $filter
     * @return array|bool
     */
    public function deleted($filter = [])
    {
        try {
            if (isset($filter['last_updated'])) {
                $filter['deleted_at'] = \Carbon::createFromTimestamp($filter['last_updated'])->toDateTimeString();
            }
            $data['posts']     = $this->post->deleted($filter);
            $data['questions'] = $this->question->deleted($filter);
            $data['answers']   = $this->answer->deleted($filter);

            return $data;
        } catch (\Exception $e) {
            $this->logger->error($e);

            return false;
        }

        return false;
    }
}
