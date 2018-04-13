<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Exclude;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * Category
 * @UniqueEntity(
 *     fields={"name"},
 *     message="This category name is already exist."
 * )
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255,unique=true)
     */
    private $name;

    /**
     * @var \DateTime
     * @Exclude
     * @ORM\Column(name="created_on", type="datetime",options={"default"="CURRENT_TIMESTAMP"}, nullable=false)
     */
    private $createdOn;

    /**
     * @var \DateTime
     * @Exclude
     * @ORM\Column(name="updated_on", type="datetime", nullable=true)
     */
    private $updatedOn;

    /**
     *
     * Many Products can have many Categories.
     * @ORM\ManyToMany(targetEntity="AdminBundle\Entity\Product", mappedBy="categories")
     */
    private $products;

    /**
     * Category constructor.
     */
    public function __construct()
    {
        $this->setCreatedOn(new \DateTime());
        $this->setUpdatedOn(new \DateTime());
        $this->products = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @ORM\PreUpdate
     */
    public function PreUpdate() {

        $this->setUpdatedOn(new \DateTime());
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Category
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     * @param \DateTime $createdOn
     */
    public function setCreatedOn($createdOn)
    {
        $this->createdOn = $createdOn;
    }

    /**
     * @return mixed
     */
    public function getUpdatedOn()
    {
        return $this->updatedOn;
    }

    /**
     * @param mixed $updatedOn
     */
    public function setUpdatedOn($updatedOn)
    {
        $this->updatedOn = $updatedOn;
    }



    /**
     * @return mixed
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @param mixed $products
     */
    public function setProducts($products)
    {
        $this->products = $products;
    }


    /**
     * @return string
     */
    public function __toString() {
        return $this->name;
    }
}

