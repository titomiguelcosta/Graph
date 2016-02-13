<?php

namespace Uniregistry\Model;

use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @package Uniregistry\Model
 * @JMS\ExclusionPolicy("all")
 */
class Edge
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
     * @var Node
     * @JMS\Expose()
     * @JMS\Type("string")
     * @Assert\NotBlank()
     * @Assert\Type(type="Uniregistry\Model\Node")
     */
    protected $from;

    /**
     * @var Node
     * @JMS\Expose()
     * @JMS\Type("string")
     * @Assert\NotBlank()
     * @Assert\Type(type="Uniregistry\Model\Node")
     */
    protected $to;

    /**
     * @var float
     * @JMS\Expose()
     * @JMS\Type("double")
     * @Assert\NotBlank()
     * @Assert\Type("float")
     */
    protected $cost = 0.0;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return Edge
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return Node
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @param Node $from
     * @return Edge
     */
    public function setFrom(Node $from = null)
    {
        $this->from = $from;

        return $this;
    }

    /**
     * @return Node
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * @param Node $to
     * @return Edge
     */
    public function setTo(Node $to = null)
    {
        $this->to = $to;

        return $this;
    }

    /**
     * @return float
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * @param float $cost
     * @return Edge
     */
    public function setCost($cost)
    {
        $this->cost = $cost;

        return $this;
    }
}