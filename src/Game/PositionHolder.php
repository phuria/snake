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
class PositionHolder implements AdvanceInterface
{
    /**
     * @var int
     */
    private $x;

    /**
     * @var int
     */
    private $y;

    /**
     * @var PayloadInterface[]
     */
    private $payload = [];

    /**
     * @param int $x
     * @param int $y
     */
    public function __construct($x, $y)
    {
        $this->x = $x;
        $this->y = $y;
    }

    /**
     * @return int
     */
    public function getX()
    {
        return $this->x;
    }

    /**
     * @return int
     */
    public function getY()
    {
        return $this->y;
    }

    /**
     * @param PayloadInterface $payload
     */
    public function addPayload(PayloadInterface $payload)
    {
        $this->payload[spl_object_hash($payload)] = $payload;
    }

    /**
     * @param PayloadInterface $payload
     */
    public function removePayload(PayloadInterface $payload)
    {
        unset($this->payload[spl_object_hash($payload)]);
    }

    /**
     * @inheritdoc
     */
    public function advance()
    {
        foreach ($this->payload as $payload) {
            if ($payload->isExpired()) {
                $this->removePayload($payload);
                continue;
            }

            $payload->advance();
        }
    }

    /**
     * @param RendererInterface $renderer
     */
    public function render(RendererInterface $renderer)
    {
        foreach ($this->payload as $payload) {
            if ($payload->isVisible()) {
                $renderer->renderCharacter($this->getX(), $this->getY(), $payload->getCharacter());
            }
        }
    }
}