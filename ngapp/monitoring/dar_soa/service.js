(function () {
    'use strict';
    angular
        .module('app')

        .factory('DSMonitoringSvc', DSMonitoringSvc)
    DSMonitoringSvc.$inject = ['baseService'];

    function DSMonitoringSvc(baseService) {
        var service = new baseService();
        service.url = APIURL + 'api/dar_soa_monitoring';
        return service;
    }
})();
