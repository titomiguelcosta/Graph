<?php

namespace Uniregistry\Parser;

use Uniregistry\Model\Query;

interface QueryParserInterface
{
    /** @return Query */
    public function getQuery();
}
