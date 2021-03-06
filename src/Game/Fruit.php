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
class Fruit implements PayloadInterface
{
    /**
     * @var FormattedText
     */
    private $character;

    public function __construct()
    {
        $colors = [
            Screen::COLOR_RED_ON_BLACK,
            Screen::COLOR_BLUE_ON_BLACK,
            Screen::COLOR_YELLOW_ON_BLACK,
            Screen::COLOR_DEFAULT
        ];

        $characters = ['@', '#', '*', 'O'];

        $this->character = new FormattedText($characters[array_rand($characters)], [
            'colorPair' => $colors[array_rand($colors)]
        ]);
    }

    /**
     * @inheritdoc
     */
    public function advance()
    {
        return;
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
}