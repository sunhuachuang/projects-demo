<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;

/**
 * Transaction
 *
 * @ORM\Table(name="transaction")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TransactionRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt",timeAware=false)
 */
class Transaction
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

    /** 1=>get, 2=>provide
     * @var int
     *
     * @ORM\Column(name="type", type="smallint")
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="money", type="decimal", precision=10, scale=2)
     * @Assert\NotBlank()
     */
    private $money;

    /** o=>等待确认, 1=>已打款， 2=>交易完成
     * @var int
     *
     * @ORM\Column(name="status", type="smallint")
     */
    private $status = 0;

    /** 0=>不是提现, 其他数字代表提现钱包id
     * @var int
     *
     * @ORM\Column(name="tixian", type="smallint")
     */
    private $tixian = 0;
 
    /** 是否匹配
     * @var bool
     *
     * @ORM\Column(name="match_flag", type="boolean")
     */
    private $matchFlag = false;

    /** 是否超时
     * @var bool
     *
     * @ORM\Column(name="is_max_time", type="boolean")
     */
    private $isMaxTime = false;

    /** 是否锁定
     * @var bool
     *
     * @ORM\Column(name="is_lock", type="boolean")
     */
    private $isLock = false;

    /** 是否手动
     * @var bool
     *
     * @ORM\Column(name="is_hand", type="boolean")
     */
    private $isHand = true;

    /** 是否排完队
     * @var bool
     *
     * @ORM\Column(name="is_queue", type="boolean")
     */
    private $isQueue = false;

    /** 订单编号
     * @var string
     *
     * @ORM\Column(name="order_number", type="string", length=255)
     */
    private $orderNumber;

    /**
     * @var bool
     *
     * @ORM\Column(name="bank_flag", type="boolean")
     */
    private $bankFlag;

    /**
     * @var bool
     *
     * @ORM\Column(name="my_pay_flag", type="boolean")
     */
    private $myPayFlag;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="transactions")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255)
     */
    private $username;

    /**
     * @ORM\OneToOne(targetEntity="Transaction", mappedBy="matchProvide")
     */
    private $matchGet;

    /**
     * @ORM\OneToOne(targetEntity="Transaction", inversedBy="matchGet")
     * @ORM\JoinColumn(name="get_id", referencedColumnName="id")
     */
    private $matchProvide;

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
     * Set type
     *
     * @param integer $type
     *
     * @return Transaction
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set money
     *
     * @param string $money
     *
     * @return Transaction
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
     * Set status
     *
     * @param boolean $status
     *
     * @return Transaction
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return bool
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set matchFlag
     *
     * @param boolean $matchFlag
     *
     * @return Transaction
     */
    public function setMatchFlag($matchFlag)
    {
        $this->matchFlag = $matchFlag;

        return $this;
    }

    /**
     * Get matchFlag
     *
     * @return bool
     */
    public function getMatchFlag()
    {
        return $this->matchFlag;
    }

    /**
     * Set orderNumber
     *
     * @param string $orderNumber
     *
     * @return Transaction
     */
    public function setOrderNumber($orderNumber)
    {
        $this->orderNumber = $orderNumber;

        return $this;
    }

    /**
     * Get orderNumber
     *
     * @return string
     */
    public function getOrderNumber()
    {
        return $this->orderNumber;
    }

    /**
     * Set bankFlag
     *
     * @param boolean $bankFlag
     *
     * @return Transaction
     */
    public function setBankFlag($bankFlag)
    {
        $this->bankFlag = $bankFlag;

        return $this;
    }

    /**
     * Get bankFlag
     *
     * @return bool
     */
    public function getBankFlag()
    {
        return $this->bankFlag;
    }

    /**
     * Set myPayFlag
     *
     * @param boolean $myPayFlag
     *
     * @return Transaction
     */
    public function setMyPayFlag($myPayFlag)
    {
        $this->myPayFlag = $myPayFlag;

        return $this;
    }

    /**
     * Get myPayFlag
     *
     * @return bool
     */
    public function getMyPayFlag()
    {
        return $this->myPayFlag;
    }

    public function setUser(User $user)
    {
        $this->user = $user;
        $this->username = $user->getUsername();
        return $this;
    }

    public function getUser()
    {
        return $this->user;
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

    public function setMatchGet(Transaction $get)
    {
        $this->matchGet = $get;
        $this->matchFlag = true;
        return $this;
    }

    public function getMatchGet()
    {
        return $this->matchGet;
    }

    public function setMatchProvide(Transaction $provide)
    {
        $this->matchProvide = $provide;
        $this->matchFlag = true;
        return $this;
    }

    public function getMatchProvide()
    {
        return $this->matchProvide;
    }

    public function setTixian($tixian)
    {
        $this->tixian = $tixian;
        return $this;
    }

    public function getTixian()
    {
        return $this->tixian;
    }

    public function setIsMaxTime($isMaxTime)
    {
        $this->isMaxTime = $isMaxTime;
        return $this;
    }

    public function getIsMaxTime()
    {
        return $this->isMaxTime;
    }

    public function setIsHand($isHand)
    {
        $this->isHand = $isHand;
        return $this;
    }

    public function getIsHand()
    {
        return $this->isHand;
    }

    public function setIsQueue($isQueue)
    {
        $this->isQueue = $isQueue;
        return $this;
    }

    public function getIsQueue()
    {
        return $this->isQueue;
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
}

