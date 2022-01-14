angular.module('app')
    .controller('SARPOMasterCtrl', SARPOMasterCtrl)
    .controller('SARPOViewCtrl', SARPOViewCtrl)

SARPOMasterCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector'];
SARPOViewCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector', 'data', '$uibModalInstance', '$filter'];

function SARPOMasterCtrl($scope, $ocLazyLoad, $injector) {
    var vm = this;
    vm.data = [];
    vm.list = [];
    vm.variables = {};
    $ocLazyLoad.load([
        SETTINGSURL + 'po_sar_master/service.js?v=' + VERSION,
    ]).then(function (d) {
        POSarSvc = $injector.get('POSarSvc');
        vm.getPOMaster();
    });

    vm.getPOMaster = function () {
        LOADING.classList.add("open");
        POSarSvc.get().then(function (response) {
            if (response.message) {
                vm.data = [];
            } else {
                vm.data = response;
            }
            vm.list = vm.data;
            LOADING.classList.remove("open");
        })
    }
    vm.defaultGrid = {
        enableRowSelection: true,
        enableCellEdit: false,
        enableColumnMenus: false,
        modifierKeysToMultiSelect: true,
        enableRowHeaderSelection: false,
        enableFiltering: true,
        columnDefs: [
            { name: "poNumber", displayName: 'PO No.', field: "poNumber", width: 200 },
            { name: "Day Type", field: "dayType", width: 200, enableFiltering: false },
            { name: "Qty", field: "qty", width: 90, cellFilter: 'number:2', cellClass: 'text-right', enableFiltering: false },
            { name: "Rate", field: "rate", width: 90, cellFilter: 'number:2', cellClass: 'text-right', enableFiltering: false },
            { name: "Unit", field: "unit", width: 90, enableFiltering: false },
        ],
        data: "vm.list",
        onRegisterApi: function (gridApi) {
            gridApi.selection.on.rowSelectionChanged(null, function (row) {
                vm.gridClick(row.entity);
            });
        }
    };
    vm.gridClick = function (row) {
        vm.variables = angular.copy(row);
        vm.variables.index = vm.data.indexOf(row);
    }
    vm.save = function () {
        LOADING.classList.add("open");
        var data = angular.copy(vm.variables);
        data.qty = AppSvc.getAmount("" + vm.variables.qty);
        data.amount = AppSvc.getAmount("" + vm.variables.amount);
        POSarSvc.save(data).then(function (response) {
            if (response.success) {
                if (response.id) {
                    data.id = response.id;
                    vm.data.push(data);
                } else {
                    vm.data.splice(vm.variables.index, 1, data);
                }
                vm.list = vm.data;
                vm.clearFunction()
                AppSvc.showSwal('Success', response.message, 'success');
            } else {
                AppSvc.showSwal('Confirmation', response.message, 'warning');
            }
            LOADING.classList.remove("open");
        })
    }
    vm.delete = function (row) {
        POSarSvc.delete(vm.variables.id).then(function (response) {
            if (response.success) {
                vm.data.splice(vm.variables.index, 1);
                vm.list = vm.data;
                vm.clearFunction();
                AppSvc.showSwal('Success', response.message, 'success');
            } else {
                AppSvc.showSwal('Error', response.message, 'error');
            }
            LOADING.classList.remove("open");
        })
    }
    vm.clearFunction = function () {
        vm.variables = {};
    }
}
function SARPOViewCtrl($scope, $ocLazyLoad, $injector, data, $uibModalInstance, filter) {
    var modal = this;
    modal.data = [];
    modal.list = [];
    $ocLazyLoad.load([
        SETTINGSURL + 'po_sar_master/service.js?v=' + VERSION,
    ]).then(function (d) {
        POSarSvc = $injector.get('POSarSvc');
        modal.getGL();
    });
    modal.getGL = function () {
        LOADING.classList.add("open");
        POSarSvc.get().then(function (response) {
            if (response.message) {
                modal.data = [];
            } else {
                modal.data = response;
            }
            modal.list = modal.data;
            LOADING.classList.remove("open");
        })
    }
    modal.defaultGrid = {
        enableRowSelection: true,
        enableCellEdit: false,
        enableColumnMenus: false,
        modifierKeysToMultiSelect: true,
        enableRowHeaderSelection: false,
        columnDefs: [
            { name: "poNumber", displayName: 'PO No.', field: "poNumber" },
            { name: "Day Type", field: "dayType" },
            { name: "Qty", field: "qty", cellFilter: 'number:2', cellClass: 'text-right' },
            { name: "Rate", field: "rate", cellFilter: 'number:2', cellClass: 'text-right' },
            { name: "Unit", field: "unit" },
        ],
        data: "modal.list",
        onRegisterApi: function (gridApi) {
            gridApi.selection.on.rowSelectionChanged(null, function (row) {
                $uibModalInstance.close(row.entity)
            });
        }
    };

    modal.searching = function () {
        if (!modal.search) {
            return modal.list = modal.data;
        }
        modal.list = filter('filter')(modal.data, { gl: modal.search });
    }

    modal.close = function () {
        $uibModalInstance.dismiss('cancel');
    }
}