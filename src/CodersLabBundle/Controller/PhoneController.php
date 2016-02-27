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
     * @Route("/newPhone/{personId}", name = "newPhone")
     * @Method("GET")
     * @Template()
     */
    public function newPhoneAction($personId) {
        $phone = new Phone();

        $action = $this->generateUrl('newPhone', ['personId' => $personId]);
        $phoneForm = $this->generateFormPhone($phone, $action);

        return ['form' => $phoneForm->createView()];
    }

    /**
     * @Route("/newPhone/{personId}", name = "newPhoneSave")
     * @Method("POST")
     * @Template("CodersLabBundle:Phone:newPhone.html.twig")
     */
    public function newPhoneSaveAction(Request $req, $personId) {
        $phone = new Phone();

        $action = $this->generateUrl('newPhone', ['personId' => $personId]);
        $form = $this->generateFormPhone($phone, $action);

        $form->handleRequest($req);

        if ($form->isSubmitted()) {
            $repo = $this->getDoctrine()->getRepository('CodersLabBundle:Person');
            $person = $repo->find($personId);

            $phone->setPerson($person);

            $em = $this->getDoctrine()->getManager();
            $em->persist($phone);
            $em->flush();
        }

        return $this->redirectToRoute('showPerson', ['id' => $personId]);
    }

    /**
     * @Route("/modifyPhone/{phoneId}/{personId}", name = "modifyPhone")
     * @Method("GET")
     * @Template()
     */
    public function modifyPhoneAction($phoneId, $personId) {
        $repo = $this->getDoctrine()->getRepository('CodersLabBundle:Phone');
        $phone = $repo->find($phoneId);

        $action = $this->generateUrl('modifyPhone', ['phoneId' => $phoneId, 'personId' => $personId]);
        $addressForm = $this->generateFormPhone($phone, $action);

        return ['form' => $addressForm->createView()];
    }

    /**
     * @Route("/modifyPhone/{phoneId}/{personId}", name = "modifyPhoneSave")
     * @Method("POST")
     */
    public function modifyPhoneSaveAction(Request $req, $phoneId, $personId) {
        $repo = $this->getDoctrine()->getRepository('CodersLabBundle:Phone');
        $phone = $repo->find($phoneId);

        $action = $this->generateUrl('modifyPhone', ['phoneId' => $phoneId, 'personId' => $personId]);
        $addressForm = $this->generateFormPhone($phone, $action);

        $addressForm->handleRequest($req);

        if ($addressForm->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($phone);
            $em->flush();
        }

        return $this->redirectToRoute('showPerson', ['id' => $personId]);
    }

    /**
     * @Route("/deletePhone/{phoneId}/{personId}", name ="deletePhone")
     */
    public function deletePhoneAction($phoneId, $personId) {
        $repo = $this->getDoctrine()->getRepository('CodersLabBundle:Phone');
        $phone = $repo->find($phoneId);

        $em = $this->getDoctrine()->getManager();
        $em->remove($phone);
        $em->flush();

        return $this->redirectToRoute('showPerson', ['id' => $personId]);
    }

    /**
     * @Route("/showPhone/{id}", name ="showPhone")
     * @Template()
     */
    public function showPhoneAction($id) {
        $repo = $this->getDoctrine()->getRepository('CodersLabBundle:Phone');
        $phone = $repo->find($id);

        return ['phone' => $phone];
    }

    /**
     * @Route("/showAllPhones", name = "showAllPhones")
     * @Template()
     */
    public function showAllPhonesAction() {
        $repo = $this->getDoctrine()->getRepository('CodersLabBundle:Phone');
        $phones = $repo->findAll();

        return ['phones' => $phones];
    }

    /**
     * @Route("/showPhonesForPerson/{personId}")
     * @Template()
     */
    public function showPhonesForPersonAction($personId) {
        $repo = $this->getDoctrine()->getRepository('CodersLabBundle:Person');
        $person = $repo->find($personId);

        return ['person' => $person];
    }

}