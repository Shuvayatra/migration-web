<?php
namespace App\Nrna\Services;

use App\Nrna\Models\CountryTag;
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
     * @var CountryUpdateService
     */
    private $update;
    /**
     * @var JourneyService
     */
    private $journey;
    /**
     * @var PlaceService
     */
    private $place;
    /**
     * @var SectionService
     */
    private $section;

    /**
     * @param PostService    $post
     * @param CountryService $country
     * @param AnswerService  $answer
     * @param JourneyService $journey
     * @param PlaceService   $place
     * @param SectionService $section
     * @param Log            $logger
     * @internal param Log $logger
     */
    public function __construct(
        PostService $post,
        CountryService $country,
        AnswerService $answer,
        JourneyService $journey,
        PlaceService $place,
        SectionService $section,
        Log $logger
    ) {
        $this->post    = $post;
        $this->country = $country;
        $this->answer  = $answer;
        $this->logger  = $logger;
        $this->journey = $journey;
        $this->place   = $place;
        $this->section = $section;
    }

    /**
     * gets latest posts,country,question
     * @param  array $filter
     * @return array|bool
     */
    public function latest($filter = [])
    {
        try {
            if (isset($filter['last_updated'])) {
                $filter['updated_at'] = \Carbon::createFromTimestamp($filter['last_updated'])->toDateTimeString();
            }

            $data['posts']    = $this->post->latest($filter);
            $data['sections'] = $this->section->latest($filter);
            return $data;
        } catch (\Exception $e) {
            $this->logger->error($e);

            return false;
        }

        return false;
    }

    /**
     * gets deleted posts,question,answers
     * @param  array $filter
     * @return array|bool
     */
    public function deleted($filter = [])
    {
        try {
            if (isset($filter['last_updated'])) {
                $filter['deleted_at'] = \Carbon::createFromTimestamp($filter['last_updated'])->toDateTimeString();
            }
            $data['posts']    = $this->post->deleted($filter);
            $data['sections'] = $this->section->deleted($filter);

            return $data;
        } catch (\Exception $e) {
            $this->logger->error($e);

            return false;
        }

        return false;
    }
}
