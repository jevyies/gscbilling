(function() {
    'use strict';
    angular
        .module('app')

    .factory('OCLABNOTINSvc', OCLABNOTINSvc)
        .factory('OCLABNOTINDTLSvc', OCLABNOTINDTLSvc)

    OCLABNOTINSvc.$inject = ['baseService'];
    OCLABNOTINDTLSvc.$inject = ['baseService'];

    function OCLABNOTINSvc(baseService) {
        var service = new baseService();
        service.url = APIURL + 'api/oc_labnotin';
        return service;
    }

    function OCLABNOTINDTLSvc(baseService) {
        var service = new baseService();
        service.url = APIURL + 'api/oc_labnotin/detail';
        return service;
    }
})();