(function () {
    'use strict';
    angular
        .module('app')

        .factory('DSConfirmationSvc', DSConfirmationSvc)
    DSConfirmationSvc.$inject = ['baseService'];

    function DSConfirmationSvc(baseService) {
        var service = new baseService();
        service.url = APIURL + 'api/dar_confirmation';
        return service;
    }
})();
