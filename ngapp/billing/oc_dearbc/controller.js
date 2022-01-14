angular.module('app')
    .controller('OCDEARBCCtrl', OCDEARBCCtrl)
    .controller('OCDEARBCHdrCtrl', OCDEARBCHdrCtrl)
    .controller('OCDEARBCSearchHdrCtrl', OCDEARBCSearchHdrCtrl)
    .controller('OCDEARBCDtlCtrl', OCDEARBCDtlCtrl)
    .controller('SearchEmployeeCtrl', SearchEmployeeCtrl)
    .controller('OCDEARBCLetterHeadCtrl', OCDEARBCLetterHeadCtrl)
    .controller('OCDEARBCPrintPreviewCtrl', OCDEARBCPrintPreviewCtrl)
    .controller('SearchPeriodCtrl', SearchPeriodCtrl)
    .controller('TransmitBillingCtrl', TransmitBillingCtrl)

OCDEARBCCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector'];
OCDEARBCHdrCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector', 'data', '$uibModalInstance'];
OCDEARBCSearchHdrCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector', 'data', '$uibModalInstance'];
OCDEARBCDtlCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector', 'data', '$uibModalInstance'];
SearchEmployeeCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector', 'data', '$uibModalInstance'];
OCDEARBCLetterHeadCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector', 'data', '$uibModalInstance'];
OCDEARBCPrintPreviewCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector', 'data', '$uibModalInstance'];
SearchPeriodCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector', 'data', '$uibModalInstance'];
TransmitBillingCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector', 'data', '$uibModalInstance'];

