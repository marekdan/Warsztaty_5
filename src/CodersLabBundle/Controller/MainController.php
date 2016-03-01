<?php

namespace CodersLabBundle\Controller;


use CodersLabBundle\Entity\Person;
use CodersLabBundle\Entity\PersonRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use CodersLabBundle\Entity\User;
use CodersLabBundle\Form\UserType;


class MainController extends Controller {

    /**
     * @Route("/mainSite", name = "mainSite")
     * @Template()
     */
    public function mainSiteAction() {
        return [];
    }

    /**
     * @Route("/addPersonToUser/{personId}/{userId}", name = "addPersonToUser")
     */
    public function addPersonToUserAction($personId, $userId) {
        $repo = $this->getDoctrine()->getRepository('CodersLabBundle:Person');
        $person = $repo->find($personId);

        $repo = $this->getDoctrine()->getRepository('CodersLabBundle:User');
        $user = $repo->find($userId);

        $person->addUser($user);

        $em = $this->getDoctrine()->getManager();
        $em->flush();

        return $this->redirectToRoute('showAll');
    }

    /**
     * @Route("/showContacts/{userId}")
     * @Template()
     */
    public function showContactsAction($userId){
        $repo = $this->getDoctrine()->getRepository('CodersLabBundle:User');
        $user = $repo->find($userId);

        $repoPer = $this->getDoctrine()->getRepository('CodersLabBundle:Person');

        $persons = $repoPer->findByUser($user);

        return ['persons'=>$persons];
    }
}
