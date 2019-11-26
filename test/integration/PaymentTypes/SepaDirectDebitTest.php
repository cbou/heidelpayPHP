<?php
/**
 * This class defines integration tests to verify interface and
 * functionality of the payment method sepa direct debit.
 *
 * Copyright (C) 2018 heidelpay GmbH
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @link  https://docs.heidelpay.com/
 *
 * @author  Simon Gabriel <development@heidelpay.com>
 *
 * @package  heidelpayPHP/test/integration/payment_types
 */
namespace heidelpayPHP\test\integration\PaymentTypes;

use heidelpayPHP\Constants\ApiResponseCodes;
use heidelpayPHP\Exceptions\HeidelpayApiException;
use heidelpayPHP\Resources\PaymentTypes\SepaDirectDebit;
use heidelpayPHP\Resources\TransactionTypes\Charge;
use heidelpayPHP\test\BasePaymentTest;
use RuntimeException;

class SepaDirectDebitTest extends BasePaymentTest
{
    /**
     * Verify sepa direct debit can be created.
     *
     * @test
     *
     * @throws HeidelpayApiException A HeidelpayApiException is thrown if there is an error returned on API-request.
     * @throws RuntimeException      A RuntimeException is thrown when there is a error while using the SDK.
     */
    public function sepaDirectDebitShouldBeCreatableWithMandatoryFieldsOnly()
    {
        /** @var SepaDirectDebit $directDebit */
        $directDebit = new SepaDirectDebit('DE89370400440532013000');
        $directDebit = $this->heidelpay->createPaymentType($directDebit);
        $this->assertInstanceOf(SepaDirectDebit::class, $directDebit);
        $this->assertNotNull($directDebit->getId());

        /** @var SepaDirectDebit $fetchedDirectDebit */
        $fetchedDirectDebit = $this->heidelpay->fetchPaymentType($directDebit->getId());
        $this->assertEquals($directDebit->expose(), $fetchedDirectDebit->expose());
    }

    /**
     * Verify sepa direct debit can be created.
     *
     * @test
     *
     * @return SepaDirectDebit
     *
     * @throws HeidelpayApiException A HeidelpayApiException is thrown if there is an error returned on API-request.
     * @throws RuntimeException      A RuntimeException is thrown when there is a error while using the SDK.
     */
    public function sepaDirectDebitShouldBeCreatable(): SepaDirectDebit
    {
        /** @var SepaDirectDebit $directDebit */
        $directDebit = (new SepaDirectDebit('DE89370400440532013000'))
            ->setHolder('Max Mustermann')
            ->setBic('COBADEFFXXX');
        $directDebit = $this->heidelpay->createPaymentType($directDebit);
        $this->assertInstanceOf(SepaDirectDebit::class, $directDebit);
        $this->assertNotNull($directDebit->getId());

        /** @var SepaDirectDebit $fetchedDirectDebit */
        $fetchedDirectDebit = $this->heidelpay->fetchPaymentType($directDebit->getId());
        $this->assertEquals($directDebit->expose(), $fetchedDirectDebit->expose());

        return $fetchedDirectDebit;
    }

    /**
     * Verify authorization is not allowed for sepa direct debit.
     *
     * @test
     *
     * @param SepaDirectDebit $directDebit
     *
     * @throws HeidelpayApiException A HeidelpayApiException is thrown if there is an error returned on API-request.
     * @throws RuntimeException      A RuntimeException is thrown when there is a error while using the SDK.
     * @depends sepaDirectDebitShouldBeCreatable
     */
    public function authorizeShouldThrowException(SepaDirectDebit $directDebit)
    {
        $this->expectException(HeidelpayApiException::class);
        $this->expectExceptionCode(ApiResponseCodes::API_ERROR_TRANSACTION_AUTHORIZE_NOT_ALLOWED);

        $this->heidelpay->authorize(1.0, 'EUR', $directDebit, self::RETURN_URL);
    }

    /**
     * @test
     *
     * @param SepaDirectDebit $directDebit
     *
     * @return Charge
     *
     * @throws HeidelpayApiException A HeidelpayApiException is thrown if there is an error returned on API-request.
     * @throws RuntimeException      A RuntimeException is thrown when there is a error while using the SDK.
     * @depends sepaDirectDebitShouldBeCreatable
     */
    public function directDebitShouldBeChargeable(SepaDirectDebit $directDebit): Charge
    {
        $charge = $directDebit->charge(100.0, 'EUR', self::RETURN_URL);
        $this->assertNotNull($charge);
        $this->assertNotNull($charge->getId());

        return $charge;
    }

    /**
     * Verify sdd charge is refundable.
     *
     * @test
     *
     * @param Charge $charge
     *
     * @throws HeidelpayApiException A HeidelpayApiException is thrown if there is an error returned on API-request.
     * @throws RuntimeException      A RuntimeException is thrown when there is a error while using the SDK.
     * @depends directDebitShouldBeChargeable
     */
    public function directDebitChargeShouldBeRefundable(Charge $charge)
    {
        $cancellation = $charge->cancel();
        $this->assertNotNull($cancellation);
        $this->assertNotNull($cancellation->getId());
    }
}
