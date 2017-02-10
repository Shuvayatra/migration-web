<?php
namespace App\Nrna\Repositories\Notice;

use App\Nrna\Models\Notice;

class NoticeRepository
{
    /**
     * @var Notice
     */
    private $notice;

    /**
     * NoticeRepository constructor.
     *
     * @param Notice $notice
     */
    public function __construct(Notice $notice)
    {
        $this->notice = $notice;
    }

    /**
     * write brief description
     *
     * @param      $page
     *
     * @param null $id
     *
     * @return mixed
     */
    public function getByPage($page, $id = null)
    {
        $query = $this->notice->published()->screen($page);
        if (!is_null($id)) {
            $query->whereRaw("screen->>'dynamic_id' = ?", [$id]);
        }

        return $query->orderBy('created_by', 'desc')->first();
    }
}