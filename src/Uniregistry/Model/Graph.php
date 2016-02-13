<?php

namespace Uniregistry\Model;

use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @package Uniregistry\Model
 * @JMS\AccessType("public_method")
 * @JMS\ExclusionPolicy("all")
 * @JMS\XmlRoot("graph")
 */
class Graph
{
    /**
     * @var string
     * @JMS\Expose()
     * @JMS\Type("string")
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     */
    protected $id;

    /**
     * @var string
     * @JMS\Expose()
     * @JMS\Type("string")
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     */
    protected $name;

    /**
     * @var Node[]
     * @JMS\Expose()
     * @JMS\Type("ArrayCollection<Uniregistry\Model\Node>")
     * @JMS\XmlList(entry="node")
     * @Assert\Count(min="1")
     */
    protected $nodes;

    /**
     * @var Edge[]
     * @JMS\Expose()
     * @JMS\Type("ArrayCollection<Uniregistry\Model\Edge>")
     * @JMS\XmlList(entry="node")
     *
     */
    protected $edges;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return Graph
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Graph
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return ArrayCollection<Node>
     */
    public function getNodes()
    {
        return $this->nodes;
    }

    /**
     * @param ArrayCollection $nodes
     * @return Graph
     */
    public function setNodes(ArrayCollection $nodes)
    {
        $this->nodes = $nodes;

        return $this;
    }

    /**
     * @param $id
     * @return null|Node
     */
    public function getNode($id)
    {
        $node = null;
        /** @var Node $n */
        foreach ($this->getNodes() as $n) {
            if ($id === $n->getId()) {
                $node = $n;
                break;
            }
        }

        return $node;
    }

    /**
     * @return ArrayCollection<Edge>
     */
    public function getEdges()
    {
        return $this->edges;
    }

    /**
     * @param ArrayCollection $edges
     * @return Graph
     */
    public function setEdges(ArrayCollection $edges)
    {
        $this->edges = $edges;

        return $this;
    }

    /**
     * @Assert\IsTrue(message="Node ids must be unique")
     */
    public function hasUniqueNodes()
    {
        $nodes = $this->getNodes()->toArray();
        $ids = array_map(function (Node $node) { return $node->getId(); }, $nodes);

        return count($nodes) === count(array_unique($ids));
    }
}