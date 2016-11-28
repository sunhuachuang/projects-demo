<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\User;
use AppBundle\Entity\Book;

/**
 * BookOrder
 *
 * @ORM\Table()
 * @ORM\Entity
 * @Gedmo\SoftDeleteable(fieldName="deletedAt",timeAware=false)
 */
class BookOrder
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
     * @ORM\Column(name="address", type="string", length=255)
     */
    private $address;

    /**
     * @var integer
     *
     * @ORM\Column(name="zipcode", type="smallint")
     */
    private $zipcode;

    /**
     * @var string
     *
     * @ORM\Column(name="reciver", type="string", length=100)
     */
    private $reciver;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=100)
     */
    private $email;

    /**
     * @var integer
     *
     * @ORM\Column(name="tel", type="smallint")
     */
    private $tel;

    /**
     * @var string
     *
     * @ORM\Column(name="order_desc", type="string", length=255)
     */
    private $orderDesc;

    /**
     * @var integer
     *
     * @ORM\Column(name="number", type="smallint")
     */
    private $number;

    /**
     * @ORM\ManyToOne(targetEntity="Book", inversedBy="bookOrders")
     * @ORM\JoinColumn(name="book_id", referencedColumnName="id")
     */
    private $book;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="bookOrders")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

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
     * Set address
     *
     * @param string $address
     *
     * @return BookOrder
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set zipcode
     *
     * @param integer $zipcode
     *
     * @return BookOrder
     */
    public function setZipcode($zipcode)
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    /**
     * Get zipcode
     *
     * @return integer
     */
    public function getZipcode()
    {
        return $this->zipcode;
    }

    /**
     * Set reciver
     *
     * @param string $reciver
     *
     * @return BookOrder
     */
    public function setReciver($reciver)
    {
        $this->reciver = $reciver;

        return $this;
    }

    /**
     * Get reciver
     *
     * @return string
     */
    public function getReciver()
    {
        return $this->reciver;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return BookOrder
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set tel
     *
     * @param integer $tel
     *
     * @return BookOrder
     */
    public function setTel($tel)
    {
        $this->tel = $tel;

        return $this;
    }

    /**
     * Get tel
     *
     * @return integer
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * Set orderDesc
     *
     * @param string $orderDesc
     *
     * @return BookOrder
     */
    public function setOrderDesc($orderDesc)
    {
        $this->orderDesc = $orderDesc;

        return $this;
    }

    /**
     * Get orderDesc
     *
     * @return string
     */
    public function getOrderDesc()
    {
        return $this->orderDesc;
    }

    /**
     * Set number
     *
     * @param integer $number
     *
     * @return BookOrder
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

    public function getUser()
    {
        return $this->user;
    }

    public function setUser(User $user)
    {
        $this->user = $user;
        return $this;
    }

    public function getBook()
    {
        return $this->book;
    }

    public function setBook(Book $book)
    {
        $this->book = $book;
        return $this;
    }
}

