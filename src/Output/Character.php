<?php

/**
 * This file is part of phuria/snake package.
 *
 * Copyright (c) 2017 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\Snake\Output;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class Character
{
    /**
     * @var string
     */
    private $char;

    /**
     * @var bool
     */
    private $colorInverted;

    /**
     * @param string $char
     * @param bool   $colorInverted
     */
    public function __construct($char, $colorInverted = false)
    {
        $this->char = $char;
        $this->colorInverted = $colorInverted;
    }

    /**
     * @return bool
     */
    public function isColorInverted()
    {
        return $this->colorInverted;
    }

    /**
     * @return string
     */
    public function getChar()
    {
        return $this->char;
    }
}