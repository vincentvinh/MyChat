<?php

namespace ChatBundle\Controller;

use ChatBundle\Entity\Text;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ChatBundle:Default:index.html.twig');
    }
    public function chatAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $text = new Text();
        $texts = $em->getRepository('ChatBundle:Text')->findAll();


        $form = $this->createForm('ChatBundle\Form\TextType', $text);

        $form->handleRequest($request);
        if($form->isValid())
        {
            $text->setDateCreation(new \DateTime());
            $em->persist($text);
            $em->flush();
            return $this->render('ChatBundle:user:chat.html.twig', array(
                'texts' => $texts,
                'form' => $form->createView(),
            ));
        }

        return $this->render('ChatBundle:user:chat.html.twig', array(
            'texts' => $texts,
            'form' => $form->createView(),
        ));



    }
}
