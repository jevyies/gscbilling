(function () {
    'use strict';
    angular
        .module('app')

        .factory('UserSvc', UserSvc)
    UserSvc.$inject = ['baseService'];

    function UserSvc(baseService) {
        var service = new baseService();
        service.url = APIURL + 'api/users';
        return service;
    }
})();
