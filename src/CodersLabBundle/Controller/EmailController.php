<?php

namespace CodersLabBundle\Controller;


use CodersLabBundle\Entity\Email;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EmailController extends Controller {

    public function generateFormEmail($email, $action) {
        $form = $this->createFormBuilder($email);
        $form->add('emailAdress', 'text');
        $form->add('type', 'text');
        $form->add('save', 'submit', ['label' => 'Submit']);

        $form->setAction($action);

        $emailForm = $form->getForm();

        return $emailForm;
    }

    /**
     * @Route("/newEmail", name = "newEmail")
     * @Method("GET")
     * @Template()
     */
    public function newEmailAction() {
        $email = new Email();

        $action = $this->generateUrl('newEmail');
        $emailForm = $this->generateFormEmail($email, $action);

        return ['form' => $emailForm->createView()];
    }

    /**
     * @Route("/newEmail", name = "newEmailSave")
     * @Method("POST")
     * @Template("CodersLabBundle:Person:newEmail.html.twig")
     */
    public function newEmailSaveAction(Request $req) {
        $email = new Email();

        $action = $this->generateUrl('newEmail');
        $form = $this->generateFormEmail($email, $action);

        $form->handleRequest($req);

        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($email);
            $em->flush();
        }

        //return $this->redirectToRoute('showPerson', ['id' => $id]);
        return new Response('Email created');
    }
}
