<?php

/**
 * This file is part of phuria/snake package.
 *
 * Copyright (c) 2017 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\Snake;

use Phuria\Snake\Game\Board;
use Phuria\Snake\Game\StatsBoard;
use Phuria\Snake\Input\InputReader;
use Phuria\Snake\Ncurses\Screen;
use Phuria\Snake\Ncurses\Window;
use Phuria\Snake\Output\FormattedText;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class Launcher
{
    public static $debugText;

    /**
     * Entry point.
     */
    public function run()
    {
        $screen = new Screen();
        $screen->initializeColors();

        if (ncurses_can_change_color()) {
            exit;
        }

        $topWindow = new Window(1);
        $statsBoard = new StatsBoard($topWindow);
        $gameWindow = new Window(0,0,1,0);
        $input = new InputReader();

        $board = new Board(
            $gameWindow->getSizeX() - 1,
            $gameWindow->getSizeY() - 1,
            $statsBoard
        );
        $board->initializeSnake();

        $direction = 'a';

        while(true) {

            $key = $input->readLatestKey();
            $direction = in_array($key, ['w', 's', 'a', 'd']) ? $key : $direction;

            switch ($direction) {
                case 'w':
                    $board->modifyHeadPosition(-1, 0);
                    break;
                case 's':
                    $board->modifyHeadPosition(1, 0);
                    break;
                case 'a';
                    $board->modifyHeadPosition(0, -1);
                    break;
                case 'd':
                    $board->modifyHeadPosition(0, 1);
                    break;
            }

            $board->advance();
            $gameWindow->clear();
            $board->render($gameWindow);
            $gameWindow->refresh();
            usleep( 50000);
        }
    }
}