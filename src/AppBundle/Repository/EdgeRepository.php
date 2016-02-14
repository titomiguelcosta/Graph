<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class EdgeRepository extends EntityRepository
{
    /**
     * @param $graph
     * @param $from
     * @param $to
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getPaths($graph, $from, $to)
    {
        $sql = "WITH RECURSIVE search_path (path_ids, length, is_visited, graph_id) AS
(
    SELECT
        ARRAY[node_id, destination_node_id],
        link_length,
        node_id = destination_node_id,
        graph_id
    FROM
        node_links_view
    WHERE graph_id = :graph
    UNION ALL
    SELECT
        path_ids || d.destination_node_id,
        f.length + d.link_length,
        d.destination_node_id = ANY(f.path_ids),
        d.graph_id
    FROM
        node_links_view d, search_path f
    WHERE
        f.path_ids[array_length(path_ids, 1)] = d.node_id
        AND NOT f.is_visited
)
SELECT * FROM search_path
WHERE path_ids[1] = :start AND path_ids[array_length(path_ids, 1)] = :end AND graph_id = :graph
ORDER BY length ASC";

        return $this
            ->getEntityManager()
            ->getConnection()
            ->executeQuery($sql, ['graph' => $graph, 'start' => $from, 'end' => $to])
            ->fetchAll(\PDO::FETCH_ASSOC);
    }
}