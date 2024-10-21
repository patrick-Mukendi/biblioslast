<?php

namespace App\Controller\Admin;

use App\Entity\Editor;
use App\Form\EditorType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EditorController extends AbstractController
{
    #[Route('/admin/editor', name: 'app_admin_editor', methods: ['POST', 'GET'])]
    public function index(Request $request, EntityManagerInterface $manager): Response
    {
        $editor = new Editor();
        $form = $this->createForm(EditorType::class, $editor);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($editor);
            $manager->flush();

            return $this->redirectToRoute('app_admin_editor');
        }

        return $this->render('admin/editor/index.html.twig', [
            'controller_name' => 'EditorController',
            'form' => $form,
        ]);
    }
}
