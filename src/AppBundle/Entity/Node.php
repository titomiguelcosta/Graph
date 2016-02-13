<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Uniregistry\Model\Node as NodeModel;

class Node extends NodeModel
{
    /** @var Graph */
    protected $graph;

    /** @var ArrayCollection<Edge> */
    protected $fromEdges;

    /** @var ArrayCollection<Edge> */
    protected $toEdges;

    public function __construct()
    {
        $this->fromEdges = new ArrayCollection();
        $this->toEdges = new ArrayCollection();
    }

    /**
     * @return Graph
     */
    public function getGraph()
    {
        return $this->graph;
    }

    /**
     * @param Graph $graph
     * @return Node
     */
    public function setGraph(Graph $graph)
    {
        $this->graph = $graph;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getFromEdges()
    {
        return $this->fromEdges;
    }

    /**
     * @param ArrayCollection $fromEdges
     * @return Node
     */
    public function setFromEdges(ArrayCollection $fromEdges)
    {
        $this->fromEdges = $fromEdges;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getToEdges()
    {
        return $this->toEdges;
    }

    /**
     * @param ArrayCollection $toEdges
     * @return Node
     */
    public function setToEdges(ArrayCollection $toEdges)
    {
        $this->toEdges = $toEdges;

        return $this;
    }

    /**
     * @param Edge $fromEdge
     * @return Node
     */
    public function addFromEdge(Edge $fromEdge)
    {
        $this->fromEdges->add($fromEdge);

        return $this;
    }

    /**
     * @param Edge $fromEdge
     */
    public function removeFromEdge(Edge $fromEdge)
    {
        $this->fromEdges->removeElement($fromEdge);
    }

    /**
     * @param \AppBundle\Entity\Edge $toEdge
     * @return Node
     */
    public function addToEdge(Edge $toEdge)
    {
        $this->toEdges->add($toEdge);

        return $this;
    }

    /**
     * @param \AppBundle\Entity\Edge $toEdge
     */
    public function removeToEdge(Edge $toEdge)
    {
        $this->toEdges->removeElement($toEdge);
    }
}
