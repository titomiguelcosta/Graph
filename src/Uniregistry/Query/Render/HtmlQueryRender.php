<?php

namespace Uniregistry\Query\Render;

use AppBundle\Repository\EdgeRepository;

use Symfony\Component\Templating\EngineInterface;
use Uniregistry\Model\Graph;
use Uniregistry\Model\Path;
use Uniregistry\Model\Query;

class HtmlQueryRender implements QueryRenderInterface
{
    /** @var EdgeRepository */
    protected $edgeRepository;

    /** @var EngineInterface */
    protected $templateEngine;

    /**
     * @param EdgeRepository $edgeRepository
     */
    public function __construct(EdgeRepository $edgeRepository, EngineInterface $templateEngine)
    {
        $this->edgeRepository = $edgeRepository;
        $this->templateEngine = $templateEngine;
    }

    public function render(Graph $graph, Query $query)
    {
        $paths = [];
        /** @var Path $path */
        foreach($query->getPaths() as $path) {
            $results = $this
                ->edgeRepository
                ->getPaths($graph->getId(), $path->getStart(), $path->getEnd());
            $paths[] = ['path' => $path, 'results' => $results];
        }

        $cheapest = [];
        /** @var Path $path */
        foreach($query->getCheapest() as $path) {
            $results = $this
                ->edgeRepository
                ->getPaths($graph->getId(), $path->getStart(), $path->getEnd());
            $cheapest[] = ['path' => $path, 'result' => array_shift($results)];
        }

        return $this->templateEngine->render($this->template(), ['paths' => $paths, 'cheapest' => $cheapest]);
    }

    protected function template()
    {
        $html = <<<HTML
            <h2>Answers</h2>

            <h3>Paths</h3>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Path</th>
                        <th>Length</th>
                    </tr>
                </thead>
                <tbody>
                    {% for answer in paths %}
                        <tr>
                            <td colspan="2"><strong>{{ answer.path.start }} -&gt; {{ answer.path.end }}</strong></td>
                        </tr>
                        {% for result in answer.results %}
                            <tr>
                                <td>{{ result.path_ids }}</td>
                                <td>{{ result.length }}</td>
                            </tr>
                        {% endfor %}
                    {% else %}
                        <tr>
                            <td colspan="2">No answers.</td>
                        </tr>
                    {% endfor %}
                </tbody>
            </table>

            <hr>

            <h3>Cheapest</h3>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Query</th>
                        <th>Path</th>
                        <th>Length</th>
                    </tr>
                </thead>
                <tbody>
                    {% for result in cheapest %}
                        <tr>
                            <td><strong>{{ result.path.start }} -&gt; {{ result.path.end }}</strong></td>
                            <td>{{ result.result.path_ids }}</td>
                            <td>{{ result.result.length }}</td>
                        </tr>
                    {% else %}
                        <tr>
                            <td colspan="2">No answers.</td>
                        </tr>
                    {% endfor %}
                </tbody>
            </table>
HTML;

        return $html;
    }
}