<?php

namespace Front\AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Front\UserBundle\Entity\User;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Group
 *
 * @ORM\Table(name="base_group")
 * @ORM\Entity(repositoryClass="Front\AppBundle\Repository\GroupRepository")
 */
class Group
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="Front\UserBundle\Entity\User", mappedBy="group")
     * @ORM\JoinTable(name="base_group_user")
     */
    private $users;

    /**
     * @var Collection
     *
     * @ORM\ManyToMany(targetEntity="Front\AppBundle\Entity\Profile", inversedBy="groups", cascade={"persist"})
     * @ORM\JoinTable(name="base_group_profile")
     */
    private $profiles;

    /**
     * Group constructor.
     */
    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->profiles = new ArrayCollection();
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
     * @return Collection
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @param Collection $users
     */
    public function setUsers($users)
    {
        $this->users = $users;
    }

    /**
     * @return Collection
     */
    public function getProfiles()
    {
        return $this->profiles;
    }

    /**
     * @param Collection $profiles
     */
    public function setProfiles($profiles)
    {
        $this->profiles = $profiles;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    public function addUser(User $user)
    {
        if (!$this->users->contains($user)) {
            $user->setGroup($this);
            $this->users->add($user);
        }

        return $this;
    }

    public function addProfile(Profile $profile)
    {
        if (!$this->users->contains($profile)) {
            $profile->addGroup($this);
            $this->profiles->add($profile);
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getName();
    }

    /**
     * This function prevent the save in DB if the entity is not in a correct state
     * @Assert\Callback
     * @param ExecutionContextInterface $context
     */
    public function isEntityCorrect(ExecutionContextInterface $context)
    {
        $applicationNames  = new ArrayCollection();
        $applicationDouble = new ArrayCollection();
        foreach ($this->getProfiles() as $profile) {
            /** @var Profile $profile */
            $applicationName = $profile->getApplication()->getName();
            if (!$applicationNames->contains($applicationName)) {
                $applicationNames->add($applicationName);
            }
            else {
                $applicationDouble->add($applicationName);
            }
        }

        if ($applicationDouble->count() > 0) {
            // The constraint is violated
            $context
                ->buildViolation('Impossible de donner plusieurs profils à une même application ('.implode(", ", $applicationDouble->toArray()).')')
                ->atPath('profiles')// The attribute that is violated
                ->addViolation();
        }
    }
}

