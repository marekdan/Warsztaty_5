<?php

namespace CodersLabBundle\Controller;


use CodersLabBundle\Entity\Adress;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AdressController extends Controller {

    public function generateFormAddress($address, $action) {
        $form = $this->createFormBuilder($address);
        $form->add('city', 'text');
        $form->add('street', 'text');
        $form->add('houseNumber', 'text');
        $form->add('flatNumber', 'text');
        $form->add('save', 'submit', ['label' => 'Submit']);

        $form->setAction($action);

        $addressForm = $form->getForm();

        return $addressForm;
    }

    /**
     * @Route("/newAddress/{personId}", name = "newAddress")
     * @Method("GET")
     * @Template()
     */
    public function newAddressAction($personId) {
        $address = new Adress();

        $action = $this->generateUrl('newAddress', ['personId' => $personId]);
        $addressForm = $this->generateFormAddress($address, $action);

        return ['form' => $addressForm->createView()];
    }

    /**
     * @Route("/newAddress/{personId}", name = "newAddressSave")
     * @Method("POST")
     * @Template("CodersLabBundle:Adress:newAdress.html.twig")
     */
    public function newAddressSaveAction(Request $req, $personId) {
        $address = new Adress();

        $action = $this->generateUrl('newAddress', ['personId' => $personId]);
        $form = $this->generateFormAddress($address, $action);

        $form->handleRequest($req);

        if ($form->isSubmitted()) {
            $repo = $this->getDoctrine()->getRepository('CodersLabBundle:Person');
            $person = $repo->find($personId);

            $address->setPerson($person);

            $em = $this->getDoctrine()->getManager();
            $em->persist($address);
            $em->flush();
        }

        return new Response('Address created');
    }

    /**
     * @Route("/showAddress/{id}", name ="showAddress")
     * @Template()
     */
    public function showAddressAction($id) {
        $repo = $this->getDoctrine()->getRepository('CodersLabBundle:Adress');
        $address = $repo->find($id);

        return ['address' => $address];
    }

    /**
     * @Route("/showAllAddress")
     * @Template()
     */
    public function showAllAddressAction() {
        $repo = $this->getDoctrine()->getRepository('CodersLabBundle:Adress');
        $addresses = $repo->findAll();

        return ['addresses' => $addresses];
    }

}
