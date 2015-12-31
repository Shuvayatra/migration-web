<?php
namespace App\Nrna\Services;

use Alaouy\Youtube\Youtube;

/**
 * Class YoutubeService
 * @package App\Nrna\Services
 */
class YoutubeService
{
    /**
     * @param $key
     * @return array
     */
    public function getVideoInfo($key)
    {
        $result              = [];
        $result['duration']  = '';
        $result['thumbnail'] = '';
        $key                 = trim($key);
        try {
            if (filter_var($key, FILTER_VALIDATE_URL)) {
                $array = explode('=', $key);
                $key   = end($array);
            }

            $video = \Youtube::getVideoInfo($key);
            $start = new \DateTime('@0'); // Unix epoch
            $start->add(new \DateInterval($video->contentDetails->duration));
            $result['duration']  = $start->format('H:i:s');
            $result['thumbnail'] = isset($video->snippet->thumbnails->standard->url) ? $video->snippet->thumbnails->standard->url : $video->snippet->thumbnails->high->url;
        } catch (\Exception $e) {
            return $result;
        }

        return $result;
    }
}
