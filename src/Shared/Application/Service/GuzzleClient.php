<?php

namespace XTags\Shared\Application\Service;

use GuzzleHttp\Client;

class GuzzleClient
{
    const GET = 'GET';

    public static function get($url, $config = [], $schema, $fieldData)
    {
        $client = new Client();

        $response = $client->request(self::GET, $url, $config);
        $body = $response->getBody()->getContents();
        
        $jsonBody = json_decode($body);
        $jsonBody->uno = new \stdClass;
        // $jsonBody->uno->results = $jsonBody->results;

        $array = explode('.', $fieldData);
        $results = $jsonBody;

        foreach ($array as $value) {
            $results = $results->$value;
        }
        $responseBody = [];


        foreach ($results as $result) {
            $data = [];
            foreach ($schema as $parseField => $field) {
                $data[$parseField] = $result->$field;
            }
            $responseBody[] = $data;
        }
        return $responseBody;
    }
}
