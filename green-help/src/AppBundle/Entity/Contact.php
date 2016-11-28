<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;

/**
 * Contact
 *
 * @ORM\Table(name="contacts")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ContactRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt",timeAware=false)
 */
class Contact
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
     * @ORM\Column(name="title", type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(max="50")
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="self_username", type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(max="50")
     */
    private $selfUsername;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(max="50")
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=20)
     * @Assert\NotBlank()
     * @Assert\Length(max="20")
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="text")
     * @Assert\NotBlank()
     * @Assert\Length(max="200")
     */
    private $message;

    /** is company
     * @var bool
     *
     * @ORM\Column(name="is_company", type="boolean")
     */
    private $isCompany;

    /**
     * @var bool
     *
     * @ORM\Column(name="read_flag", type="boolean")
     */
    private $readFlag = false;

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
     * Set title
     *
     * @param string $title
     *
     * @return Contact
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
     * Set username
     *
     * @param string $username
     *
     * @return Contact
     */
    public function setSelfUsername($username)
    {
        $this->selfUsername = $username;

        return $this;
    }

    /**
     * Get SELFusername
     *
     * @return string
     */
    public function getSelfUsername()
    {
        return $this->selfUsername;
    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return Contact
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return Contact
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set message
     *
     * @param string $message
     *
     * @return Contact
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set isCompany
     *
     * @param boolean $isCompany
     *
     * @return Contact
     */
    public function setIsCompany($type)
    {
        $this->isCompany = $type;

        return $this;
    }

    /**
     * Get isCompany
     *
     * @return bool
     */
    public function getIsCompany()
    {
        return $this->isCompany;
    }

    public function setReadFlag($flag)
    {
        $this->readFlag = $flag;
        return $this;
    }

    public function getReadFlag()
    {
        return $this->readFlag;
    }
}

