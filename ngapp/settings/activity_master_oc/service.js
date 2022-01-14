(function() {
    'use strict';
    angular
        .module('app')

    .factory('ActivityOCSvc', ActivityOCSvc)
    ActivityOCSvc.$inject = ['baseService'];

    function ActivityOCSvc(baseService) {
        var service = new baseService();
        service.url = APIURL + 'api/activity_oc';
        return service;
    }
})();