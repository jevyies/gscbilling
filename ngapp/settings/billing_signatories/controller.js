angular.module('app')
    .controller('BillingSignatoryCtrl', BillingSignatoryCtrl)
    .controller('NewSignatoryCtrl', NewSignatoryCtrl)
    .controller('SearchSignatoryCtrl', SearchSignatoryCtrl)

BillingSignatoryCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector'];
NewSignatoryCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector', 'data', '$uibModalInstance'];
SearchSignatoryCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector', 'data', '$uibModalInstance'];

function BillingSignatoryCtrl($scope, $ocLazyLoad, $injector) {
    var vm = this;
    vm.data = [];
    vm.list = [];
    $ocLazyLoad.load([
        SETTINGSURL + 'billing_signatories/service.js?v=' + VERSION,
    ]).then(function (d) {
        BSignatorySvc = $injector.get('BSignatorySvc');
        vm.getSignatory();
    });

    vm.getSignatory = function () {
        LOADING.classList.add("open");
        BSignatorySvc.get().then(function (response) {
            if (response.message) {
                vm.data = [];
            } else {
                response.forEach(item => {
                    var Middle = item.mname ? item.mname : '';
                    var FName = item.fname ? ', ' + item.fname : '';
                    item.fullname = item.lname + FName + ' ' + Middle;
                })
                vm.data = response;
            }
            vm.list = vm.data;
            LOADING.classList.remove("open");
        })
    }
    var cellTemplate1 =
        '<div class="text-center pointer" ng-click="grid.appScope.vm.addSignatory(row.entity)"><span class="fa fa-edit text-success"></span></div>';
    var cellTemplate2 =
        '<div class="text-center pointer" ng-click="grid.appScope.vm.delete(row.entity)"><span class="fa fa-trash text-danger"></span></div>';
    vm.defaultGrid = {
        enableRowSelection: true,
        enableCellEdit: false,
        enableColumnMenus: false,
        modifierKeysToMultiSelect: true,
        enableRowHeaderSelection: false,
        columnDefs: [
            { name: "Last Name", field: "lname" },
            { name: "First Name", field: "fname" },
            { name: "Middle Name", field: "mname" },
            { name: "Ext. Name", field: "ename" },
            { name: "Position", field: "position" },
            { name: "  ", cellTemplate: cellTemplate1, width: 20 },
            { name: " ", cellTemplate: cellTemplate2, width: 20 }
        ],
        data: "vm.list",
    };
    vm.addSignatory = function (row) {
        var data;
        if (!row) {
            data = 'menu';
        } else {
            row.index = vm.data.indexOf(row);
            data = row;
        }
        var options = {
            data: data,
            animation: true,
            templateUrl: SETTINGSURL + "billing_signatories/add_signatory.html?v=" + VERSION,
            controllerName: "NewSignatoryCtrl",
            viewSize: "lg",
            filesToLoad: [
                SETTINGSURL + "billing_signatories/add_signatory.html?v=" + VERSION,
                SETTINGSURL + "billing_signatories/controller.js?v=" + VERSION
            ]
        };
        AppSvc.modal(options).then(function (data) {
            if (data) {
                if (row) {
                    vm.data.splice(row.index, 1, data);
                } else {
                    vm.data.push(data);
                }
                vm.list = vm.data;
            }
        });
    }
    vm.delete = function (row) {
        var index = vm.data.indexOf(row);
        BSignatorySvc.delete(row.id).then(function (response) {
            if (response.success) {
                vm.data.splice(index, 1);
                vm.list = vm.data;
                AppSvc.showSwal('Success', response.message, 'success');
            } else {
                AppSvc.showSwal('Error', response.message, 'error');
            }
            LOADING.classList.remove("open");
        })
    }
}
function NewSignatoryCtrl($scope, $ocLazyLoad, $injector, data, $uibModalInstance) {
    var modal = this;
    modal.variables = {};
    if (data.id) {
        modal.variables = angular.copy(data);
    }
    $ocLazyLoad.load([
        SETTINGSURL + 'billing_signatories/service.js?v=' + VERSION,
    ]).then(function (d) {
        BSignatorySvc = $injector.get('BSignatorySvc');
    });

    modal.save = function () {
        LOADING.classList.add("open");
        BSignatorySvc.save(modal.variables).then(function (response) {
            if (response.success) {
                if (response.id) {
                    modal.variables.id = response.id;
                }
                $uibModalInstance.close(modal.variables);
                AppSvc.showSwal('Success', response.message, 'success');
            } else {
                AppSvc.showSwal('Confirmation', response.message, 'warning');
            }
            LOADING.classList.remove("open");
        })
    }
    modal.close = function () {
        $uibModalInstance.dismiss('cancel');
    }
}
function SearchSignatoryCtrl($scope, $ocLazyLoad, $injector, data, $uibModalInstance) {
    var modal = this;
    var filter = $injector.get('$filter');
    modal.data = [];
    modal.list = [];
    $ocLazyLoad.load([
        SETTINGSURL + 'billing_signatories/service.js?v=' + VERSION,
    ]).then(function (d) {
        BSignatorySvc = $injector.get('BSignatorySvc');
        modal.getCC();
    });
    modal.getCC = function () {
        LOADING.classList.add("open");
        BSignatorySvc.get().then(function (response) {
            if (response.message) {
                modal.data = [];
            } else {
                response.forEach(item => {
                    var Middle = item.mname ? item.mname : '';
                    var FName = item.fname ? ', ' + item.fname : '';
                    item.fullname = item.lname + FName + ' ' + Middle;
                })
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
            { name: "Name", field: "fullname" },
            { name: "Position", field: "position" },
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
        modal.list = filter('filter')(modal.data, { fullname: modal.search });
    }

    modal.addSignatory = function () {
        var options = {
            data: 'menu',
            animation: true,
            templateUrl: SETTINGSURL + "billing_signatories/add_signatory.html?v=" + VERSION,
            controllerName: "NewSignatoryCtrl",
            viewSize: "lg",
            filesToLoad: [
                SETTINGSURL + "billing_signatories/add_signatory.html?v=" + VERSION,
                SETTINGSURL + "billing_signatories/controller.js?v=" + VERSION
            ]
        };
        AppSvc.modal(options).then(function (data) {
            if (data) {
                var Middle = data.mname ? data.mname : '';
                var FName = data.fname ? ', ' + data.fname : '';
                data.fullname = data.lname + FName + ' ' + Middle;
                modal.data.push(data);
                modal.list = modal.data;
            }
        });
    }

    modal.close = function () {
        $uibModalInstance.dismiss('cancel');
    }
}