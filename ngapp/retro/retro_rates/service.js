(function () {
    'use strict';
    angular
        .module('app')

        .factory('RetroRateSvc', RetroRateSvc)
    RetroRateSvc.$inject = ['baseService'];

    function RetroRateSvc(baseService) {
        var service = new baseService();
        service.url = APIURL + 'api/retro_rate';
        return service;
    }
})();
