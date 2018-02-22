<?php

/*
 * This file is part of eoko\magento2.
 *
 * PHP Version 7.1
 *
 * @author    Romain DARY <romain.dary@eoko.fr>
 * @copyright 2011-2018 Eoko. All rights reserved.
 */

namespace Eoko\Magento2\Client\Search;

use Eoko\Magento2\Client\Exception\NotAValidOperator;

class SearchFilter
{
    const EQ = 'eq';
    const FINSET = 'finset';
    const FROM = 'from';
    const GT = 'gt';
    const GTEQ = 'gteq';
    const IN = 'in';
    const LIKE = 'like';
    const LT = 'lt';
    const LTEQ = 'lteq';
    const MOREQ = 'moreq';
    const NEQ = 'neq';
    const NIN = 'nin';
    const NOTNULL = 'notnull';
    const NULL = 'null';
    const TO = 'to';

    public static $operators = [
        self::EQ => 'Equals',
        self::FINSET => 'A value within a set of values',
        self::FROM => 'The beginning of a range. Must be used with to',
        self::GT => 'Greater than',
        self::GTEQ => 'Greater than or equal',
        self::IN => 'In. The value can contain a comma-separated list of values.',
        self::LIKE => 'Like. The value can contain the SQL wildcard characters when like is specified.',
        self::LT => 'Less than',
        self::LTEQ => 'Less than or equal',
        self::MOREQ => 'More or equal',
        self::NEQ => 'Not equal',
        self::NIN => 'Not in. The value can contain a comma-separated list of values.',
        self::NOTNULL => 'Not null',
        self::NULL => 'Null',
        self::TO => 'The end of a range. Must be used with from',
    ];

    protected $field;
    protected $value;
    protected $conditionType;

    /**
     * SearchItem constructor.
     *
     * @param $field
     * @param $value
     * @param $conditionType
     *
     * @throws NotAValidOperator
     */
    public function __construct(string $field, string $value, string $conditionType)
    {
        $this->field = $field;
        $this->value = $value;

        if (!isset(self::$operators[$conditionType])) {
            throw new NotAValidOperator($conditionType);
        }
        $this->conditionType = $conditionType;
    }

    public function toArray()
    {
        return [
            'field' => $this->field,
            'value' => $this->value,
            'condition_type' => $this->conditionType,
        ];
    }
}
