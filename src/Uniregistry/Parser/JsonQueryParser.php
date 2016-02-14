<?php

namespace Uniregistry\Parser;

use JMS\Serializer\Serializer;
use Uniregistry\Model\Query;

class JsonQueryParser implements QueryParserInterface
{
    /** @var string */
    private $json;

    /** @var Serializer */
    private $serializer;

    /**
     * @param Serializer $serializer
     */
    public function __construct(Serializer $serializer)
    {
        $this->json = '';
        $this->serializer = $serializer;
    }

    /**
     * @return string
     */
    public function getJson()
    {
        return $this->json;
    }

    /**
     * @param string $json
     * @return JsonQueryParser
     */
    public function setJson($json)
    {
        $this->json = $json;

        return $this;
    }

    /**
     * @return Query
     */
    public function getQuery()
    {
        return $this->serializer->deserialize($this->json, 'Uniregistry\Model\Query', 'json');
    }
}