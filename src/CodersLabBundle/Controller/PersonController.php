<?php

namespace CodersLabBundle\Controller;


use CodersLabBundle\Entity\Person;
use CodersLabBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PersonController extends Controller {

    public function generateFormPerson($person, $action) {
        $form = $this->createFormBuilder($person);
        $form->add('name', 'text');
        $form->add('surname', 'text');
        $form->add('description', 'text');
        $form->add('save', 'submit', ['label' => 'Submit']);

        $form->setAction($action);

        $personForm = $form->getForm();

        return $personForm;
    }

    /**
     * @Route("/newPerson/{userId}", name = "newPerson")
     * @Method("GET")
     * @Template()
     */
    public function newPersonAction($userId) {
        $person = new Person();

        $action = $this->generateUrl('newPerson');
        $personForm = $this->generateFormPerson($person, $action);

        $repoUser = $this->getDoctrine()->getRepository('CodersLabBundle:User');
        $user = $repoUser->find($userId);

        $person->addUser($user);

        return ['form' => $personForm->createView()];
    }

    /**
     * @Route("/newPerson/{userId}", name = "newPersonSave")
     * @Method("POST")
     * @Template("CodersLabBundle:Person:newPerson.html.twig")
     */
    public function newPersonSaveAction(Request $req, $userId) {
        $person = new Person();

        $action = $this->generateUrl('newPerson');
        $form = $this->generateFormPerson($person, $action);

        $form->handleRequest($req);

        $repoUser = $this->getDoctrine()->getRepository('CodersLabBundle:User');
        $user = $repoUser->find($userId);

        $person->addUser($user);

        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($person);
            $em->flush();
        }
        $id = $person->getId();

        return $this->redirectToRoute('showPerson', ['id' => $id]);
    }

    /**
     * @Route("/modifyPerson/{id}", name ="modifyPerson")
     * @Method("GET")
     * @Template()
     */
    public function modifyPersonAction($id) {
        $repo = $this->getDoctrine()->getRepository('CodersLabBundle:Person');
        $person = $repo->find($id);

        $action = $this->generateUrl('modifyPerson', ['id' => $id]);
        $personForm = $this->generateFormPerson($person, $action);

        return ['form' => $personForm->createView()];
    }

    /**
     * @Route("/modifyPerson/{id}", name ="modifyPersonSave")
     * @Method("POST")
     */
    public function modifyPersonSaveAction(Request $req, $id) {
        $repo = $this->getDoctrine()->getRepository('CodersLabBundle:Person');
        $person = $repo->find($id);

        $action = $this->generateUrl('modifyPerson', ['id' => $id]);
        $personForm = $this->generateFormPerson($person, $action);

        $personForm->handleRequest($req);

        if ($personForm->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($person);
            $em->flush();
        }

        return $this->redirectToRoute('showPerson', ['id' => $id]);
    }

    /**
     * @Route("/deletePerson/{id}", name = "deletePerson")
     */
    public function deletePersonAction($id) {
        $repo = $this->getDoctrine()->getRepository('CodersLabBundle:Person');
        $person = $repo->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($person);
        $em->flush();

        return new Response('Person Deleted');
    }

    /**
     * @Route("/showPerson/{id}", name ="showPerson")
     * @Template()
     */
    public function showPersonAction($id) {
        $repo = $this->getDoctrine()->getRepository('CodersLabBundle:Person');
        $person = $repo->find($id);

        return ['person' => $person];
    }

    /**
     * @Route("/showAll", name = "showAll")
     * @Template()
     */
    public function showAllPersonAction() {
        $repo = $this->getDoctrine()->getRepository('CodersLabBundle:Person');
        $persons = $repo->findAll();

        return ['persons' => $persons];
    }
}
