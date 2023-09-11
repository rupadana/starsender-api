<?php

namespace Rupadana\StarsenderApi;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Stringable;

class StarsenderApi
{
    protected static string $url = "https://starsender.online";

    protected static function getApiKey()
    {
        return config('starsender-api.api_key');
    }

    public static function getHttpClient()
    {
        return Http::withHeader('apikey', static::getApiKey());
    }

    public static function transformPhoneNumber($number, $transform = true)
    {
        if (config('starsender-api.is_production', false) == false && config('starsender-api.force_message_to', '') != null) {
            $number = config('starsender-api.force_message_to');
        }
        // dd(config('starsender-api.is_production'));

        if ($transform === false) return $number;

        return str($number)
            ->whenStartsWith('08', fn (Stringable $string) => $string->substr(1))
            ->start('62')
            ->append('@s.whatsapp.net')
            ->value();
    }

    public static function sendText(?string $to, ?string $message)
    {
        return static::getHttpClient()
            ->post(
                static::getApiUrl(
                    '/sendText'
                        . '?message='
                        . rawurldecode($message)
                        . '&tujuan='
                        . rawurlencode(static::transformPhoneNumber($to))
                )
            );
    }

    public static function sendFilesViaUrl(
        ?string $to,
        ?string $message,
        ?string $file
    ) {
        return static::getHttpClient()
            ->post(
                static::getApiUrl(
                    '/sendFiles'
                        . '?message='
                        . rawurldecode($message)
                        . '&tujuan='
                        . rawurlencode(static::transformPhoneNumber($to))
                ),
                [
                    'file' => $file
                ]
            );
    }

    public static function sendFiles(
        ?string $to,
        ?string $message,
        ?string $filePath
    ) {
        return static::getHttpClient()
            ->post(
                static::getApiUrl(
                    '/sendFiles'
                        . '?message='
                        . rawurldecode($message)
                        . '&tujuan='
                        . rawurlencode(static::transformPhoneNumber($to))
                ),
                [
                    'file' => curl_file_create($filePath)
                ]
            );
    }

    /**
     * Send Button Message
     * 
     * @param string|null $to
     * @param string|null $message
     * @param string|null $button - Button 1|Button 2|Button 3
     * @param array $optional - [ "footer" : string, "file_url" : url, "jadwal" : 2021-01-01 10:00:00 ] 
     * @return void
     */
    public static function sendButton(
        ?string $to,
        ?string $message,
        ?array $button,
        array $optional = []
    ) {

        $data = [
            'tujuan' => static::transformPhoneNumber($to, false),
            'message' => $message,
            'button' => implode('|', $button),
            ...$optional
        ];

        return static::getHttpClient()
            ->post(
                static::getApiUrl(
                    '/sendButton'
                ),
                $data
            );
    }


    public static function getApiUrl(?string $endpoint = '')
    {
        $url = static::$url . '/api';

        if ($endpoint != '') {
            $url .= $endpoint;
        }

        return $url;
    }
}
