<?php

namespace AppBundle\Adapter;

use Uniregistry\Model\Edge;
use Uniregistry\Model\Graph;
use Uniregistry\Model\Node;
use AppBundle\Entity\Edge as EntityEdge;
use AppBundle\Entity\Node as EntityNode;
use AppBundle\Entity\Graph as EntityGraph;

class EntityAdapter implements GraphAdapterInterface
{
    /**
     * @param Graph $g
     * @return EntityGraph
     */
    public function getGraph(Graph $g)
    {
        $graph = new EntityGraph();
        $graph->setId($g->getId());
        $graph->setName($g->getName());

        /** @var Node $n */
        foreach ($g->getNodes() as $n) {
            $node = $this->castNode($n);
            $graph->addNode($node);
        }

        /** @var Edge $e */
        foreach($g->getEdges() as $e) {
            $edge = $this->castEdge($e, $graph);
            $graph->addEdge($edge);
        }

        return $graph;
    }

    /**
     * @param Node $n
     * @return EntityNode
     */
    private function castNode(Node $n)
    {
        $node = new EntityNode();
        $node->setId($n->getId());
        $node->setName($n->getName());

        return $node;
    }

    /**
     * @param Edge $e
     * @param EntityGraph $graph
     * @return EntityEdge
     */
    private function castEdge(Edge $e, EntityGraph $graph)
    {
        $edge = new EntityEdge();
        $edge->setId($e->getId());
        $edge->setCost($e->getCost());

        $nodeFrom = $graph->getNode($e->getFrom()->getId());
        if ($nodeFrom instanceof EntityNode) {
            $edge->setFrom($nodeFrom);
            $nodeFrom->addFromEdge($edge);
        }

        $nodeTo = $graph->getNode($e->getTo()->getId());
        if ($nodeTo instanceof EntityNode) {
            $edge->setTo($nodeTo);
            $nodeTo->addToEdge($edge);
        }

        return $edge;
    }
}