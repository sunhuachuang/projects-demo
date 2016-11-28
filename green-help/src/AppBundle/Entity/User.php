<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * User
 *
 * @ORM\Table(name="users")
 * @UniqueEntity("username")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt",timeAware=false)
 */
class User implements UserInterface
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
     * @ORM\Column(name="username", type="string", length=20)
     * @Assert\NotBlank()
     * @Assert\Length(max="20")
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="second_password", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $secondPassword;

    /**
     * @var string
     *
     * @ORM\Column(name="bank", type="string", length=20)
     * @Assert\NotBlank()
     * @Assert\Length(max="20")
     */
    private $bank;

    /**
     * @ORM\ManyToOne(targetEntity="Param")
     * @ORM\JoinColumn(name="bank_id", referencedColumnName="id")
     */
    private $bankObject;

    /**
     * @var string
     *
     * @ORM\Column(name="bank_number", type="string", length=50)
     * @Assert\NotBlank()
     * @Assert\Length(max="20")
     */
    private $bankNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="bank_name", type="string", length=20)
     * @Assert\NotBlank()
     * @Assert\Length(max="20")
     */
    private $bankName;

    /**
     * @var string
     *
     * @ORM\Column(name="bank_province", type="string", length=20)
     * @Assert\NotBlank()
     * @Assert\Length(max="20")
     */
    private $bankProvince;

    /**
     * @var string
     *
     * @ORM\Column(name="bank_city", type="string", length=20)
     * @Assert\NotBlank()
     * @Assert\Length(max="20")
     */
    private $bankCity;

    /**
     * @var string
     *
     * @ORM\Column(name="bank_address", type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(max="255")
     */
    private $bankAddress;

    /**
     * @var string
     *
     * @ORM\Column(name="report_department", type="string", length=100)
     * @Assert\NotBlank()
     * @Assert\Length(max="50")
     */
    private $reportDepartment;

    /**
     * @var string
     *
     * @ORM\Column(name="cart_id", type="string", length=100, nullable=true)
     * @Assert\Length(max="19")
     */
    private $cartId;

    /**
     * @var string
     *
     * @ORM\Column(name="reference_phone", type="string", length=15, nullable=true)
     * @Assert\Length(max="11")
     */
    private $referencePhone;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=15)
     * @Assert\NotBlank()
     * @Assert\Length(max="11")
     */
    private $phone;

    /**
     * @var bool
     *
     * @ORM\Column(name="agree_flag", type="boolean")
     */
    private $agreeFlag;

    /**
     * @var array
     *
     * @ORM\Column(name="roles", type="json_array")
     */
    private $roles = ['ROLE_USER'];

    /**
     * @var string
     *
     * @ORM\Column(name="salt", type="string", length=255, nullable=true)
     */
    private $salt;

    /**
     * @var string
     *
     * @ORM\Column(name="level", type="string", length=20)
     */
    private $level = '其他';

    /**
     * @ORM\ManyToOne(targetEntity="Param")
     * @ORM\JoinColumn(name="level_id", referencedColumnName="id")
     */
    private $levelObject;

    /** 0 => no, 1 => waiting, 2 => ok
     * @var integer
     *
     * @ORM\Column(name="declarate_status", type="smallint")
     */
    private $declarateStatus = 0;

    /**
     * @var string
     *
     * @ORM\Column(name="my_pay", type="string", length=50, nullable=true)
     * @Assert\Length(max="50")
     */
    private $myPay;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_leader", type="boolean")
     */
    private $isLeader = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_bonus", type="boolean")
     */
    private $isBonus = true;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_declarate", type="boolean")
     */
    private $isDeclarate = true;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_lock", type="boolean")
     */
    private $isLock = false;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     */
    private $parent;

    private $parentName;

    /**
     * @ORM\OneToMany(targetEntity="User", mappedBy="parent")
     */
    private $children;

    /**
     * @ORM\OneToMany(targetEntity="LevelApplication", mappedBy="user", orphanRemoval=true)
     */
    private $levelApplications;

    /**
     * @ORM\OneToMany(targetEntity="DeclarateApplication", mappedBy="user", orphanRemoval=true)
     */
    private $declarateApplications;

    /**
     * @ORM\OneToMany(targetEntity="UserWallet", mappedBy="user", orphanRemoval=true)
     */
    private $wallets;

    /**
     * @ORM\OneToMany(targetEntity="Transaction", mappedBy="user")
     */
    private $transactions;

    public function __construct()
    {
        $this->children   = new ArrayCollection();
        $this->levelApplications = new ArrayCollection();
        $this->declarateApplications = new ArrayCollection();
        $this->wallets = new ArrayCollection();
        $this->transactions = new ArrayCollection();
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
     * Set username
     *
     * @param string $username
     *
     * @return User
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
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set secondPassword
     *
     * @param string $secondPassword
     *
     * @return User
     */
    public function setSecondPassword($secondPassword)
    {
        $this->secondPassword = $secondPassword;

        return $this;
    }

    /**
     * Get secondPassword
     *
     * @return string
     */
    public function getSecondPassword()
    {
        return $this->secondPassword;
    }

    /**
     * Set bank
     *
     * @param string $bank
     *
     * @return User
     */
    public function setBank($bank)
    {
        $this->bank = $bank;

        return $this;
    }

    /**
     * Get bank
     *
     * @return string
     */
    public function getBank()
    {
        return $this->bank;
    }

    /**
     * Set bankNumber
     *
     * @param string $bankNumber
     *
     * @return User
     */
    public function setBankNumber($bankNumber)
    {
        $this->bankNumber = $bankNumber;

        return $this;
    }

    /**
     * Get bankNumber
     *
     * @return string
     */
    public function getBankNumber()
    {
        return $this->bankNumber;
    }

    /**
     * Set bankName
     *
     * @param string $bankName
     *
     * @return User
     */
    public function setBankName($bankName)
    {
        $this->bankName = $bankName;

        return $this;
    }

    /**
     * Get bankName
     *
     * @return string
     */
    public function getBankName()
    {
        return $this->bankName;
    }

    /**
     * Set bankProvince
     *
     * @param string $bankProvince
     *
     * @return User
     */
    public function setBankProvince($bankProvince)
    {
        $this->bankProvince = $bankProvince;

        return $this;
    }

    /**
     * Get bankProvince
     *
     * @return string
     */
    public function getBankProvince()
    {
        return $this->bankProvince;
    }

    /**
     * Set bankCity
     *
     * @param string $bankCity
     *
     * @return User
     */
    public function setBankCity($bankCity)
    {
        $this->bankCity = $bankCity;

        return $this;
    }

    /**
     * Get bankCity
     *
     * @return string
     */
    public function getBankCity()
    {
        return $this->bankCity;
    }

    /**
     * Set bankAddress
     *
     * @param string $bankAddress
     *
     * @return User
     */
    public function setBankAddress($bankAddress)
    {
        $this->bankAddress = $bankAddress;

        return $this;
    }

    /**
     * Get bankAddress
     *
     * @return string
     */
    public function getBankAddress()
    {
        return $this->bankAddress;
    }

    /**
     * Set reportDepartment
     *
     * @param string $reportDepartment
     *
     * @return User
     */
    public function setReportDepartment($reportDepartment)
    {
        $this->reportDepartment = $reportDepartment;

        return $this;
    }

    public function setCartId($cart)
    {
        $this->cartId = $cart;
        return $this;
    }

    public function getCartId()
    {
        return $this->cartId;
    }

    /**
     * Get reportDepartment
     *
     * @return string
     */
    public function getReportDepartment()
    {
        return $this->reportDepartment;
    }

    /**
     * Set referencePhone
     *
     * @param string $referencePhone
     *
     * @return User
     */
    public function setReferencePhone($referencePhone)
    {
        $this->referencePhone = $referencePhone;

        return $this;
    }

    /**
     * Get referencePhone
     *
     * @return string
     */
    public function getReferencePhone()
    {
        return $this->referencePhone;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return User
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
     * Set agreeFlag
     *
     * @param boolean $agreeFlag
     *
     * @return User
     */
    public function setAgreeFlag($agreeFlag)
    {
        $this->agreeFlag = $agreeFlag;

        return $this;
    }

    /**
     * Get agreeFlag
     *
     * @return bool
     */
    public function getAgreeFlag()
    {
        return $this->agreeFlag;
    }

    /**
     * Set roles
     *
     * @param array $roles
     * @return User
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Get roles
     *
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Set salt
     *
     * @param string $salt
     * @return user
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Get salt
     *
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    public function eraseCredentials()
    {
    }

    public function setLevel($level)
    {
        $this->level = $level;
        return $this;
    }

    public function getLevel()
    {
        return $this->level;
    }

    public function setDeclarateStatus($declarateStatus)
    {
        $this->declarateStatus = $declarateStatus;
        return $this;
    }

    public function getDeclarateStatus()
    {
        return $this->declarateStatus;
    }

    public function getChildren()
    {
        return $this->children;
    }

    public function addChild(User $child)
    {
        $this->chilren->add($child);
        $child->setParent($this);

        return $this;
    }

    public function hasChild()
    {
        return $this->children->count();
    }

    public function getParent()
    {
        return $this->parent;
    }

    public function setParent(User $parent = null)
    {
        $this->parent = $parent;
        return $this;
    }

    public function setParentName($parentName)
    {
        $this->parentName = $parentName;
        return $this;
    }

    public function getParentName()
    {
        return $this->parentName;
    }

    public function getLevelApplications()
    {
        return $this->levelApplications;
    }

    public function isLevelApplication($level)
    {
        foreach($this->levelApplications as $apply) {
            if($apply->getLevel() === $level && !$apply->getApproveFlag()) {
                return true;
            }
        }
        return false;
    }

    public function getDeclarateApplications()
    {
        return $this->declarateApplications;
    }

    public function setWallets($wallets)
    {
        $this->wallets = $wallets;
        return $this;
    }

    public function getWallets()
    {
        return $this->wallets;
    }

    public function getAllMoney()
    {
        $money = 0.00;
        foreach($this->wallets as $wallet) {
            if($wallet->getName() === '激活币') {
                continue;
            }
            $money += $wallet->getMoney();
        }
        return $money;
    }

    public function getWallet($name)
    {
        foreach($this->wallets as $wallet) {
            if($wallet->getName() === $name) {
                return $wallet;
            }
        }
        return false;
    }

    //1 -> add, 2->desc
    public function getWalletHistories($slug)
    {
        $histories = [];
        foreach($this->wallets as $wallet) {
            foreach($wallet->getWalletHistories() as $history) {
                if($history->getType() === $slug) {
                    $histories[] = $history;
                }
            }
        }

        return $histories;
    }

    //1->get 2-> provide
    public function getTransactions($slug)
    {
        $transactions = [];
        foreach($this->transactions as $transaction) {
            if($transaction->getType() === intval($slug)) {
                $transactions[] = $transaction;
            }
        }

        return $transactions;
    }

    public function countMoney($slug)
    {
        $number = 0.00;
        $trans = $this->getTransactions($slug);
        foreach($trans as $tran) {
            $number += $tran->getMoney();
        }
        return $number;
    }

    public function setBankObject($bankObject)
    {
        $this->bankObject = $bankObject;
        $this->bank = $bankObject->getValue();
        return $this;
    }

    public function getBankObject()
    {
        return $this->bankObject;
    }

    public function setLevelObject($levelObject)
    {
        $this->levelObject = $levelObject;
        $this->level = $levelObject->getValue();
        return $this;
    }

    public function getLevelObject()
    {
        return $this->levelObject;
    }

    public function setMyPay($myPay)
    {
        $this->myPay = $myPay;
        return $this;
    }

    public function getMyPay()
    {
        return $this->myPay;
    }

    public function setIsLock($isLock)
    {
        $this->isLock = $isLock;
        return $this;
    }

    public function getIsLock()
    {
        return $this->isLock;
    }

    public function setIsLeader($isLeader)
    {
        $this->IsLeader = $isLeader;
        return $this;
    }

    public function getIsLeader()
    {
        return $this->isLeader;
    }

    public function setIsBonus($isBonus)
    {
        $this->isBonus = $isBonus;
        return $this;
    }

    public function getIsBonus()
    {
        return $this->isBonus;
    }

    public function setIsDeclarate($isDeclarate)
    {
        $this->isDeclarate = $isDeclarate;
        return $this;
    }

    public function getIsDeclarate()
    {
        return $this->isDeclarate;
    }
}

