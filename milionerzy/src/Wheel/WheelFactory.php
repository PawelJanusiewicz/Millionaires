<?php

namespace Sda\Millionaires\Wheel;

use Sda\Millionaires\Exception\ExceptionCodes;
use Sda\Millionaires\Exception\ExceptionMessages;
use Sda\Millionaires\Wheel\Exception\WheelException;

/**
 * Class WheelFactory
 * @package Sda\Millionaires\Wheel
 */
class WheelFactory
{

    /**
     * @param string $type
     * @param array $usedWheels
     * @return WheelSwitch
     * @throws WheelException
     */
    public static function makeWheel($type, array $usedWheels)
    {

        switch ($type) {
            case WheelSwitch::WHEEL_FIFTY_FIFTY:
                self::wheelUsageCheck(WheelSwitch::WHEEL_FIFTY_FIFTY, $usedWheels);
                return new FiftyFifty(WheelSwitch::WHEEL_FIFTY_FIFTY);
                break;
            case WheelSwitch::WHEEL_PUBLIC_QUESTION:
                self::wheelUsageCheck(WheelSwitch::WHEEL_PUBLIC_QUESTION, $usedWheels);
                return new PublicQuestion(WheelSwitch::WHEEL_PUBLIC_QUESTION);
                break;
            case WheelSwitch::WHEEL_EXPERT_QUESTION:
                self::wheelUsageCheck(WheelSwitch::WHEEL_EXPERT_QUESTION, $usedWheels);
                return new ExpertQuestion(WheelSwitch::WHEEL_EXPERT_QUESTION);
                break;
            case WheelSwitch::WHEEL_CHANGE_QUESTION:
                self::wheelUsageCheck(WheelSwitch::WHEEL_CHANGE_QUESTION, $usedWheels);
                return new ChangeQuestion(WheelSwitch::WHEEL_CHANGE_QUESTION);
                break;
            default:
                die('zla zmienna');
                break;
        }
    }

    private static function wheelUsageCheck($wheelType, $usedWheels)
    {
        if (true === in_array($wheelType, $usedWheels)) {
            throw new WheelException(
                ExceptionMessages::WHEEL_ALREADY_USED,
                ExceptionCodes::WHEEL_ALREADY_USED
            );
        }
    }
}