(function() {
    'use strict';
    angular
        .module('app')

    .factory('OCCBSvc', OCCBSvc)
        .factory('OCCBDtlSvc', OCCBDtlSvc)

    OCCBSvc.$inject = ['baseService'];
    OCCBDtlSvc.$inject = ['baseService'];

    function OCCBSvc(baseService) {
        var service = new baseService();
        service.url = APIURL + 'api/oc_cb';
        return service;
    }

    function OCCBDtlSvc(baseService) {
        var service = new baseService();
        service.url = APIURL + 'api/oc_cb/detail';
        return service;
    }
})();