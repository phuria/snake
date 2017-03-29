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
     * @param  $sizeX
     * @param $sizeY
     */
    public function __construct($sizeX, $sizeY)
    {
        for ($x = 0; $x <= $sizeX; $x++) {
            for ($y = 0; $y <= $sizeY; $y++) {
                $this->map[$x][$y] = $this->elements[] = $holder = new PositionHolder($x, $y);
            }
        }

        $this->sizeX = $sizeX;
        $this->sizeY = $sizeY;
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
     */
    public function modifyHeadPosition($x, $y)
    {
        foreach ($this->elements as $element) {
            if ($head = $element->getSnakeHead()) {
                $element->removePayload($head);
                $element->addPayload(new SnakePart($this->snakePartCount()));

                $x = $this->checkPosition($element->getX() + $x, $this->sizeX);
                $y = $this->checkPosition($element->getY() + $y, $this->sizeY);

                $this->getHolder($x, $y)->addPayload(new SnakeHead());
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
            $count += (int) $element->hasSnakePart();
        }

        return $count;
    }
}