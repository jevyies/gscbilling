(function() {
    'use strict';
    angular
        .module('app')

    .factory('DMPIDARSvc', DMPIDARSvc)
        .factory('DMPIDARDetailDetailSvc', DMPIDARDetailDetailSvc)
        .factory('DMPIDARDetailIncentiveSvc', DMPIDARDetailIncentiveSvc)

    DMPIDARSvc.$inject = ['baseService'];
    DMPIDARDetailDetailSvc.$inject = ['baseService'];
    DMPIDARDetailIncentiveSvc.$inject = ['baseService'];

    function DMPIDARSvc(baseService) {
        var service = new baseService();
        service.url = APIURL + 'api/dmpi_dar';
        return service;
    }

    function DMPIDARDetailDetailSvc(baseService) {
        var service = new baseService();
        service.url = APIURL + 'api/dmpi_dar/supervisor';
        return service;
    }

    function DMPIDARDetailIncentiveSvc(baseService) {
        var service = new baseService();
        service.url = APIURL + 'api/dmpi_dar/incentive';
        return service;
    }
})();