<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Uniregistry\Model\Graph as GraphModel;

class Graph extends GraphModel
{
    public function __construct()
    {
        $this->nodes = new ArrayCollection();
        $this->edges = new ArrayCollection();
    }

    /**
     * @param Edge $edge
     * @return Graph
     */
    public function addEdge(Edge $edge)
    {
        $this->edges->add($edge);
        $edge->setGraph($this);

        return $this;
    }

    /**
     * @param Edge $edge
     */
    public function removeEdge(Edge $edge)
    {
        $this->edges->removeElement($edge);
    }

    /**
     * @param Node $node
     * @return Graph
     */
    public function addNode(Node $node)
    {
        $this->nodes->add($node);
        $node->setGraph($this);

        return $this;
    }

    /**
     * @param Node $node
     */
    public function removeNode(Node $node)
    {
        $this->nodes->removeElement($node);
    }
}
