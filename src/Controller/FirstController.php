<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FirstController extends AbstractController
{
    #[Route('/first', name: 'first')]
    public function index(): Response
    {
        return $this->render('first/index.html.twig',[
            'name' => 'Taallah',
            'firstname' => 'Nejib'
        ]);
    }

    //#[Route('/sayHello/{name}/{firstname}', name: 'say.hello')]
    public function sayHello(Request $request, $name, $firstname): Response
    {
        return $this->render('first/hello.html.twig', [
            'name' => $name,
            'firstname' => $firstname,
            'path' => '    '
        
        ]);
    }
    #[Route(
        '/multi/{entier1<\d+>}/{entier2<\d+>}',
         name: 'multiplication',
         //requirements: ['entier1' => '\d+','entier2' => '\d+']
         )]
    public function multiplication($entier1, $entier2){
        $resultat = $entier1 * $entier2;
        return new Response("<h1>$resultat</h1>");
    }
    #[Route('/template', name: 'template')]
    public function template(): Response
    {
        return $this->render('template.html.twig');
    }
}
