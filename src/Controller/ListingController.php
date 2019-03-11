<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Listing;


class ListingController extends AbstractController
{
    /**
     * @Route("/listing", name="listing")
     */
    public function index()
    {
    	$listings = $this->getDoctrine()
			    ->getRepository(Listing::class)->findAll();

			$listing_img_path = $this->getParameter('listing_img_path');

// var_dump($listings);
      return $this->render('listing/index.html.twig', [
          'listings' => $listings,
          'listing_img_path' => $listing_img_path
      ]);
    }//index()

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
