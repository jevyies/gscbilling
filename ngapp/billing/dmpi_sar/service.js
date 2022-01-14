(function () {
    'use strict';
    angular
        .module('app')

        .factory('DMPISARSvc', DMPISARSvc)
    DMPISARSvc.$inject = ['baseService'];

    function DMPISARSvc(baseService) {
        var service = new baseService();
        service.url = APIURL + 'api/dmpi_sar';
        return service;
    }
})();