function OCDEARBCCtrl($scope, $ocLazyLoad, $injector) {
    var vm = this;
    vm.dearbc = {};
    vm.header = {};
    vm.data = [];
    vm.list = [];
    vm.dataDearbc = [];
    vm.listDearbc = [];
    $ocLazyLoad.load([
        BILLINGURL + 'oc_dearbc/service.js?v=' + VERSION,
    ]).then(function(d) {
        OCDEARBCSvc = $injector.get('OCDEARBCSvc');
        OCDEARBCDearbcSvc = $injector.get('OCDEARBCDearbcSvc');
    });
    vm.defaultGrid = {
        enableRowSelection: true,
        enableCellEdit: false,
        enableColumnMenus: false,
        modifierKeysToMultiSelect: true,
        enableRowHeaderSelection: false,
        columnDefs: [
            { name: "Name", field: "Name", width: 300, pinnedLeft: true },
            { name: "Chapa", field: "Chapa", displayName: 'Chapa', width: 120 },
            { name: "rd-st", field: "rd_st", displayName: 'rd-st', width: 120 },
            { name: "rd-ot", field: "rd_ot", displayName: 'rd-ot', width: 120 },
            { name: "rd-nd", field: "rd_nd", displayName: 'rd-nd', width: 120 },
            { name: "rd-ndot", field: "rd_ndot", displayName: 'rd-ndot', width: 120 },
            { name: "shol-st", field: "shol_st", displayName: 'shol-st', width: 120 },
            { name: "shol-ot", field: "shol_ot", displayName: 'shol-ot', width: 120 },
            { name: "shol-nd", field: "shol_nd", displayName: 'shol-nd', width: 120 },
            { name: "shol-ndot", field: "shol_ndot", displayName: 'shol-ndot', width: 120 },
            { name: "shrd-st", field: "shrd_st", displayName: 'shrd-st', width: 120 },
            { name: "shrd-ot", field: "shrd_ot", displayName: 'shrd-ot', width: 120 },
            { name: "shrd-nd", field: "shrd_nd", displayName: 'shrd-nd', width: 120 },
            { name: "shrd-ndot", field: "shrd_ndot", displayName: 'shrd-ndot', width: 120 },
            { name: "rhol-st", field: "rhol_st", displayName: 'rhol-st', width: 120 },
            { name: "rhol-ot", field: "rhol_ot", displayName: 'rhol-ot', width: 120 },
            { name: "rhol-nd", field: "rhol_nd", displayName: 'rhol-nd', width: 120 },
            { name: "rhol-ndot", field: "rhol_ndot", displayName: 'rhol-ndot', width: 120 },
            { name: "rhrd-st", field: "rhrd_st", displayName: 'rhrd-st', width: 120 },
            { name: "rhrd-ot", field: "rhrd_ot", displayName: 'rhrd-ot', width: 120 },
            { name: "rhrd-nd", field: "rhrd_nd", displayName: 'rhrd-nd', width: 120 },
            { name: "rhrd-ndot", field: "rhrd_ndot", displayName: 'rhrd-ndot', width: 120 },
            { name: "rhrd-ndot", field: "rhrd_ndot", displayName: 'rhrd-ndot', width: 120 },
            { name: "extra", field: "extra", displayName: 'Extra', width: 120 },
            { name: "silpat", field: "silpat", displayName: 'SIL/PAT', width: 120 },
            { name: "adjustment", field: "adjustment", displayName: 'Adjustment', width: 120 },
            { name: "incentive", field: "incentive", displayName: 'Incentive', width: 120 },
            { name: "addpay", field: "addpay", displayName: 'Addpay', width: 120 },
            { name: "volumepay", field: "volumepay", displayName: 'Volumepay', width: 120 },
            { name: "allowance", field: "allowance", displayName: 'Allowance', width: 120 },
            { name: "cola", field: "cola", displayName: 'COLA', width: 120 },
            { name: "grosspay", field: "grosspay", displayName: 'Grosspay', width: 120 },
            { name: "sss_ec", field: "sss_ec", displayName: 'SSS EC', width: 120 },
            { name: "sss_er", field: "sss_er", displayName: 'SSS ER', width: 120 },
            { name: "phic_er", field: "phic_er", displayName: 'PHIC ER', width: 120 },
            { name: "hdmf_er", field: "hdmf_er", displayName: 'HDMF ER', width: 120 },
            { name: "mpro", field: "mpro", displayName: 'MPF', width: 120 },
            { name: "Overall Total", field: "total", width: 150, pinnedRight: true },
        ],
        data: "vm.list",
        onRegisterApi: function(gridApi) {
            gridApi.selection.on.rowSelectionChanged(null, function(row) {
                vm.addEmployee(row.entity);
            });
        }
    };
    vm.dearbcGrid = {
        enableRowSelection: true,
        enableCellEdit: false,
        enableColumnMenus: false,
        modifierKeysToMultiSelect: true,
        enableRowHeaderSelection: false,
        columnDefs: [
            { name: "PayStation", field: "paystation", width: "100%" },
        ],
        data: "vm.listDearbc",
        onRegisterApi: function(gridApi) {
            gridApi.selection.on.rowSelectionChanged(null, function(row) {
                vm.clickSOA(row.entity);
            });
        }
    };
    vm.newLetterHead = function(pass_value) {
        if (pass_value == 'new') {
            data = pass_value;
        } else {
            if (!vm.dearbc.TOCDID) {
                return AppSvc.showSwal("Requirement", "Please select header to update.", "warning");
            }
            data = angular.copy(vm.dearbc);
        }
        var options = {
            data: data,
            animation: true,
            templateUrl: BILLINGURL + "oc_dearbc/new_letterhead.html?v=" + VERSION,
            controllerName: "OCDEARBCLetterHeadCtrl",
            viewSize: "lg",
            filesToLoad: [
                BILLINGURL + "oc_dearbc/new_letterhead.html?v=" + VERSION,
                BILLINGURL + "oc_dearbc/controller.js?v=" + VERSION
            ]
        };
        AppSvc.modal(options).then(function(data) {
            if (data) {
                if (pass_value == 'new') {
                    vm.clearAll();
                }
                vm.dearbc = angular.copy(data);
            }
        });
    }
    vm.newDEARBC = function(pass_value) {
        if (!vm.dearbc.TOCDID) {
            return AppSvc.showSwal("Requirement", "Please select Header to continue.", "warning");
        }
        if (pass_value == 'new') {
            data = pass_value;
        } else {
            if (!vm.header.TOCDHDR) {
                return AppSvc.showSwal("Requirement", "Please select header to update.", "warning");
            }
            data = angular.copy(vm.header);
        }
        var options = {
            data: { data: data, hdr_id: vm.dearbc.TOCDID, period_date: vm.dearbc.period_date, period: vm.dearbc.period },
            animation: true,
            templateUrl: BILLINGURL + "oc_dearbc/new_dearbc.html?v=" + VERSION,
            controllerName: "OCDEARBCHdrCtrl",
            viewSize: "lg",
            filesToLoad: [
                BILLINGURL + "oc_dearbc/new_dearbc.html?v=" + VERSION,
                BILLINGURL + "oc_dearbc/controller.js?v=" + VERSION
            ]
        };
        AppSvc.modal(options).then(function(data) {
            if (data) {
                vm.header = angular.copy(data);
                if (pass_value == 'new') {
                    vm.dataDearbc.push(data);
                    vm.list = [];
                    vm.data = [];
                } else {
                    vm.dataDearbc.splice(vm.header.index, 1, data);
                    vm.getTotalBilling(vm.header.TOCDHDR);
                }
            }
        });
    }
    vm.searchDearbc = function() {
        var options = {
            data: 'menu',
            animation: true,
            templateUrl: BILLINGURL + "oc_dearbc/search_header.html?v=" + VERSION,
            controllerName: "OCDEARBCSearchHdrCtrl",
            viewSize: "lg",
            filesToLoad: [
                BILLINGURL + "oc_dearbc/search_header.html?v=" + VERSION,
                BILLINGURL + "oc_dearbc/controller.js?v=" + VERSION
            ]
        };
        AppSvc.modal(options).then(function(data) {
            if (data) {
                vm.dearbc = angular.copy(data);
                vm.searchHdr(vm.dearbc.TOCDID);
            }
        });
    }
    vm.searchHdr = function(hdr_id) {
        if (!hdr_id) {
            return AppSvc.showSwal("Requirement", "Please select header to continue.", "warning");
        }
        LOADING.classList.add("open");
        OCDEARBCSvc.get({ getHdr: true, hdr_id: hdr_id }).then(function(response) {
            if (response.message) {
                vm.dataDearbc = [];
            } else {
                vm.dataDearbc = response;
            }
            vm.listDearbc = vm.dataDearbc;
            LOADING.classList.remove("open");
        })
    }
    vm.clickSOA = function(row) {
        row.index = vm.dataDearbc.indexOf(row);
        vm.header = angular.copy(row);
        vm.searchDtl(vm.header.TOCDHDR);
        vm.getTotalBilling(vm.header.TOCDHDR);
    }
    vm.searchDtl = function(hdr_id) {
        if (!hdr_id) {
            return AppSvc.showSwal("Requirement", "Please select header to continue.", "warning");
        }
        LOADING.classList.add("open");
        OCDEARBCSvc.get({ getDtl: true, hdr_id: hdr_id }).then(function(response) {
            if (response.message) {
                vm.data = [];
            } else {
                vm.data = response;
            }
            vm.list = vm.data;
            LOADING.classList.remove("open");
        })
    }
    vm.deleteDearbc = function() {
        if (!vm.dearbc.TOCDID) {
            return AppSvc.showSwal("Requirement", "Please select DEARBC to delete.", "warning");
        }
        OCDEARBCDearbcSvc.delete(vm.dearbc.TOCDID).then(function(response) {
            if (response.success) {
                vm.clearAll();
                LOADING.classList.remove("open");
                return AppSvc.showSwal('Success', response.message, 'success');
            } else {
                return AppSvc.showSwal('Error', 'Something went wrong', 'error');
            }
        })
    }
    vm.delete = function() {
        if (!vm.header.TOCDHDR) {
            return AppSvc.showSwal("Requirement", "Please select header to delete.", "warning");
        }
        OCDEARBCSvc.delete(vm.header.TOCDHDR).then(function(response) {
            if (response.success) {
                vm.dataDearbc.splice(vm.header.index, 1);
                vm.clear();
                LOADING.classList.remove("open");
                return AppSvc.showSwal('Success', response.message, 'success');
            } else {
                return AppSvc.showSwal('Error', 'Something went wrong', 'error');
            }
        })
    }
    vm.addEmployee = function(row) {
        if (!vm.header.TOCDHDR) {
            return AppSvc.showSwal("Requirement", "Please select header to continue.", "warning");
        }
        if (vm.dearbc.Status == 'TRANSMITTED') {
            return AppSvc.showSwal("Warning", "DEARBC was already transmitted. Cannot update.", "warning");
        }
        var data = 'menu';
        if (row) {
            row.index = vm.data.indexOf(row);
            data = angular.copy(row);
        }
        var options = {
            data: { variables: data, hdr_id: vm.header.TOCDHDR },
            animation: true,
            templateUrl: BILLINGURL + "oc_dearbc/add_employee.html?v=" + VERSION,
            controllerName: "OCDEARBCDtlCtrl",
            viewSize: "lg",
            filesToLoad: [
                BILLINGURL + "oc_dearbc/add_employee.html?v=" + VERSION,
                BILLINGURL + "oc_dearbc/controller.js?v=" + VERSION
            ]
        };
        AppSvc.modal(options).then(function(data) {
            if (data) {
                if (row) {
                    if (data == 'deleted') {
                        vm.data.splice(row.index, 1);
                    } else {
                        vm.data.splice(row.index, 1, data);
                    }
                } else {
                    vm.data.push(data);
                }
                vm.list = vm.data;
                vm.getTotalBilling(vm.header.TOCDHDR);
            }
        });
    }

    vm.printPreview = function() {
        if (!vm.dearbc.TOCDID) {
            return AppSvc.showSwal("Requirement", "Please select DEARBC to continue.", "warning");
        }
        var options = {
            data: { id: vm.dearbc.TOCDID, period_date: vm.dearbc.period_date },
            animation: true,
            templateUrl: BILLINGURL + "oc_dearbc/print_preview.html?v=" + VERSION,
            controllerName: "OCDEARBCPrintPreviewCtrl",
            viewSize: "full",
            filesToLoad: [
                BILLINGURL + "oc_dearbc/print_preview.html?v=" + VERSION,
                BILLINGURL + "oc_dearbc/controller.js?v=" + VERSION
            ]
        };
        AppSvc.modal(options);
    }

    vm.transmit = function() {
        if (!vm.dearbc.TOCDID) {
            return AppSvc.showSwal("Requirement", "Please select DEARBC to continue.", "warning");
        }
        var options = {
            data: { id: vm.dearbc.TOCDID },
            animation: true,
            templateUrl: BILLINGURL + "oc_dearbc/transmit_billing.html?v=" + VERSION,
            controllerName: "TransmitBillingCtrl",
            viewSize: "md",
            filesToLoad: [
                BILLINGURL + "oc_dearbc/transmit_billing.html?v=" + VERSION,
                BILLINGURL + "oc_dearbc/controller.js?v=" + VERSION
            ]
        };
        AppSvc.modal(options).then(function(data){
            if(data){
                vm.dearbc.Status = data;
            }
        });
    }

    vm.reactivate = function() {
        if (!vm.dearbc.TOCDID) {
            return AppSvc.showSwal("Requirement", "Please select DEARBC to continue.", "warning");
        }
        AppSvc.confirmation('Are You Sure?', 'Are you sure you want to reactivate this record?', 'Reactivate', 'Cancel', true).then(function(data) {
            if (data) {
                var options = {
                    animation: true,
                    templateUrl: BILLINGURL + "oc_bcc/access_required.html?v=" + VERSION,
                    controllerName: "AccessRequiredCtrl",
                    viewSize: "sm",
                    filesToLoad: [
                        BILLINGURL + "oc_bcc/access_required.html?v=" + VERSION,
                        BILLINGURL + "oc_bcc/controller.js?v=" + VERSION
                    ]
                };
                AppSvc.modal(options).then(function(data){
                    if(data){
                        var reactivated_by = data;
                        var options = {
                            animation: true,
                            templateUrl: BILLINGURL + "oc_bcc/reason_reactivation.html?v=" + VERSION,
                            controllerName: "AccessRequiredCtrl",
                            viewSize: "sm",
                            filesToLoad: [
                                BILLINGURL + "oc_bcc/reason_reactivation.html?v=" + VERSION,
                                BILLINGURL + "oc_bcc/controller.js?v=" + VERSION
                            ]
                        };
                        AppSvc.modal(options).then(function(data){
                            if(data){
                                var reason = data;
                                LOADING.classList.add("open");
                                OCDEARBCSvc.save({ id: vm.dearbc.TOCDID, reactivation: true, reactivatedBy: reactivated_by, reasonofreactivation: reason }).then(function(response) {
                                    if (response.success) {
                                        vm.dearbc.Status = 'ACTIVE';
                                        AppSvc.showSwal('Success', response.message, 'success');
                                    } else {
                                        AppSvc.showSwal('Error', 'Something went wrong', 'error');
                                    }
                                    LOADING.classList.remove("open");
                                })
                            }
                        });
                    }
                });
            }
        })
    }

    vm.getTotalBilling = function(hdr_id) {
        LOADING.classList.add("open");
        OCDEARBCSvc.get({ getTotalBilling: true, hdr_id: hdr_id }).then(function(response) {
            if (!response.message) {
                var TotalBilling = response[0].TotalBilling;
                vm.header.TotalGross = TotalBilling;
                vm.header.TotalAdminfee = TotalBilling * (vm.header.admin_percentage / 100);
                vm.header.TotalBilling = parseFloat(TotalBilling) + parseFloat(vm.header.TotalAdminfee);
            } else {
                vm.header.TotalBilling = 0;
            }
            LOADING.classList.remove("open");
        })
    }

    vm.clear = function() {
        vm.list = [];
        vm.header = {};
    }

    vm.clearAll = function() {
        vm.list = [];
        vm.header = {};
        vm.listDearbc = [];
        vm.dearbc = {};
    }
}

