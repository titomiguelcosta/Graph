<?php

namespace Uniregistry\Parser;

use JMS\Serializer\Serializer;
use Uniregistry\Model\Graph;

class XmlGraphParser implements GraphParserInterface
{
    /** @var string */
    private $xml;

    /** @var Serializer */
    private $serializer;

    /**
     * @param Serializer $serializer
     */
    public function __construct(Serializer $serializer)
    {
        $this->xml = '';
        $this->serializer = $serializer;
    }

    /**
     * @return string
     */
    public function getXml()
    {
        return $this->xml;
    }

    /**
     * @param string $xml
     * @return XmlGraphParser
     */
    public function setXml($xml)
    {
        $this->xml = $xml;

        return $this;
    }

    /**
     * @return Graph
     */
    public function getGraph()
    {
        return $this->serializer->deserialize($this->xml, 'Uniregistry\Model\Graph', 'xml');
    }
}