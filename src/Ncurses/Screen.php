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

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class Screen
{
    /**
     * Initializing application.
     */
    public function __construct()
    {
        ncurses_init();
        ncurses_curs_set(0);
    }

    /**
     * Cleaning screen, ending game.
     */
    public function __destruct()
    {
        ncurses_end();
    }
}