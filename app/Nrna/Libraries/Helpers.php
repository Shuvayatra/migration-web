<?php

function _t($object, $key)
{
    return "";
}

function removeParam($url, $param)
{
    $url = preg_replace('/(&|\?)' . preg_quote($param) . '=[^&]*$/', '', $url);
    $url = preg_replace('/(&|\?)' . preg_quote($param) . '=[^&]*&/', '$1', $url);

    return $url;
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
