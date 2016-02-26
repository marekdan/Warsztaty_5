<?php

namespace CodersLabBundle\Controller;


use CodersLabBundle\Entity\Person;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
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
     * @Route("/newPerson", name = "newPerson")
     * @Method("GET")
     * @Template()
     */
    public function newPersonAction() {
        $person = new Person();

        $action = $this->generateUrl('newPerson');
        $personForm = $this->generateFormPerson($person, $action);

        return ['form' => $personForm->createView()];
    }

    /**
     * @Route("/newPerson", name = "newPersonSave")
     * @Method("POST")
     * @Template("CodersLabBundle:Person:newPerson.html.twig")
     */
    public function newPersonSaveAction(Request $req) {
        $person = new Person();

        $action = $this->generateUrl('newPerson');
        $form = $this->generateFormPerson($person, $action);

        $form->handleRequest($req);

        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($person);
            $em->flush();
        }
        $id = $person->getId();

        return $this->redirectToRoute('showPerson', ['id' => $id]);
    }

    //TODO modify add POST AND GET method
    /**
     * @Route("/modifyPerson/{id}", name ="modifyPerson")
     * @Template()
     */
    public function modifyPersonAction(Request $req, $id) {
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

        return ['form' => $personForm->createView()];
    }

    /**
     * @Route("/deletePerson/{id}")
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
     * @Route("/showAll")
     * @Template()
     */
    public function showAllPersonAction() {
        $repo = $this->getDoctrine()->getRepository('CodersLabBundle:Person');
        $persons = $repo->findAll();

        return ['persons' => $persons];
    }
}
