<?php

/**
 * This file is part of phuria/snake package.
 *
 * Copyright (c) 2017 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\Snake\Game;

use Phuria\Snake\Ncurses\Screen;
use Phuria\Snake\Output\FormattedText;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class SnakeHead implements PayloadInterface
{
    /**
     * @var FormattedText
     */
    private $character;

    /**
     * SnakeHead constructor.
     */
    public function __construct()
    {
        $this->character = new FormattedText(':', [
            'colorInverted' => true,
            'colorPair'     => Screen::COLOR_GREEN_ON_BLACK
        ]);
    }

    /**
     * @inheritdoc
     */
    public function isExpired()
    {
        return false;
    }

    /**
     * @inheritdoc
     */
    public function isVisible()
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    public function getCharacter()
    {
        return $this->character;
    }

    /**
     * @inheritdoc
     */
    public function advance()
    {
        return;
    }
}