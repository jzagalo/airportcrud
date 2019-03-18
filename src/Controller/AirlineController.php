<?php
// src/Controller/AirportController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController; 

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use App\Entity\Airports;
use App\Entity\Airline;

class AirlineController extends AbstractController 

{
    
    /**
	 * @Route("/airlines" , name="show_airlines")
	 * @Method("GET")
	 */
    public function showAirlines()
    {
       $airlines = $this->getDoctrine()->getRepository(Airline::class)->findAll();   
        return $this->render('airline/index.html.twig', array(
        	'airlines' => $airlines
        ));

    }

      /**
	 * @Route("/airlines/new" , name="add_airline")
	 * @Method("GET")
	 */
    public function addAirline(Request $request)
    {
      
        $airline = new Airline();		
		
		$form = $this->createFormBuilder($airline)
			->add('name', TextType::class, 
				array('attr' => array('class' => 'form-control')))
			->add('country', TextType::class, 
				array('attr' => array('class' => 'form-control')))			
			->add('airports', EntityType::class, ['choices' => $airline->getAirports(),
			'placeholder' => 'Choose Airport',
			'class' => Airports::class,
			'attr' => array('class' => 'form-control') ])
				
			->add('save', SubmitType::class, 
				array('attr' => array(
					'label' => 'Create',
					'class' => 'btn btn-primary mt-3')))
			->getForm();

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$airline = $form->getData();
			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->persist($airline);

	        // actually executes the queries (i.e. the INSERT query)
	        $entityManager->flush();
	        return $this->redirectToRoute('show_airlines');
		}	


        return $this->render('airline/new.html.twig', array(
        	'form' => $form->createView()
        ));
    }

     /**
	 * @Route("/airline/delete/{id}" , name="delete_airline")
	 * @Method("POST")
	 */

	 public function deleteAirline(Request $request, $id) {
		
	 	$airline = $this->getDoctrine()->getRepository(Airline::class)->find((int)$id);
	 	$entityManager = $this->getDoctrine()->getManager();
		$entityManager->remove($airline);
		$entityManager->flush();
		
		return $this->json($id);
	 }

	 /**
	 * @Route("/airlines/edit/{id}" , name="edit_airline")
	 * @Method({"GET", "POST"})
	 */

	 public function editAirport(Request $request, $id) {
	 	$airportChoice = new Airline();
	 	$airline = $this->getDoctrine()->getRepository(Airline::class)->find((int)$id);


	 	$form = $this->createFormBuilder($airline)
			->add('name', TextType::class, 
				array('attr' => array('class' => 'form-control')))
			->add('country', TextType::class, 
				array('attr' => array('class' => 'form-control')))			
			->add('airports', EntityType::class, ['choices' => $airportChoice->getAirports(),
			'placeholder' => 'Choose Airport',
			'class' => Airports::class,
			'attr' => array('class' => 'form-control') ])
				
			->add('save', SubmitType::class, 
				array('attr' => array(
					'label' => 'Create',
					'class' => 'btn btn-primary mt-3')))
			->getForm();

		$form->handleRequest($request);

		if($form->isSubmitted() && $form->isValid()){
			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->persist($airline);
			$entityManager->flush();

			return $this->redirectToRoute('show_airlines');
		}

		 return $this->render('airline/new.html.twig', array(
        	'form' => $form->createView()
        ));

	 }

}