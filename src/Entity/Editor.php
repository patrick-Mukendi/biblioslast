<?php

namespace App\Entity;

use App\Repository\EditorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EditorRepository::class)]
class Editor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'Editor')]
    private ?Book $books = null;

    /**
     * @var Collection<int, Book>
     */
    #[ORM\OneToMany(targetEntity: Book::class, mappedBy: 'editorBook')]
    private Collection $book;

    public function __construct()
    {
        $this->book = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getBooks(): ?Book
    {
        return $this->books;
    }

    public function setBooks(?Book $books): static
    {
        $this->books = $books;

        return $this;
    }

    /**
     * @return Collection<int, Book>
     */
    public function getBook(): Collection
    {
        return $this->book;
    }

    public function addBook(Book $book): static
    {
        if (!$this->book->contains($book)) {
            $this->book->add($book);
            $book->setEditorBook($this);
        }

        return $this;
    }

    public function removeBook(Book $book): static
    {
        if ($this->book->removeElement($book)) {
            // set the owning side to null (unless already changed)
            if ($book->getEditorBook() === $this) {
                $book->setEditorBook(null);
            }
        }

        return $this;
    }
}
