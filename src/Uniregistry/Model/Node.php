<?php

namespace Uniregistry\Model;

use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @package Uniregistry\Model
 * @JMS\ExclusionPolicy("all")
 */
class Node
{
    /**
     * @var string
     * @JMS\Expose()
     * @JMS\Type("string")
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     */
    protected $id;

    /**
     * @var string
     * @JMS\Expose()
     * @JMS\Type("string")
     * @Assert\Type(type="string")
     */
    protected $name;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return Node
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
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
     * @return Node
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }
}