<?php

namespace App\Entity;

/**
 * TableHistory
 */
class TableHistory
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $table;

    /**
     * @var string
     */
    private $entry;

    /**
     * @var array
     */
    private $values;

    /**
     * @var \DateTime
     */
    private $timestamp;

    /**
     * @var User
     */
    private $user;

    public function __construct(string $entityClass, $entityID, array $values)
    {
        $this->setTimestamp(new \DateTime());
        $this->table = $entityClass;
        $this->entry = $entityID;
        $this->values = $values;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set table
     *
     * @param string $table
     *
     * @return TableHistory
     */
    public function setTable($table)
    {
        $this->table = $table;

        return $this;
    }

    /**
     * Get table
     *
     * @return string
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * Set entry
     *
     * @param string $entry
     *
     * @return TableHistory
     */
    public function setEntry($entry)
    {
        $this->entry = $entry;

        return $this;
    }

    /**
     * Get entry
     *
     * @return string
     */
    public function getEntry()
    {
        return $this->entry;
    }

    /**
     * Set values
     *
     * @param array $values
     *
     * @return TableHistory
     */
    public function setValues($values)
    {
        $this->values = $values;

        return $this;
    }

    /**
     * Get values
     *
     * @return array
     */
    public function getValues()
    {
        return $this->values;
    }

    /**
     * Set timestamp
     *
     * @param \DateTime $timestamp
     *
     * @return TableHistory
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \DateTime
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set user
     *
     * @param User $user
     *
     * @return TableHistory
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }
}

