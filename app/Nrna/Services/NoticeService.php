<?php
namespace App\Nrna\Services;

use App\Nrna\Repositories\Notice\NoticeRepository;

class NoticeService
{
    /**
     * @var NoticeRepository
     */
    private $noticeRepository;

    /**
     * BlockService constructor.
     *
     * @param NoticeRepository $noticeRepository
     *
     * @internal param Notice $notice
     *
     * @internal param BlockRepositoryInterface $block
     */
    public function __construct(NoticeRepository $noticeRepository)
    {
        $this->noticeRepository = $noticeRepository;
    }

    /**
     * home page blocks
     *
     * @param      $page
     * @param null $id
     *
     * @return array
     * @internal param array $filters
     *
     */
    public function getByPage($page, $id = null)
    {
        $notice = $this->noticeRepository->getByPage($page, $id);

        return $notice->api_metadata;
    }
}
