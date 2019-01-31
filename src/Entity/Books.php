<?php

namespace App\Entity;

use App\Entity\Image;
use App\Entity\Keyword;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BooksRepository")
 */
class Books
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le titre ne peut pas etre vide")
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Assert\NotBlank(message="Le titre ne peut pas etre vide")
     */
    private $author;

    /**
     * @ORM\Column(type="integer")
     * @Assert\GreaterThan(
     *      value = 0, message ="Minimum 1 euros"
     * )
     */
    private $price;
    /**
     * @ORM\OneToOne(targetEntity="Image", cascade={"persist","remove"} )
     *
     */
    private $image;
    /**
     * 
     *
     * @ORM\OneToMany(targetEntity="Keyword",mappedBy="book",cascade={"persist","remove"})
     */
    private $keywords;
    public function __construct()
    {
        $this->keywords = new ArrayCollection;
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    
    public function getImage(): ?Image
    {
        return $this->image;
    }


    public function setImage($image): void
    {
        $this->image = $image;

    }


    public function getKeywords()
    {
        return $this->keywords;
    }
    public function addKeywords(Keyword $keyword)
    {
        $this->keywords->add($keyword);
        $keyword->setBook($this);
    }
    public function removeKeywords(Keyword $keyword)
    {
        $this->keywords->removeElement($keyword);
    }
}
