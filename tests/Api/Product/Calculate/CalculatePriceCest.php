<?php

declare(strict_types=1);

namespace App\Tests\Api\Product\Calculate;

use App\Tests\Api\HttpHeaderTrait;
use App\Tests\ApiTester;
use Codeception\Util\HttpCode;

class CalculatePriceCest
{
    use HttpHeaderTrait;

    private const string ROUTE = '/api/v1/calculate-price';

    public function success(ApiTester $tester): void
    {
        $tester->sendPost(
            self::ROUTE,
            [
                'product' => 1,
                'taxNumber' => 'DE123456789',
                'couponCode' => 'P20'
            ]
        );

        $tester->seeResponseCodeIs(HttpCode::OK);

        $tester->seeResponseMatchesJsonType([
            'price' => 'float:>=0'
        ]);
    }

    public function incorrectTaxNumberLength(ApiTester $tester): void
    {
        $tester->sendPost(
            self::ROUTE,
            [
                'product' => 1,
                'taxNumber' => 'DE123',
                'couponCode' => 'P20'
            ]
        );

        $tester->seeResponseCodeIs(HttpCode::BAD_REQUEST);

        $tester->seeResponseContainsJson([
            'errors' => [
                'field' => 'taxNumber',
                'message' => 'Invalid tax number.',
            ]
        ]);
    }

    public function incorrectTaxNumberFormat(ApiTester $tester): void
    {
        $tester->sendPost(
            self::ROUTE,
            [
                'product' => 1,
                'taxNumber' => 'FAKE123456789',
                'couponCode' => 'P30'
            ]
        );

        $tester->seeResponseCodeIs(HttpCode::BAD_REQUEST);

        $tester->seeResponseContainsJson([
            'errors' => [
                'field' => 'taxNumber',
                'message' => 'Invalid tax number.',
            ]
        ]);
    }

    public function incorrectTaxNumberType(ApiTester $tester): void
    {
        $tester->sendPost(
            self::ROUTE,
            [
                'product' => 1,
                'taxNumber' => null,
                'couponCode' => 'P20'
            ]
        );

        $tester->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);

        $tester->seeResponseContainsJson([
            'errors' => [
                'field' => 'taxNumber',
                'message' => 'The type of the "taxNumber" must be one of types "string" (null given)',
            ]
        ]);
    }

    public function incorrectCouponCode(ApiTester $tester): void
    {
        $tester->sendPost(
            self::ROUTE,
            [
                'product' => 1,
                'taxNumber' => 'DE123456789',
                'couponCode' => 'P1'
            ]
        );

        $tester->seeResponseCodeIs(HttpCode::BAD_REQUEST);

        $tester->seeResponseContainsJson([
            'errors' => [
                'field' => 'couponCode',
                'message' => 'The coupon "P1" does not exist',
            ]
        ]);
    }

    public function incorrectProductId(ApiTester $tester): void
    {
        $tester->sendPost(
            self::ROUTE,
            [
                'product' => 777,
                'taxNumber' => 'DE123456789',
                'couponCode' => 'P30'
            ]
        );

        $tester->seeResponseCodeIs(HttpCode::NOT_FOUND);

        $tester->seeResponseContainsJson([
            'message' => 'Product entity id "777" not found.',
        ]);
    }
}
