<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * UserWallet
 *
 * @ORM\Table(name="user_wallets")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserWalletRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt",timeAware=false)
 */
class UserWallet
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
     * @ORM\Column(name="name", type="string", length=20)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="money", type="decimal", precision=10, scale=2)
     */
    private $money;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="wallets")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="UserWalletHistory", mappedBy="wallet", orphanRemoval=true)
     */
    private $walletHistories;

    public function __construct()
    {
        $this->walletHistories = new ArrayCollection();
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
     * @return UserWallet
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
     * Set money
     *
     * @param string $money
     *
     * @return UserWallet
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

    public function setUser(User $user)
    {
        $this->user = $user;
        return $this;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setWalletHistories($histories)
    {
        $this->walletHistories = $histories;
        return $this;
    }

    public function getWalletHistories()
    {
        return $this->walletHistories;
    }

    /**
     * Add wallethistory
     *
     * @param \AppBundle\Entity\UserWalletHistory $wallethistory
     *
     * @return UserWallet
     */
    public function addWalletHistory(\AppBundle\Entity\UserWalletHistory $walletHistory)
    {
        $this->walletHistories->add($walletHistory);
        $walletHistory->setWallet($this);
        return $this;
    }

    /**
     * Remove wallethistory
     *
     * @param \AppBundle\Entity\UserWalletHistory $wallethistory
     */
    public function removeWalletHistory(\AppBundle\Entity\UserWalletHistory $walletHistory)
    {
        $this->walletHistories->removeElement($wallethistory);
    }
}
