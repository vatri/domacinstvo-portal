<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

use Psr\Log\LoggerInterface;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="")
     */
    public function index()
    {
        return $this->render('home/home.html.twig');
    }

    /**
     * @Route("/ajax_contact", methods={ "POST" })
     **/
    public function ajax_contact(\Swift_Mailer $mailer, Request $request, LoggerInterface $logger, ParameterBagInterface $parameterBag){
    	
    	$admin_email = $parameterBag->get('email.admin');
    	$name = $request->request->get('name');
    	$email = $request->request->get('email');
    	$message_text = $request->request->get('message');
    	// var_dump($name,$email,$message_text);
		$body = "Name: $name <br>E-mail: $email<br>Message:<br>$message_text";

    	$message = (new \Swift_Message('[Domacinstvo.rs] Kontakt forma obrazac podnijet'))
        // ->setFrom('no-repl')
	        ->setTo($admin_email)
    	    ->setBody($body, 'text/html');

    	$ok = $mailer->send($message, $errors);

    	if(!$ok){
    		$logger->error("Email sending error: $email > $admin_email, msg:".substr($message_text, 0, 30));
    		return new Response("Грешка на систему. Контактирајте нас на $admin_email .");
    	}

    	$logger->info("Email sent: $email > $admin_email, msg:".substr($message_text, 0, 30));

    	return new Response("ok");
    }

}//class
