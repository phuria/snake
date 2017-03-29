<?php

/**
 * This file is part of phuria/snake package.
 *
 * Copyright (c) 2017 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\Snake\Input;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class InputReader
{
    /**
     * @var resource
     */
    private $handler;

    /**
     * InputReader constructor.
     */
    public function __construct()
    {
        $this->handler = fopen('php://stdin', 'r');
        stream_set_blocking($this->handler, false);
    }

    /**
     * @return string
     */
    public function readInput()
    {
        return fread($this->handler, 16);
    }

    /**
     * @return string
     */
    public function readLatestKey()
    {
        $input = $this->readInput();

        return $input ? substr($input, -1) : null;
    }
}