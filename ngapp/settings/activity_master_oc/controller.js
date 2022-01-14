angular.module('app')
    .controller('ActivityOCCtrl', ActivityOCCtrl)
    .controller('ActivityViewOCCtrl', ActivityViewOCCtrl)

ActivityOCCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector'];
ActivityViewOCCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector', 'data', '$uibModalInstance', '$filter'];

function ActivityOCCtrl($scope, $ocLazyLoad, $injector) {
    var vm = this;
    vm.data = [];
    vm.list = [];
    vm.variables = {};
    $ocLazyLoad.load([
        SETTINGSURL + 'activity_master_oc/service.js?v=' + VERSION,
    ]).then(function(d) {
        ActivityOCSvc = $injector.get('ActivityOCSvc');
        vm.getActivityMaster();
    });

    vm.getActivityMaster = function() {
        LOADING.classList.add("open");
        ActivityOCSvc.get({ client: 'ALL' }).then(function(response) {
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
            { name: "Activity", field: "activity" },
            { name: "Client", field: "client" },
        ],
        data: "vm.list",
        onRegisterApi: function(gridApi) {
            gridApi.selection.on.rowSelectionChanged(null, function(row) {
                vm.gridClick(row.entity);
            });
        }
    };
    vm.gridClick = function(row) {
        vm.variables = angular.copy(row);
        vm.variables.index = vm.data.indexOf(row);
    }
    vm.save = function() {
        LOADING.classList.add("open");
        ActivityOCSvc.save(vm.variables).then(function(response) {
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
    vm.delete = function(row) {
        ActivityOCSvc.delete(vm.variables.id).then(function(response) {
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
    vm.clearFunction = function() {
        vm.variables = {};
    }
}

function ActivityViewOCCtrl($scope, $ocLazyLoad, $injector, data, $uibModalInstance, filter) {
    var modal = this;
    modal.data = [];
    modal.list = [];
    modal.client = '';
    if (data != 'menu') {
        modal.client = data;
    }
    $ocLazyLoad.load([
        SETTINGSURL + 'activity_master_oc/service.js?v=' + VERSION,
    ]).then(function(d) {
        ActivityOCSvc = $injector.get('ActivityOCSvc');
        modal.getActivity();
    });
    modal.getActivity = function() {
        LOADING.classList.add("open");
        ActivityOCSvc.get({ client: modal.client }).then(function(response) {
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
            { name: "Client", field: "client" },
        ],
        data: "modal.list",
        onRegisterApi: function(gridApi) {
            gridApi.selection.on.rowSelectionChanged(null, function(row) {
                $uibModalInstance.close(row.entity)
            });
        }
    };

    modal.searching = function() {
        if (!modal.search) {
            return modal.list = modal.data;
        }
        modal.list = filter('filter')(modal.data, { activity: modal.search });
    }

    modal.close = function() {
        $uibModalInstance.dismiss('cancel');
    }
}