<?php

namespace AppBundle\DBAL\Types;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

class UserPositionType extends AbstractEnumType
{
    const FIRST  = 'first';
    const SECOND = 'second';
    const THIRD  = 'third';

    protected static $choices = array(
        self::FIRST  => 'first',
        self::SECOND => 'second',
        self::THIRD  => 'third',
    );
}
