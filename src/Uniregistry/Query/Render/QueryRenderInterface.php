<?php

namespace Uniregistry\Query\Render;

use Uniregistry\Model\Query;
use Uniregistry\Model\Graph;

interface QueryRenderInterface
{
    public function render(Graph $graph, Query $query);
}
