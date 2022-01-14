angular.module('app')
    .controller('VolumeReport', VolumeReport)

VolumeReport.$inject = ['$scope', '$ocLazyLoad', '$injector'];

function VolumeReport($scope, $ocLazyLoad, $injector) {
    var vm = this;
    vm.variables = {};
    vm.variables.from = new Date();
    vm.variables.to = new Date();
    vm.details = [];
    $ocLazyLoad.load([REPURL + 'sar_volume_report/service.js?v=' + VERSION]).then(function (d) {
        VRSvc = $injector.get('VRSvc');
    });
    vm.generate = function () {
        var data = angular.copy(vm.variables);
        data.from = vm.variables.from ? AppSvc.getDate(vm.variables.from) : '0000-00-00';
        data.to = vm.variables.to ? AppSvc.getDate(vm.variables.to) : '0000-00-00';
        VRSvc.save(data).then(function (response) {
            if (response.message) {
                vm.details = [];
                AppSvc.showSwal('Confirmation', 'No data found', 'warning');
            } else {
                response.forEach(function (item) {
                    if (item.volumeType == 1) {
                        item.volume = 'CHECK DAM';
                    } else if (item.volumeType == 2) {
                        item.volume = 'DAIRY';
                    } else {
                        item.volume = 'PAPAYA';
                    }
                })
                vm.details = response;
            }
        })
    }
    vm.defaultGrid = {
        enableRowSelection: true,
        enableCellEdit: false,
        enableColumnMenus: false,
        modifierKeysToMultiSelect: false,
        enableRowHeaderSelection: false,
        enableFiltering: true,
        columnDefs: [
            { name: "Date Performed", field: "datePerformed", width: 180 },
            { name: "Volume Type", field: "volume", width: 180 },
            { name: "Control No", field: "controlNo", width: 180 },
            { name: "PO Number", field: "poNumber", width: 180 },
            { name: "Description", field: "activity", width: 180 },
            { name: "Quantity", field: "qty", width: 180, cellFilter: "number:2", cellClass: 'text-right' },
            { name: "Unit", field: "unit", width: 180 },
            { name: "Rate", field: "rate", width: 180, cellFilter: "number:2", cellClass: 'text-right' },
            { name: "Amount", field: "amount", width: 180, cellFilter: "number:2", cellClass: 'text-right' },
        ],
        data: "vm.details",
        // onRegisterApi: function (gridApi) {
        //     vm.gridApi = gridApi;
        // }
    };
    vm.downloadExcel = function () {
        window.open('report/sar_volume_report?from=' + AppSvc.getDate(vm.variables.from) + '&to=' + AppSvc.getDate(vm.variables.to));
    }
}