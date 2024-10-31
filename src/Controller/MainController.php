<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(): Response
    {
        $isAuthentification = false;

        if($this->getUser() != null){
            $isAuthentification = true;
        }
       
        return $this->render('main/index.html.twig', [
            'statutAuth' => $isAuthentification,
        ]);
    }
}
