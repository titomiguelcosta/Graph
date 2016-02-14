<?php

namespace Uniregistry\Tests\Parser;

use JMS\Serializer\EventDispatcher\EventDispatcher;
use JMS\Serializer\SerializerBuilder;
use Symfony\Component\Validator\Validation;
use Uniregistry\Listener\Serializer\PostDeserializeSubscribe;
use Uniregistry\Model\Edge;
use Uniregistry\Model\Node;
use Uniregistry\Parser\XmlGraphParser;

class XmlGraphParserTest extends \PHPUnit_Framework_TestCase
{
    private $serializer;
    private $validator;

    public function setUp()
    {
        $builder = SerializerBuilder::create();
        $builder->configureListeners(function (EventDispatcher $dispatcher) {
            $dispatcher->addSubscriber(new PostDeserializeSubscribe());
        });

        $this->serializer = $builder->build();
        $this->validator = Validation::createValidatorBuilder()->enableAnnotationMapping()->getValidator();
    }

    /**
     * @test
     */
    public function validDocument()
    {
        $parser = new XmlGraphParser($this->serializer);
        $xml = file_get_contents(__DIR__.'/../Features/Parser/Graph/Xml/ValidDocument.xml');

        $graph = $parser->setXml($xml)->getGraph();

        ### Graph ###
        $this->assertInstanceOf('Uniregistry\Model\Graph', $graph);
        $this->assertSame('g0', $graph->getId());
        $this->assertSame('The Graph Name', $graph->getName());
        $this->assertCount(0, $this->validator->validate($graph));

        ### Nodes ###
        $this->assertCount(2, $graph->getNodes());
        /** @var Node $firstNode */
        $firstNode = $graph->getNodes()->first();
        $this->assertInstanceOf('Uniregistry\Model\Node', $firstNode);
        $this->assertSame('a', $firstNode->getId());
        $this->assertSame('A name', $firstNode->getName());
        /** @var Node $lastNode */
        $lastNode = $graph->getNodes()->last();
        $this->assertInstanceOf('Uniregistry\Model\Node', $lastNode);
        $this->assertSame('e', $lastNode->getId());
        $this->assertSame('E name', $lastNode->getName());

        ### Edges ###
        $this->assertCount(2, $graph->getEdges());
        /** @var Edge $firstEdge */
        $firstEdge = $graph->getEdges()->first();
        $this->assertInstanceOf('Uniregistry\Model\Edge', $firstEdge);
        $this->assertSame('e1', $firstEdge->getId());
        $this->assertSame(42.0, $firstEdge->getCost());
        $this->assertInstanceOf('Uniregistry\Model\Node', $firstEdge->getFrom());
        $this->assertSame('a', $firstEdge->getFrom()->getId());
        $this->assertInstanceOf('Uniregistry\Model\Node', $firstEdge->getTo());
        $this->assertSame('e', $firstEdge->getTo()->getId());

        /** @var Edge $lastEdge */
        $lastEdge = $graph->getEdges()->last();
        $this->assertInstanceOf('Uniregistry\Model\Edge', $lastEdge);
        $this->assertSame('e5', $lastEdge->getId());
        $this->assertSame(0.0, $lastEdge->getCost());
        $this->assertInstanceOf('Uniregistry\Model\Node', $lastEdge->getFrom());
        $this->assertSame('a', $lastEdge->getFrom()->getId());
        $this->assertInstanceOf('Uniregistry\Model\Node', $lastEdge->getTo());
        $this->assertSame('a', $lastEdge->getTo()->getId());
    }
}
