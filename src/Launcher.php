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
use Phuria\Snake\Output\FigletRenderer;
use Povils\Figlet\Figlet;

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
        $screen->initializeColors();

        if (ncurses_can_change_color()) {
            exit;
        }

        $topWindow = new Window(1);
        $statsBoard = new StatsBoard($topWindow);
        $gameWindow = new Window(0,0,1,0);
        $input = new InputReader();

        $gameWindow->renderTextBlockCentered($c = file_get_contents(__DIR__.'/../font/logo.txt'), [
            'colorPair' => Screen::COLOR_GREEN_ON_BLACK
        ]);
        $gameWindow->refresh();
        $input->waitForKeyPress();

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

            $moveX = $moveY = 0;

            switch ($direction) {
                case 'w':
                    $moveX = -1;
                    break;
                case 's':
                    $moveX = 1;
                    break;
                case 'a';
                    $moveY = -1;
                    break;
                case 'd':
                    $moveY = 1;
                    break;
            }

            $result = $board->modifyHeadPosition($moveX, $moveY);

            if (Board::RESULT_GAME_OVER === $result) {
                break;
            }

            $board->advance();
            $gameWindow->clear();
            $board->render($gameWindow);
            $gameWindow->refresh();
            usleep( 50000);
        }

        $figlet = new Figlet();
        $figlet->setFontDir(__DIR__ . '/../font/');
        $figlet->setFont('roman');

        $topWindow->clear();
        $topWindow->refresh();

        $figletRenderer = new FigletRenderer($figlet, $gameWindow);
        $figletRenderer->renderCenter("{$statsBoard->getScore()} pts.", [
            'colorPair' => Screen::COLOR_GREEN_ON_BLACK
        ]);

        sleep(2);
        $input->waitForKeyPress();
    }
}