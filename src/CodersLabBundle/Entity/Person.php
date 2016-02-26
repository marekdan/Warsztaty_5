<?php

namespace CodersLabBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * Person
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="CodersLabBundle\Entity\PersonRepository")
 */
class Person {

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
     * @ORM\Column(name="name", type="string", length=60)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="surname", type="string", length=60)
     */
    private $surname;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=100)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity = "Adress", mappedBy="person")
     */
    private $adresses;

    /**
     * @ORM\OneToOne(targetEntity = "Phone", mappedBy="person")
     */
    private $phones;

    /**
     * @ORM\OneToOne(targetEntity = "Email", mappedBy="person")
     */
    private $emails;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Person
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set surname
     *
     * @param string $surname
     * @return Person
     */
    public function setSurname($surname) {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Get surname
     *
     * @return string
     */
    public function getSurname() {
        return $this->surname;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Person
     */
    public function setDescription($description) {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Set adresses
     *
     * @param \CodersLabBundle\Entity\Adress $adresses
     * @return Person
     */
    public function setAdresses(\CodersLabBundle\Entity\Adress $adresses = null) {
        $this->adresses = $adresses;

        return $this;
    }

    /**
     * Get adresses
     *
     * @return \CodersLabBundle\Entity\Adress
     */
    public function getAdresses() {
        return $this->adresses;
    }

    /**
     * Set phones
     *
     * @param \CodersLabBundle\Entity\Phone $phones
     * @return Person
     */
    public function setPhones(\CodersLabBundle\Entity\Phone $phones = null) {
        $this->phones = $phones;

        return $this;
    }

    /**
     * Get phones
     *
     * @return \CodersLabBundle\Entity\Phone
     */
    public function getPhones() {
        return $this->phones;
    }

    /**
     * Set emails
     *
     * @param \CodersLabBundle\Entity\Email $emails
     * @return Person
     */
    public function setEmails(\CodersLabBundle\Entity\Email $emails = null) {
        $this->emails = $emails;

        return $this;
    }

    /**
     * Get emails
     *
     * @return \CodersLabBundle\Entity\Email
     */
    public function getEmails() {
        return $this->emails;
    }

    /**
     * Constructor
     */
    public function __construct() {
        $this->adresses = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add adresses
     *
     * @param \CodersLabBundle\Entity\Adress $adresses
     * @return Person
     */
    public function addAdress(\CodersLabBundle\Entity\Adress $adresses) {
        $this->adresses[] = $adresses;

        return $this;
    }

    /**
     * Remove adresses
     *
     * @param \CodersLabBundle\Entity\Adress $adresses
     */
    public function removeAdress(\CodersLabBundle\Entity\Adress $adresses) {
        $this->adresses->removeElement($adresses);
    }
}
