<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;

/**
 * DeclarateApplication
 *
 * @ORM\Table(name="declarate_applications")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DeclarateApplicationRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt",timeAware=false)
 */
class DeclarateApplication
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

    /** 1=>waiting, 2=>accsess, 3=>failure
     * @var int
     *
     * @ORM\Column(name="status", type="smallint")
     */
    private $status;

    /**
     * @var int
     *
     * @ORM\Column(name="childrenNumber", type="integer")
     */

    private $childrenNumber;

    /**
     * @var int
     *
     * @ORM\Column(name="groupNumber", type="integer")
     */

    private $groupNumber;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="declarateApplications")
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
     * Set status
     *
     * @param integer $status
     *
     * @return DeclarateApplication
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
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

    public function setChildrenNumber($childrenNumber)
    {
        $this->childrenNumber = $childrenNumber;
        return $this;
    }

    public function getChildrenNumber()
    {
        return $this->childrenNumber;
    }

    public function setGroupNumber($groupNumber)
    {
        $this->groupNumber = $groupNumber;
        return $this;
    }

    public function getGroupNumber()
    {
        return $this->groupNumber;
    }
}

