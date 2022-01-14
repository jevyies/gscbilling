(function() {
    'use strict';
    angular
        .module('app')

    .factory('OCDEARBCSvc', OCDEARBCSvc)
        .factory('OCDEARBCDtlSvc', OCDEARBCDtlSvc)
        .factory('OCDEARBCDearbcSvc', OCDEARBCDearbcSvc)
    OCDEARBCSvc.$inject = ['baseService'];
    OCDEARBCDtlSvc.$inject = ['baseService'];
    OCDEARBCDearbcSvc.$inject = ['baseService'];

    function OCDEARBCSvc(baseService) {
        var service = new baseService();
        service.url = APIURL + 'api/oc_dearbc';
        return service;
    }

    function OCDEARBCDtlSvc(baseService) {
        var service = new baseService();
        service.url = APIURL + 'api/oc_dearbc/detail';
        return service;
    }

    function OCDEARBCDearbcSvc(baseService) {
        var service = new baseService();
        service.url = APIURL + 'api/oc_dearbc/dearbc';
        return service;
    }
})();