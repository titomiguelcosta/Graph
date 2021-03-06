<?php

namespace AppBundle\Entity;

use Uniregistry\Model\Edge as EdgeModel;

class Edge extends EdgeModel
{
    /** @var Graph */
    protected $graph;

    /**
     * @return Graph
     */
    public function getGraph()
    {
        return $this->graph;
    }

    /**
     * @param Graph $graph
     */
    public function setGraph(Graph $graph)
    {
        $this->graph = $graph;
    }
}
