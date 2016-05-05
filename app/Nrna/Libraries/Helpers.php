<?php

function _t($object, $key)
{
    return "";
}

function removeParam($url, $param)
{
    if (is_array($param)) {
        foreach ($param as $par) {
            $url = preg_replace('/(&|\?)' . preg_quote($par) . '=[^&]*$/', '', $url);
            $url = preg_replace('/(&|\?)' . preg_quote($par) . '=[^&]*&/', '$1', $url);
        }

        return $url;
    }
    $url = preg_replace('/(&|\?)' . preg_quote($param) . '=[^&]*$/', '', $url);
    $url = preg_replace('/(&|\?)' . preg_quote($param) . '=[^&]*&/', '$1', $url);

    return $url;
}

function getQueryParams($url)
{
    $query_str = parse_url($url, PHP_URL_QUERY);
    parse_str($query_str, $query_params);

    return $query_params;

}

function post_type_icon($type)
{
    $post_type = [
        'text'  => 'fa-file-text-o',
        'audio' => 'fa-volume-up',
        'video' => 'fa-video-camera',
        'place' => 'fa-plane',
    ];

    return isset($post_type[$type]) ? $post_type[$type] : '';
}
