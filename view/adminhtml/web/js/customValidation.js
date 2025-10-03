/**
 * Mavenbird Technologies Private Limited
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://mavenbird.com/Mavenbird-Module-License.txt
 *
 * =================================================================
 *
 * @category   Mavenbird
 * @package    Mavenbird_RefundRequest
 * @author     Mavenbird Team
 * @copyright  Copyright (c) 2018-2024 Mavenbird Technologies Private Limited ( http://mavenbird.com )
 * @license    http://mavenbird.com/Mavenbird-Module-License.txt
 */
require([
        'jquery',
        'mage/translate',
        'jquery/validate'],
    function($){
        $.validator.addMethod(
            'validate-comma-separated-emails', function (emaillist) {
                emaillist = emaillist.trim();
                if (emaillist.charAt(0) == ',' || emaillist.charAt(emaillist.length - 1) == ',') {
                    return false;
                }
                var emails = emaillist.split(',');
                var invalidEmails = [];
                var i;
                for (i = 0; i < emails.length; i++) {
                    var email = emails[i].trim();
                    if (email.length == 0) {
                        return false
                    } else {
                        if (!Validation.get('validate-email').test(email)) {
                            invalidEmails.push(email);
                        }
                    }
                }
                if (invalidEmails.length) {
                    return false;
                }
                return true;
            },
            $.mage.__('One or more admin email has an invalid email form, xample: john@gmail.com.'));
    }
);