function OCDEARBCLetterHeadCtrl($scope, $ocLazyLoad, $injector, data, $uibModalInstance) {
    var modal = this;
    modal.variables = {};
    modal.variables.Status = 'ACTIVE';
    if (data != 'new') {
        modal.variables = angular.copy(data);
    }
    $ocLazyLoad.load([
        BILLINGURL + 'oc_dearbc/service.js?v=' + VERSION,
    ]).then(function(d) {
        OCDEARBCSvc = $injector.get('OCDEARBCSvc');
    });
    modal.searchPeriod = function() {
        var options = {
            data: 'menu',
            animation: true,
            templateUrl: BILLINGURL + "oc_dearbc/search_period.html?v=" + VERSION,
            controllerName: "SearchPeriodCtrl",
            viewSize: "lg",
            filesToLoad: [
                BILLINGURL + "oc_dearbc/search_period.html?v=" + VERSION,
                BILLINGURL + "oc_dearbc/controller.js?v=" + VERSION
            ]
        };
        AppSvc.modal(options).then(function(data) {
            if (data) {
                var split1 = data.PeriodFrom.toString().split("-");
                var split2 = data.PeriodTo.toString().split("-");
                modal.variables.period_date = data.xMonth.toString().toUpperCase() + " " + split1[2] + "-" + split2[2] + " " + data.xYear;
                modal.variables.PayMonthPeriod = data.PayMonthPeriod;
                modal.variables.PeriodFrom = data.PeriodFrom;
                modal.variables.PeriodTo = data.PeriodTo;
                modal.variables.period = data.xPeriod.toString() + data.xPhase.toString();
            }
        });
    }
    modal.searchSig = function(number) {
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
        AppSvc.modal(options).then(function(data) {
            if (data) {
                if (number == 1) {
                    modal.variables.prepared_by = data.fullname;
                    modal.variables.prepared_by_desig = data.position;
                } else if (number == 2) {
                    modal.variables.checked_by = data.fullname;
                    modal.variables.checked_by_desig = data.position;
                } else if (number == 3) {
                    modal.variables.approved_by = data.fullname;
                    modal.variables.approved_by_desig = data.position;
                }
            }
        })
    }
    modal.save = function() {
        LOADING.classList.add("open");
        modal.variables.save_dearbc = true;
        OCDEARBCSvc.save(modal.variables).then(function(response) {
            if (response.success) {
                if (response.id) {
                    modal.variables.TOCDID = response.id;
                }
                AppSvc.showSwal('Success', response.message, 'success');
                $uibModalInstance.close(modal.variables);
            } else {
                AppSvc.showSwal('Error', 'Nothing to change.', 'error');
            }
            LOADING.classList.remove("open");
        })
    }
    modal.close = function() {
        $uibModalInstance.dismiss('cancel');
    }
}

