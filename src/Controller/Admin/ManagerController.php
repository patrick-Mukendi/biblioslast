<?php

namespace App\Controller\Admin;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ManagerController extends AbstractController
{
    #[Route('/admin/manager', name: 'app_admin_manager')]
    public function index(UserRepository $user): Response
    {
        $user = $user->getCount();

        return $this->render('admin/manager/index.html.twig', [
            'usernombre' => $user,
        ]);
    }
}
