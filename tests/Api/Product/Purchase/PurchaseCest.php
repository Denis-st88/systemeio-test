<?php

declare(strict_types=1);

namespace App\Tests\Api\Product\Purchase;

use App\Tests\Api\HttpHeaderTrait;
use App\Tests\ApiTester;
use Codeception\Util\HttpCode;

class PurchaseCest
{
    use HttpHeaderTrait;

    private const string ROUTE = '/api/v1/purchase';

    public function success(ApiTester $tester): void
    {
        $tester->sendPost(
            self::ROUTE,
            [
                'product' => 1,
                'taxNumber' => 'DE123456789',
                'couponCode' => 'P20',
                'paymentProcessor' => 'paypal'
            ]
        );

        $tester->seeResponseCodeIs(HttpCode::OK);

        $tester->seeResponseContainsJson([
            'code' => 'SUCCESS'
        ]);
    }

    public function incorrectPaymentType(ApiTester $tester): void
    {
        $tester->sendPost(
            self::ROUTE,
            [
                'product' => 1,
                'taxNumber' => 'DE123456789',
                'couponCode' => 'P20',
                'paymentProcessor' => 'incorrect'
            ]
        );

        $tester->seeResponseCodeIs(HttpCode::BAD_REQUEST);

        $tester->seeResponseContainsJson([
            'errors' => [
                'field' => 'paymentProcessor',
                'message' => 'Invalid value "incorrect". Please select one of the following types: "paypal", "stripe".',
            ]
        ]);
    }

    public function failPayment(ApiTester $tester): void
    {
        $tester->sendPost(
            self::ROUTE,
            [
                'product' => 1,
                'taxNumber' => 'DE123456789',
                'couponCode' => 'P20',
                'paymentProcessor' => 'stripe'
            ]
        );

        $tester->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);

        $tester->seeResponseContainsJson([
            'message' => 'Price must be bigger then 100',
        ]);
    }
}
