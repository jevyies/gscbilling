angular.module('app')
    .controller('SARPOReportCtrl', SARPOReportCtrl)

SARPOReportCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector', 'data', '$uibModalInstance'];

function SARPOReportCtrl($scope, $ocLazyLoad, $injector, data, $uibModalInstance) {
    var modal = this;
    modal.variables = {};
    modal.variables.from = new Date();
    modal.variables.to = new Date();
    $ocLazyLoad.load([
        REPURL + 'dmpi_oc_reports/service.js?v=' + VERSION,
    ]).then(function (d) {
        SARPOReportSvc = $injector.get('SARPOReportSvc');
    });

    modal.print = function (type) {
        var from = AppSvc.getDate(modal.variables.from);
        var to = AppSvc.getDate(modal.variables.to);
        SARPOReportSvc.get({ from: from, to: to, exists: true }).then(function (response) {
            if (response.message) {
                return AppSvc.showSwal('Error', 'Nothing to Display', 'error');
            }
            window.open('report/dmpi_oc/sar_po_report?' + type + '=true&from=' + from + '&to=' + to);
        })
    }
    modal.close = function () {
        $uibModalInstance.dismiss('cancel');
    }
}