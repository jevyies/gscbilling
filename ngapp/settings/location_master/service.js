(function () {
    'use strict';
    angular
        .module('app')

        .factory('LocationSvc', LocationSvc)
        LocationSvc.$inject = ['baseService'];

    function LocationSvc(baseService) {
        var service = new baseService();
        service.url = APIURL + 'api/location';
        return service;
    }
})();
