angular.module('app')
    .controller('ActivityCtrl', ActivityCtrl)
    .controller('ActivityViewCtrl', ActivityViewCtrl)

ActivityCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector'];
ActivityViewCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector', 'data', '$uibModalInstance', '$filter'];

function ActivityCtrl($scope, $ocLazyLoad, $injector) {
    var vm = this;
    vm.data = [];
    vm.list = [];
    vm.variables = {};
    $ocLazyLoad.load([
        SETTINGSURL + 'activity_master/service.js?v=' + VERSION,
    ]).then(function (d) {
        ActivitySvc = $injector.get('ActivitySvc');
        vm.getActivityMaster();
    });

    vm.getActivityMaster = function () {
        LOADING.classList.add("open");
        ActivitySvc.get().then(function (response) {
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
            { name: "ID", displayName: 'ID', field: "id", width: 60, enableFiltering: false },
            { name: "Activity", field: "activity" },
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
        ActivitySvc.save(vm.variables).then(function (response) {
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
        ActivitySvc.delete(vm.variables.id).then(function (response) {
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
function ActivityViewCtrl($scope, $ocLazyLoad, $injector, data, $uibModalInstance, filter) {
    var modal = this;
    modal.data = [];
    modal.list = [];
    $ocLazyLoad.load([
        SETTINGSURL + 'activity_master/service.js?v=' + VERSION,
    ]).then(function (d) {
        ActivitySvc = $injector.get('ActivitySvc');
        modal.getActivity();
    });
    modal.getActivity = function () {
        LOADING.classList.add("open");
        ActivitySvc.get().then(function (response) {
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
            { name: "Activity", field: "activity" },
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
        modal.list = filter('filter')(modal.data, { activity: modal.search });
    }

    modal.close = function () {
        $uibModalInstance.dismiss('cancel');
    }
}