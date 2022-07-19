<?php

namespace App\Entity;

use App\Repository\ActorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ActorRepository::class)]
class Actor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    /** 
    * @Annotation 
    * @Assert\NotBlank
    */
    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    /** 
    * @Annotation 
    * @Assert\NotBlank
    */
    #[ORM\Column(type: 'integer')]
    private $birthYear;

    #[ORM\ManyToMany(targetEntity: Movie::class, mappedBy: 'actors')]
    private $movies;

    #[ORM\Column(type: 'string', length: 255)]
    private $imagePath;

    public function __construct()
    {
        $this->movies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Movie>
     */
    public function getMovies(): Collection
    {
        return $this->movies;
    }

    public function addMovie(Movie $movie): self
    {
        if (!$this->movies->contains($movie)) {
            $this->movies[] = $movie;
            $movie->addActor($this);
        }

        return $this;
    }

    public function removeMovie(Movie $movie): self
    {
        if ($this->movies->removeElement($movie)) {
            $movie->removeActor($this);
        }

        return $this;
    }
	/**
	 * 
	 * @return mixed
	 */
	function getBirthYear() {
		return $this->birthYear;
	}
	
	/**
	 * 
	 * @param mixed $birthYear 
	 * @return Actor
	 */
	function setBirthYear($birthYear): self {
		$this->birthYear = $birthYear;
		return $this;
	}
	/**
	 * @return mixed
	 */
	function getImagePath() {
		return $this->imagePath;
	}
	
	/**
	 * @param mixed $imagePath 
	 * @return Actor
	 */
	function setImagePath($imagePath): self {
		$this->imagePath = $imagePath;
		return $this;
	}
}
