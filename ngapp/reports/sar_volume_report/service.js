(function () {
    'use strict';
    angular
        .module('app')

        .factory('VRSvc', VRSvc)

    VRSvc.$inject = ['baseService'];

    function VRSvc(baseService) {
        var service = new baseService();
        service.url = APIURL + 'report/sar_volume_report';
        return service;
    }
})();
