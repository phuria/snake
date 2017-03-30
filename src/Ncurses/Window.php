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
use Phuria\Snake\Output\FormattedText;

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
     * @param int $rows
     * @param int $cols
     * @param int $x
     * @param int $y
     */
    public function __construct($rows = 0, $cols = 0, $x = 0, $y = 0)
    {
        $this->handler = ncurses_newwin($rows, $cols, $x, $y);
        ncurses_getmaxyx($this->handler, $x, $y);
        $this->sizeX = $x;
        $this->sizeY = $y;
    }

    /**
     * @param int    $positionX
     * @param int    $positionY
     * @param string $string
     */
    public function renderString($positionX, $positionY, $string)
    {
        ncurses_mvwaddstr($this->handler, $positionX, $positionY, $string);
    }

    /**
     * @inheritdoc
     */
    public function renderText($positionX, $positionY, FormattedText $text)
    {
        $this->applyFormatting($text);
        $this->renderString($positionX, $positionY, $text->getText());
    }

    /**
     * @param int $positionX
     * @param int $positionY
     * @param int $code
     */
    public function renderCharacterCode($positionX, $positionY, $code)
    {
        ncurses_wmove($this->handler, $positionX, $positionY);
        ncurses_waddch($this->handler, $code);
    }

    /**
     * @param int           $positionX
     * @param FormattedText $text
     * @param string        $padString
     */
    public function renderTextWithPadding($positionX, FormattedText $text, $padString = '.')
    {
        $this->applyFormatting($text);
        $text = str_pad($text->getText(), $this->sizeY, $padString);
        $this->renderString($positionX, 0, $text);
    }

    /**
     * @param FormattedText $text
     */
    private function applyFormatting(FormattedText $text)
    {
        if ($text->isColorInverted()) {
            ncurses_wattron($this->handler, NCURSES_A_REVERSE);
        } else {
            ncurses_wattroff($this->handler, NCURSES_A_REVERSE);
        }

        ncurses_wcolor_set($this->handler, $text->getColorPair());
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