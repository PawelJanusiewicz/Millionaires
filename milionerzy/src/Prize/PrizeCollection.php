<?php

namespace Sda\Millionaires\Prize;

use Sda\Millionaires\TypedCollection;

/**
 * Class PrizeCollection
 * @package Sda\Millionaires\Prize
 */
class PrizeCollection extends TypedCollection
{
    /**
     * PrizeCollection constructor.
     */
    public function __construct()
    {
        $this->setItemType(Prize::class);
    }

}