<?php
/**
 * Created by PhpStorm.
 * User: RicardoHenrique
 * Date: 02/04/2017
 * Time: 21:55
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Address;
use AppBundle\Entity\Order;
use AppBundle\Entity\OrderItem;
use AppBundle\Entity\Person;
use AppBundle\Entity\Phone;
use AppBundle\Entity\Product;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ImportController extends Controller
{

    /**
     * @Route("/import")
     */
    public function importAction(Request $request)
    {
        $file = $request->files->get('files');

        $file = reset($file);

        $uploadedFile = $this->_doUpload($file);

        $parsedFile = $this->_parseFile($uploadedFile);

        return new Response("OK");
    }

    private function _parseFile($uploadedFile)
    {
        if (file_exists($uploadedFile)) {
            $xml = simplexml_load_file($uploadedFile);

            $manager = $this->getDoctrine()->getManager();

            foreach ($xml as $key => $value) {
                switch ($key) {
                    case 'person' :
                        $this->persistPerson($value);
                        break;

                    case 'shiporder' :
                        $this->persistOrder($value);
                        break;
                }
            }

            //$manager->flush();

            die();
        }
    }

    private function _doUpload($file)
    {
        $originalName = $file->getClientOriginalName();

        $pathTemp = $file->getPathname();

        $baseDir = (realpath($this->container->getParameter('kernel.root_dir').'/..'));

        $uploadDir = $baseDir
            . DIRECTORY_SEPARATOR
            . 'web'
            . DIRECTORY_SEPARATOR
            . 'uploads';

        $pathFile = $uploadDir . DIRECTORY_SEPARATOR . $originalName;

        if (!is_dir($uploadDir)) {
            $created = mkdir($uploadDir, umask(), true);

            if (!$created) {
                throw new \RuntimeException("Não foi possível criar a pasta para armazenar o arquivo.");
            }
        }

        $uploaded = $file->move($uploadDir, $pathFile);

        if ($uploaded) {
            return $pathFile;
        }

        return NULL;
    }

    public function persistPerson($data)
    {
        $manager = $this->getDoctrine()->getManager();
        $personExists = $manager->getRepository('AppBundle:Person')->find($data->personid);

        if (!$personExists) {
            $person = new Person();
            $person->setName($data->personname);

            $manager->persist($person);
        }

        foreach ($data->phones as $phone) {
            foreach($phone as $phoneNumber) {
                $phone = new Phone();
                $phone->setPerson($person);
                $phone->setPhone($phoneNumber);

                $manager->persist($phone);
            }
        }

        $manager->flush();
    }

    public function persistOrder($data)
    {
        $manager = $this->getDoctrine()->getManager();
        $order = $manager->getRepository('AppBundle\Entity\Person')->find($data->orderid);

        if ($order) {
            $person = $manager->getRepository('AppBundle\Entity\Person')->find($data->orderperson);

            if ($person) {
                $address = new Address();
                $address->setPerson($person);
                $address->setAddress($data->shipto->address);
                $address->setCity($data->shipto->city);
                $address->setCountry($data->shipto->country);

                $manager->persist($address);

                $order = new Order();
                $order->setPerson($person);
                $order->setDelivery($address);

                $manager->persist($order);

                foreach ($data->items as $item) {
                    foreach ($item as $itemData) {
                        $product = new Product();
                        $product->setTitle($itemData->title);
                        $product->setPrice($itemData->price);

                        $manager->persist($product);

                        $orderItem = new OrderItem();
                        $orderItem->setOrder($order);
                        $orderItem->setProduct($product);
                        $orderItem->setQuantity($itemData->quantity);

                        $manager->persist($orderItem);
                    }
                }

                $manager->flush();
            }
        }
    }

}