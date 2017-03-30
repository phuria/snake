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

use Phuria\Snake\Ncurses\Window;
use Phuria\Snake\Output\FormattedText;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class StatsBoard implements AdvanceInterface
{
    const STATS_FORMAT = "   Snake - Copyright (c) 2017 Beniamin Jonatan Simko | Score: %d | Frame: %d | FPS: %d ";

    /**
     * @var Window
     */
    private $window;

    /**
     * @var int
     */
    private $framesCount = 0;

    /**
     * @var int
     */
    private $score = 0;

    /**
     * @var float
     */
    private $startTime;

    /**
     * @param Window $window
     */
    public function __construct(Window $window)
    {
        $this->window = $window;
        $this->startTime = microtime(true);
    }

    /**
     * @inheritdoc
     */
    public function advance()
    {
        $this->framesCount++;
        $fps = $this->framesCount / (microtime(true) - $this->startTime);
        $text = sprintf(static::STATS_FORMAT, $this->score, $this->framesCount, $fps);
        $this->window->renderTextWithPadding(0, new FormattedText($text, [
            'colorInverted' => true
        ]), ' ');
        $this->window->refresh();
    }

    /**
     * @param int $score
     */
    public function addScore($score)
    {
        $this->score += $score;
    }
}