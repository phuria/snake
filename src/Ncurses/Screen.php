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
    const COLOR_DEFAULT = 1;
    const COLOR_GREEN_ON_BLACK = 2;
    const COLOR_RED_ON_BLACK = 3;
    const COLOR_BLACK_ON_BLUE = 4;
    const COLOR_BLUE_ON_BLACK = 5;
    const COLOR_YELLOW_ON_BLACK = 6;

    /**
     * Initializing application.
     */
    public function __construct()
    {
        ncurses_init();
        ncurses_start_color();
        ncurses_curs_set(0);
    }

    /**
     * Cleaning screen, ending game.
     */
    public function __destruct()
    {
        ncurses_end();
    }

    public function initializeColors()
    {
        ncurses_init_pair(static::COLOR_DEFAULT, NCURSES_COLOR_WHITE, NCURSES_COLOR_BLACK);
        ncurses_init_pair(static::COLOR_GREEN_ON_BLACK, NCURSES_COLOR_GREEN, NCURSES_COLOR_BLACK);
        ncurses_init_pair(static::COLOR_RED_ON_BLACK, NCURSES_COLOR_RED, NCURSES_COLOR_BLACK);
        ncurses_init_pair(static::COLOR_BLACK_ON_BLUE, NCURSES_COLOR_BLACK, NCURSES_COLOR_BLUE);
        ncurses_init_pair(static::COLOR_BLUE_ON_BLACK, NCURSES_COLOR_BLUE, NCURSES_COLOR_BLACK);
        ncurses_init_pair(static::COLOR_YELLOW_ON_BLACK, NCURSES_COLOR_YELLOW, NCURSES_COLOR_BLACK);
    }
}