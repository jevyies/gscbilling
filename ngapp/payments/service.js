(function () {
    'use strict';
    angular
        .module('app')

        .factory('PaymentSvc', PaymentSvc)

    PaymentSvc.$inject = ['baseService'];

    function PaymentSvc(baseService) {
        var service = new baseService();
        service.url = APIURL + 'api/payment';
        return service;
    }
})();
