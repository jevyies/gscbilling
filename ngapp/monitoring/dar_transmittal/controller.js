
angular.module('app')
    .controller('DARTransmittalCtrl', DARTransmittalCtrl)
    .controller('TransmitSummaryCtrl', TransmitSummaryCtrl)

DARTransmittalCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector', '$filter'];
TransmitSummaryCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector', 'data', '$uibModalInstance'];

function DARTransmittalCtrl($scope, $ocLazyLoad, $injector, filter) {
    var vm = this;
    var defaultValue = 'GSMPC-';
    vm.searchSOA = defaultValue;
    vm.variables = {};
    vm.list = [];
    vm.filtered = [];
    vm.totalAmount = 0;
    $ocLazyLoad.load([
        MONURL + 'dar_confirmation/service.js?v=' + VERSION,
        REPURL + 'dmpi_oc_reports/service.js?v=' + VERSION,
        BILLINGURL + 'dmpi_dar/service.js?v=' + VERSION,
    ]).then(function (d) {
        DSConfirmationSvc = $injector.get('DSConfirmationSvc');
        TransmittalReportSvc = $injector.get('TransmittalReportSvc');
        DMPIDARSvc = $injector.get('DMPIDARSvc');
        vm.getTransmittalNos();
    });
    vm.getTransmittalNos = function () {
        LOADING.classList.add('open');
        DMPIDARSvc.get({ autoNo: true }).then(function (response) {
            if (response.message) {
                vm.transmittalNos = [];
            } else {
                vm.transmittalNos = response;
            }
            LOADING.classList.remove('open');
        })
    }
    vm.changeTransmittal = function () {
        if (!vm.searchTrans) {
            return vm.transmittals = vm.transmittalNos;
        }
        vm.transmittals = filter('filter')(vm.transmittalNos, { TransmittalNo: vm.searchTrans });
    }
    vm.clickTransmittal = function (row) {
        vm.transmittals = [];
        vm.searchTrans = row.TransmittalNo;
    }
    vm.searchTransmittal = function () {
        var data = {
            transmittal: true,
            search: vm.searchTrans,
            role: 1
        }
        LOADING.classList.add("open");
        DSConfirmationSvc.get(data).then(function (response) {
            if (response.message) {
                vm.list = [];
                vm.totalAmount = 0;
            } else {
                var no = 1;
                vm.totalAmount = 0;
                response.forEach(function (item) {
                    item.No = no;
                    no++;
                    item.PPeriod = item.pmy + '-' + item.period;
                    vm.totalAmount = vm.totalAmount + parseFloat(item.Amount);
                })
                vm.list = response;
            }
            vm.filtered = vm.list;
            LOADING.classList.remove("open");
        })
    }
    vm.searchControlNo = function () {
        if (vm.searchCNo) {
            return vm.filtered = filter('filter')(vm.list, { id: vm.searchCNo });
        }
        vm.filtered = vm.list;
        // var data = {
        //     controlNo: true,
        //     search: vm.searchCNo
        // }
        // LOADING.classList.add("open");
        // DSConfirmationSvc.get(data).then(function (response) {
        //     if (response.message) {
        //         vm.list = [];
        //     } else {
        //         var no = 1;
        //         response.forEach(function (item) {
        //             item.No = no;
        //             no++;
        //             item.PPeriod = item.pmy + '-' + item.period;
        //         })
        //         vm.list = response;
        //     }
        //     LOADING.classList.remove("open");
        // })
    }
    vm.searchSOANumber = function () {
        if (!vm.searchSOA || defaultValue !== vm.searchSOA.substring(0, 6)) {
            vm.searchSOA = defaultValue;
            vm.filtered = vm.statusFiltered
        } else {
            return vm.filtered = filter('filter')(vm.list, { soaNumber: vm.searchSOA });
        }
        // var data = {
        //     soaNumber: true,
        //     search: vm.searchSOA
        // }
        // LOADING.classList.add("open");
        // DSConfirmationSvc.get(data).then(function (response) {
        //     if (response.message) {
        //         vm.list = [];
        //     } else {
        //         var no = 1;
        //         response.forEach(function (item) {
        //             item.No = no;
        //             no++;
        //             item.PPeriod = item.pmy + '-' + item.period;
        //         })
        //         vm.list = response;
        //     }
        //     LOADING.classList.remove("open");
        // })
    }
    var rowTemplate = '<div ng-repeat="(colRenderIndex, col) in colContainer.renderedColumns track by col.colDef.name" class="ui-grid-cell"  ui-grid-cell context-menu="grid.appScope.vm.rightClick(row.entity)"></div>'
    vm.defaultGrid = {
        enableRowSelection: true,
        enableCellEdit: false,
        enableColumnMenus: false,
        modifierKeysToMultiSelect: true,
        enableRowHeaderSelection: false,
        columnDefs: [
            { name: "No.", field: "No", width: 80 },
            { name: "Control No.", field: "id", width: 135 },
            { name: "SOA No", displayName: 'SOA No', field: "soaNumber", width: 200 },
            { name: "Batch No", field: "Batches", width: 200 },
            { name: "SOA Date", displayName: 'SOA Date', field: "soaDate", width: 200 },
            { name: "Location", displayName: 'Location', field: "Location", width: 200 },
            { name: "Period", displayName: 'Period', field: "PPeriod", width: 200 },
            { name: "Status", field: "status", width: 200 },
            { name: "ST", displayName: 'ST', field: "gtSt", width: 200, cellClass: 'text-right', cellFilter: 'number:2' },
            { name: "OT", displayName: 'OT', field: "gtOt", width: 200, cellClass: 'text-right', cellFilter: 'number:2' },
            { name: "ND", displayName: 'ND', field: "gtNd", width: 200, cellClass: 'text-right', cellFilter: 'number:2' },
            { name: "NDOT", displayName: 'NDOT', field: "gtNdot", width: 200, cellClass: 'text-right', cellFilter: 'number:2' },
            { name: "Amount", field: "Amount", width: 200, cellClass: 'text-right', cellFilter: 'number:2' },
            { name: "Batch By", field: "BatchedBy", width: 200 },
            { name: "Uploaded By", field: "adminencodedby", width: 200 },
        ],
        data: "vm.filtered",
        rowTemplate: rowTemplate,
        onRegisterApi: function (gridApi) {
            vm.gridApi = gridApi;
            // gridApi.selection.on.rowSelectionChanged(null, function (row) {
            //     vm.openDetails(row.entity);
            // });
        }
    }
    vm.rightClick = function (row) {
        var contextMenuData = [];
        contextMenuData.push(['View Details', function () {
            vm.openDetails(row);
        }]);
        contextMenuData.push(['Set to transmitted', function () {
            vm.setToTransmitted(row);
        }]);
        return contextMenuData;
    }
    vm.setToTransmitted = function (row) {
        var l = vm.gridApi.selection.getSelectedRows();
        var ids = [];
        // var submitted = true;
        // l.forEach(function (item) {
        //     ids.push(item.id)
        //     if (item.status !== 'submitted' || item.status !== 'transmitted') {
        //         submitted = false;
        //     }
        // })
        // if (!submitted) {
        //     return AppSvc.showSwal('Confirmation', 'Status must be submitted', 'warning');
        // }
        var index = vm.list.indexOf(row);
        AppSvc.confirmation('Confirmation', 'Are You sure you want to update status to transmitted?', 'Confirm', 'Cancel').then(function (data) {
            if (data) {
                DSConfirmationSvc.save({ rows: ids }).then(function (response) {
                    if (response.success) {
                        l.forEach(function (item) {
                            item.status = 'transmitted';
                            vm.list.splice(vm.list.indexOf(item), 1, item);
                        })
                        vm.filtered = vm.list;
                        AppSvc.showSwal('Success', response.message, 'success');
                    } else {
                        AppSvc.showSwal('Error', 'Something went wrong', 'error');
                    }
                })
            }
        })
    }
    vm.openDetails = function (row) {
        row.index = vm.list.indexOf(row);
        var options = {
            data: row,
            animation: true,
            templateUrl: MONURL + "dar_confirmation/soa_details.html?v=" + VERSION,
            controllerName: "SOADetailsCtrl",
            viewSize: "full",
            filesToLoad: [
                MONURL + "dar_confirmation/soa_details.html?v=" + VERSION,
                MONURL + "dar_confirmation/controller.js?v=" + VERSION
            ]
        };
        AppSvc.modal(options);
    }

    vm.bulkTransmittal = function () {
        if (vm.list.length == 0) {
            return AppSvc.showSwal('Confirmation', 'No SOA to be transmitted', 'warning');
        }
        var allConfirmed = true;
        var data = [];
        vm.list.forEach(function (item) {
            if (item.status !== 'submitted') {
                allConfirmed = false;
            }
            data.push(item.id);
        })
        // if (!allConfirmed) {
        //     return AppSvc.showSwal('Confirmation', 'Cannot Proceed. Check details first', 'warning');
        // }
        DSConfirmationSvc.save({ rows: data }).then(function (response) {
            if (response.success) {
                vm.list.forEach(function (item) {
                    item.status = 'transmitted';
                })
                AppSvc.showSwal('Success', response.message, 'success');
            } else {
                AppSvc.showSwal('Error', 'Something went wrong', 'error');
            }
        })
    }
    vm.printTransmittal = function () {
        var data = {};
        data.exists = true;
        data.transmittalNo = vm.searchTrans;
        TransmittalReportSvc.get(data).then(function (response) {
            if (response.message) {
                return AppSvc.showSwal('Error', 'Nothing to Display', 'error');
            }
            window.open('report/dmpi_oc/transmittal_report?transmittalNo=' + data.transmittalNo);
        })
    }
    vm.transmittalSummary = function () {
        if (vm.list.length == 0) {
            return AppSvc.showSwal('Confirmation', 'No Transmittal to be printed', 'warning');
        }
        var bool = false;
        vm.list.forEach(function (item) {
            if (item.status !== 'transmitted') {
                bool = true;
            }
        })
        if (bool) {
            return AppSvc.showSwal('Confirmation', 'Cannot Proceed. Please set first to transmitted', 'warning');
        }
        var options = {
            data: vm.searchTrans,
            animation: true,
            templateUrl: MONURL + "dar_transmittal/signatory.html?v=" + VERSION,
            controllerName: "TransmitSummaryCtrl",
            viewSize: "md",
            filesToLoad: [
                MONURL + "dar_transmittal/signatory.html?v=" + VERSION,
                MONURL + "dar_transmittal/controller.js?v=" + VERSION
            ]
        };
        AppSvc.modal(options);
    }
}
function TransmitSummaryCtrl($scope, $ocLazyLoad, $injector, data, $uibModalInstance) {
    var modal = this;
    modal.addSig = 0;
    modal.searchTrans = data;
    modal.variables = {};
    $ocLazyLoad.load([
        MONURL + 'dar_confirmation/service.js?v=' + VERSION,
    ]).then(function (d) {
        DSConfirmationSvc = $injector.get('DSConfirmationSvc');
        modal.getTransmittalInfo();
    });
    modal.getTransmittalInfo = function () {
        LOADING.classList.add('open');
        DSConfirmationSvc.get({ transmittalInfo: true, No: modal.searchTrans }).then(function (response) {
            if (response.message) {
                modal.variables = {};
            } else {
                modal.variables = response[0];
            }
            LOADING.classList.remove('open');
        })
    }
    modal.searchSignatory = function (number) {
        var options = {
            data: 'menu',
            animation: true,
            templateUrl: SETTINGSURL + "billing_signatories/signatory_modal.html?v=" + VERSION,
            controllerName: "SearchSignatoryCtrl",
            viewSize: "md",
            filesToLoad: [
                SETTINGSURL + "billing_signatories/signatory_modal.html?v=" + VERSION,
                SETTINGSURL + "billing_signatories/controller.js?v=" + VERSION
            ]
        };
        AppSvc.modal(options).then(function (data) {
            if (data) {
                if (number == 2) {
                    modal.variables.confirmedBy = data.fullname;
                    modal.variables.confirmedByPosition = data.position;
                } else {
                    modal.variables.approvedBy = data.fullname;
                    modal.variables.approvedByPosition = data.position;
                }
            }
        })
    }

    modal.printTransmittal = function (number) {
        var data = angular.copy(modal.variables);
        data.exists = true;
        data.summary = true;
        data.transmittalBeginning = true;
        data.transmitNo = modal.searchTrans;
        DSConfirmationSvc.save(data).then(function (response) {
            if (!response.success) {
                return AppSvc.showSwal('Error', 'Nothing to Display', 'error');
            }
            if (number == 1) {
                window.open('report/dmpi_oc/transmittal_report?summary=true&copy=1&transmitNo=' + data.transmitNo);
            } else { 
                window.open('report/dmpi_oc/transmittal_report?long=true&summary=true&copy=1&transmitNo=' + data.transmitNo);
            }
        })
    }
    modal.removeSignatory = function () {
        modal.addSig = 0;
        modal.variables.approvedBy2 = '';
        modal.variables.approvedByPosition2 = '';
    }
    modal.close = function () {
        $uibModalInstance.dismiss('cancel');
    }
}