(function () {
    'use strict';
    angular
        .module('app')

        .factory('BSignatorySvc', BSignatorySvc)
        BSignatorySvc.$inject = ['baseService'];

    function BSignatorySvc(baseService) {
        var service = new baseService();
        service.url = APIURL + 'api/billing_signatory';
        return service;
    }
})();
