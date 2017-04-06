<?php
/**
 * Created by PhpStorm.
 * User: RicardoHenrique
 * Date: 05/04/2017
 * Time: 21:21
 */

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class PeopleController extends Controller
{

    /**
     * @Route("/people.json")
     * @Method("GET")
     */
    public function indexAction()
    {
        $manager = $this->getDoctrine()->getManager();
        $people = $manager->getRepository('AppBundle:Person')->findAll();

        if (!$people) {
            return new JsonResponse([
                'success' => false,
                'message' => 'Empty database.',
            ]);
        }

        $arrReturn = [];

        foreach ($people as $person) {
            $arrReturn[] = $person->toString();
        }

        return new JsonResponse([
                'success' => true,
                'rows' => $arrReturn,
                'total' => count($arrReturn),
        ]);
    }
}