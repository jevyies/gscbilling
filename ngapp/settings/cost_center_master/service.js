(function () {
    'use strict';
    angular
        .module('app')

        .factory('CCSvc', CCSvc)
        CCSvc.$inject = ['baseService'];

    function CCSvc(baseService) {
        var service = new baseService();
        service.url = APIURL + 'api/cost_center';
        return service;
    }
})();
