<?php
/**
 * This provides validation functions concerning secret keys.
 *
 * Copyright (C) 2018 Heidelpay GmbH
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
 * @package  heidelpay/mgw_sdk/validators
 */
namespace heidelpay\MgwPhpSdk\Validators;

class KeyValidator
{
    /**
     * Returns true if the given key has a valid format.
     *
     * @param $key
     *
     * @return bool
     */
    public static function validate($key): bool
    {
        $match = [];
        preg_match('/^[sp]{1}-(priv)-[a-zA-Z0-9]+/', $key, $match);
        return !(\count($match) < 2 || $match[1] !== 'priv');
    }
}
