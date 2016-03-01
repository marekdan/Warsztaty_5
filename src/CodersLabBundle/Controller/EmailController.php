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
        $form->add('emailAdress', 'text', ['required'=>false]);
        $form->add('type', 'text',['required'=>false]);
        $form->add('save', 'submit', ['label' => 'Submit']);
        $form->setAction($action);

        $emailForm = $form->getForm();

        return $emailForm;
    }

    /**
     * @Route("/newEmail/{personId}", name = "newEmail")
     * @Method("GET")
     * @Template()
     */
    public function newEmailAction($personId) {
        $email = new Email();

        $action = $this->generateUrl('newEmail', ['personId' => $personId]);
        $emailForm = $this->generateFormEmail($email, $action);

        return ['form' => $emailForm->createView()];
    }

    /**
     * @Route("/newEmail/{personId}", name = "newEmailSave")
     * @Method("POST")
     * @Template("CodersLabBundle:Person:newEmail.html.twig")
     */
    public function newEmailSaveAction(Request $req, $personId) {
        $email = new Email();

        $action = $this->generateUrl('newEmail', ['personId' => $personId]);
        $form = $this->generateFormEmail($email, $action);
        $form->handleRequest($req);

//        $validator = $this->get('validator');
//
//        $errors = $validator->validate($email);
//        if (count($errors) > 0) {
//            return $this->render("CodersLabBundle:Email:errorEmail.html.twig", ['errors'=>$errors]);
//            //return new Response('Blad');
//        }

        if ($form->isSubmitted() && ($form->isValid())) {
            $repo = $this->getDoctrine()->getRepository('CodersLabBundle:Person');
            $person = $repo->find($personId);

            $email->setPerson($person);

            $em = $this->getDoctrine()->getManager();
            $em->persist($email);
            $em->flush();
            return $this->redirectToRoute('showPerson', ['id' => $personId]);
        }

        return $this->render("CodersLabBundle:Email:newEmail.html.twig", ['form' => $form->createView()]);
    }

    /**
     * @Route("/modifyEmail/{emailId}/{personId}", name = "modifyEmail")
     * @Method("GET")
     * @Template()
     */
    public function modifyEmailAction($emailId, $personId) {
        $repo = $this->getDoctrine()->getRepository('CodersLabBundle:Email');
        $email = $repo->find($emailId);

        $action = $this->generateUrl('modifyEmail', ['emailId' => $emailId, 'personId' => $personId]);
        $emailForm = $this->generateFormEmail($email, $action);

        return ['form' => $emailForm->createView()];
    }

    /**
     * @Route("/modifyEmail/{emailId}/{personId}", name = "modifyEmailSave")
     * @Method("POST")
     */
    public function modifyEmailSaveAction(Request $req, $emailId, $personId) {
        $repo = $this->getDoctrine()->getRepository('CodersLabBundle:Email');
        $email = $repo->find($emailId);

        $action = $this->generateUrl('modifyEmail', ['emailId' => $emailId, 'personId' => $personId]);
        $emailForm = $this->generateFormEmail($email, $action);

        $emailForm->handleRequest($req);

        if ($emailForm->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($email);
            $em->flush();
        }

        return $this->redirectToRoute('showPerson', ['id' => $personId]);
    }

    /**
     * @Route("/deleteEmail/{emailId}/{personId}", name ="deleteEmail")
     */
    public function deleteEmailAction($emailId, $personId) {
        $repo = $this->getDoctrine()->getRepository('CodersLabBundle:Email');
        $email = $repo->find($emailId);

        $em = $this->getDoctrine()->getManager();
        $em->remove($email);
        $em->flush();

        return $this->redirectToRoute('showPerson', ['id' => $personId]);
    }

    /**
     * @Route("/showEmail/{emailId}", name ="showEmail")
     * @Template()
     */
    public function showEmailAction($emailId) {
        $repo = $this->getDoctrine()->getRepository('CodersLabBundle:Email');
        $email = $repo->find($emailId);

        return ['email' => $email];
    }

    /**
     * @Route("/showAllEmails", name = "showAllEmails")
     * @Template()
     */
    public function showAllEmailsAction() {
        $repo = $this->getDoctrine()->getRepository('CodersLabBundle:Email');
        $emails = $repo->findAll();

        return ['emails' => $emails];
    }
}
