angular.module('app')
    .controller('SARPerDeptReportCtrl', SARPerDeptReportCtrl)

SARPerDeptReportCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector', 'data', '$uibModalInstance'];

function SARPerDeptReportCtrl($scope, $ocLazyLoad, $injector, data, $uibModalInstance) {
    var modal = this;
    modal.variables = {};
    modal.variables.dept = 'ALL';
    modal.variables.from = new Date();
    modal.variables.to = new Date();
    $ocLazyLoad.load([
        REPURL + 'dmpi_oc_reports/service.js?v=' + VERSION,
    ]).then(function (d) {
        SARPerDeptReportSvc = $injector.get('SARPerDeptReportSvc');
    });

    modal.print = function (type) {
        var from = AppSvc.getDate(modal.variables.from);
        var to = AppSvc.getDate(modal.variables.to);
        SARPerDeptReportSvc.get({ dept: modal.variables.dept, from: from, to: to, exists: true }).then(function (response) {
            if (response.message) {
                return AppSvc.showSwal('Error', 'Nothing to Display', 'error');
            }
            window.open('report/dmpi_oc/sar_per_department?' + type + '=true&from=' + from + '&to=' + to + '&dept=' + modal.variables.dept);
        })
    }
    modal.close = function () {
        $uibModalInstance.dismiss('cancel');
    }
}