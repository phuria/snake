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
interface AdvanceInterface
{
    /**
     * Must be called every game tick.
     */
    public function advance();
}