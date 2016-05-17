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
    protected $post;
    /**
     * @var CountryService
     */
    protected $country;
    /**
     * @var QuestionService
     */
    protected $question;
    /**
     * @var AnswerService
     */
    protected $answer;
    /**
     * @var CountryUpdateService
     */
    protected $update;
    /**
     * @var JourneyService
     */
    protected $journey;
    /**
     * @var PlaceService
     */
    protected $place;
    /**
     * @var SectionService
     */
    protected $section;
    /**
     * @var CategoryService
     */
    protected $category;

    /**
     * @param PostService     $post
     * @param CountryService  $country
     * @param AnswerService   $answer
     * @param JourneyService  $journey
     * @param PlaceService    $place
     * @param SectionService  $section
     * @param Log             $logger
     * @param CategoryService $category
     * @internal param Log $logger
     */
    public function __construct(
        PostService $post,
        CountryService $country,
        AnswerService $answer,
        JourneyService $journey,
        PlaceService $place,
        SectionService $section,
        Log $logger,
        CategoryService $category
    ) {
        $this->post    = $post;
        $this->country = $country;
        $this->answer  = $answer;
        $this->logger  = $logger;
        $this->journey = $journey;
        $this->place   = $place;
        $this->section = $section;
        $this->category = $category;
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
            $data['sections'] = $this->category->latest($filter);
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
            $data['categories'] = $this->category->deleted($filter);

            return $data;
        } catch (\Exception $e) {
            $this->logger->error($e);

            return false;
        }

        return false;
    }
}
