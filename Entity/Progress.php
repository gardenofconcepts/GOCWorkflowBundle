<?php

namespace GOC\WorkflowBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="workflow_progress")
 * @ORM\Entity(repositoryClass="Adticket\Elvis\ContactBundle\Repository\ContactRepository")
 */
class Progress
{
    const STATUS_COMPLETE = 1;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $status = self::STATUS_COMPLETE;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $owner;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $actor;

    /**
     * @ORM\Column(name="`references`", type="object", nullable=true)
     */
    private $references = array();

    private $data;

    public function setActor($actor)
    {
        $this->actor = $actor;
    }

    public function getActor()
    {
        return $this->actor;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setOwner($owner)
    {
        $this->owner = $owner;
    }

    public function getOwner()
    {
        return $this->owner;
    }

    public function addReference($key, $object)
    {
        $this->reference[$key] = $object;
    }

    public function getReference($key)
    {
        if (isset($this->references[$key])) {
            return $this->reference[$key];
        }
        return null;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    public function getData()
    {
        return $this->data;
    }
}
