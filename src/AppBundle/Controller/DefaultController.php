<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Graph;
use AppBundle\Form\QueryGraphType;
use AppBundle\Form\ValidateGraphType;
use Doctrine\DBAL\DBALException;
use JMS\Serializer\Exception\XmlErrorException;
use JsonSchema\Exception\JsonDecodingException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Uniregistry\Model\Path;

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
     * @Route("/validate", name="validate")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function validateAction(Request $request)
    {
        $form = $this->createForm(ValidateGraphType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $xml = $form->get('xml')->getData();

            try {
                $graph = $this->get('uniregistry.parser.graph.xml')->setXml($xml)->getGraph();
                $errors = $this->get('validator')->validate($graph);
                if (0 === count($errors)) {
                    $this->addFlash('success', 'It is a xml valid document representing a graph.');
                    $this->addFlash('document', $xml);

                    return $this->redirectToRoute('validate');
                } else {
                    $form->addError(new FormError($errors));
                    $this->addFlash('error', 'Invalid xml document.');
                }
            } catch (XmlErrorException $e) {
                $form->addError(new FormError($e->getMessage()));
            }
        }

        return $this->render('AppBundle::validate.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/populate", name="populate")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function populateAction(Request $request)
    {
        $form = $this->createForm(ValidateGraphType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $xml = $form->get('xml')->getData();

            try {
                $graph = $this->get('uniregistry.parser.graph.xml')->setXml($xml)->getGraph();
                $errors = $this->get('validator')->validate($graph);

                if (0 === count($errors)) {
                    $entity = $this->get('uniregistry.adapter.entity')->getGraph($graph);

                    $this->get('doctrine.orm.default_entity_manager')->persist($entity);

                    $this->get('doctrine.orm.default_entity_manager')->flush();
                    $this->addFlash('success', 'New graph added.');

                    return $this->redirectToRoute('populate');
                } else {
                    $form->addError(new FormError($errors));
                    $this->addFlash('error', 'Invalid document.');
                }
            } catch (XmlErrorException $e) {
                $form->addError(new FormError($e->getMessage()));
            } catch (DBALException $e) {
                $form->addError(new FormError($e->getMessage()));
            }
        }

        $graphs = $this->getDoctrine()->getRepository('AppBundle:Graph')->findAll();

        return $this->render('AppBundle::populate.html.twig', ['form' => $form->createView(), 'graphs' => $graphs]);
    }

    /**
     * @Route("/query", name="query")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function queryAction(Request $request)
    {
        $graphs = $this->getDoctrine()->getRepository('AppBundle:Graph')->findAll();
        $answers = '';

        $form = $this->createForm(QueryGraphType::class, null, ['graphs' => $graphs]);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $graph = $this->getDoctrine()->getRepository('AppBundle:Graph')->find($form->get('graph')->getData());
            $json = $form->get('json')->getData();
            $format = $form->get('format')->getData();

            try {
                $query = $this->get('uniregistry.parser.query.json')->setJson($json)->getQuery();
                $errors = $this->get('validator')->validate($query);
                if (0 === count($errors)) {
                    $answers = $this->get('uniregistry.query.render.'.$format)->render($graph, $query);

                    if ('json' === $format) {
                        return new Response($answers, 200, ['content-type' => 'application/json']);
                    }
                } else {
                    $form->addError(new FormError($errors));
                    $this->addFlash('error', 'Invalid json document.');
                }
            } catch (JsonDecodingException $e) {
                $form->addError(new FormError($e->getMessage()));
            } catch (\RuntimeException $e) {
                $form->addError(new FormError($e->getMessage()));
            }
        }

        return $this->render('AppBundle::query.html.twig', ['form' => $form->createView(), 'graphs' => $graphs, 'answers' => $answers]);
    }
}
