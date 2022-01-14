(function () {
    'use strict';
    angular
        .module('app')

        .factory('DARReportSvc', DARReportSvc)

    DARReportSvc.$inject = ['baseService'];

    function DARReportSvc(baseService) {
        var service = new baseService();
        service.url = APIURL + 'report/dar_report';
        return service;
    }
})();
