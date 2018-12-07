<?php
/**
 * This file defines the constants needed for the card example.
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
 * @link  http://dev.heidelpay.com/
 *
 * @author  Simon Gabriel <development@heidelpay.com>
 *
 * @package  heidelpay/mgw_sdk/examples
 */

require_once __DIR__ . '/../Constants.php';

define('EXAMPLE_PATH', __DIR__);
define('EXAMPLE_URL', EXAMPLE_BASE_FOLDER . 'CreditCardCharge');
define('CONTROLLER_URL', EXAMPLE_URL . '/Controller.php');
define('EXAMPLE_PUBLIC_KEY', PUBLIC_KEY);
define('EXAMPLE_PRIVATE_KEY', PRIVATE_KEY);
