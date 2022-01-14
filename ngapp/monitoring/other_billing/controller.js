angular.module('app')
    .controller('OtherBillingMonitoringCtrl', OtherBillingMonitoringCtrl)

OtherBillingMonitoringCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector', '$filter'];

function OtherBillingMonitoringCtrl($scope, $ocLazyLoad, $injector, filter) {
    var vm = this;
    vm.client = 'SLERS';
    $ocLazyLoad.load([
        MONURL + 'other_billing/service.js?v=' + VERSION,
    ]).then(function(d) {
        OtherBillingMonitoringSvc = $injector.get('OtherBillingMonitoringSvc');
    });

    vm.generate = function() {
        if (!vm.year) {
            return AppSvc.showSwal('Requirement', 'Please enter year.', 'warning');
        }
        OtherBillingMonitoringSvc.save({ client: vm.client, year: vm.year }).then(function(response) {
            if (!response.message) {
                window.open('report/monitoring_report_oc?client=' + vm.client + '&year=' + vm.year);
            } else {
                AppSvc.showSwal('Error', 'No data found.', 'warning');
            }
        })
    }
}