<?php

/**
 * This file is part of phuria/snake package.
 *
 * Copyright (c) 2017 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\Snake\Ncurses;

use Phuria\Snake\Game\RendererInterface;
use Phuria\Snake\Output\Character;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class Window implements RendererInterface
{
    /**
     * @var resource
     */
    private $handler;

    /**
     * @var int
     */
    private $sizeX;

    /**
     * @var int
     */
    private $sizeY;

    /**
     * Window constructor.
     */
    public function __construct()
    {
        $this->handler = ncurses_newwin(0, 0, 0, 0);
        ncurses_getmaxyx($this->handler, $x, $y);
        $this->sizeX = $x;
        $this->sizeY = $y;
    }

    /**
     * @param int    $positionX
     * @param int    $positionY
     * @param string $char
     */
    public function renderChar($positionX, $positionY, $char)
    {
        //ncurses_bkgdset(NCURSES_COLOR_BLUE);
        //ncurses_wcolor_set($this->handler, NCURSES_COLOR_RED);
        ncurses_mvwaddstr($this->handler, $positionX, $positionY, $char);
        ncurses_wcolor_set($this->handler, 1);
        //ncurses_wmove($this->handler, $positionX, $positionY);
        //ncurses_waddstr($this->handler, $char);
    }

    /**
     * @param int    $positionX
     * @param int    $positionY
     * @param string $char
     */
    public function renderCharReverse($positionX, $positionY, $char)
    {
        ncurses_wattron($this->handler, NCURSES_A_REVERSE);
        $this->renderChar($positionX, $positionY, $char);
        ncurses_wattroff($this->handler, NCURSES_A_REVERSE);
    }

    /**
     * @inheritdoc
     */
    public function renderCharacter($positionX, $positionY, Character $character)
    {
        if ($pair = $character->getColorPair()) {
            ncurses_wcolor_set($this->handler, $pair);
        } else {
            ncurses_wcolor_set($this->handler, Screen::COLOR_DEFAULT);
        }

        if ($character->isColorInverted()) {
            $this->renderCharReverse($positionX, $positionY, $character->getChar());
        } else {
            $this->renderChar($positionX, $positionY, $character->getChar());
        }

    }

    /**
     * Clear window.
     */
    public function clear()
    {
        ncurses_wclear($this->handler);
    }

    /**
     * Render new stuff.
     */
    public function refresh()
    {
        ncurses_wrefresh($this->handler);
    }

    /**
     * @return int
     */
    public function getSizeX()
    {
        return $this->sizeX;
    }

    /**
     * @return int
     */
    public function getSizeY()
    {
        return $this->sizeY;
    }
}