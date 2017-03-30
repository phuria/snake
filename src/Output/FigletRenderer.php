<?php

/**
 * This file is part of phuria/snake package.
 *
 * Copyright (c) 2017 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\Snake\Output;

use Phuria\Snake\Ncurses\Window;
use Povils\Figlet\Figlet;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class FigletRenderer
{
    /**
     * @var Figlet
     */
    private $figlet;

    /**
     * @var Window
     */
    private $window;

    /**
     * @param Figlet $figlet
     * @param Window $window
     */
    public function __construct(Figlet $figlet, Window $window)
    {
        $this->figlet = $figlet;
        $this->window = $window;
    }

    /**
     * @param string $text
     * @param array  $options
     */
    public function renderCenter($text, array $options = [])
    {
        $this->window->clear();
        $this->window->renderTextBlockCentered($this->figlet->render($text), $options);
        $this->window->refresh();
    }
}