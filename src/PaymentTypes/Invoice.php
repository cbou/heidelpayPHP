<?php
/**
 * This represents the invoice payment type.
 *
 * @license Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 * @copyright Copyright © 2016-present heidelpay GmbH. All rights reserved.
 *
 * @link  http://dev.heidelpay.com/
 *
 * @author  Simon Gabriel <development@heidelpay.de>
 *
 * @package  heidelpay/PaymentTypes
 */
namespace heidelpay\NmgPhpSdk\PaymentTypes;

class Invoice extends BasePaymentType
{
    //<editor-fold desc="Overridable Methods">
    /**
     * {@inheritDoc}
     */
    public function getResourcePath()
    {
        return 'types/invoice';
    }
    //</editor-fold>
}
