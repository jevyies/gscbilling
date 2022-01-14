
angular.module('app')
    .controller('DARForTransmittalCtrl', DARForTransmittalCtrl)
    .controller('ForTransmitSummaryCtrl', ForTransmitSummaryCtrl)

DARForTransmittalCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector', '$filter'];
ForTransmitSummaryCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector', 'data', '$uibModalInstance'];

function DARForTransmittalCtrl($scope, $ocLazyLoad, $injector, filter) {
    var vm = this;
    var defaultValue = 'GSMPC-';
    vm.searchSOA = defaultValue;
    vm.variables = {};
    vm.list = [];
    vm.filtered = [];
    vm.showSOAs = false;
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
            search: vm.searchTrans
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
                vm.transmittalDate = response[0].transmittal_date;
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
            { name: "Confirmed By", field: "ConfirmationBy", width: 200 },
            { name: "Remarks", field: "Remarks2", width: 200 },
        ],
        data: "vm.filtered",
        onRegisterApi: function (gridApi) {
            gridApi.selection.on.rowSelectionChanged(null, function (row) {
                // vm.openDetails(row.entity);
            });
        }
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
            if (item.status !== 'confirmed') {
                allConfirmed = false;
            }
            data.push(item.id);
        })
        if (!allConfirmed) {
            return AppSvc.showSwal('Confirmation', 'Cannot Proceed. Check details first', 'warning');
        }
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
        vm.showSOAs = false;
        var data = [];
        var allConfirmed = true;
        vm.soaStatus = [];
        var dataWRemarks = [];
        vm.list.forEach(function (item) {
            if (item.status !== 'confirmed' && item.status !== 'PRINTED TRANSMITTAL') {
                allConfirmed = false;
                vm.soaStatus.push(item.soaNumber);
            }
            if (item.Remarks) {
                dataWRemarks.push(item.soaNumber + ' - ' + item.Remarks);
            }
            data.push(item.id);
        })
        if (!allConfirmed) {
            vm.showSOAs = true;
            vm.showThisSOA = vm.soaStatus.toString();
            return AppSvc.showSwal('Confirmation', 'All SOA status must be confirmed', 'warning');
        }
        var options = {
            data: { trans: vm.searchTrans, remarks: dataWRemarks, rows: data },
            animation: true,
            templateUrl: MONURL + "dar_for_transmittal/signatory.html?v=" + VERSION,
            controllerName: "ForTransmitSummaryCtrl",
            viewSize: "md",
            filesToLoad: [
                MONURL + "dar_for_transmittal/signatory.html?v=" + VERSION,
                MONURL + "dar_for_transmittal/controller.js?v=" + VERSION
            ]
        };
        AppSvc.modal(options);
    }
    vm.proceedTransmittalSummary = function () {
        var confirmed = false;
        var dataWRemarks = [];
        vm.list.forEach(function (item) {
            if (item.status === 'confirmed') {
                confirmed = true;
            }
            if (item.status === 'PRINTED TRANSMITTAL') {
                confirmed = true;
            }
            if (item.Remarks) {
                dataWRemarks.push(item.soaNumber + ' - ' + item.Remarks);
            }
        })
        if (!confirmed) {
            return AppSvc.showSwal('Confirmation', 'Must have atleast 1 confirmed', 'warning');
        }
        var options = {
            data: { trans: vm.searchTrans, remarks: dataWRemarks },
            animation: true,
            templateUrl: MONURL + "dar_for_transmittal/signatory.html?v=" + VERSION,
            controllerName: "ForTransmitSummaryCtrl",
            viewSize: "md",
            filesToLoad: [
                MONURL + "dar_for_transmittal/signatory.html?v=" + VERSION,
                MONURL + "dar_for_transmittal/controller.js?v=" + VERSION
            ]
        };
        AppSvc.modal(options);
    }
    vm.previewTransmittal = function (number) {
        if (vm.list.length == 0) {
            return AppSvc.showSwal('Confirmation', 'Search Transmittal First', 'warning');
        }
        if (number == 1) {
            window.open('report/dmpi_oc/transmittal_report?summary=true&copy=2&preview=true&transmitNo=' + vm.searchTrans);
        } else {
            window.open('report/dmpi_oc/transmittal_report?long=true&summary=true&copy=2&preview=true&transmitNo=' + vm.searchTrans);
        }

    }
}
function ForTransmitSummaryCtrl($scope, $ocLazyLoad, $injector, data, $uibModalInstance) {
    var modal = this;
    modal.addSig = 0;
    modal.searchTrans = data.trans;
    modal.soaWRemarks = data.remarks;
    modal.variables = {};
    modal.rows = data.rows;
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
                } else if (number == 3) {
                    modal.variables.approvedBy = data.fullname;
                    modal.variables.approvedByPosition = data.position;
                } else if (number == 4) {
                    modal.variables.approvedBy2 = data.fullname;
                    modal.variables.approvedByPosition2 = data.position;
                }
            }
        })
    }

    modal.printTransmittal = function (number) {
        var data = angular.copy(modal.variables);
        data.exists = true;
        data.summary = true;
        data.finalization = true;
        data.transmitNo = modal.searchTrans;
        data.rows = modal.rows;
        DSConfirmationSvc.save(data).then(function (response) {
            if (!response.success) {
                return AppSvc.showSwal('Error', 'Nothing to Display', 'error');
            }
            if (number == 1) {
                window.open('report/dmpi_oc/transmittal_report?summary=true&copy=2&transmitNo=' + data.transmitNo);
            } else {
                window.open('report/dmpi_oc/transmittal_report?long=true&summary=true&copy=2&transmitNo=' + data.transmitNo);
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