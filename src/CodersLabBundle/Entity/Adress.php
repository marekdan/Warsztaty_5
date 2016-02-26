<?php

namespace CodersLabBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * Adress
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="CodersLabBundle\Entity\AdressRepository")
 */
class Adress {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=70)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="street", type="string", length=70)
     */
    private $street;

    /**
     * @var integer
     *
     * @ORM\Column(name="houseNumber", type="integer")
     */
    private $houseNumber;

    /**
     * @var integer
     *
     * @ORM\Column(name="flatNumber", type="integer")
     */
    private $flatNumber;

    /**
     * @ORM\ManyToOne(targetEntity="Person", inversedBy="adresses")
     * @ORM\JoinColumn(name="person_id", referencedColumnName="id")
     */
    private $person;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return Adress
     */
    public function setCity($city) {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity() {
        return $this->city;
    }

    /**
     * Set street
     *
     * @param string $street
     * @return Adress
     */
    public function setStreet($street) {
        $this->street = $street;

        return $this;
    }

    /**
     * Get street
     *
     * @return string
     */
    public function getStreet() {
        return $this->street;
    }

    /**
     * Set houseNumber
     *
     * @param integer $houseNumber
     * @return Adress
     */
    public function setHouseNumber($houseNumber) {
        $this->houseNumber = $houseNumber;

        return $this;
    }

    /**
     * Get houseNumber
     *
     * @return integer
     */
    public function getHouseNumber() {
        return $this->houseNumber;
    }

    /**
     * Set flatNumber
     *
     * @param integer $flatNumber
     * @return Adress
     */
    public function setFlatNumber($flatNumber) {
        $this->flatNumber = $flatNumber;

        return $this;
    }

    /**
     * Get flatNumber
     *
     * @return integer
     */
    public function getFlatNumber() {
        return $this->flatNumber;
    }

    /**
     * Set person
     *
     * @param \CodersLabBundle\Entity\Person $person
     * @return Adress
     */
    public function setPerson(\CodersLabBundle\Entity\Person $person = null) {
        $this->person = $person;

        return $this;
    }

    /**
     * Get person
     *
     * @return \CodersLabBundle\Entity\Person
     */
    public function getPerson() {
        return $this->person;
    }
}
