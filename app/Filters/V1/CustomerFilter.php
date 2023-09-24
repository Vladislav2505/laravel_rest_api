<?php

namespace App\Filters\V1;

use App\Filters\ApiFilter;
use Illuminate\Http\Request;

class CustomerFilter extends ApiFilter
{
    protected array $saveParams = [
        'name' => ['eq'],
        'type' => ['eq'],
        'email' => ['eq'],
        'address' => ['eq'],
        'city' => ['eq'],
        'postalCode' => ['eq', 'gt', 'lt'],
    ];

    protected array $columnMap = [
        'postalCode' => 'postal_code',
    ];

    protected array $operatorMap = [
        'eq' => '=',
        'gt' => '>',
        'lt' => '<',
        'lte' => '<=',
        'qte' => '>=',
    ];
}
