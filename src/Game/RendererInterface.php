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

use Phuria\Snake\Output\FormattedText;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
interface RendererInterface
{
    /**
     * @param int           $positionX
     * @param int           $positionY
     * @param FormattedText $text
     */
    public function renderText($positionX, $positionY, FormattedText $text);
}