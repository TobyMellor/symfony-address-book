<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

use AppBundle\Entity\Contact;
use AppBundle\Entity\User;
use AppBundle\Form\ContactFormType;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        if (!$this->container->get('security.authorization_checker')->isGranted('ROLE_USER')) { // move to MiddleWare
            $this->addFlash(
                'alerts',
                [
                    'type'    => 'danger',
                    'message' => 'security.login.messages.unauthorized'
                ]
            );
            
            return new RedirectResponse($this->generateUrl('login'));
        }
        
        $contact = new Contact;
        
        $form = $this->createForm(ContactFormType::class, $contact);
    
        $form->handleRequest($request);
    
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $contact = $form->getData();
                
                $em = $this->getDoctrine()->getManager();
                $em->persist($contact);
                $em->flush();
                
                $this->addFlash(
                    'alerts',
                    [
                        'type' => 'success',
                        'message' => 'contact.create.success'
                    ]  
                );
            } else {
                $this->addFlash(
                    'alerts',
                    [
                        'type'    => 'danger',
                        'message' => 'contact.create.error'
                    ]  
                );
            }
        }
        
        return $this->render('dashboard/index.html.twig', [
            'csrf_token' => $this->get('security.csrf.token_manager')->getToken($form->getName())->getValue(),
            'contacts'   => $this->getDoctrine()->getRepository(Contact::class)->findAll()
        ]);
    }
    
    /**
     * @Route("/contact/edit", name="edit-contact-no-id")
     * @Route("/contact/edit/{id}", name="edit-contact")
     * @Method({"POST"})
     */
    public function editAction(Request $request, $id = null) {
        if ($id !== null) {
            $em = $this->getDoctrine()->getManager();
        
            $contact = $this->findContactById($em, $id);
            
            // If I had more time I would use the form in indexAction and validate properly
            // and use a PUT HTTP method sent through jquery
            $contact->setName($request->get('name'));
            $contact->setPhone($request->get('phone'));
            $contact->setEmail($request->get('email'));
            
            $em->merge($contact);
            $em->flush();
            
            $this->addFlash(
                'alerts',
                [
                    'type'    => 'success',
                    'message' => 'contact.edit.success'
                ]
            );
        }
        
        return new RedirectResponse($this->generateUrl('homepage'));
    }
    
    /**
     * @Route("/contact/delete/{id}", name="delete-contact")
     */
    public function deleteAction($id) {
        $em = $this->getDoctrine()->getManager();
        
        $contact = $this->findContactById($em, $id);
        
        $em->remove($contact);
        $em->flush();
        
        $this->addFlash(
            'alerts',
            [
                'type'    => 'success',
                'message' => 'contact.delete.success'
            ]
        );
        
        return new RedirectResponse($this->generateUrl('homepage'));
    }
    
    private function findContactById($em, $id) {
        return $em->getRepository(Contact::class)->findOneById($id);
    }
}
