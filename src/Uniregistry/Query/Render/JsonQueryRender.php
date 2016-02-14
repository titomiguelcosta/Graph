<?php

namespace Uniregistry\Query\Render;

use AppBundle\Repository\EdgeRepository;
use Uniregistry\Model\Graph;
use Uniregistry\Model\Path;
use Uniregistry\Model\Query;

class JsonQueryRender implements QueryRenderInterface
{
    /** @var EdgeRepository */
    protected $edgeRepository;

    /**
     * @param EdgeRepository $edgeRepository
     */
    public function __construct(EdgeRepository $edgeRepository)
    {
        $this->edgeRepository = $edgeRepository;
    }

    public function render(Graph $graph, Query $query)
    {
        /** @var Path $path */
        foreach ($query->getPaths() as $path) {
            $results = $this
                ->edgeRepository
                ->getPaths($graph->getId(), $path->getStart(), $path->getEnd());
            $result = [
                'from' => $path->getStart(),
                'to' => $path->getEnd()
            ];
            if (count($results) > 0) {
                foreach ($results as $answer) {
                    $result['paths'][] = $answer['path_ids'];
                }
            } else {
                $result['paths'] = [];
            }
            $paths['answers']['paths'][] = $result;
        }

        /** @var Path $path */
        foreach ($query->getCheapest() as $path) {
            $results = $this
                ->edgeRepository
                ->getPaths($graph->getId(), $path->getStart(), $path->getEnd());
            $result = [
                'from' => $path->getStart(),
                'to' => $path->getEnd(),
                'path' => count($results) > 0
                    ? array_shift($results)['path_ids']
                    : false
            ];
            $paths['answers']['cheapest'][] = $result;
        }

        return json_encode($paths);
    }
}
