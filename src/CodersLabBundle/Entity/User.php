<?php

// src/CodersLabBundle/Entity/User.php

namespace CodersLabBundle\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 * @ORM\Entity(repositoryClass="CodersLabBundle\Entity\UserRepository")
 */
class User extends BaseUser {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToMany(targetEntity = "Person", mappedBy = "users")
     */
    private $persons;

    /**
     * Add persons
     *
     * @param \CodersLabBundle\Entity\Person $persons
     * @return User
     */
    public function addPerson(\CodersLabBundle\Entity\Person $persons)
    {
        $this->persons[] = $persons;

        return $this;
    }

    /**
     * Remove persons
     *
     * @param \CodersLabBundle\Entity\Person $persons
     */
    public function removePerson(\CodersLabBundle\Entity\Person $persons)
    {
        $this->persons->removeElement($persons);
    }

    /**
     * Get persons
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPersons()
    {
        return $this->persons;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->persons = new ArrayCollection();
    }
}
