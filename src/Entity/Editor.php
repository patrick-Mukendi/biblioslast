<?php

namespace App\Entity;

use App\Repository\EditorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EditorRepository::class)]
class Editor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank()]
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, Book>
     */
    #[ORM\OneToMany(targetEntity: Book::class, mappedBy: 'editor')]
    private Collection $bookEditor;

    /**
     * @var Collection<int, Book>
     */
    #[ORM\OneToMany(targetEntity: Book::class, mappedBy: 'editorBook')]
    private Collection $books;

    public function __construct()
    {
        $this->bookEditor = new ArrayCollection();
        $this->books = new ArrayCollection();
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

    /**
     * @return Collection<int, Book>
     */
    public function getBookEditor(): Collection
    {
        return $this->bookEditor;
    }

    public function addBookEditor(Book $bookEditor): static
    {
        if (!$this->bookEditor->contains($bookEditor)) {
            $this->bookEditor->add($bookEditor);
            $bookEditor->setEditor($this);
        }

        return $this;
    }

    public function removeBookEditor(Book $bookEditor): static
    {
        if ($this->bookEditor->removeElement($bookEditor)) {
            // set the owning side to null (unless already changed)
            if ($bookEditor->getEditor() === $this) {
                $bookEditor->setEditor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Book>
     */
    public function getBooks(): Collection
    {
        return $this->books;
    }

    public function addBook(Book $book): static
    {
        if (!$this->books->contains($book)) {
            $this->books->add($book);
            $book->setEditorBook($this);
        }

        return $this;
    }

    public function removeBook(Book $book): static
    {
        if ($this->books->removeElement($book)) {
            // set the owning side to null (unless already changed)
            if ($book->getEditorBook() === $this) {
                $book->setEditorBook(null);
            }
        }

        return $this;
    }
}
