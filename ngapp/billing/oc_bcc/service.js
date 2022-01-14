(function() {
    'use strict';
    angular
        .module('app')

    .factory('OCBccSvc', OCBccSvc)
        .factory('OCBccDtlSvc', OCBccDtlSvc)

    OCBccSvc.$inject = ['baseService'];
    OCBccDtlSvc.$inject = ['baseService'];

    function OCBccSvc(baseService) {
        var service = new baseService();
        service.url = APIURL + 'api/oc_bcc';
        return service;
    }

    function OCBccDtlSvc(baseService) {
        var service = new baseService();
        service.url = APIURL + 'api/oc_bcc/detail';
        return service;
    }
})();