function OCDEARBCHdrCtrl($scope, $ocLazyLoad, $injector, data, $uibModalInstance) {
    var modal = this;
    modal.variables = {};
    modal.variables.admin_percentage = 0;
    if (data.data != 'new') {
        modal.variables = angular.copy(data.data);
    }
    modal.variables.letter_id = data.hdr_id;
    modal.variables.period_date = data.period_date;
    modal.variables.period = data.period;
    $ocLazyLoad.load([
        BILLINGURL + 'oc_dearbc/service.js?v=' + VERSION,
    ]).then(function(d) {
        OCDEARBCSvc = $injector.get('OCDEARBCSvc');
    });
    modal.searchSig = function(number) {
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
        AppSvc.modal(options).then(function(data) {
            if (data) {
                if (number == 1) {
                    modal.variables.prepared_by = data.fullname;
                    modal.variables.prepared_by_desig = data.position;
                } else if (number == 2) {
                    modal.variables.checked_by = data.fullname;
                    modal.variables.checked_by_desig = data.position;
                } else if (number == 3) {
                    modal.variables.approved_by = data.fullname;
                    modal.variables.approved_by_desig = data.position;
                }
            }
        })
    }
    modal.save = function() {
        LOADING.classList.add("open");
        modal.variables.save_header = true;
        OCDEARBCSvc.save(modal.variables).then(function(response) {
            if (response.success) {
                if (response.id) {
                    modal.variables.TOCDHDR = response.id;
                    modal.variables.SOANo = response.SOANo;
                }
                $uibModalInstance.close(modal.variables);
            } else {
                AppSvc.showSwal('Error', 'Something went wrong', 'error');
            }
            LOADING.classList.remove("open");
        })
    }
    modal.close = function() {
        $uibModalInstance.dismiss('cancel');
    }
}

