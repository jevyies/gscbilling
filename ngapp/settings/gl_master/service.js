(function () {
    'use strict';
    angular
        .module('app')

        .factory('GLSvc', GLSvc)
        GLSvc.$inject = ['baseService'];

    function GLSvc(baseService) {
        var service = new baseService();
        service.url = APIURL + 'api/gl_code';
        return service;
    }
})();
