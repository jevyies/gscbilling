(function() {
    'use strict';
    angular
        .module('app')

    .factory('OtherBillingMonitoringSvc', OtherBillingMonitoringSvc)
    OtherBillingMonitoringSvc.$inject = ['baseService'];

    function OtherBillingMonitoringSvc(baseService) {
        var service = new baseService();
        service.url = APIURL + 'report/monitoring_report_oc';
        return service;
    }
})();