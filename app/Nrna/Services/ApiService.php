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
<<<<<<< HEAD
     * @var CountryTagService
     */
    private $countryTag;

    /**
     * @param PostService       $post
     * @param CountryService    $country
     * @param AnswerService     $answer
     * @param JourneyService    $journey
     * @param PlaceService      $place
     * @param Log               $logger
     * @param CountryTagService $countryTag
=======
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
>>>>>>> Section feature
     */
    public function __construct(
        PostService $post,
        CountryService $country,
        AnswerService $answer,
        JourneyService $journey,
        PlaceService $place,
<<<<<<< HEAD
        Log $logger,
        CountryTagService $countryTag
    ) {
        $this->post       = $post;
        $this->country    = $country;
        $this->answer     = $answer;
        $this->logger     = $logger;
        $this->journey    = $journey;
        $this->place      = $place;
        $this->countryTag = $countryTag;
=======
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
>>>>>>> Section feature
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
<<<<<<< HEAD
            $data['posts']        = $this->post->latest($filter);
            $data['countries']    = $this->country->latest();
            $data['journeys']     = $this->journey->latest($filter);
            $data['places']       = $this->place->latest($filter);
            $data['country_tags'] = $this->countryTag->latest($filter);
=======
            $data['posts']    = $this->post->latest($filter);
            $data['sections'] = $this->section->latest($filter);
>>>>>>> Section feature

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
<<<<<<< HEAD
            $data['posts']        = $this->post->deleted($filter);
            $data['places']       = $this->place->deleted($filter);
            $data['country_tags'] = $this->countryTag->deleted($filter);
=======
            $data['posts']    = $this->post->deleted($filter);
            $data['sections'] = $this->section->deleted($filter);
>>>>>>> Section feature

            return $data;
        } catch (\Exception $e) {
            $this->logger->error($e);

            return false;
        }

        return false;
    }
}
