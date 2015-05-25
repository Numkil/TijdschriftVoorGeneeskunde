<?php

namespace AppBundle\Entity\Types;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

/**
 * Class PricingType
 */
class PaymentType extends AbstractEnumType
{
    const DEFAULT_PRICE = 'D';            //60 euro
    const STUDENT_PRICE = 'S';            //30 euro
    const FOREIGN_PRICE = 'F';            //70 euro
    const BOOKSTORE_PRICE = 'B';          //?? euro
    const FREE_PRICE = 'FR';
    const MENTOR_PRICE = 'M';             //30 euro
    const FOREIGN_DOCTOR_PRICE = 'FD';    //?? euro

    protected static $choices = [
        self::DEFAULT_PRICE => 'Default price',
        self::STUDENT_PRICE => 'Student price',
        self::FOREIGN_PRICE => 'Foreign price',
        self::BOOKSTORE_PRICE => 'Bookstore price',
        self::FREE_PRICE => 'Free price',
        self::MENTOR_PRICE => 'Mentor price',
        self::FOREIGN_DOCTOR_PRICE => 'Foreign Doctor price',
    ];
}
