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

use App\Entity\Airports;

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
      
		$airport = new Airports();
		
		$form = $this->createFormBuilder($airport)
			->add('name', TextType::class, 
				array('attr' => array('class' => 'form-control')))
			->add('country', TextType::class, 
				array('attr' => array('class' => 'form-control')))
			->add('location', TextType::class, 
				array('attr' => array('class' => 'form-control')))
			->add('airlines', TextType::class, 
				array('attr' => array('class' => 'form-control')))
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
	 	//$airport = new Airports();
	 	$airport = $this->getDoctrine()->getRepository(Airports::class)->find((int)$id);

	 	$form = $this->createFormBuilder($airport)
			->add('name', TextType::class, 
				array('attr' => array('class' => 'form-control')))
			->add('country', TextType::class, 
				array('attr' => array('class' => 'form-control')))
			->add('location', TextType::class, 
				array('attr' => array('class' => 'form-control')))
			->add('airlines', TextType::class, 
				array('attr' => array('class' => 'form-control')))
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