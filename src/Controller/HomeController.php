<?php

declare(strict_types = 1 );


namespace App\Controller;

use App\Form\ChatType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home' , methods : ['GET', 'POST'])]
    public function index(Request $request): Response
    {

        $form = $this->createForm(ChatType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            dd($form->getData());

        }

        return $this->render('home/index.html.twig', [
            'form' => $form->createView(),

        ]);
    }
}