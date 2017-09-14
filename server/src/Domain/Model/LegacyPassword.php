<?php

namespace App\Domain\Model;

trait LegacyPassword
{
    /**
     * @var string
     */
    private $legacyPassword;

    /**
     * @var string
     */
    private $legacySalt;

    /**
     * Get legacyPassword
     *
     * @return string
     */
    public function getLegacyPassword()
    {
        return $this->legacyPassword;
    }

    /**
     * Get legacySalt
     *
     * @return string
     */
    public function getLegacySalt()
    {
        return $this->legacySalt;
    }
}
