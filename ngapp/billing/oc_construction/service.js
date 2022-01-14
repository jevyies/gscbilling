(function() {
    'use strict';
    angular
        .module('app')

    .factory('OCConstructionSvc', OCConstructionSvc)
        .factory('OCConstructionDtlSvc', OCConstructionDtlSvc)

    OCConstructionSvc.$inject = ['baseService'];
    OCConstructionDtlSvc.$inject = ['baseService'];

    function OCConstructionSvc(baseService) {
        var service = new baseService();
        service.url = APIURL + 'api/oc_construction';
        return service;
    }

    function OCConstructionDtlSvc(baseService) {
        var service = new baseService();
        service.url = APIURL + 'api/oc_construction/detail';
        return service;
    }
})();