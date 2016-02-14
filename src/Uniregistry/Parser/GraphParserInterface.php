<?php

namespace Uniregistry\Parser;

use Uniregistry\Model\Graph;

interface GraphParserInterface
{
    /** @return Graph */
    public function getGraph();
}
