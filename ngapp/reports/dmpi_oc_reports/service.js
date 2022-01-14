(function () {
    'use strict';
    angular
        .module('app')

        .factory('TransmittalReportSvc', TransmittalReportSvc)
        .factory('ReactivatedSOASvc', ReactivatedSOASvc)
        .factory('BANDSvc', BANDSvc)
        .factory('AgingReportSvc', AgingReportSvc)
        .factory('YearToDateSvc', YearToDateSvc)
        .factory('AllClientReportSvc', AllClientReportSvc)
        .factory('AnnualReportSvc', AnnualReportSvc)
        .factory('WeeklyReportSvc', WeeklyReportSvc)
        .factory('MonthlyReportSvc', MonthlyReportSvc)
        .factory('AccrualReportSvc', AccrualReportSvc)
        .factory('SARPerDeptReportSvc', SARPerDeptReportSvc)
        .factory('SARPOReportSvc', SARPOReportSvc)
        .factory('OCLedgerReportSvc', OCLedgerReportSvc)

        TransmittalReportSvc.$inject = ['baseService'];
        ReactivatedSOASvc.$inject = ['baseService'];
        BANDSvc.$inject = ['baseService'];
        AgingReportSvc.$inject = ['baseService'];
        YearToDateSvc.$inject = ['baseService'];
        AllClientReportSvc.$inject = ['baseService'];
        AnnualReportSvc.$inject = ['baseService'];
        WeeklyReportSvc.$inject = ['baseService'];
        MonthlyReportSvc.$inject = ['baseService'];
        AccrualReportSvc.$inject = ['baseService'];
        SARPerDeptReportSvc.$inject = ['baseService'];
        SARPOReportSvc.$inject = ['baseService'];
        OCLedgerReportSvc.$inject = ['baseService'];

    function TransmittalReportSvc(baseService) {
        var service = new baseService();
        service.url = APIURL + 'report/dmpi_oc/transmittal_report';
        return service;
    }
    function ReactivatedSOASvc(baseService) {
        var service = new baseService();
        service.url = APIURL + 'report/dmpi_oc/reactivated_soa';
        return service;
    }
    function BANDSvc(baseService) {
        var service = new baseService();
        service.url = APIURL + 'report/dmpi_oc/billing_and_collection';
        return service;
    }
    function AgingReportSvc(baseService) {
        var service = new baseService();
        service.url = APIURL + 'report/dmpi_oc/aging_report';
        return service;
    }
    function YearToDateSvc(baseService) {
        var service = new baseService();
        service.url = APIURL + 'report/dmpi_oc/year_to_date';
        return service;
    }
    function AllClientReportSvc(baseService) {
        var service = new baseService();
        service.url = APIURL + 'report/dmpi_oc/per_client_report';
        return service;
    }
    function AnnualReportSvc(baseService) {
        var service = new baseService();
        service.url = APIURL + 'report/dmpi_oc/annual_report';
        return service;
    }
    function WeeklyReportSvc(baseService) {
        var service = new baseService();
        service.url = APIURL + 'report/dmpi_oc/weekly_report';
        return service;
    }
    function WeeklyReportSvc(baseService) {
        var service = new baseService();
        service.url = APIURL + 'report/dmpi_oc/weekly_report';
        return service;
    }
    function MonthlyReportSvc(baseService) {
        var service = new baseService();
        service.url = APIURL + 'report/dmpi_oc/monthly_report';
        return service;
    }
    function AccrualReportSvc(baseService) {
        var service = new baseService();
        service.url = APIURL + 'report/dmpi_oc/accrual_report';
        return service;
    }
    function SARPerDeptReportSvc(baseService) {
        var service = new baseService();
        service.url = APIURL + 'report/dmpi_oc/sar_per_department';
        return service;
    }
    function SARPOReportSvc(baseService) {
        var service = new baseService();
        service.url = APIURL + 'report/dmpi_oc/sar_po_report';
        return service;
    }
    function OCLedgerReportSvc(baseService) {
        var service = new baseService();
        service.url = APIURL + 'report/dmpi_oc/oc_ledger_report';
        return service;
    }
})();
