<?php
namespace App\Nrna\Services\Api;

use Suin\RSSWriter\Item;
use Suin\RSSWriter\SimpleXMLElement;

/**
 * Class Item
 * @package Suin\RSSWriter
 */
class PostRssItem extends Item
{
    protected $extendFields = [];

    public function extend(array $field)
    {
        array_push($this->extendFields, $field);

        return $this;
    }

    public function asXML()
    {
        $xml = new SimpleXMLElement(
            '<?xml version="1.0" encoding="UTF-8"?><item></item>',
            LIBXML_NOERROR | LIBXML_ERR_NONE | LIBXML_ERR_FATAL
        );

        if ($this->preferCdata) {
            $xml->addCdataChild('title', $this->title);
        } else {
            $xml->addChild('title', $this->title);
        }

        $xml->addChild('link', $this->url);

        if ($this->preferCdata) {
            $xml->addCdataChild('description', $this->description);
        } else {
            $xml->addChild('description', $this->description);
        }

        if ($this->contentEncoded) {
            $xml->addCdataChild('xmlns:content:encoded', $this->contentEncoded);
        }

        foreach ($this->categories as $category) {
            $element = $xml->addChild('category', $category[0]);

            if (isset($category[1])) {
                $element->addAttribute('domain', $category[1]);
            }
        }

        if ($this->guid) {
            $guid = $xml->addChild('guid', $this->guid);

            if ($this->isPermalink === false) {
                $guid->addAttribute('isPermaLink', 'false');
            }
        }

        if ($this->pubDate !== null) {
            $xml->addChild('pubDate', date(DATE_RSS, $this->pubDate));
        }

        if (is_array($this->enclosure) && (count($this->enclosure) == 3)) {
            $element = $xml->addChild('enclosure');
            $element->addAttribute('url', $this->enclosure['url']);
            $element->addAttribute('type', $this->enclosure['type']);

            if ($this->enclosure['length']) {
                $element->addAttribute('length', $this->enclosure['length']);
            }
        }

        if (!empty($this->author)) {
            $xml->addChild('author', $this->author);
        }

        foreach ($this->extendFields as $extend) {
            $key = array_keys($extend)[0];
            $xml->addChild("xmlns:{$key}", array_values($extend)[0]);
        }

        return $xml;
    }
}
