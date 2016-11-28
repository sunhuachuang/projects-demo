<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\Entity\User;

/**
 * Book
 *
 * @ORM\Table()
 * @ORM\Entity
 * @Gedmo\SoftDeleteable(fieldName="deletedAt",timeAware=false)
 */
class Book
{
    /**
     * Hook timestampeable behavior
     * updates createdAt, updatedAt fields
     */
    use TimestampableEntity;

    /**
     * Hook softdeleteable behavior
     * updates deletedAt field
     */
    use SoftDeleteableEntity;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="writer", type="string", length=255)
     */
    private $writer;

    /**
     * @var string
     *
     * @ORM\Column(name="press", type="string", length=255)
     */
    private $press;

    /**
     * @var string
     *
     * @ORM\Column(name="version", type="string", length=10)
     */
    private $version;

    /**
     * @var string
     *
     * @ORM\Column(name="shop_price", type="decimal")
     */
    private $shopPrice;

    /**
     * @var string
     *
     * @ORM\Column(name="market_price", type="decimal")
     */
    private $marketPrice;

    /**
     * @var integer
     *
     * @ORM\Column(name="number", type="integer")
     */
    private $number;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_sale", type="boolean")
     */
    private $isSale = 0;

    /**
     * @var string
     *
     * @ORM\Column(name="old_level", type="string", length=10)
     */
    private $oldLevel;

    /**
     * @var integer
     *
     * @ORM\Column(name="click_count", type="integer")
     */
    private $clickCount = 0;

    /**
     * @var string
     * @ORM\Column(name="cover_img", type="string", length=255)
     * @Assert\Image()
     */
    private $coverImg;

    /**
     * @var string
     * @ORM\Column(name="brief", type="text", nullable=true)
     */
    private $brief;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="books")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="BookCategory", inversedBy="books")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $bookCategory;

    private $bookParentCategory;

    /**
     * @ORM\OneToMany(
     *     targetEntity="BookOrder",
     *     mappedBy="book"
     * )
     */
    private $bookOrders;

    /**
     * @ORM\OneToMany(
     *     targetEntity="BookImage",
     *     mappedBy="book",
     *     cascade={"persist","remove"}
     * )
     */
    private $bookImages;

    public function __construct()
    {
        $this->bookImages = new ArrayCollection;
        $this->bookOrders = new ArrayCollection;
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
     * Set name
     *
     * @param string $name
     *
     * @return Book
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
     * Set writer
     *
     * @param string $writer
     *
     * @return Book
     */
    public function setWriter($writer)
    {
        $this->writer = $writer;

        return $this;
    }

    /**
     * Get writer
     *
     * @return string
     */
    public function getWriter()
    {
        return $this->writer;
    }

    /**
     * Set press
     *
     * @param string $press
     *
     * @return Book
     */
    public function setPress($press)
    {
        $this->press = $press;

        return $this;
    }

    /**
     * Get press
     *
     * @return string
     */
    public function getPress()
    {
        return $this->press;
    }

    /**
     * Set version
     *
     * @param string $version
     *
     * @return Book
     */
    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * Get version
     *
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Set shopPrice
     *
     * @param string $shopPrice
     *
     * @return Book
     */
    public function setShopPrice($shopPrice)
    {
        $this->shopPrice = $shopPrice;

        return $this;
    }

    /**
     * Get shopPrice
     *
     * @return string
     */
    public function getShopPrice()
    {
        return $this->shopPrice;
    }

    /**
     * Set marketPrice
     *
     * @param string $marketPrice
     *
     * @return Book
     */
    public function setMarketPrice($marketPrice)
    {
        $this->marketPrice = $marketPrice;

        return $this;
    }

    /**
     * Get marketPrice
     *
     * @return string
     */
    public function getMarketPrice()
    {
        return $this->marketPrice;
    }

    /**
     * Set number
     *
     * @param integer $number
     *
     * @return Book
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return integer
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set isSale
     *
     * @param boolean $isSale
     *
     * @return Book
     */
    public function setIsSale($isSale)
    {
        $this->isSale = $isSale;

        return $this;
    }

    /**
     * Get isSale
     *
     * @return boolean
     */
    public function getIsSale()
    {
        return $this->isSale;
    }

    /**
     * Set oldLevel
     *
     * @param string $oldLevel
     *
     * @return Book
     */
    public function setOldLevel($oldLevel)
    {
        $this->oldLevel = $oldLevel;

        return $this;
    }

    /**
     * Get oldLevel
     *
     * @return string
     */
    public function getOldLevel()
    {
        return $this->oldLevel;
    }

    /**
     * Set clickCount
     *
     * @param integer $clickCount
     *
     * @return Book
     */
    public function setClickCount($clickCount)
    {
        $this->clickCount = $clickCount;

        return $this;
    }

    /**
     * Get clickCount
     *
     * @return integer
     */
    public function getClickCount()
    {
        return $this->clickCount;
    }

    /**
     * Set coverImg
     *
     * @param string $coverImg
     *
     * @return Book
     */
    public function setCoverImg($coverImg)
    {
        $this->coverImg = $coverImg;

        return $this;
    }

    /**
     * Get coverImg
     *
     * @return string
     */
    public function getCoverImg()
    {
        return $this->coverImg;
    }

    public function getBrief()
    {
        return $this->brief;
    }

    public function setBrief($brief)
    {
        $this->brief = $brief;
        return $this;
    }

    public function getBookImages()
    {
        return $this->bookImages;
    }

    public function setBookImages($bookImages = null)
    {
        $this->bookImages = $bookImages;
        return $this;
    }

    public function addBookImage(BookImage $bookImage)
    {
        $this->bookImages->add($bookImage);
        $bookImage->setBook($this);
        return $this;
    }

    public function removeBookImage(BookImage $bookImage)
    {
        $this->bookImages->removeElement($bookImage);
        $bookImage->setBook(null);
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser(User $user)
    {
        $this->user = $user;
        return $this;
    }

    public function getBookCategory()
    {
        return $this->bookCategory;
    }

    public function setBookCategory(BookCategory $bookCategory)
    {
        $this->bookCategory = $bookCategory;
        return $this;
    }

    public function getBookParentCategory()
    {
        return $this->bookParentCategory;
    }

    public function setBookParentCategory(BookCategory $bookCategory)
    {
        $this->bookParentCategory = $bookCategory;
        return $this;
    }

    public function getbookOrders()
    {
        return $this->bookOrders;
    }

    public function setbookOrders($bookOrders = null)
    {
        $this->bookOrders = $bookOrders;
        return $this;
    }

    public function isAble(User $user)
    {
        if($this->user == $user){
            return true;
        }
        return false;
    }

}

