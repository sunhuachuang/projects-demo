<?php

namespace AppBundle\DBAL\Types;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

class UserRoleType extends AbstractEnumType
{
    const GUEST = 'ROLE_GUEST';
    const USER  = 'ROLE_USER';
    const ADMIN = 'ROLE_ADMIN';
    const SUPER = 'ROLE_SUPER';

    protected static $choices = array(
        self::GUEST => 'guest',
        self::USER  => 'user',
        self::ADMIN => 'admin',
        self::SUPER => 'super'
    );
}
