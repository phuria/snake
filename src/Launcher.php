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
use Phuria\Snake\Game\InputInterpreter;
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

        $board = new Board($window->getSizeX() - 1, $window->getSizeY() - 1);
        $board->initializeSnake();

        $frameCount = 0;
        $direction = 'a';

        while(true) {
            $key = $input->readLatestKey();
            $direction = $key ?: $direction;

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
            $window->clear();
            $board->render($window);

            $window->renderCharReverse(0, 0, "Frames: {$frameCount}");
            $window->renderCharReverse(1, 0, "Size: {$window->getSizeX()}x{$window->getSizeY()}");

            $window->refresh();
            usleep(500 * 1000);
            $frameCount++;
        }

        ncurses_getch();
    }
}