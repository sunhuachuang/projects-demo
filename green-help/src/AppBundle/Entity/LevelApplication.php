<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;

/**
 * LevelApplication
 *
 * @ORM\Table(name="level_applications")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LevelApplicationRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt",timeAware=false)
 */
class LevelApplication
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
     * @ORM\Column(name="level", type="string", length=20)
     */
    private $level;

    /**
     * @var string
     *
     * @ORM\Column(name="old_level", type="string", length=20)
     */
    private $oldLevel;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_user", type="boolean")
     */
    private $isUser = true;

    /**
     * @var bool
     *
     * @ORM\Column(name="approve_flag", type="boolean")
     */
    private $approveFlag = false;

    /**
     * @var int
     *
     * @ORM\Column(name="number", type="integer")
     */
    private $number;

    /**
     * @var string
     *
     * @ORM\Column(name="diff", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $diff;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="levelApplications")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

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
     * Set level
     *
     * @param string $level
     *
     * @return LevelApplication
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return string
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set approveFlag
     *
     * @param boolean $approveFlag
     *
     * @return LevelApplication
     */
    public function setApproveFlag($approveFlag)
    {
        $this->approveFlag = $approveFlag;

        return $this;
    }

    /**
     * Get approveFlag
     *
     * @return bool
     */
    public function getApproveFlag()
    {
        return $this->approveFlag;
    }

    /**
     * Set number
     *
     * @param integer $number
     *
     * @return LevelApplication
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return int
     */
    public function getNumber()
    {
        return $this->number;
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

    public function setOldLevel($level)
    {
        $this->oldLevel = $level;
        return $this;
    }

    public function getOldLevel()
    {
        return $this->oldLevel;
    }

    public function setIsUser($isUser)
    {
        $this->isUser = $isUser;
        return $this;
    }

    public function getIsUser()
    {
        return $this->isUser;
    }

    public function setDiff($diff)
    {
        $this->diff = $diff;
        return $this;
    }

    public function getDiff()
    {
        return $this->diff;
    }
}

