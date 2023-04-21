/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright  Copyright (c)  2023.  Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

define([
    'jquery',
    'Magento_Ui/js/form/element/date',
    'jquery/ui'
], function ($, Date) {
    'use strict';

    return Date.extend({
        initialize: function () {
            this._super();
            this.options.beforeShowDay = function (date) {
                let day = date.getDay();
                let dateString = ('0' + date.getDate()).slice(-2) + '-' + ('0' + (date.getMonth() + 1)).slice(-2) +
                    '-' + date.getFullYear();
                let excludedDates = window.checkoutConfig.datesOff;
                console.log('excludedDates1', excludedDates);
                excludedDates = Object.values(excludedDates).map(function (obj) {
                    return obj.date;
                });
                console.log('window.checkoutConfig.datesOff', window.checkoutConfig.datesOff);
                console.log('dateString', dateString);
                console.log('excludedDates2', excludedDates);
                return [
                    (window.checkoutConfig.daysOffArrayCode.indexOf(day) === -1) &&
                    (excludedDates.indexOf(dateString) === -1)];
            };
        }
    });
});
