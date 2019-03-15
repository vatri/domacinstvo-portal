<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Listing;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

use Symfony\Component\HttpFoundation\Request;
use App\Form\ListingType;


class ListingController extends AbstractController
{
    /**
     * @Route("/listing", name="listings")
     */
    public function index()
    {
//    	$listings = $this->getDoctrine()->getRepository(Listing::class)->findAll();
        $orderBy = ['title' => 'ASC'];
    	$listings = $this->getDoctrine()->getRepository(Listing::class)->findBy(['visible' => 1], $orderBy);
    	
		$listing_img_path = $this->getParameter('listing_img_path');

        return $this->render('listing/listings.html.twig', [
          'listings' => $listings,
          'listing_img_path' => $listing_img_path
        ]);
    
    }//index()
		/**
		* @Route("/publish_listing", name="publish_listing")
		*/
		public function publish_listing(Request $request)
		{

			$listing = new Listing();

			$form = $this->createForm(ListingType::class);
			$form->add('Save', SubmitType::class, ['label' => 'Објави']);

			$form->handleRequest($request);
			
			if($form->isSubmitted() && $form->isValid()){
			    $listing = $form->getData();
			    $em = $this->getDoctrine()->getManager();
			    $em->persist($listing);
			    $em->flush();
			    
			    $this->addFlash("info", "Подаци сачувани");
			    
			    return $this->redirectToRoute("listings");
			    
			}
			
			return $this->render('listing/publish_listing.html.twig',[
				'form' => $form->createView()
			]);
		}
    /**
		* @Route("/product/{id}", name="product_show")
		*/
		public function show($id)
		{
			
			// $product = $this->getDoctrine()
			//     ->getRepository(Product::class)
			//     ->find($id);

			// if (!$product) {
			//     throw $this->createNotFoundException(
			//         'No product found for id '.$id
			//     );
			// }

			// return new Response('Check out this great product: '.$product->getName());

			// // or render a template
			// // in the template, print things with {{ product.name }}
			// // return $this->render('product/show.html.twig', ['product' => $product]);
		}
}
