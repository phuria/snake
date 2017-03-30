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

use Phuria\Snake\Ncurses\Screen;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class FormattedText
{
    /**
     * @var string
     */
    private $text;

    /**
     * @var bool
     */
    private $colorInverted;

    /**
     * @var int
     */
    private $colorPair;

    /**
     * @param string $text
     * @param array  $options
     */
    public function __construct($text, array $options = [])
    {
        $options = (new OptionsResolver())->setDefaults([
            'colorInverted' => false,
            'colorPair'     => Screen::COLOR_DEFAULT
        ])->resolve($options);

        $this->text = $text;
        $this->colorInverted = $options['colorInverted'];
        $this->colorPair = $options['colorPair'];
    }

    /**
     * @return bool
     */
    public function isColorInverted()
    {
        return $this->colorInverted;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @return int
     */
    public function getColorPair()
    {
        return $this->colorPair;
    }
}