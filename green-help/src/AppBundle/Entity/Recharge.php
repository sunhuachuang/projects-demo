<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Recharge
 *
 * @ORM\Table(name="recharges")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RechargeRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt",timeAware=false)
 */
class Recharge
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
     * @ORM\Column(name="money", type="decimal", precision=10, scale=2)
     */
    private $money;

    /**
     * @ORM\ManyToOne(targetEntity="Param")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id")
     */
    private $type;

    /**
     * @var bool
     *
     * @ORM\Column(name="sureFlag", type="boolean")
     */
    private $sureFlag = false ;

    private $username;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;
 
   /**
     * @ORM\ManyToOne(targetEntity="Admin")
     * @ORM\JoinColumn(name="admin_id", referencedColumnName="id")
     */
    private $admin;
 
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
     * Set money
     *
     * @param string $money
     *
     * @return Recharge
     */
    public function setMoney($money)
    {
        $this->money = $money;

        return $this;
    }

    /**
     * Get money
     *
     * @return string
     */
    public function getMoney()
    {
        return $this->money;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Recharge
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set sureFlag
     *
     * @param boolean $sureFlag
     *
     * @return Recharge
     */
    public function setSureFlag($sureFlag)
    {
        $this->sureFlag = $sureFlag;

        return $this;
    }

    /**
     * Get sureFlag
     *
     * @return bool
     */
    public function getSureFlag()
    {
        return $this->sureFlag;
    }

    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setAdmin($admin)
    {
        $this->admin = $admin;
        return $this;
    }

    public function getAdmin()
    {
        return $this->admin;
    }

    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    public function getUsername()
    {
        return $this->username;
    }
}

