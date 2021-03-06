<?php

namespace App\Entity;

/**
 * Vote
 */
class Vote
{
    /**
     * @var string
     */
    private $cookieID;

    /**
     * @var array
     */
    private $preferences;

    /**
     * @var \DateTime
     */
    private $timestamp;

    /**
     * @var string
     */
    private $ip;

    /**
     * @var string
     */
    private $votingCode;

    /**
     * @var integer
     */
    private $number;

    /**
     * @var Award
     */
    private $award;

    /**
     * @var User
     */
    private $user;


    /**
     * Set cookieID
     *
     * @param string $cookieID
     *
     * @return Vote
     */
    public function setCookieID($cookieID)
    {
        $this->cookieID = $cookieID;

        return $this;
    }

    /**
     * Get cookieID
     *
     * @return string
     */
    public function getCookieID()
    {
        return $this->cookieID;
    }

    /**
     * Set preferences
     *
     * @param array $preferences
     *
     * @return Vote
     */
    public function setPreferences($preferences)
    {
        $this->preferences = $preferences;

        return $this;
    }

    /**
     * Get preferences
     *
     * @return array
     */
    public function getPreferences()
    {
        return $this->preferences;
    }

    /**
     * Set timestamp
     *
     * @param \DateTime $timestamp
     *
     * @return Vote
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
     * Set ip
     *
     * @param string $ip
     *
     * @return Vote
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * Get ip
     *
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set votingCode
     *
     * @param string $votingCode
     *
     * @return Vote
     */
    public function setVotingCode($votingCode)
    {
        $this->votingCode = $votingCode;

        return $this;
    }

    /**
     * Get votingCode
     *
     * @return string
     */
    public function getVotingCode()
    {
        return $this->votingCode;
    }

    /**
     * Set number
     *
     * @param integer $number
     *
     * @return Vote
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return integer
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set award
     *
     * @param Award $award
     *
     * @return Vote
     */
    public function setAward(Award $award)
    {
        $this->award = $award;

        return $this;
    }

    /**
     * Get award
     *
     * @return Award
     */
    public function getAward()
    {
        return $this->award;
    }

    /**
     * Set user
     *
     * @param User $user
     *
     *
     * @return Vote
     */
    public function setUser(User $user = null)
    {
        if ($user->isLoggedIn()) {
            $this->user = $user;
        }
        return $this;
    }

    /**
     * Get user
     *
     * @return \App\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}

