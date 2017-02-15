<?php

namespace Sda\Millionaires\Prize;

/**
 * Class Prize
 * @package Sda\Millionaires\Prize
 */
class PrizeFactory
{
    /**
     * @param array $repoData
     * @param int $actualPrize
     * @return Prize
     */
    public static function buildPrize(array $repoData, $actualPrize)
    {
        $actualFlag = ($repoData['value'] === $actualPrize);

        return new Prize(
            $repoData['value'],
            'true' === $repoData['guarantee'],
            $actualFlag
        );

    }

    public static function buildQuestionCollection($actual)
    {
        $questions = [];

    }
}