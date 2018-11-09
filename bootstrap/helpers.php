<?php

/*
* transfer current routename to css class name.
*/
function route_class(){
    return str_replace('.', '-', Route::currentRouteName());
}

/**
 * @param $value
 * @param int $length
 * @return string
 *
 * process excerpt
 * filter \r\n, filter all tags in str
 * and limit str length
 */
function make_excerpt($value, $length = 200)
{
    $excerpt = trim(preg_replace('/\r\n|\r|\n+/', ' ', strip_tags($value)));
    return str_limit($excerpt, $length);
}
?>