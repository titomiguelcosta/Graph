<?php

namespace Uniregistry\Parser;

use Uniregistry\Model\Graph;

interface ParserInterface
{
    /** @return Graph */
    public function getGraph();
}