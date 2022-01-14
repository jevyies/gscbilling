(function() {
    'use strict';
    angular
        .module('app')

    .factory('OCSlersSvc', OCSlersSvc)
        .factory('OCSlersDtlSvc', OCSlersDtlSvc)

    OCSlersSvc.$inject = ['baseService'];
    OCSlersDtlSvc.$inject = ['baseService'];

    function OCSlersSvc(baseService) {
        var service = new baseService();
        service.url = APIURL + 'api/oc_slers';
        return service;
    }

    function OCSlersDtlSvc(baseService) {
        var service = new baseService();
        service.url = APIURL + 'api/oc_slers/detail';
        return service;
    }
})();