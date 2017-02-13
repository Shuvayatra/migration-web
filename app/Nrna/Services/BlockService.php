<?php
namespace App\Nrna\Services;

use App\Nrna\Models\Block;
use App\Nrna\Repositories\Block\BlockRepositoryInterface;

class BlockService
{
    /**
     * @var BlockRepositoryInterface
     */
    private $block;
    /**
     * @var NoticeService
     */
    private $noticeService;

    /**
     * BlockService constructor.
     *
     * @param BlockRepositoryInterface $block
     * @param NoticeService            $noticeService
     */
    public function __construct(BlockRepositoryInterface $block, NoticeService $noticeService)
    {
        $this->block         = $block;
        $this->noticeService = $noticeService;
    }

    /**
     * home page blocks
     *
     * @param array $filters
     *
     * @return array
     */
    public function getHomeBlocks($filters = [])
    {
        $blocks = $this->block->getHomeBlocks($filters);
        $data   = $blocks->pluck('api_metadata')->toArray();
        $notice = $this->noticeService->getByPage('home');
        if (!empty($notice)) {
            array_push($data, $notice);
        }

        return $data;
    }

    /**
     * Categories destination/journey page blocks
     *
     * @param $id
     *
     * @param $page
     *
     * @return array
     */
    public function getCategoryBlocks($id, $page)
    {
        $blocks = $this->block->getCategoryBlocks($id, $page, request()->only('country_id', 'gender'));
        $data   = $blocks->pluck('api_metadata')->toArray();
        $notice = $this->noticeService->getByPage('country', $id);
        if (!empty($notice)) {
            array_push($data, $notice);
        }

        return $data;
    }

    /**
     * home page blocks
     * @return array
     */
    public function getJourneyBlocks()
    {
        $blocks = $this->block->getJourneyBlocks();

        return $blocks->pluck('api_metadata');
    }

    /**
     * saves block
     *
     * @param $data
     *
     * @return mixed
     */
    public function save($data)
    {
        return $this->block->create($data);
    }

    public function all($filters)
    {
        $query = Block::sorted()->orderBy('page', 'desc');
        $query->where('page', request()->get('page', 'home'));

        if (request()->get('country_id') != '') {
            $query->whereRaw("metadata->>'country_id'=?", [request()->get('country_id')]);
        }
        if (request()->get('journey_id') != '') {
            $query->whereRaw("metadata->>'journey_id'=?", [request()->get('journey_id')]);
        }

        if (request()->get('screen_id') != '') {
            $query->whereRaw("metadata->>'screen_id'=?", [request()->get('screen_id')]);
        }

        return $query->get();
    }

    /**
     * home page blocks
     *
     * @param       $screenId
     * @param array $filters
     *
     * @return array
     */
    public function getScreenBlocks($screenId, $filters = [])
    {
        $blocks = $this->block->getScreenBlocks($screenId, $filters);

        $data = $blocks->pluck('api_metadata')->toArray();

        return $data;
    }

    public function find($id)
    {
        return $this->block->find($id);
    }

    public function getBlockPosts($id)
    {
        try {
            $block = $this->block->find($id);
            $query = $block->getPostsBuilder();
            if ($block->custom_posts->count() > 0) {
                $query->whereNotIn('id', $block->custom_posts->lists('id')->toArray());
            }
            $posts    = $query->paginate();
            $response = array_except($posts->toArray(), 'data');
            $data     = $posts->pluck('api_metadata')->toArray();
            if ($block->custom_posts->count() > 0) {
                if (request()->get('page') == 1) {
                    $pinned_posts = $block->custom_posts->pluck('api_metadata')->toArray();
                    $block_posts  = $posts->pluck('api_metadata')->toArray();
                    $data         = array_merge($pinned_posts, $block_posts);
                }
            }

            $response['data'] = $data;

            return $response;

        } catch (\Exception $exception) {
            logger()->error($exception);

            return false;
        }
    }
}
