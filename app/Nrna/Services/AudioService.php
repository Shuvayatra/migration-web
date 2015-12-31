<?php
namespace App\Nrna\Services;

use App\Nrna\Libraries\MP3File;

/**
 * Class AudioService
 * @package App\Nrna\Services
 */
class AudioService
{
    /**
     * get duration of mp3 file
     *
     * @param $audio
     * @return string
     */
    public function getDuration($audio)
    {
        $duration = '';
        try {
            $mp3file   = new MP3File($audio);
            $duration1 = $mp3file->getDurationEstimate();//(faster) for CBR only
            $duration  = MP3File::formatTime($duration1);
        } catch (\Exception $e) {
        }

        return $duration;
    }
}
