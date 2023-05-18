<?php

namespace App\Controllers;

class Controller
{
    /**
     * Return data cached with ETag.
     *
     * @param array $data
     * @return array
     */
    protected function responseDataWithETag(array $data): array
    {
        // Get ETag from response json and insert it in header
        $etag = md5(json_encode($data));
        header("ETag: $etag");

        // if client have most recent data
        if (!empty($_SERVER['HTTP_IF_NONE_MATCH']) && $etag == stripslashes($_SERVER['HTTP_IF_NONE_MATCH'])) {
            http_response_code(304);
            return;
        }

        return $data;
    }

    /**
     * Return only data.
     *
     * @param array $data
     * @return array
     */
    protected function responseData(array $data): array
    {
        return $data;
    }

    /**
     * Return message with data.
     *
     * @param string $message
     * @param array $data
     * @return array
     */
    protected function responseDataWithMessage(string $message, array $data): array
    {
        return [
            "message" => $message,
            "data" => $data,
        ];
    }

    /**
     * Return only message.
     *
     * @param string $message
     * @return array
     */
    protected function responseMessage(string $message): array
    {
        return [
            "message" => $message
        ];
    }

    /**
     * Return errors.
     *
     * @param array $errors
     * @return array
     */
    protected function responseErrors(array $errors): array
    {
        return [
            "errors" => $errors
        ];
    }
}
