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

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class Board implements AdvanceInterface
{
    const RESULT_GAME_OVER = 1;
    const RESULT_GAME_IN_PROGRESS = 2;

    /**
     * @var PositionHolder[]
     */
    private $elements = [];

    /**
     * @var array
     */
    private $map = [];

    /**
     * @var int
     */
    private $sizeX;

    /**
     * @var int
     */
    private $sizeY;

    /**
     * @var StatsBoard
     */
    private $statsBoard;

    /**
     * @param int        $sizeX
     * @param int        $sizeY
     * @param StatsBoard $statsBoard
     */
    public function __construct($sizeX, $sizeY, StatsBoard $statsBoard)
    {
        for ($x = 0; $x <= $sizeX; $x++) {
            for ($y = 0; $y <= $sizeY; $y++) {
                $this->map[$x][$y] = $this->elements[] = $holder = new PositionHolder($x, $y);
            }
        }

        $this->sizeX = $sizeX;
        $this->sizeY = $sizeY;
        $this->statsBoard = $statsBoard;
    }

    /**
     * @param int $length
     */
    public function initializeSnake($length = 30)
    {
        $centerX = $this->getCenterX();
        $centerY = $this->getCenterY();

        for ($i = 0; $i < $length; $i++) {
            $this->getHolder($centerX, $centerY + $i)->addPayload(
                0 === $i ? new SnakeHead() : new SnakePart($length - $i)
            );
        }
    }

    /**
     * @return int
     */
    public function getCenterX()
    {
        return (int) $this->sizeX / 2;
    }

    /**
     * @return int
     */
    public function getCenterY()
    {
        return (int) $this->sizeY / 2;
    }

    /**
     * @param int $x
     * @param int $y
     *
     * @return PositionHolder
     */
    public function getHolder($x, $y)
    {
        return $this->map[$x][$y];
    }

    /**
     * @return PositionHolder[]
     */
    public function getElements()
    {
        return $this->elements;
    }

    /**
     * @inheritdoc
     */
    public function advance()
    {
        foreach ($this->elements as $element) {
            $element->advance();
        }

        if (1 === rand(0, 15)) {
            $this->seedFruit();
        }

        $this->statsBoard->addScore(10);
        $this->statsBoard->advance();
    }

    /**
     * Create fruit on random position.
     */
    public function seedFruit()
    {
        $holder = $this->getHolder(rand(0, $this->sizeX), rand(0, $this->sizeY));

        if ($holder->isSnakeHere() || $holder->getFruit()) {
            $this->seedFruit();
            return;
        }

        $holder->addPayload(new Fruit());
    }

    /**
     * @param RendererInterface $renderer
     */
    public function render(RendererInterface $renderer)
    {
        foreach ($this->elements as $element) {
            $element->render($renderer);
        }
    }

    /**
     * @param int $x
     * @param int $y
     *
     * @return int
     */
    public function modifyHeadPosition($x, $y)
    {
        foreach ($this->elements as $element) {
            if ($head = $element->getSnakeHead()) {
                $element->removePayload($head);

                $x = $this->checkPosition($element->getX() + $x, $this->sizeX);
                $y = $this->checkPosition($element->getY() + $y, $this->sizeY);

                $holder = $this->getHolder($x, $y);

                if ($holder->getSnakePart()) {
                    return static::RESULT_GAME_OVER;
                }

                $holder->addPayload(new SnakeHead());
                $element->addPayload(new SnakePart($this->snakePartCount()));

                if ($fruit = $holder->getFruit()) {
                    $holder->removePayload($fruit);
                    $this->statsBoard->addScore(1000);
                    $this->snakeGrow(3);
                }
            }
        }

        return static::RESULT_GAME_IN_PROGRESS;
    }

    /**
     * @param int $grow
     */
    public function snakeGrow($grow)
    {
        foreach ($this->elements as $element) {
            if ($part = $element->getSnakePart()) {
                $part->extendLife($grow);
            }
        }
    }

    /**
     * @param int $requested
     * @param int $max
     *
     * @return int
     */
    private function checkPosition($requested, $max)
    {
        if ($requested > $max) {
            return 0;
        }

        if ($requested < 0) {
            return $max;
        }

        return $requested;
    }

    /**
     * @return int
     */
    public function snakePartCount()
    {
        $count = 0;

        foreach ($this->elements as $element) {
            $count += (int) $element->getSnakePart();
        }

        return $count;
    }
}