<?php

namespace CodersLabBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Email
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="CodersLabBundle\Entity\EmailRepository")
 */
class Email {

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
     * @ORM\Column(name="emailAdress", type="string", length=100)
     */
    private $emailAdress;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=50)
     * @Assert\NotBlank( message = "Type can't be empty")
     * @Assert\Choice( choices = {"Personal", "Business"}, message = "Choose correct type")
     */
    private $type;
    //@Assert\Length( min = 2, minMessage = "Too short")


    /**
     * @ORM\ManyToOne(targetEntity="Person", inversedBy="emails")
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
     * Set emailAdress
     *
     * @param string $emailAdress
     * @return Email
     */
    public function setEmailAdress($emailAdress) {
        $this->emailAdress = $emailAdress;

        return $this;
    }

    /**
     * Get emailAdress
     *
     * @return string
     */
    public function getEmailAdress() {
        return $this->emailAdress;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Email
     */
    public function setType($type) {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType() {
        return $this->type;
    }

    /**
     * Set person
     *
     * @param \CodersLabBundle\Entity\Person $person
     * @return Email
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
