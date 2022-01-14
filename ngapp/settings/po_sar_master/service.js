(function () {
    'use strict';
    angular
        .module('app')

        .factory('POSarSvc', POSarSvc)
    POSarSvc.$inject = ['baseService'];

    function POSarSvc(baseService) {
        var service = new baseService();
        service.url = APIURL + 'api/sar_po';
        return service;
    }
})();
