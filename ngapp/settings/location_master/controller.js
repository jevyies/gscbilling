angular.module('app')
    .controller('LocationMasterCtrl', LocationMasterCtrl)
    .controller('LocationViewCtrl', LocationViewCtrl)

LocationMasterCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector'];
LocationViewCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector', 'data', '$uibModalInstance', '$filter'];

function LocationMasterCtrl($scope, $ocLazyLoad, $injector) {
    var vm = this;
    vm.data = [];
    vm.list = [];
    vm.variables = {};
    $ocLazyLoad.load([
        SETTINGSURL + 'location_master/service.js?v=' + VERSION,
    ]).then(function (d) {
        LocationSvc = $injector.get('LocationSvc');
        vm.getLocation();
    });

    vm.getLocation = function () {
        LOADING.classList.add("open");
        LocationSvc.get().then(function (response) {
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
            { name: "ID", displayName: 'ID', field: "LocationID", width: 50 },
            { name: "Location Name", field: "Location" },
            { name: "Prefix", field: "LocPrefix" },
            { name: "Code", field: "Code" },
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
        LocationSvc.save(vm.variables).then(function (response) {
            if (response.success) {
                if (response.id) {
                    vm.variables.LocationID = response.id;
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
        LocationSvc.delete(vm.variables.LocationID).then(function (response) {
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
function LocationViewCtrl($scope, $ocLazyLoad, $injector, data, $uibModalInstance, filter) {
    var modal = this;
    modal.data = [];
    modal.list = [];
    $ocLazyLoad.load([
        SETTINGSURL + 'location_master/service.js?v=' + VERSION,
    ]).then(function (d) {
        LocationSvc = $injector.get('LocationSvc');
        modal.getLocation();
    });
    modal.getLocation = function () {
        LOADING.classList.add("open");
        LocationSvc.get().then(function (response) {
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
            { name: "ID", displayName: 'ID', field: "LocationID", width: 50 },
            { name: "Location Name", field: "Location" },
            { name: "Prefix", field: "LocPrefix" },
            { name: "Code", field: "Code" },
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
        modal.list = filter('filter')(modal.data, { Location: modal.search });
    }

    modal.close = function () {
        $uibModalInstance.dismiss('cancel');
    }
}