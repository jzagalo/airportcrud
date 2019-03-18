<?php
// src/Controller/AirportController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use App\Entity\Airports;
use App\Entity\Airline;
use App\Entity\Country;


class AirportController extends Controller
{
    
    /**
	 * @Route("/airports" , name="show_airports")
	 * @Method("GET")
	 */
    public function showAirports()
    {
       $airports = $this->getDoctrine()->getRepository(Airports::class)->findAll();

        return $this->render('airport/index.html.twig', array(
        	'airports' => $airports
        ));

    }

      /**
	 * @Route("/airports/new" , name="add_airport")
	 * @Method("GET")
	 */
    public function addAirport(Request $request)
    {
      
        $airline = new Airline();  
		$airport = new Airports();
		$country = new Country();
		
		$form = $this->createFormBuilder($airport)
			->add('name', TextType::class, 
				array('attr' => array('class' => 'form-control')))
			->add('country', EntityType::class, ['choices' => $country->getCountry(),
			'placeholder' => 'Select Country',
			'class' => Country::class,
			'attr' => array('class' => 'form-control') ])	
			->add('location', ChoiceType::class,[
			    'choices' => array("portugal" => "132.5, 123.56", "nigeria" => "112.5, 103.56", "france" => "32.5, 23.56", "netherland" => "1.5, 12.56" ),
				'attr' => array('class' => 'form-control')])
			->add('airlines', EntityType::class, ['choices' => $airline->getAirports(),
			'placeholder' => 'Select Airline',
			'class' => Airports::class,
			'attr' => array('class' => 'form-control') ])
			->add('save', SubmitType::class, 
				array('attr' => array(
					'label' => 'Create',
					'class' => 'btn btn-primary mt-3')))
			->getForm();

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$airport = $form->getData();
			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->persist($airport);

	        // actually executes the queries (i.e. the INSERT query)
	        $entityManager->flush();
	        return $this->redirectToRoute('show_airports');
		}	


        return $this->render('airport/new.html.twig', array(
        	'form' => $form->createView()
        ));
    }

     /**
	 * @Route("/airports/delete/{id}" , name="delete_airport")
	 * @Method("POST")
	 */

	 public function deleteAirport(Request $request, $id) {
		
	 	$airport = $this->getDoctrine()->getRepository(Airports::class)->find((int)$id);
	 	$entityManager = $this->getDoctrine()->getManager();
		$entityManager->remove($airport);
		$entityManager->flush();
		
		return $this->json($id);
	 }

	 /**
	 * @Route("/airports/edit/{id}" , name="edit_airport")
	 * @Method({"GET", "POST"})
	 */

	 public function editAirport(Request $request, $id) {
	 	$country = new Country();
	 	$airlines = new Airline();

	 	$airport = $this->getDoctrine()->getRepository(Airports::class)->find((int)$id);

	 	$form = $this->createFormBuilder($airport)
			->add('name', TextType::class, 
				array('attr' => array('class' => 'form-control')))
			->add('country', TextType::class, 
				array('attr' => array('class' => 'form-control'),
			          'data' => $airport->getCountry()))	
			->add('location', TextType::class, 
				array('attr' => array('class' => 'form-control')))
			->add('airlines', TextType::class, 
				array('attr' => array('class' => 'form-control'),
			          'data' => $airport->getAirlines()))
			->add('save', SubmitType::class, 
				array('attr' => array(
					'label' => 'Create',
					'class' => 'btn btn-primary mt-3')))
			->getForm();

		$form->handleRequest($request);

		if($form->isSubmitted() && $form->isValid()){
			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->persist($airport);
			$entityManager->flush();

			return $this->redirectToRoute('show_airports');
		}

		 return $this->render('airport/new.html.twig', array(
        	'form' => $form->createView()
        ));

	 }

}