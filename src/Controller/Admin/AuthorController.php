<?php

namespace App\Controller\Admin;

use App\Entity\Author;
use App\Form\AuthorType;
use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AuthorController extends AbstractController
{
    #[Route('/admin/author', name: 'app_admin_author', methods: ['GET', 'POST'])]
    public function index(Request $request, EntityManagerInterface $manager): Response
    {
        $author = new Author();
        $form = $this->createForm(AuthorType::class, $author);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($author);
            $manager->flush();

            return $this->redirectToRoute('app_admin_author_view');
        }

        return $this->render('admin/author/index.html.twig', [
            'controller_name' => 'AuthorController',
            'form' => $form,
        ]);
    }

    #[Route('/admin/author_view', name: 'app_admin_author_view', methods: ['GET'])]
    public function indexView(AuthorRepository $repository): Response
    {
        $author = $repository->findAll();

        return $this->render('admin/author/index_view.html.twig', [
            'controller_name' => 'AuthorController',
            'author' => $author,
        ]);
    }

    #[Route('/admin/author/{id}', name: 'app_admin_author_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(?Author $author = null): Response
    {
        return $this->render('admin/author/show_view.html.twig', [
            'author' => $author,
        ]);
    }
}
