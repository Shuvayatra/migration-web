<?php
namespace App\Nrna\Services\Api;

use Suin\RSSWriter\Channel;
use Suin\RSSWriter\Feed;
use Suin\RSSWriter\Item;

class PostRssService
{
    /**
     * Return a string with the feed data
     *
     * @param $posts
     *
     * @return string
     */
    public function buildRssData($posts)
    {
        $now     = \Carbon::now();
        $feed    = new Feed();
        $channel = new Channel();
        $channel
            ->title('Shuvayatra')
            ->description("Shuvayatra")
            ->url(url())
            ->language('en')
            ->copyright("Copyright (c) 2016 Shuvayatra")
            ->lastBuildDate($now->timestamp)
            ->appendTo($feed);
        foreach ($posts['data'] as $post) {
            $item = new PostRssItem();
            $post = (object) $post;
            $item
                ->title($post->title)
                ->description($this->stripInvalidXml($post->description))
                ->url($post->share_url)
                ->pubDate($post->created_at)
                ->guid($post->share_url, true)
                ->preferCdata(true)
                ->appendTo($channel);
        }
        $feed = (string) $feed;
        $feed = str_replace(
            '<rss version="2.0">',
            '<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">',
            $feed
        );
        $feed = str_replace(
            '<channel>',
            '<channel>'."\n".'   <atom:link href="'.url('/rss').
            '" rel="self" type="application/rss+xml"/>',
            $feed
        );

        return $feed;
    }

    /**
     * Removes invalid XML
     *
     * @access public
     *
     * @param string $value
     *
     * @return string
     */
    protected function stripInvalidXml($value)
    {
        $ret = "";
        if (empty($value)) {
            return $ret;
        }

        $length = strlen($value);
        for ($i = 0; $i < $length; $i++) {
            $current = ord($value{$i});
            if (($current == 0x9) ||
                ($current == 0xA) ||
                ($current == 0xD) ||
                (($current >= 0x20) && ($current <= 0xD7FF)) ||
                (($current >= 0xE000) && ($current <= 0xFFFD)) ||
                (($current >= 0x10000) && ($current <= 0x10FFFF))
            ) {
                $ret .= chr($current);
            } else {
                $ret .= " ";
            }
        }

        return $ret;
    }
}