<?php
declare(strict_types=1);

namespace XTags\Infrastructure\Entrypoint\Controller\TagsController\Search;

use GuzzleHttp\Client;
use GuzzleHttp\TransferStats;
use stdClass;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class GetSearchTagsController extends AbstractController
{
    public function __invoke(Request $request): JsonResponse
    {
        // http://vocabularies.unesco.org/browser/rest/v1/search?query=aba%20sdfg*&vocab=thesaurus&lang=en&labellang=en

        $query = $request->get('q');
        $vocabulary = $request->get('vocabulary', 'thesaurus');
        $mode = $request->get('mode', 'strict');
        $lang = $request->get('lang', 'es');
        $schema = $request->get('schema', 'json-ld');

        $response = new JsonResponse();
        $url = '';
        $search = $this->getSearchUrl(rawurlencode($query).'*', $vocabulary, $lang, $lang);
        $request = $this->get_api_request($search, 'GET', [
            'on_stats' => function (TransferStats $stats) use (&$url) {
                $url = $stats->getEffectiveUri()->getQuery();
            }
        ]);

        $response->setData([
            'queryparam' => $query,
            'thesauro_data' => $request,
        ]);

        return $response;
    }

    public function getSearchUrl($query, $vocabulary, $lang, $labellang): string
    {
        $search = 'http://vocabularies.unesco.org/browser/rest/v1/search';
        $search .= "?query={$query}";
        $search .= "&vocab={$vocabulary}";
        // lang define el lenguaje de busqueda, si no se define busca en todos
        $search .= "&lang={$lang}";
        $search .= "&labellang={$lang}";

        return $search;
    }

    public function get_api_request($url, $method = 'GET', $config = [])
    {
        $client = new Client();
        $res = $client->request($method, $url, $config);
        $body = $res->getBody()->getContents();
        
        $jsonBody = json_decode($body);
        $jsonBody->uno = new stdClass;
        $jsonBody->uno->results = $jsonBody->results;

        $resultField = 'uno.results';
        $array = explode('.', $resultField);
        $results = $jsonBody;

        foreach ($array as $fieldJson => $value) {
            $results = $results->$value;
        }
        $responseBody = [];

        $schema = [
            'id' => 'localname',
            'tag_name' => 'prefLabel',
            'lang' => 'lang',
            'vocaburaly' => 'vocab'
        ];

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
