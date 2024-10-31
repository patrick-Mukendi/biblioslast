<?php

namespace App\Controller\Admin;

use App\Entity\Book;
use App\Entity\User;
use App\Form\BookType;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BookController extends AbstractController
{
    #[Route('/admin/book/{id}/edit', name: 'app_admin_book_edit', requirements:['id' => '\d+'], methods: ['GET', 'POST'])]
    #[Route('/admin/book/new', name: 'app_admin_book_new', methods: ['GET', 'POST'])]
    public function new(?Book $book, Request $request, EntityManagerInterface $manager): Response
    {
        $book ??= new Book();
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            if(! $book->getId() && $user instanceof User) {
                $book->setCreatedBy($user);
            }

            $manager->persist($book);
            $manager->flush();

            return $this->redirectToRoute(route: 'app_admin_book_view');
        }

        return $this->render('admin/book/index.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/admin/book', name: 'app_admin_book_view', methods: ['GET', 'POST'])]
    public function view(BookRepository $bookRepository): Response
    {
        $book = $bookRepository->findAll();

        return $this->render('admin/book/book_view.html.twig', [
            'book' => $book,
        ]);
    }

    #[Route('/admin/book/show/{id}', name: 'app_admin_book_show', requirements:['id' => '\d+'], methods: ['GET', 'POST'])]
    public function show(?Book $book = null): Response
    {
        return $this->render('admin/book/book_show.html.twig', [
            'book' => $book,
        ]);
    }
}
