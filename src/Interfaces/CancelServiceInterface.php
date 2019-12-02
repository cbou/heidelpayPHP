<?php
/**
 * Description
 *
 * @license Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 * @copyright Copyright © 2016-present heidelpay GmbH. All rights reserved.
 *
 * @link  http://dev.heidelpay.com/
 *
 * @author  Simon Gabriel <development@heidelpay.de>
 *
 * @package  heidelpay/${Package}
 */
namespace heidelpayPHP\Interfaces;

use heidelpayPHP\Constants\CancelReasonCodes;
use heidelpayPHP\Exceptions\HeidelpayApiException;
use heidelpayPHP\Resources\Payment;
use heidelpayPHP\Resources\TransactionTypes\Authorization;
use heidelpayPHP\Resources\TransactionTypes\Cancellation;
use heidelpayPHP\Resources\TransactionTypes\Charge;
use RuntimeException;

interface CancelServiceInterface
{
    /**
     * Performs a Cancellation transaction and returns the resulting Cancellation object.
     * Performs a full cancel if the parameter amount is null.
     *
     * @param Authorization $authorization The Authorization to be canceled.
     * @param float|null    $amount        The amount to be canceled.
     *
     * @return Cancellation The resulting Cancellation object.
     *
     * @throws HeidelpayApiException A HeidelpayApiException is thrown if there is an error returned on API-request.
     * @throws RuntimeException      A RuntimeException is thrown when there is a error while using the SDK.
     */
    public function cancelAuthorization(Authorization $authorization, float $amount = null): Cancellation;

    /**
     * Performs a Cancellation transaction for the Authorization of the given Payment object.
     * Performs a full cancel if the parameter amount is null.
     *
     * @param Payment|string $payment The Payment object or the id of the Payment the Authorization belongs to.
     * @param float|null     $amount  The amount to be canceled.
     *
     * @return Cancellation Resulting Cancellation object.
     *
     * @throws HeidelpayApiException A HeidelpayApiException is thrown if there is an error returned on API-request.
     * @throws RuntimeException      A RuntimeException is thrown when there is a error while using the SDK.
     */
    public function cancelAuthorizationByPayment($payment, float $amount = null): Cancellation;

    /**
     * Performs a Cancellation transaction for the given Charge and returns the resulting Cancellation object.
     * Performs a full cancel if the parameter amount is null.
     *
     * @param Payment|string $payment          The Payment object or the id of the Payment the charge belongs to.
     * @param string         $chargeId         The id of the Charge to be canceled.
     * @param float|null     $amount           The amount to be canceled.
     *                                         This will be sent as amountGross in case of Hire Purchase payment method.
     * @param string|null    $reasonCode       Reason for the Cancellation ref \heidelpayPHP\Constants\CancelReasonCodes.
     * @param string|null    $paymentReference A reference string for the payment.
     * @param float|null     $amountNet        The net value of the amount to be cancelled (Hire Purchase only).
     * @param float|null     $amountVat        The vat value of the amount to be cancelled (Hire Purchase only).
     *
     * @return Cancellation The resulting Cancellation object.
     *
     * @throws HeidelpayApiException A HeidelpayApiException is thrown if there is an error returned on API-request.
     * @throws RuntimeException      A RuntimeException is thrown when there is a error while using the SDK.
     */
    public function cancelChargeById(
        $payment,
        string $chargeId,
        float $amount = null,
        string $reasonCode = null,
        string $paymentReference = null,
        float $amountNet = null,
        float $amountVat = null
    ): Cancellation;

    /**
     * Performs a Cancellation transaction and returns the resulting Cancellation object.
     * Performs a full cancel if the parameter amount is null.
     *
     * @param Charge      $charge           The Charge object to create the Cancellation for.
     * @param float|null  $amount           The amount to be canceled.
     *                                      This will be sent as amountGross in case of Hire Purchase payment method.
     * @param string|null $reasonCode       Reason for the Cancellation ref \heidelpayPHP\Constants\CancelReasonCodes.
     * @param string|null $paymentReference A reference string for the payment.
     * @param float|null  $amountNet        The net value of the amount to be cancelled (Hire Purchase only).
     * @param float|null  $amountVat        The vat value of the amount to be cancelled (Hire Purchase only).
     *
     * @return Cancellation The resulting Cancellation object.
     *
     * @throws HeidelpayApiException A HeidelpayApiException is thrown if there is an error returned on API-request.
     * @throws RuntimeException      A RuntimeException is thrown when there is a error while using the SDK.
     */
    public function cancelCharge(
        Charge $charge,
        float $amount = null,
        string $reasonCode = null,
        string $paymentReference = null,
        float $amountNet = null,
        float $amountVat = null
    ): Cancellation;

    /**
     * Performs a Cancellation transaction on the Payment.
     * If no amount is given a full cancel will be performed i. e. all Charges and Authorizations will be cancelled.
     *
     * @param Payment     $payment          The payment whose authorization should be canceled.
     * @param float|null  $amount           The amount to be canceled.
     *                                      This will be sent as amountGross in case of Hire Purchase payment method.
     * @param string|null $reasonCode       Reason for the Cancellation ref \heidelpayPHP\Constants\CancelReasonCodes.
     * @param string|null $paymentReference A reference string for the payment.
     * @param float|null  $amountNet        The net value of the amount to be cancelled (Hire Purchase only).
     * @param float|null  $amountVat        The vat value of the amount to be cancelled (Hire Purchase only).
     *
     * @return Cancellation[] An array holding all Cancellation objects created with this cancel call.
     *
     * @throws HeidelpayApiException A HeidelpayApiException is thrown if there is an error returned on API-request.
     * @throws RuntimeException      A RuntimeException is thrown when there is a error while using the SDK.
     */
    public function cancelPayment(
        Payment $payment,
        float $amount = null,
        $reasonCode = CancelReasonCodes::REASON_CODE_CANCEL,
        string $paymentReference = null,
        float $amountNet = null,
        float $amountVat = null
    ): array;

    /**
     * Cancel the given amount of the payments authorization.
     *
     * @param Payment    $payment The payment whose authorization should be canceled.
     * @param float|null $amount  The amount to be cancelled. If null the remaining uncharged amount of the authorization
     *                            will be cancelled completely. If it exceeds the remaining uncharged amount the
     *                            cancellation will only cancel the remaining uncharged amount.
     *
     * @return Cancellation|null The resulting cancellation.
     *
     * @throws HeidelpayApiException A HeidelpayApiException is thrown if there is an error returned on API-request.
     * @throws RuntimeException      A RuntimeException is thrown when there is a error while using the SDK.
     */
    public function cancelPaymentAuthorization(Payment $payment, float $amount = null);
}
