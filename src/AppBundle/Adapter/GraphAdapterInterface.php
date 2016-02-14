<?php

namespace AppBundle\Adapter;

use Uniregistry\Model\Graph;

interface GraphAdapterInterface
{
    public function getGraph(Graph $graph);
}
