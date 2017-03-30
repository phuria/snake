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

use Phuria\Snake\Ncurses\Screen;

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
     * @var int
     */
    private $colorPair;

    /**
     * @param string $char
     * @param bool   $colorInverted
     * @param int    $colorPair
     */
    public function __construct($char, $colorInverted = false, $colorPair = Screen::COLOR_DEFAULT)
    {
        $this->char = $char;
        $this->colorInverted = $colorInverted;
        $this->colorPair = $colorPair;
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

    /**
     * @return int
     */
    public function getColorPair()
    {
        return $this->colorPair;
    }
}