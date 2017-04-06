<?php
/**
 * Created by PhpStorm.
 * User: RicardoHenrique
 * Date: 05/04/2017
 * Time: 21:21
 */

namespace AppBundle\Controller;


use Doctrine\ORM\Query;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class OrderController extends Controller
{
    /**
     * @Route("/orders.json")
     * @Method("GET")
     */
    public function indexAction()
    {
        $manager = $this->getDoctrine()->getManager();
        $orders = $manager->getRepository('AppBundle:Order')->findAll(\Doctrine\ORM\Query::HYDRATE_ARRAY);

        if (!$orders) {
            return new JsonResponse([
                'success' => false,
                'message' => 'Empty database.',
            ]);
        }

        $arrReturn = [];

        foreach ($orders as $order) {
            $arrReturn[] = $order->toString();
        }

        return new JsonResponse([
            'success' => true,
            'rows' => $arrReturn,
            'total' => count($arrReturn),
        ]);
    }
}