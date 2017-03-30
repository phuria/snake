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
class SnakePart implements PayloadInterface
{
    /**
     * @var int
     */
    private $expiresIn;

    /**
     * @var FormattedText
     */
    private $character;

    /**
     * @param int $expiresIn
     */
    public function __construct($expiresIn)
    {
        $this->expiresIn = $expiresIn;
        $this->character = new FormattedText(' ', [
            'colorInverted' => true,
            'colorPair'     => Screen::COLOR_GREEN_ON_BLACK
        ]);
    }

    /**
     * @inheritdoc
     */
    public function isExpired()
    {
        return 0 >= $this->expiresIn;
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
        $this->expiresIn--;
    }
}