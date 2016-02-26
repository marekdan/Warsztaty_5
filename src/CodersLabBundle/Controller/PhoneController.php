<?php

namespace CodersLabBundle\Controller;


use CodersLabBundle\Entity\Phone;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PhoneController extends Controller {

    public function generateFormPhone($phone, $action) {
        $form = $this->createFormBuilder($phone);
        $form->add('phoneNumber', 'text');
        $form->add('type', 'text');
        $form->add('save', 'submit', ['label' => 'Submit']);

        $form->setAction($action);

        $phoneForm = $form->getForm();

        return $phoneForm;
    }

    /**
     * @Route("/newPhone", name = "newPhone")
     * @Method("GET")
     * @Template()
     */
    public function newPhoneAction() {
        $phone = new Phone();

        $action = $this->generateUrl('newPhone');
        $phoneForm = $this->generateFormPhone($phone, $action);

        return ['form' => $phoneForm->createView()];
    }

    /**
     * @Route("/newPhone", name = "newPhoneSave")
     * @Method("POST")
     * @Template("CodersLabBundle:Phone:newPhone.html.twig")
     */
    public function newPhoneSaveAction(Request $req) {
        $phone = new Phone();

        $action = $this->generateUrl('newPhone');
        $form = $this->generateFormPhone($phone, $action);

        $form->handleRequest($req);

        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($phone);
            $em->flush();
        }

        return new Response('Phone created');
    }
}
