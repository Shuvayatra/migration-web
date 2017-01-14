<?php

function _t($object, $key)
{
    return "";
}

function removeParam($url, $param)
{
    $param = (array) $param;
    array_push($param, "post_type", "status");
    foreach ($param as $par) {
        $url = preg_replace('/(&|\?)'.preg_quote($par).'=[^&]*$/', '', $url);
        $url = preg_replace('/(&|\?)'.preg_quote($par).'=[^&]*&/', '$1', $url);
    }

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

/**
 * Checks if multiple keys exist in an array
 *
 * @param array        $array
 * @param array|string $keys
 *
 * @return bool
 */
function array_keys_exist(array $array, $keys)
{
    $count = 0;
    if (!is_array($keys)) {
        $keys = func_get_args();
        array_shift($keys);
    }
    foreach ($keys as $key) {
        if (array_key_exists($key, $array)) {
            $count++;
        }
    }

    return count($keys) === $count;
}

function activeCategoryTab($categories, $category)
{
    if (request()->has('active_tab') && request()->get('active_tab') == $category->id) {
        return "active";
    }

    if (!request()->has('active_tab') && !request()->get('active_tab') == $category->id && $categories->first(
        ) == $category
    ) {
        return "active";
    }

    return "";
}

/**
 * Return active class if the url pattern matches
 *
 * @param string $urlPattern
 *
 * @return string
 */
function activeFor($urlPattern)
{
    return str_contains(request()->fullUrl(), $urlPattern) ? 'active' : '';
}
