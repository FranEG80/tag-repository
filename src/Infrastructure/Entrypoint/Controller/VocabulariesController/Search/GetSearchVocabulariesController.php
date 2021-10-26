<?php
declare(strict_types=1);

namespace XTags\Infrastructure\Entrypoint\Controller\VocabulariesController\Search;

use GuzzleHttp\Client;
use GuzzleHttp\TransferStats;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use XTags\Application\Query\Vocabularies\SearchInVocabularies\SearchInVocabulariesQuery;

final class GetSearchVocabulariesController extends AbstractController
{
    const DEFAULT_LANG_SEARCH = '';
    const DEFAULT_LANG_LABEL = '';
    const DEFAULT_SCHEMA ='json-ld';
    const DEFAULT_VOCABULARIES = 'all';
    const DEFAULT_MODE = 'strict';
    const DEFAULT_SUGGESTIONS = false;
    
    use HandleTrait;

    public function __construct(MessageBusInterface $commandBus)
    {
        $this->messageBus = $commandBus;
    }

    public function __invoke(Request $request): JsonResponse
    {

        $query = $request->get('q');
        $vocabulary = $request->get('vocabulary', self::DEFAULT_VOCABULARIES);
        $mode = $request->get('mode', self::DEFAULT_MODE);
        $langsearch = $request->get('langsearch', self::DEFAULT_LANG_SEARCH);
        $langlabel = $request->get('langlabel', self::DEFAULT_LANG_SEARCH);
        $schema = $request->get('schema', self::DEFAULT_SCHEMA);
        $suggestions = $request->get('schema', self::DEFAULT_SUGGESTIONS);
        $tagId = $request->get('id');

        $suggestions = ($suggestions == true  && $suggestions !== self::DEFAULT_SUGGESTIONS) ? true : self::DEFAULT_SUGGESTIONS; 

        
        $search = $this->handle(
            SearchInVocabulariesQuery::create($vocabulary, $query, $mode, $langsearch, $langlabel, $schema, $suggestions, $tagId)
        );

        return  new JsonResponse($search, Response::HTTP_OK);

    }

    public function isLoggedUserAllowed(): bool
    {
        // TODO Implements auth logic
        return true;
    }
}
