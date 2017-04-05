<?php
/**
 * Created by PhpStorm.
 * User: RicardoHenrique
 * Date: 03/04/2017
 * Time: 20:30
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="people")
 */
class Person
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=60)
     */
    private $name;

    /**
     * One Person has many Phones.
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Phone", mappedBy="person")
     */
    private $phones;

    /**
     * One Person has many Addresses.
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Address", mappedBy="person")
     */
    private $addresses;

    public function __construct()
    {
        $this->phones = new ArrayCollection();
        $this->addresses = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Person
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return Person
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPhones()
    {
        return $this->phones;
    }

    /**
     * @param mixed $phones
     * @return Person
     */
    public function setPhones($phones)
    {
        $this->phones = $phones;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddresses()
    {
        return $this->addresses;
    }

    /**
     * @param mixed $addresses
     * @return Person
     */
    public function setAddresses($addresses)
    {
        $this->addresses = $addresses;
        return $this;
    }
}