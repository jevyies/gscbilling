(function () {
    'use strict';
    angular
        .module('app')

        .factory('RTSvc', RTSvc)

    RTSvc.$inject = ['baseService'];

    function RTSvc(baseService) {
        var service = new baseService();
        service.url = APIURL + 'report/retro_report';
        return service;
    }
})();
