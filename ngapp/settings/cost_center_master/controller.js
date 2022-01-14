angular.module('app')
    .controller('CostCenterCtrl', CostCenterCtrl)
    .controller('CostCenterViewCtrl', CostCenterViewCtrl)

CostCenterCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector'];
CostCenterViewCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector', 'data', '$uibModalInstance', '$filter'];

function CostCenterCtrl($scope, $ocLazyLoad, $injector) {
    var vm = this;
    vm.data = [];
    vm.list = [];
    vm.variables = {};
    $ocLazyLoad.load([
        SETTINGSURL + 'cost_center_master/service.js?v=' + VERSION,
    ]).then(function (d) {
        CCSvc = $injector.get('CCSvc');
        vm.getCCMaster();
    });

    vm.getCCMaster = function () {
        LOADING.classList.add("open");
        CCSvc.get().then(function (response) {
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
        columnDefs: [
            { name: "ID", displayName: 'ID', field: "id", width: 60 },
            { name: "Cost Center", field: "costcenter" },
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
        CCSvc.save(vm.variables).then(function (response) {
            if (response.success) {
                if (response.id) {
                    vm.variables.id = response.id;
                    vm.data.push(vm.variables);
                } else {
                    vm.data.splice(vm.variables.index, 1, vm.variables);
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
        CCSvc.delete(vm.variables.id).then(function (response) {
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
function CostCenterViewCtrl($scope, $ocLazyLoad, $injector, data, $uibModalInstance, filter) {
    var modal = this;
    modal.data = [];
    modal.list = [];
    $ocLazyLoad.load([
        SETTINGSURL + 'cost_center_master/service.js?v=' + VERSION,
    ]).then(function (d) {
        CCSvc = $injector.get('CCSvc');
        modal.getCC();
    });
    modal.getCC = function () {
        LOADING.classList.add("open");
        CCSvc.get().then(function (response) {
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
            { name: "ID", displayName: 'ID', field: "id", width: 60 },
            { name: "Cost Center", field: "costcenter" },
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
        modal.list = filter('filter')(modal.data, { costcenter: modal.search });
    }

    modal.close = function () {
        $uibModalInstance.dismiss('cancel');
    }
}