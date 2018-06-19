<?php

namespace CollabimApp\InternalApi;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class DataController
{
    private $dataMapper;

    public function __construct(DataMapper $dataMapper)
    {
        $this->dataMapper = $dataMapper;
    }

    /**
     * @Route(path="/internalApi/{method}/{securityEndpointKey}")
     */
    public function getDataAction(string $method, string $securityEndpointKey, Request $request)
    {
        $sql = $this->dataMapper->getQueries($method, $securityEndpointKey);
        $data = $this->dataMapper->getData($sql['prepareDataStatement'], $sql['getDataStatement']);

        return new JsonResponse($data);
    }
}
