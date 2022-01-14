angular.module('app')
    .controller('GLMasterCtrl', GLMasterCtrl)
    .controller('GLViewCtrl', GLViewCtrl)

GLMasterCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector'];
GLViewCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector', 'data', '$uibModalInstance', '$filter'];

function GLMasterCtrl($scope, $ocLazyLoad, $injector) {
    var vm = this;
    vm.data = [];
    vm.list = [];
    vm.variables = {};
    $ocLazyLoad.load([
        SETTINGSURL + 'gl_master/service.js?v=' + VERSION,
    ]).then(function (d) {
        GLSvc = $injector.get('GLSvc');
        vm.getGLMaster();
    });

    vm.getGLMaster = function () {
        LOADING.classList.add("open");
        GLSvc.get({type: 'all'}).then(function (response) {
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
            { name: "GL", displayName: 'GL', field: "gl" },
            { name: "Type", displayName: 'Type', field: "type" },
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
        GLSvc.save(vm.variables).then(function (response) {
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
        GLSvc.delete(vm.variables.id).then(function (response) {
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
function GLViewCtrl($scope, $ocLazyLoad, $injector, data, $uibModalInstance, filter) {
    var modal = this;
    modal.data = [];
    modal.list = [];
    modal.type = data;
    $ocLazyLoad.load([
        SETTINGSURL + 'gl_master/service.js?v=' + VERSION,
    ]).then(function (d) {
        GLSvc = $injector.get('GLSvc');
        modal.getGL();
    });
    modal.getGL = function () {
        LOADING.classList.add("open");
        GLSvc.get({ type: modal.type }).then(function (response) {
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
            { name: "GL", displayName: 'GL', field: "gl" },
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