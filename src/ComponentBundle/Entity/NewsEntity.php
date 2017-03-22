<?php

namespace ComponentBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="news")
 * @ORM\Entity(repositoryClass="ComponentBundle\Repository\NewsEntityRepository")
 */
class NewsEntity
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     */
    protected $guid;

    /**
     * @ORM\Column(type="string", length=50, nullable=false)
     * @Assert\NotBlank()
     */
    protected $category;

    /**
     * @ORM\Column(type="string", length=255)
     * @Gedmo\Slug(fields={"category"}, updatable=false, unique=false)
     */
    protected $slug;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     */
    protected $title;

    /**
     * @ORM\Column(type="text", nullable=false)
     * @Assert\NotBlank()
     */
    protected $description;

    /**
     *
     * @var \DateTime $created
     *
     * @ORM\Column(type="datetime")
     * @Assert\NotNull()
     */
    protected $pubDate;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     */
    protected $link;

    /**
     * @ORM\OneToOne(targetEntity="MediaEntity")
     * @ORM\JoinColumn(name="media_id", onDelete="CASCADE", referencedColumnName="id")
     */
    protected $media;

    /**
     *
     * @var \DateTime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    protected $created;

    /**
     * NewsEntity constructor.
     * @param $guid
     * @param $category
     * @param $title
     * @param $description
     * @param $pubDate
     * @param $link
     */
    public function __construct($guid, $category, $title, $description, $pubDate, $link)
    {
        $this->guid = $guid;
        $this->category = $category;
        $this->title = $title;
        $this->description = $description;
        $this->pubDate = $pubDate;
        $this->link = $link;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set guid
     *
     * @param string $guid
     *
     * @return $this
     */
    public function setGuid($guid)
    {
        $this->guid = $guid;

        return $this;
    }

    /**
     * Get guid
     *
     * @return string
     */
    public function getGuid()
    {
        return $this->guid;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * Set category
     *
     * @param string $category
     *
     * @return $this
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set pubDate
     *
     * @param string $pubDate
     *
     * @return $this
     */
    public function setPubDate($pubDate)
    {
        $this->pubDate = $pubDate;

        return $this;
    }

    /**
     * Get pubDate
     *
     * @return string
     */
    public function getPubDate()
    {
        return $this->pubDate;
    }

    /**
     * Set link
     *
     * @param string $link
     *
     * @return $this
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get link
     *
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set media
     *
     * @param \ComponentBundle\Entity\MediaEntity $media
     *
     * @return $this
     */
    public function setMedia(\ComponentBundle\Entity\MediaEntity $media = null)
    {
        $this->media = $media;

        return $this;
    }

    /**
     * Get media
     *
     * @return \ComponentBundle\Entity\MediaEntity
     */
    public function getMedia()
    {
        return $this->media;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return $this
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @return array
     */
    public function toArray():array
    {
        $properties = get_object_vars($this);

        foreach( $properties as $name => $property ) {
            if ( $property instanceof \DateTime ) {
                $properties[$name] = $property->format(\DateTime::ATOM);
            }
        }

        $properties['media'] = [];

        if ($media = $this->getMedia()) {
            $properties['media'] = $media->toArray();
        }

        return $properties;
    }
}