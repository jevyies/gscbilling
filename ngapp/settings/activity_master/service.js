(function () {
    'use strict';
    angular
        .module('app')

        .factory('ActivitySvc', ActivitySvc)
    ActivitySvc.$inject = ['baseService'];

    function ActivitySvc(baseService) {
        var service = new baseService();
        service.url = APIURL + 'api/activity';
        return service;
    }
})();
