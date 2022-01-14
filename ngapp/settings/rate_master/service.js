(function () {
    'use strict';
    angular
        .module('app')

        .factory('RateSvc', RateSvc)
    RateSvc.$inject = ['baseService'];

    function RateSvc(baseService) {
        var service = new baseService();
        service.url = APIURL + 'api/rate';
        return service;
    }
})();
