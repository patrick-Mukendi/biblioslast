<?php

namespace App\Entity;

use App\Enum\BookStatus;
use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    /**
     * @var Collection<int, Author>
     */
    #[ORM\OneToMany(targetEntity: Author::class, mappedBy: 'bookAuthor')]
    private Collection $authors;

    #[ORM\Column(length: 255)]
    private ?string $isbn = null;

    #[ORM\Column(length: 255)]
    private ?string $cover = null;

    /**
     * @var Collection<int, Editor>
     */
    #[ORM\OneToMany(targetEntity: Editor::class, mappedBy: 'books')]
    private Collection $Editor;

    #[ORM\Column]
    private ?\DateTimeImmutable $editedAt = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $plot = null;

    #[ORM\Column]
    private ?int $pageNumber = null;

    #[ORM\Column(length: 255)]
    private ?BookStatus $status = null;

    /**
     * @var Collection<int, Comments>
     */
    #[ORM\ManyToMany(targetEntity: Comments::class, inversedBy: 'book')]
    private Collection $comments;

    #[ORM\ManyToOne(inversedBy: 'books')]
    private ?Author $authorBook = null;

    /**
     * @var Collection<int, Comments>
     */
    #[ORM\ManyToMany(targetEntity: Comments::class, mappedBy: 'books')]
    private Collection $commentBook;

    #[ORM\ManyToOne(inversedBy: 'book')]
    private ?Editor $editorBook = null;

    #[ORM\ManyToOne(inversedBy: 'book')]
    private ?Author $authorbook = null;

    public function __construct()
    {
        $this->authors = new ArrayCollection();
        $this->Editor = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->commentBook = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Collection<int, Author>
     */
    public function getAuthors(): Collection
    {
        return $this->authors;
    }

    

    public function getIsbn(): ?string
    {
        return $this->isbn;
    }

    public function setIsbn(string $isbn): static
    {
        $this->isbn = $isbn;

        return $this;
    }

    public function getCover(): ?string
    {
        return $this->cover;
    }

    public function setCover(string $cover): static
    {
        $this->cover = $cover;

        return $this;
    }

    /**
     * @return Collection<int, Editor>
     */
    public function getEditor(): Collection
    {
        return $this->Editor;
    }

    public function addEditor(Editor $editor): static
    {
        if (!$this->Editor->contains($editor)) {
            $this->Editor->add($editor);
            $editor->setBooks($this);
        }

        return $this;
    }

    public function removeEditor(Editor $editor): static
    {
        if ($this->Editor->removeElement($editor)) {
            // set the owning side to null (unless already changed)
            if ($editor->getBooks() === $this) {
                $editor->setBooks(null);
            }
        }

        return $this;
    }

    public function getEditedAt(): ?\DateTimeImmutable
    {
        return $this->editedAt;
    }

    public function setEditedAt(\DateTimeImmutable $editedAt): static
    {
        $this->editedAt = $editedAt;

        return $this;
    }

    public function getPlot(): ?string
    {
        return $this->plot;
    }

    public function setPlot(string $plot): static
    {
        $this->plot = $plot;

        return $this;
    }

    public function getPageNumber(): ?int
    {
        return $this->pageNumber;
    }

    public function setPageNumber(int $pageNumber): static
    {
        $this->pageNumber = $pageNumber;

        return $this;
    }

    public function getStatus(): ?BookStatus
    {
        return $this->status;
    }

    public function setStatus(BookStatus $status): static
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection<int, Comments>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comments $comment): static
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
        }

        return $this;
    }

    public function removeComment(Comments $comment): static
    {
        $this->comments->removeElement($comment);

        return $this;
    }

    public function getAuthorBook(): ?Author
    {
        return $this->authorBook;
    }

    public function setAuthorBook(?Author $authorBook): static
    {
        $this->authorBook = $authorBook;

        return $this;
    }

    /**
     * @return Collection<int, Comments>
     */
    public function getCommentBook(): Collection
    {
        return $this->commentBook;
    }

    public function addCommentBook(Comments $commentBook): static
    {
        if (!$this->commentBook->contains($commentBook)) {
            $this->commentBook->add($commentBook);
            $commentBook->addBook($this);
        }

        return $this;
    }

    public function removeCommentBook(Comments $commentBook): static
    {
        if ($this->commentBook->removeElement($commentBook)) {
            $commentBook->removeBook($this);
        }

        return $this;
    }

    public function getEditorBook(): ?Editor
    {
        return $this->editorBook;
    }

    public function setEditorBook(?Editor $editorBook): static
    {
        $this->editorBook = $editorBook;

        return $this;
    }
}
