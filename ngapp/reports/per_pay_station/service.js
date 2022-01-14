(function () {
    'use strict';
    angular
        .module('app')

        .factory('PPStationSvc', PPStationSvc)

    PPStationSvc.$inject = ['baseService'];

    function PPStationSvc(baseService) {
        var service = new baseService();
        service.url = APIURL + 'report/pp_station_report';
        return service;
    }
})();
