<?php

namespace Uniregistry\Tests\Parser;

use JMS\Serializer\EventDispatcher\EventDispatcher;
use JMS\Serializer\SerializerBuilder;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validation;
use Uniregistry\Listener\Serializer\PreDeserializeSubscribe;
use Uniregistry\Model\Path;
use Uniregistry\Parser\JsonQueryParser;

class JsonQueryParserTest extends \PHPUnit_Framework_TestCase
{
    private $serializer;
    private $validator;

    public function setUp()
    {
        $builder = SerializerBuilder::create();
        $builder->configureListeners(function(EventDispatcher $dispatcher) {
            $dispatcher->addSubscriber(new PreDeserializeSubscribe());
        });
        $this->serializer = $builder->build();
        $this->validator = Validation::createValidatorBuilder()->enableAnnotationMapping()->getValidator();
    }

    /**
     * @test
     */
    public function validDocument()
    {
        $parser = new JsonQueryParser($this->serializer);
        $json = file_get_contents(__DIR__.'/../Features/Parser/Query/Json/ValidDocument.json');

        $query = $parser->setJson($json)->getQuery();

        ### Query ###
        $this->assertInstanceOf('Uniregistry\Model\Query', $query);
        $this->assertCount(0, $this->validator->validate($query));
        $this->assertInstanceOf('Doctrine\Common\Collections\ArrayCollection', $query->getPaths());
        $this->assertInstanceOf('Doctrine\Common\Collections\ArrayCollection', $query->getCheapest());
        $this->assertCount(2, $query->getPaths());
        $this->assertCount(1, $query->getCheapest());

        ### Paths ###
        /** @var Path $firstPath */
        $firstPath = $query->getPaths()->first();
        $this->assertInstanceOf('Uniregistry\Model\Path', $firstPath);
        $this->assertSame('a', $firstPath->getStart());
        $this->assertSame('c', $firstPath->getEnd());
        /** @var Path $lastPath */
        $lastPath = $query->getPaths()->last();
        $this->assertInstanceOf('Uniregistry\Model\Path', $lastPath);
        $this->assertSame('a', $lastPath->getStart());
        $this->assertSame('e', $lastPath->getEnd());
        /** @var Path $firstPath */
        $firstPath = $query->getCheapest()->first();
        $this->assertInstanceOf('Uniregistry\Model\Path', $firstPath);
        $this->assertSame('b', $firstPath->getStart());
        $this->assertSame('d', $firstPath->getEnd());
    }

    /**
     * @test
     */
    public function onlyCheapestDocument()
    {
        $parser = new JsonQueryParser($this->serializer);
        $json = file_get_contents(__DIR__.'/../Features/Parser/Query/Json/OnlyCheapestDocument.json');

        $query = $parser->setJson($json)->getQuery();

        ### Query ###
        $this->assertInstanceOf('Uniregistry\Model\Query', $query);
        $this->assertCount(0, $this->validator->validate($query));
        $this->assertInstanceOf('Doctrine\Common\Collections\ArrayCollection', $query->getPaths());
        $this->assertInstanceOf('Doctrine\Common\Collections\ArrayCollection', $query->getCheapest());
        $this->assertCount(0, $query->getPaths());
        $this->assertCount(1, $query->getCheapest());

        ### Paths ###
        /** @var Path $firstPath */
        $firstPath = $query->getCheapest()->first();
        $this->assertInstanceOf('Uniregistry\Model\Path', $firstPath);
        $this->assertSame('b', $firstPath->getStart());
        $this->assertSame('d', $firstPath->getEnd());
    }

    /**
     * @test
     */
    public function onlyPathsDocument()
    {
        $parser = new JsonQueryParser($this->serializer);
        $json = file_get_contents(__DIR__.'/../Features/Parser/Query/Json/OnlyPathsDocument.json');

        $query = $parser->setJson($json)->getQuery();

        ### Query ###
        $this->assertInstanceOf('Uniregistry\Model\Query', $query);
        $this->assertCount(0, $this->validator->validate($query));
        $this->assertInstanceOf('Doctrine\Common\Collections\ArrayCollection', $query->getPaths());
        $this->assertInstanceOf('Doctrine\Common\Collections\ArrayCollection', $query->getCheapest());
        $this->assertCount(2, $query->getPaths());
        $this->assertCount(0, $query->getCheapest());

        ### Paths ###
        /** @var Path $firstPath */
        $firstPath = $query->getPaths()->first();
        $this->assertInstanceOf('Uniregistry\Model\Path', $firstPath);
        $this->assertSame('a', $firstPath->getStart());
        $this->assertSame('c', $firstPath->getEnd());
        /** @var Path $lastPath */
        $lastPath = $query->getPaths()->last();
        $this->assertInstanceOf('Uniregistry\Model\Path', $lastPath);
        $this->assertSame('a', $lastPath->getStart());
        $this->assertSame('e', $lastPath->getEnd());
    }

    /**
     * @test
     */
    public function noPathsDocument()
    {
        $parser = new JsonQueryParser($this->serializer);
        $json = file_get_contents(__DIR__.'/../Features/Parser/Query/Json/NoPathsDocument.json');

        $query = $parser->setJson($json)->getQuery();

        ### Query ###
        $this->assertInstanceOf('Uniregistry\Model\Query', $query);
        /** @var ConstraintViolationList $errors */
        $errors = $this->validator->validate($query);
        $this->assertCount(1, $errors);
        $this->assertInstanceOf('Symfony\Component\Validator\ConstraintViolationList', $errors);
        $this->assertSame('At least on path must be defined', $errors->get(0)->getMessage());
        $this->assertInstanceOf('Doctrine\Common\Collections\ArrayCollection', $query->getPaths());
        $this->assertInstanceOf('Doctrine\Common\Collections\ArrayCollection', $query->getCheapest());
        $this->assertCount(0, $query->getPaths());
        $this->assertCount(0, $query->getCheapest());
    }
}