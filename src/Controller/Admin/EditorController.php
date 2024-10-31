<?php

namespace App\Controller\Admin;

use App\Entity\Editor;
use App\Form\EditorType;
use App\Repository\EditorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EditorController extends AbstractController
{
    #[Route('/admin/editor/new', name: 'app_admin_editor_new', methods: ['POST', 'GET'])]
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        $editor = new Editor();
        $form = $this->createForm(EditorType::class, $editor);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($editor);
            $manager->flush();

            return $this->redirectToRoute('app_admin_editor_view');
        }

        return $this->render('admin/editor/index.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/admin/editor', name: 'app_admin_editor_view', methods: ['POST', 'GET'])]
    public function view(EditorRepository $editorRepository): Response
    {
        $editor = $editorRepository->findAll();

        return $this->render('admin/editor/editor_view.html.twig', [
            'editor' => $editor,
        ]);
    }

    #[Route('/admin/editor/show/{id}', requirements: ['id' => '\d+'], name: 'app_admin_editor_show', methods: ['GET'])]
    public function show(?Editor $editor = null): Response
    {
        return $this->render('admin/editor/editor_show.html.twig', parameters: [
            'editor' => $editor,
        ]);
    }
}
