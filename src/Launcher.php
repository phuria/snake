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
use Phuria\Snake\Game\PositionHolder;
use Phuria\Snake\Input\InputReader;
use Phuria\Snake\Ncurses\Screen;
use Phuria\Snake\Ncurses\Window;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class Launcher
{
    /**
     * Entry point.
     */
    public function run()
    {
        $screen = new Screen();
        $window = new Window();
        $input = new InputReader();

        $board = new Board($window->getSizeX(), $window->getSizeY());
        $board->initializeSnake();

        $frameCount = 0;

        $positionX = 0;
        $positionY = 0;

        while(true) {

            $key = $input->readLatestKey();

            switch ($key) {
                case 'w':
                    $positionX--;
                    break;
                case 's':
                    $positionX++;
                    break;
                case 'a';
                    $positionY--;
                    break;
                case 'd':
                    $positionY++;
                    break;
            }

            $board->advance();
            $window->clear();
            $board->render($window);

            $window->renderCharReverse(0, 0, "Frames: {$frameCount}");

            $window->refresh();
            usleep(500 * 1000);
            $frameCount++;
        }

        ncurses_getch();
    }
}