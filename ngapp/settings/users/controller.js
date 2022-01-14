angular.module('app')
    .controller('UserMasterCtrl', UserMasterCtrl)
    .controller('UsersViewCtrl', UsersViewCtrl)
    .controller('UserAccessRightsCtrl', UserAccessRightsCtrl)

UserMasterCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector'];
UsersViewCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector', 'data', '$uibModalInstance', '$filter'];
UserAccessRightsCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector', 'data', '$uibModalInstance', '$filter'];

function UserMasterCtrl($scope, $ocLazyLoad, $injector) {
    var vm = this;
    vm.data = [];
    vm.list = [];
    vm.variables = {};
    vm.variables.role_id = 2;
    $ocLazyLoad.load([
        SETTINGSURL + 'users/service.js?v=' + VERSION,
    ]).then(function (d) {
        UserSvc = $injector.get('UserSvc');
        vm.getUsers();
    });

    vm.getUsers = function () {
        LOADING.classList.add("open");
        UserSvc.get().then(function (response) {
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
            { name: "name", displayName: 'Name', field: "name" },
            { name: "email", displayName: 'Email', field: "email" },
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
        vm.variables.role_id = parseInt(row.role_id);
        vm.variables.index = vm.data.indexOf(row);
    }
    vm.save = function () {
        LOADING.classList.add("open");
        UserSvc.save(vm.variables).then(function (response) {
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
        UserSvc.delete(vm.variables.id).then(function (response) {
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
    vm.resetPassword = function () {
        UserSvc.save({ reset: true, id: vm.variables.id }).then(function (response) {
            if (response.success) {
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
        vm.variables.role_id = 2;
    }
    vm.accessRights = function(){
        var options = {
            data: vm.variables.id,
            animation: true,
            templateUrl: SETTINGSURL + "users/access-rights.html?v=" + VERSION,
            controllerName: "UserAccessRightsCtrl",
            viewSize: "md",
            filesToLoad: [
                SETTINGSURL + "users/access-rights.html?v=" + VERSION,
                SETTINGSURL + "users/controller.js?v=" + VERSION
            ]
        };
        AppSvc.modal(options);
    }
}
function UsersViewCtrl($scope, $ocLazyLoad, $injector, data, $uibModalInstance, filter) {
    var modal = this;
    modal.data = [];
    modal.list = [];
    $ocLazyLoad.load([
        SETTINGSURL + 'users/service.js?v=' + VERSION,
    ]).then(function (d) {
        UserSvc = $injector.get('UserSvc');
        modal.getUsers();
    });
    modal.getUsers = function () {
        LOADING.classList.add("open");
        UserSvc.get().then(function (response) {
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
            { name: "name", displayName: 'Name', field: "name" },
            { name: "email", displayName: 'Email', field: "email" },
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
function UserAccessRightsCtrl($scope, $ocLazyLoad, $injector, data, $uibModalInstance, filter){
    var modal = this;
    modal.list = [];
    modal.userRights = [];
    modal.checkedAccessRights = [];
    modal.id = data;
    modal.variables = {};
    $ocLazyLoad.load([
        SETTINGSURL + 'users/service.js?v=' + VERSION,
    ]).then(function (d) {
        UserSvc = $injector.get('UserSvc');
        modal.getAllAccessRights();
    });
    modal.defaultGrid = {
        enableRowSelection: true,
        enableCellEdit: false,
        enableColumnMenus: false,
        modifierKeysToMultiSelect: false,
        enableRowHeaderSelection: true,
        enableFiltering: true,
        columnDefs: [
            { name: "menu", displayName: 'Menu Title', field: "FormName" },
        ],
        data: "modal.list",
        onRegisterApi: function (gridApi) {
            modal.gridApi = gridApi;
        }
    }
    modal.getAllAccessRights = function(){
        UserSvc.get({accessRights: true, all: true}).then(function(response){
            if(response.message){
                modal.list = [];
            }else{
                modal.list = response;
                
            }
        })
        modal.getUserAccessRights();
    }
    modal.getUserAccessRights = function(){
        UserSvc.get({accessRights: true, id: modal.id}).then(function(response){
            if(response.message){
                modal.userRights = [];
                modal.checkedAccessRights = [];
            }else{
                modal.userRights = response;
                response.forEach(function(item){
                    var l = filter('filter')(modal.list, { FormControlID: item.AccessRghtsFormID }, true);
                    modal.checkedAccessRights.push(modal.list.indexOf(l[0]));
                })
                modal.checkAccessRights();
            }
            
        })
    }
    modal.checkAccessRights = function(){
        var $interval = $injector.get('$interval');
        $interval(
            function() {
                modal.checkedAccessRights.forEach(function(list) {
                    modal.gridApi.selection.toggleRowSelection(modal.list[list]);
                });
            },
            0,
            1
        );
    }
    modal.save = function(){
        var selectedAccessRights = [];
		var rows = modal.gridApi.selection.getSelectedRows();
		rows.forEach(function(row) {
			selectedAccessRights.push(parseInt(row.FormControlID));
		});
		modal.variables['accessList'] = selectedAccessRights;
        modal.variables['id'] = modal.id;
        modal.variables['saveAccessRights'] = true;
        LOADING.classList.add("open");
        UserSvc.save(modal.variables).then(function(response){
            if(response.success){
                AppSvc.showSwal('Success', response.message, 'success');
            }else{
                AppSvc.showSwal('Confirmation', response.message, 'warning');
            }
            LOADING.classList.remove("open");
        })
    }
    modal.close = function () {
        $uibModalInstance.dismiss('cancel');
    }
}