function OCDEARBCSearchHdrCtrl($scope, $ocLazyLoad, $injector, data, $uibModalInstance) {
    var modal = this;
    modal.data = [];
    modal.list = [];
    var filter = $injector.get('$filter');
    $ocLazyLoad.load([
        BILLINGURL + 'oc_dearbc/service.js?v=' + VERSION,
    ]).then(function(d) {
        OCDEARBCSvc = $injector.get('OCDEARBCSvc');
        modal.getData();
    });

    modal.getData = function() {
        LOADING.classList.add("open");
        OCDEARBCSvc.get({ getDearbc: true }).then(function(response) {
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
            { name: "Period Date", field: "period_date" }
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
        modal.list = filter('filter')(modal.data, { period_date: modal.search });
    }

    modal.close = function() {
        $uibModalInstance.dismiss('cancel');
    }
}

function OCDEARBCDtlCtrl($scope, $ocLazyLoad, $injector, data, $uibModalInstance) {
    var modal = this;
    var filter = $injector.get("$filter");
    modal.variables = {};
    modal.variables.hdr_id = data.hdr_id;
    if (data.variables.TODDTL) {
        modal.variables = angular.copy(data.variables);
    }
    $ocLazyLoad.load([
        BILLINGURL + 'oc_dearbc/service.js?v=' + VERSION,
    ]).then(function(d) {
        OCDEARBCSvc = $injector.get('OCDEARBCSvc');
        OCDEARBCDtlSvc = $injector.get('OCDEARBCDtlSvc');
    });
    modal.searchEmployee = function() {
        var options = {
            data: 'menu',
            templateUrl: BILLINGURL + 'oc_dearbc/employee_list.html?v=' + VERSION,
            controllerName: 'SearchEmployeeCtrl',
            viewSize: 'lg',
            filesToLoad: [
                BILLINGURL + 'oc_dearbc/controller.js?v=' + VERSION,
            ],
        };
        AppSvc.modal(options).then(function(data) {
            if (data) {
                if (data.ChapaID_New == "") {
                    modal.variables.Chapa = data.ChapaID_Old;
                } else {
                    modal.variables.Chapa = data.ChapaID_New;
                }
                var ExtName = data.ExtName != '' ? data.ExtName + " " : "";
                modal.variables.Name = data.LName + ", " + ExtName + data.FName + " " + data.MName;
            }
        });
    }
    modal.linkMeSenpai = function() {
        LOADING.classList.add("open");
        OCDEARBCSvc.get({ getLinkedData: true, chapa: modal.variables.Chapa, hdr_id: modal.variables.hdr_id }).then(function(response) {
            if (!response.message) {
                modal.variables.rd_st = response.rd_st.toString();
                modal.variables.rd_ot = response.rd_ot.toString();
                modal.variables.rd_nd = response.rd_nd.toString();
                modal.variables.rd_ndot = response.rd_ndot.toString();
                modal.variables.shol_st = response.shol_st.toString();
                modal.variables.shol_ot = response.shol_ot.toString();
                modal.variables.shol_nd = response.shol_nd.toString();
                modal.variables.shol_ndot = response.shol_ndot.toString();
                modal.variables.rhol_st = response.rhol_st.toString();
                modal.variables.rhol_ot = response.rhol_ot.toString();
                modal.variables.rhol_nd = response.rhol_nd.toString();
                modal.variables.rhol_ndot = response.rhol_ndot.toString();
                modal.variables.shrd_st = response.shrd_st.toString();
                modal.variables.shrd_ot = response.shrd_ot.toString();
                modal.variables.shrd_nd = response.shrd_nd.toString();
                modal.variables.shrd_ndot = response.shrd_ndot.toString();
                modal.variables.rhrd_st = response.rhrd_st.toString();
                modal.variables.rhrd_ot = response.rhrd_ot.toString();
                modal.variables.rhrd_nd = response.rhrd_nd.toString();
                modal.variables.rhrd_ndot = response.rhrd_ndot.toString();
                modal.variables.extra = response.extra.toString();
                modal.variables.adjustment = response.adjustment.toString();
                modal.variables.incentive = response.incentive.toString();
                modal.variables.addpay = response.addpay.toString();
                modal.variables.cola = response.cola.toString();
                modal.variables.silpat = response.silpat.toString();
                modal.variables.sss_ec = response.sss_ec.toString();
                modal.variables.sss_er = response.sss_er.toString();
                modal.variables.phic_er = response.phic_er.toString();
                modal.variables.hdmf_er = response.hdmf_er.toString();
                modal.variables.mpro = response.mpro.toString();
            } else {
                return AppSvc.showSwal('Ooops', 'No Data Found in Payroll', 'warning');
            }
            LOADING.classList.remove("open");
        });
    }
    modal.compute = function() {
        var rd_st = modal.variables.rd_st ? parseFloat(AppSvc.getAmount(modal.variables.rd_st)) : 0;
        var rd_ot = modal.variables.rd_ot ? parseFloat(AppSvc.getAmount(modal.variables.rd_ot)) : 0;
        var rd_nd = modal.variables.rd_nd ? parseFloat(AppSvc.getAmount(modal.variables.rd_nd)) : 0;
        var rd_ndot = modal.variables.rd_ndot ? parseFloat(AppSvc.getAmount(modal.variables.rd_ndot)) : 0;
        var shol_st = modal.variables.shol_st ? parseFloat(AppSvc.getAmount(modal.variables.shol_st)) : 0;
        var shol_ot = modal.variables.shol_ot ? parseFloat(AppSvc.getAmount(modal.variables.shol_ot)) : 0;
        var shol_nd = modal.variables.shol_nd ? parseFloat(AppSvc.getAmount(modal.variables.shol_nd)) : 0;
        var shol_ndot = modal.variables.shol_ndot ? parseFloat(AppSvc.getAmount(modal.variables.shol_ndot)) : 0;
        var rhol_st = modal.variables.rhol_st ? parseFloat(AppSvc.getAmount(modal.variables.rhol_st)) : 0;
        var rhol_ot = modal.variables.rhol_ot ? parseFloat(AppSvc.getAmount(modal.variables.rhol_ot)) : 0;
        var rhol_nd = modal.variables.rhol_nd ? parseFloat(AppSvc.getAmount(modal.variables.rhol_nd)) : 0;
        var rhol_ndot = modal.variables.rhol_ndot ? parseFloat(AppSvc.getAmount(modal.variables.rhol_ndot)) : 0;
        var shrd_st = modal.variables.shrd_st ? parseFloat(AppSvc.getAmount(modal.variables.shrd_st)) : 0;
        var shrd_ot = modal.variables.shrd_ot ? parseFloat(AppSvc.getAmount(modal.variables.shrd_ot)) : 0;
        var shrd_nd = modal.variables.shrd_nd ? parseFloat(AppSvc.getAmount(modal.variables.shrd_nd)) : 0;
        var shrd_ndot = modal.variables.shrd_ndot ? parseFloat(AppSvc.getAmount(modal.variables.shrd_ndot)) : 0;
        var rhrd_st = modal.variables.rhrd_st ? parseFloat(AppSvc.getAmount(modal.variables.rhrd_st)) : 0;
        var rhrd_ot = modal.variables.rhrd_ot ? parseFloat(AppSvc.getAmount(modal.variables.rhrd_ot)) : 0;
        var rhrd_nd = modal.variables.rhrd_nd ? parseFloat(AppSvc.getAmount(modal.variables.rhrd_nd)) : 0;
        var rhrd_ndot = modal.variables.rhrd_ndot ? parseFloat(AppSvc.getAmount(modal.variables.rhrd_ndot)) : 0;
        var extra = modal.variables.extra ? parseFloat(AppSvc.getAmount(modal.variables.extra)) : 0;
        var silpat = modal.variables.silpat ? parseFloat(AppSvc.getAmount(modal.variables.silpat)) : 0;
        var adjustment = modal.variables.adjustment ? parseFloat(AppSvc.getAmount(modal.variables.adjustment)) : 0;
        var incentive = modal.variables.incentive ? parseFloat(AppSvc.getAmount(modal.variables.incentive)) : 0;
        var addpay = modal.variables.addpay ? parseFloat(AppSvc.getAmount(modal.variables.addpay)) : 0;
        var volumepay = modal.variables.volumepay ? parseFloat(AppSvc.getAmount(modal.variables.volumepay)) : 0;
        var allowance = modal.variables.allowance ? parseFloat(AppSvc.getAmount(modal.variables.allowance)) : 0;
        var cola = modal.variables.cola ? parseFloat(AppSvc.getAmount(modal.variables.cola)) : 0;
        var sss_ec = modal.variables.sss_ec ? parseFloat(AppSvc.getAmount(modal.variables.sss_ec)) : 0;
        var sss_er = modal.variables.sss_er ? parseFloat(AppSvc.getAmount(modal.variables.sss_er)) : 0;
        var phic_er = modal.variables.phic_er ? parseFloat(AppSvc.getAmount(modal.variables.phic_er)) : 0;
        var hdmf_er = modal.variables.hdmf_er ? parseFloat(AppSvc.getAmount(modal.variables.hdmf_er)) : 0;
        var mpro = modal.variables.mpro ? parseFloat(AppSvc.getAmount(modal.variables.mpro)) : 0;

        var grosspay = rd_st + rd_ot + rd_nd + rd_ndot + shol_st + shol_ot + shol_nd + shol_ndot + rhol_st + rhol_ot + rhol_nd + rhol_ndot +
            shrd_st + shrd_ot + shrd_nd + shrd_ndot + rhrd_st + rhrd_ot + rhrd_nd + rhrd_ndot + extra + silpat + adjustment + incentive + addpay +
            volumepay + allowance + cola;
        var total = grosspay + sss_ec + sss_er + phic_er + hdmf_er + mpro;
        modal.variables.grosspay = filter("number")(grosspay, 2);
        modal.variables.total = filter("number")(total, 2);
    }
    modal.save = function() {
        if (!modal.variables.Chapa) {
            return AppSvc.showSwal('Ooops', 'Select Employee first', 'warning');
        }
        LOADING.classList.add("open");
        modal.variables.detail = true;
        var data = angular.copy(modal.variables);
        data.rd_st = modal.variables.rd_st ? parseFloat(AppSvc.getAmount(modal.variables.rd_st)) : 0;
        data.rd_ot = modal.variables.rd_ot ? parseFloat(AppSvc.getAmount(modal.variables.rd_ot)) : 0;
        data.rd_nd = modal.variables.rd_nd ? parseFloat(AppSvc.getAmount(modal.variables.rd_nd)) : 0;
        data.rd_ndot = modal.variables.rd_ndot ? parseFloat(AppSvc.getAmount(modal.variables.rd_ndot)) : 0;
        data.shol_st = modal.variables.shol_st ? parseFloat(AppSvc.getAmount(modal.variables.shol_st)) : 0;
        data.shol_ot = modal.variables.shol_ot ? parseFloat(AppSvc.getAmount(modal.variables.shol_ot)) : 0;
        data.shol_nd = modal.variables.shol_nd ? parseFloat(AppSvc.getAmount(modal.variables.shol_nd)) : 0;
        data.shol_ndot = modal.variables.shol_ndot ? parseFloat(AppSvc.getAmount(modal.variables.shol_ndot)) : 0;
        data.rhol_st = modal.variables.rhol_st ? parseFloat(AppSvc.getAmount(modal.variables.rhol_st)) : 0;
        data.rhol_ot = modal.variables.rhol_ot ? parseFloat(AppSvc.getAmount(modal.variables.rhol_ot)) : 0;
        data.rhol_nd = modal.variables.rhol_nd ? parseFloat(AppSvc.getAmount(modal.variables.rhol_nd)) : 0;
        data.rhol_ndot = modal.variables.rhol_ndot ? parseFloat(AppSvc.getAmount(modal.variables.rhol_ndot)) : 0;
        data.shrd_st = modal.variables.shrd_st ? parseFloat(AppSvc.getAmount(modal.variables.shrd_st)) : 0;
        data.shrd_ot = modal.variables.shrd_ot ? parseFloat(AppSvc.getAmount(modal.variables.shrd_ot)) : 0;
        data.shrd_nd = modal.variables.shrd_nd ? parseFloat(AppSvc.getAmount(modal.variables.shrd_nd)) : 0;
        data.shrd_ndot = modal.variables.shrd_ndot ? parseFloat(AppSvc.getAmount(modal.variables.shrd_ndot)) : 0;
        data.rhrd_st = modal.variables.rhrd_st ? parseFloat(AppSvc.getAmount(modal.variables.rhrd_st)) : 0;
        data.rhrd_ot = modal.variables.rhrd_ot ? parseFloat(AppSvc.getAmount(modal.variables.rhrd_ot)) : 0;
        data.rhrd_nd = modal.variables.rhrd_nd ? parseFloat(AppSvc.getAmount(modal.variables.rhrd_nd)) : 0;
        data.rhrd_ndot = modal.variables.rhrd_ndot ? parseFloat(AppSvc.getAmount(modal.variables.rhrd_ndot)) : 0;
        data.extra = modal.variables.extra ? parseFloat(AppSvc.getAmount(modal.variables.extra)) : 0;
        data.silpat = modal.variables.silpat ? parseFloat(AppSvc.getAmount(modal.variables.silpat)) : 0;
        data.adjustment = modal.variables.adjustment ? parseFloat(AppSvc.getAmount(modal.variables.adjustment)) : 0;
        data.incentive = modal.variables.incentive ? parseFloat(AppSvc.getAmount(modal.variables.incentive)) : 0;
        data.addpay = modal.variables.addpay ? parseFloat(AppSvc.getAmount(modal.variables.addpay)) : 0;
        data.volumepay = modal.variables.volumepay ? parseFloat(AppSvc.getAmount(modal.variables.volumepay)) : 0;
        data.allowance = modal.variables.allowance ? parseFloat(AppSvc.getAmount(modal.variables.allowance)) : 0;
        data.cola = modal.variables.cola ? parseFloat(AppSvc.getAmount(modal.variables.cola)) : 0;
        data.sss_ec = modal.variables.sss_ec ? parseFloat(AppSvc.getAmount(modal.variables.sss_ec)) : 0;
        data.sss_er = modal.variables.sss_er ? parseFloat(AppSvc.getAmount(modal.variables.sss_er)) : 0;
        data.phic_er = modal.variables.phic_er ? parseFloat(AppSvc.getAmount(modal.variables.phic_er)) : 0;
        data.hdmf_er = modal.variables.hdmf_er ? parseFloat(AppSvc.getAmount(modal.variables.hdmf_er)) : 0;
        data.mpro = modal.variables.mpro ? parseFloat(AppSvc.getAmount(modal.variables.mpro)) : 0;
        data.grosspay = modal.variables.grosspay ? parseFloat(AppSvc.getAmount(modal.variables.grosspay)) : 0;
        data.total = modal.variables.total ? parseFloat(AppSvc.getAmount(modal.variables.total)) : 0;
        OCDEARBCSvc.save(data).then(function(response) {
            if (response.success) {
                if (response.id) {
                    modal.variables.TODDTL = response.id;
                }
                $uibModalInstance.close(modal.variables);
                AppSvc.showSwal('Success', response.message, 'success');
            } else {
                AppSvc.showSwal('Confirmation', response.message, 'warning');
            }
            LOADING.classList.remove("open");
        })
    }
    modal.delete = function() {
        if (!modal.variables.TODDTL) {
            return AppSvc.showSwal("Requirement", "Please select detail to delete.", "warning");
        }
        OCDEARBCDtlSvc.delete(modal.variables.TODDTL).then(function(response) {
            if (response.success) {
                $uibModalInstance.close('deleted');
                LOADING.classList.remove("open");
                return AppSvc.showSwal('Success', response.message, 'success');
            } else {
                return AppSvc.showSwal('Error', 'Something went wrong', 'error');
            }
        })
    }
    modal.close = function() {
        $uibModalInstance.dismiss('cancel');
    }
}

function SearchEmployeeCtrl($scope, $ocLazyLoad, $injector, data, $uibModalInstance) {
    var modal = this;
    modal.filtered = [];
    modal.filteredList = [];
    modal.loading = "";

    $ocLazyLoad.load([
        BILLINGURL + 'oc_dearbc/service.js?v=' + VERSION,
    ]).then(function(d) {
        OCDEARBCSvc = $injector.get('OCDEARBCSvc');
        modal.getData();
    });

    modal.getData = function() {
        modal.loading = 'Loading Data...';
        OCDEARBCSvc.get({ getEmployee: true }).then(function(response) {
            if (response.message) {
                modal.filtered = [];
            } else {
                modal.filteredList = response;
                modal.filtered = modal.filteredList;
            }
            modal.loading = '';
        });
    }

    modal.defaultGrid = {
        enableRowSelection: true,
        enableCellEdit: false,
        enableColumnMenus: false,
        modifierKeysToMultiSelect: true,
        enableRowHeaderSelection: false,
        columnDefs: [
            { name: 'Old Chapa ID', field: 'ChapaID_Old' },
            { name: 'LAST NAME', field: 'LName' },
            { name: 'FIRST NAME', field: 'FName' },
            { name: 'MIDDLE NAME', field: 'MName' },
        ],
        data: 'modal.filtered',
        onRegisterApi: function(gridApi) {
            gridApi.selection.on.rowSelectionChanged(null, function(row) {
                modal.clickRow(row.entity);
            });
        },
    };

    modal.clickRow = function(row) {
        $uibModalInstance.close(row);
    }

    modal.refresh = function() {
        modal.getData();
    }

    modal.searching = function() {
        if (!modal.search) {
            return (modal.filtered = modal.filteredList);
        }
        // var filter = $injector.get('$filter');
        var searchFound = [];
        var temp_storage = modal.filteredList;
        temp_storage.forEach(function(item) {
            // search field
            if (
                item.LName.toUpperCase().startsWith(modal.search.toUpperCase()) ||
                item.FName.toUpperCase().startsWith(modal.search.toUpperCase()) ||
                item.ChapaID_Old.toUpperCase().startsWith(modal.search.toUpperCase())
            ) {
                searchFound.push(item);
            }
        });
        return (modal.filtered = searchFound);
    }

    modal.close = function() {
        $uibModalInstance.dismiss('cancel');
    }
}

function OCDEARBCPrintPreviewCtrl($scope, $ocLazyLoad, $injector, data, $uibModalInstance) {
    var modal = this;
    modal.variables = {};
    if (data) {
        modal.variables.TOCDID = data.id;
        modal.variables.period_date = data.period_date;
    }
    $ocLazyLoad.load([
        BILLINGURL + 'oc_dearbc/service.js?v=' + VERSION,
    ]).then(function(d) {
        OCDEARBCSvc = $injector.get('OCDEARBCSvc');
        modal.getData();
    });

    modal.getData = function() {
        LOADING.classList.add("open");
        OCDEARBCSvc.get({ getReportPreviewData: true, id: modal.variables.TOCDID }).then(function(response) {
            if (!response.message) {
                modal.variables = response[0];
                if (modal.variables.letter_to == '') {
                    modal.variables.letter_to = "";
                }
                if (modal.variables.body == '') {
                    modal.variables.body = "Dear ,<br><br>Attached are the supporting documents of out billing rendered by <b>GENERAL SERVICES MULTIPURPOSE COOPERATIVE</b> for the period <u>" + modal.variables.period_date + "</u>";
                }
                if (modal.variables.body2 == '') {
                    modal.variables.body2 = "Please Issue check in the name of <b><u>GENERAL SERVICES MULTIPURPOSE COOPERATIVE</u></b><br><br><br>Thank You!";
                }
            } else {
                $uibModalInstance.dismiss();
            }
            LOADING.classList.remove("open");
        });
    }

    modal.generate = function() {
        LOADING.classList.add("open");
        modal.variables.printPreview = true;
        OCDEARBCSvc.save(modal.variables).then(function(response) {
            if (response.success) {
                window.open('api/oc_dearbc?generateReportLetterHead=true&id=' + modal.variables.TOCDID);
                response.array_result.forEach(function(item) {
                    OCDEARBCSvc.save({ printPreviewDetails: true, id: item.TOCDHDR }).then(function(response) {
                        if (response.success) {
                            window.open('api/oc_dearbc?printPreviewDetails=true&id=' + item.TOCDHDR);
                        }
                    })
                })
            } else {
                AppSvc.showSwal("Oops", "No Data Found.", "warning");
            }
            LOADING.classList.remove("open");
        })
    }

    modal.close = function() {
        $uibModalInstance.dismiss('cancel');
    }
}

function SearchPeriodCtrl($scope, $ocLazyLoad, $injector, data, $uibModalInstance) {
    var modal = this;
    modal.filtered = [];
    modal.filteredList = [];
    modal.search = "";

    $ocLazyLoad.load([
        BILLINGURL + 'oc_dearbc/service.js?v=' + VERSION,
    ]).then(function(d) {
        OCDEARBCSvc = $injector.get('OCDEARBCSvc');
        modal.getData();
    });

    modal.getData = function() {
        OCDEARBCSvc.get({ getPeriod: true }).then(function(response) {
            if (response.message) {
                modal.filtered = [];
            } else {
                modal.filteredList = response;
                modal.filtered = modal.filteredList;
            }
        });
    }

    modal.defaultGrid = {
        enableRowSelection: true,
        enableCellEdit: false,
        enableColumnMenus: false,
        modifierKeysToMultiSelect: true,
        enableRowHeaderSelection: false,
        columnDefs: [
            { name: 'Period', field: 'xPhase' },
            { name: 'Month', field: 'xMonth' },
            { name: 'Year', field: 'xYear' },
        ],
        data: 'modal.filtered',
        onRegisterApi: function(gridApi) {
            gridApi.selection.on.rowSelectionChanged(null, function(row) {
                modal.clickRow(row.entity);
            });
        },
    };

    modal.clickRow = function(row) {
        $uibModalInstance.close(row);
    }

    modal.searching = function() {
        if (!modal.search) {
            return (modal.filtered = modal.filteredList);
        }
        // var filter = $injector.get('$filter');
        var searchFound = [];
        var temp_storage = modal.filteredList;
        temp_storage.forEach(function(item) {
            // search field
            if (
                item.xMonth.toUpperCase().startsWith(modal.search.toUpperCase())
            ) {
                searchFound.push(item);
            }
        });
        return (modal.filtered = searchFound);
    }

    modal.close = function() {
        $uibModalInstance.dismiss('cancel');
    }
}
function TransmitBillingCtrl($scope, $ocLazyLoad, $injector, data, $uibModalInstance) {
    var modal = this;
    modal.variables = {};
    modal.variables.id = data.id;
    modal.variables.date_transmitted = new Date();

    $ocLazyLoad.load([
        BILLINGURL + 'oc_dearbc/service.js?v=' + VERSION,
    ]).then(function(d) {
        OCDEARBCSvc = $injector.get('OCDEARBCSvc');
        modal.getData();
    });

    modal.getData = function (){
        OCDEARBCSvc.get({ getHeaderID: modal.variables.id }).then(function(response) {
            if (!response.message) {
                modal.variables = response[0];
                modal.variables.date_transmitted = new Date(response[0].date_transmitted);
            }
        })
    }

    modal.transmit = function() {
        AppSvc.confirmation('Are You Sure?', 'Are you sure you want to transmit this record?', 'Transmit', 'Cancel', true).then(function(data) {
            if (data) {
                LOADING.classList.add("open");
                var data = angular.copy(modal.variables);
                data.date_transmitted = AppSvc.getDate(modal.variables.date_transmitted);
                data.transmittal = true;
                console.log(data);
                OCDEARBCSvc.save(data).then(function(response) {
                    if (response.success) {
                        $uibModalInstance.close('TRANSMITTED');
                        AppSvc.showSwal('Success', response.message, 'success');
                    } else {
                        AppSvc.showSwal('Error', 'Something went wrong', 'error');
                    }
                    LOADING.classList.remove("open");
                })
            }
        })
    }

    modal.close = function() {
        $uibModalInstance.dismiss('cancel');
    }
}