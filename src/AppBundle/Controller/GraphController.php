<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Graph;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class GraphController extends Controller
{
    /**
     * @Route("/graph/{id}/remove", name="graph_remove")
     */
    public function removeAction(Graph $graph)
    {
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($graph);
        $manager->flush();

        $this->addFlash('success', sprintf('Graph "%s" was removed successfully.', $graph->getName()));

        return $this->redirectToRoute('populate');
    }

    /**
     * @Route("/graph/example/query", name="graph_example_query")
     */
    public function exampleQueryAction()
    {
        $json = file_get_contents($this->getParameter('kernel.root_dir') . '/../src/Uniregistry/Tests/Features/Parser/Query/Json/ValidDocument.json');
        $data = json_decode($json, true);

        return new JsonResponse($data);
    }

    /**
     * @Route("/graph/example/create", name="graph_example_create")
     */
    public function exampleCreateAction()
    {
        $xml = file_get_contents($this->getParameter('kernel.root_dir') . '/../src/Uniregistry/Tests/Features/Parser/Graph/Xml/ValidDocument.xml');

        return new Response($xml, 200, ['content-type' => 'text/xml']);
    }
}