<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommentRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Comment
{
    const COMMENTS_LIMIT = 2;
    const STATE_ACCEPT = 'accept';
    const STATE_REJECT_SPAM = 'reject_spam';
    const STATE_MIGHT_BE_SPAM = 'might_be_spam';
    const STATE_SUBMITTED = 'submitted';
    const STATE_SPAM = 'spam';
    const STATE_HAM = 'ham';
    const STATE_PUBLISHED = 'published';
    const STATE_PUBLISH_HAM = 'publish_ham';
    const STATE_REJECT = 'reject';

    /**
     * @var int $id
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string $text
     *
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $text;

    /**
     * @var bool $visible
     *
     * @ORM\Column(type="boolean",  options={"default": "1"})
     * @Assert\NotBlank()
     * @Assert\Length(min="1", max="255")
     */
    private $visible = true;

    /**
     * @var Conference|null $conference
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Conference", inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank()
     */
    private $conference;

    /**
     * @var User|null $author
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank()
     */
    private $author;

    /**
     * @var \DateTimeInterface $created
     *
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @var Photo $photo
     *
     * @ORM\OneToOne(targetEntity="App\Entity\Photo", inversedBy="comment", cascade={"persist", "remove"})
     */
    private $photo;

    /**
     * @var string|null $state
     *
     * @ORM\Column(type="string", length=255, options={"default": "submitted"})
     */
    private $state = self::STATE_SUBMITTED;

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->text;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getText(): ?string
    {
        return $this->text;
    }

    /**
     * @param string $text
     *
     * @return $this
     */
    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function isVisible(): ?bool
    {
        return $this->visible;
    }

    /**
     * @param bool $visible
     *
     * @return $this
     */
    public function setVisible(bool $visible): self
    {
        $this->visible = $visible;

        return $this;
    }

    /**
     * @return Conference|null
     */
    public function getConference(): ?Conference
    {
        return $this->conference;
    }

    /**
     * @param Conference|null $conference
     *
     * @return $this
     */
    public function setConference(?Conference $conference): self
    {
        $this->conference = $conference;

        return $this;
    }

    /**
     * @return User|null
     */
    public function getAuthor(): ?User
    {
        return $this->author;
    }

    /**
     * @param User|null $author
     *
     * @return $this
     */
    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return Photo|null
     */
    public function getPhoto(): ?Photo
    {
        return $this->photo;
    }

    /**
     * @param Photo|null $photo
     *
     * @return $this
     */
    public function setPhoto(?Photo $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getState(): ?string
    {
        return $this->state;
    }

    /**
     * @param string $state
     *
     * @return $this
     */
    public function setState(string $state): self
    {
        $this->state = $state;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    /**
     * @param \DateTimeInterface $created
     *
     * @return $this
     */
    public function setCreated(\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    /**
     * @ORM\PrePersist()
     */
    public function setCreatedValue()
    {
        $this->setCreated(new \DateTime());
    }
}
