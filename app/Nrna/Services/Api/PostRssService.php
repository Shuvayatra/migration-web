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
                ->extend(['sy:source' => $post->source])
                ->extend(['sy:postType' => $post->type])
                ->extend(['sy:language' => $post->language])
                ->extend(['sy:featured_image' => $post->featured_image])
                ->extend(['sy:like_count' => $post->like_count])
                ->extend(['sy:share_count' => $post->share_count])
                ->extend(['sy:tags' => implode(',', $post->tags)])
                ->extend(['sy:categories' => implode(',', $post->categories)])
                ->guid($post->share_url, true)
                ->preferCdata(true)
                ->appendTo($channel);
            if ($post->type == 'text') {
                //$item->extend(['sy:content' => isset($post->data->content) ? $post->data->content : '']);
            } else {
                $item->extend(['sy:media_url' => isset($post->data->media_url) ? $post->data->media_url : ''])
                     ->extend(['sy:duration' => isset($post->data->duration) ? $post->data->duration : ''])
                     ->extend(['sy:thumbnail' => isset($post->data->thumbnail) ? $post->data->thumbnail : '']);
            }
        }
        $feed = (string) $feed;
        $feed = str_replace(
            'version="2.0"',
            'xmlns:sy="http://shuvayatra.org/doc/rss/" version="2.0"',
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