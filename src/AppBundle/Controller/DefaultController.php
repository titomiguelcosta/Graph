<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        return $this->render('AppBundle::homepage.html.twig');
    }

    /**
     * @Route("/populate", name="populate")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function populateAction(Request $request)
    {
        $xml = $request->request->get('xml', '');

        $graph = $this->get('uniregistry.parser.xml')->setXml($xml)->getGraph();
        $errors = $this->get('validator')->validate($graph);

        if (0 === count($errors)) {
            $entity = $this->get('uniregistry.adapter.entity')->getGraph($graph);

            $application = new Application($this->get('kernel'));
            $application->setAutoExit(false);

            // Drop old database
            $options = array('command' => 'doctrine:database:drop', '--force' => true);
            $application->run(new ArrayInput($options));

            // Make sure we close the original connection because it lost the reference to the database
            $this->get('doctrine.orm.default_entity_manager')->getConnection()->close();

            // Create new database
            $options = array('command' => 'doctrine:database:create');
            $application->run(new ArrayInput($options));

            // Update schema
            $options = array('command' => 'doctrine:schema:update','--force' => true);
            $application->run(new ArrayInput($options));

            $this->get('doctrine.orm.default_entity_manager')->persist($entity);
            $this->get('doctrine.orm.default_entity_manager')->flush();
        } else {
            throw new BadRequestHttpException('Invalid document: '. $errors);
        }

        return $this->redirectToRoute('homepage');
    }
}
