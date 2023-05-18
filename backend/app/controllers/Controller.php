<?php

namespace App\Controllers;

class Controller
{
    protected function responseDataWithETag($data)
    {
        $etag = md5(json_encode($data));
        header("ETag: $etag");
        if (!empty($_SERVER['HTTP_IF_NONE_MATCH']) && $etag == stripslashes($_SERVER['HTTP_IF_NONE_MATCH'])) {
            http_response_code(304);
            return;
        }

        return $data;
    }
}
