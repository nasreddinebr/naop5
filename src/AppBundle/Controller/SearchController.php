<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class SearchController
 *
 * @package \AppBundle\Controller
 */
class SearchController extends Controller
{

    /**
     * @Route("/search",name="search")
     * @param Request $request
     * @return Response
     */
    public function searcheFromTermAction (Request $request){
        // Recuperate search results
        // Escapes special characters in a string
        $link = "";
        if (!empty($request->request)) {
            // Escapes special characters in a string
            $characters = $request->request->get('q');
            $results = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('AppBundle:Aves')
                ->findByName($characters);

            // If no results were found
            if (empty($results))
                return new Response("<li>Aucune espece trouver</li>");

            // Create the response and return it
            if (!empty($request->server->get('HTTPS')) && ('on' == $request->server->get('HTTPS'))) {
                $uri = 'https://';
            } else {
                $uri = 'http://';
            }
            $uri .= $request->server->get('HTTP_HOST') . '/search/result/';
            $link = "";
            foreach ($results as $result) {
                $link .= '<li class="list-group-item result"><a href="' . $uri . $result->getId() .
                    '" class="list-group-item-action">'
                    . $result->getNameVern() . ' (' . $result->getTlName() .
                    ')</a></li>';
            }
        }
        return new Response($link);
    }

    /**
     * @Route("/search/result/{id}",name="search_result",requirements={"id"="\d+"})
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function searchResultAction($id) {
        // If no id has been sent
        if (empty($id))
            throw new Exception("Id not found");

        // Retrieve the observations
        $observations = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Observation')
            ->findByAves($id);

        // Start XML file, echo parent node
        echo '<markers>';
        // Iterate through the rows, printing XML nodes for each
        foreach ($observations as $observation){
            // Add to XML document node
            echo '<marker id="' . $observation->getId() . '" lat="' . $observation->getLatitude() . '" lng="'
                . $observation->getLongitude() . '"></marker>';
        }
        // End XML file
        echo '</markers>';

        return $this->render('Core/search_result.html.twig');
    }

    /**
     * @Route("/observation/{id}",name="observation",requirements={"id"="\d+"})
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function observationAction ($id) {
        $repository = $this->getDoctrine()->getManager();
        $obsrvation = $repository
            ->getRepository('AppBundle:Observation')
            ->find($id);

        $picture = $repository->getRepository('AppBundle:Picture')
            ->findOneByObservation($id);

        return $this->render('Core/observation.html.twig', array(
            'observation'   => $obsrvation,
            'picture'       => $picture,
        ));
    }
}
