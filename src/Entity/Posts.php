<?php

namespace App\Entity;

use App\Repository\PostsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PostsRepository::class)
 */
class Posts
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity=Comments::class, mappedBy="posts")
     */
    private $PostComment;

    /**
     * @ORM\ManyToMany(targetEntity=Categories::class, inversedBy="posts")
     */
    private $PostsCategories;

    public function __construct()
    {
        $this->PostComment = new ArrayCollection();
        $this->PostsCategories = new ArrayCollection();
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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Collection|Comments[]
     */
    public function getPostComment(): Collection
    {
        return $this->PostComment;
    }

    public function addPostComment(Comments $postComment): self
    {
        if (!$this->PostComment->contains($postComment)) {
            $this->PostComment[] = $postComment;
            $postComment->setPosts($this);
        }

        return $this;
    }

    public function removePostComment(Comments $postComment): self
    {
        if ($this->PostComment->removeElement($postComment)) {
            // set the owning side to null (unless already changed)
            if ($postComment->getPosts() === $this) {
                $postComment->setPosts(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Categories[]
     */
    public function getPostsCategories(): Collection
    {
        return $this->PostsCategories;
    }

    public function addPostsCategory(Categories $postsCategory): self
    {
        if (!$this->PostsCategories->contains($postsCategory)) {
            $this->PostsCategories[] = $postsCategory;
        }

        return $this;
    }

    public function removePostsCategory(Categories $postsCategory): self
    {
        $this->PostsCategories->removeElement($postsCategory);

        return $this;
    }
}
