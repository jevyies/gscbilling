angular.module('app')
    .controller('OCLABNOTINCTRL', OCLABNOTINCTRL)
    .controller('OCLABNOTINHDRCTRL', OCLABNOTINHDRCTRL)
    .controller('OCLABNOTINSearchHdrCtrl', OCLABNOTINSearchHdrCtrl)
    .controller('OCLABNOTINDtlCtrl', OCLABNOTINDtlCtrl)
    .controller('GLAccountListCtrl', GLAccountListCtrl)
    .controller('CostCenterListCtrl', CostCenterListCtrl)
    .controller('OCLABNOTINPrintPreviewCtrl', OCLABNOTINPrintPreviewCtrl)
    .controller('OCLABNOTINPrintPreviewTransmittalCtrl', OCLABNOTINPrintPreviewTransmittalCtrl)
    .controller('TransmitBillingCtrl', TransmitBillingCtrl)

OCLABNOTINCTRL.$inject = ['$scope', '$ocLazyLoad', '$injector'];
OCLABNOTINHDRCTRL.$inject = ['$scope', '$ocLazyLoad', '$injector', 'data', '$uibModalInstance'];
OCLABNOTINSearchHdrCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector', 'data', '$uibModalInstance'];
OCLABNOTINDtlCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector', 'data', '$uibModalInstance'];
GLAccountListCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector', 'data', '$uibModalInstance'];
CostCenterListCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector', 'data', '$uibModalInstance'];
OCLABNOTINPrintPreviewCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector', 'data', '$uibModalInstance'];
OCLABNOTINPrintPreviewTransmittalCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector', 'data', '$uibModalInstance'];
TransmitBillingCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector', 'data', '$uibModalInstance'];

function OCLABNOTINCTRL($scope, $ocLazyLoad, $injector) {
    var vm = this;
    vm.header = {};
    vm.data = [];
    vm.list = [];
    $ocLazyLoad.load([
        BILLINGURL + 'oc_labnotin/service.js?v=' + VERSION,
    ]).then(function(d) {
        OCLABNOTINSvc = $injector.get('OCLABNOTINSvc');
    });

    vm.defaultGrid = {
        enableRowSelection: true,
        enableCellEdit: false,
        enableColumnMenus: false,
        modifierKeysToMultiSelect: true,
        enableRowHeaderSelection: false,
        columnDefs: [
            { name: "Activity", field: "Activity", width: "15%" },
            { name: "Date", field: "date", width: "15%" },
            { name: "GL", field: "gl", width: "15%" },
            { name: "CC", field: "cc", width: "15%" },
            { name: "Hours Accomplished", field: "hrs", width: "13%" },
            { name: "Rate/Hour", field: "rate_hr", width: "12%", cellFilter: 'number:2' },
            { name: "Amount Billed", field: "amount_billed", width: "15%", cellFilter: 'number:2' }
        ],
        data: "vm.list",
        onRegisterApi: function(gridApi) {
            gridApi.selection.on.rowSelectionChanged(null, function(row) {
                vm.addDetail(row.entity);
            });
        }
    };

    vm.newHeader = function(pass_value) {
        if (pass_value == 'new') {
            data = pass_value;
        } else {
            if (!vm.header.TOCLHDR) {
                return AppSvc.showSwal("Requirement", "Please select header to update.", "warning");
            }
            data = angular.copy(vm.header);
        }
        var options = {
            data: data,
            animation: true,
            templateUrl: BILLINGURL + "oc_labnotin/new_header.html?v=" + VERSION,
            controllerName: "OCLABNOTINHDRCTRL",
            viewSize: "lg",
            filesToLoad: [
                BILLINGURL + "oc_labnotin/new_header.html?v=" + VERSION,
                BILLINGURL + "oc_labnotin/controller.js?v=" + VERSION
            ]
        };
        AppSvc.modal(options).then(function(data) {
            if (data) {
                if (pass_value == 'new') {
                    vm.clear();
                }
                vm.header = angular.copy(data);
                vm.getTotalBilling(vm.header.TOCLHDR);
            }
        });
    }

    vm.searchHeader = function() {
        var options = {
            data: 'menu',
            animation: true,
            templateUrl: BILLINGURL + "oc_labnotin/search_header.html?v=" + VERSION,
            controllerName: "OCLABNOTINSearchHdrCtrl",
            viewSize: "lg",
            filesToLoad: [
                BILLINGURL + "oc_labnotin/search_header.html?v=" + VERSION,
                BILLINGURL + "oc_labnotin/controller.js?v=" + VERSION
            ]
        };
        AppSvc.modal(options).then(function(data) {
            if (data) {
                vm.header = angular.copy(data);
                vm.searchDtl(vm.header.TOCLHDR);
                vm.getTotalBilling(vm.header.TOCLHDR);
            }
        });
    }

    vm.searchDtl = function(hdr_id) {
        if (!hdr_id) {
            return AppSvc.showSwal("Requirement", "Please select header to continue.", "warning");
        }
        LOADING.classList.add("open");
        OCLABNOTINSvc.get({ getDtl: true, hdr_id: hdr_id }).then(function(response) {
            if (response.message) {
                vm.data = [];
            } else {
                vm.data = response;
            }
            vm.list = vm.data;
            LOADING.classList.remove("open");
        })
    }

    vm.addDetail = function(row) {
        if (!vm.header.TOCLHDR) {
            return AppSvc.showSwal("Requirement", "Please select header to continue.", "warning");
        }
        if (vm.header.Status == 'TRANSMITTED') {
            return AppSvc.showSwal("Warning", "LABNOTIN was already transmitted. Cannot update.", "warning");
        }
        var data = 'menu';
        if (row) {
            row.index = vm.data.indexOf(row);
            data = angular.copy(row);
        }
        var options = {
            data: { variables: data, hdr_id: vm.header.TOCLHDR },
            animation: true,
            templateUrl: BILLINGURL + "oc_labnotin/add_detail.html?v=" + VERSION,
            controllerName: "OCLABNOTINDtlCtrl",
            viewSize: "lg",
            filesToLoad: [
                BILLINGURL + "oc_labnotin/add_detail.html?v=" + VERSION,
                BILLINGURL + "oc_labnotin/controller.js?v=" + VERSION
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
                vm.getTotalBilling(data.hdr_id);
            }
        });
    }

    vm.getTotalBilling = function(hdr_id) {
        LOADING.classList.add("open");
        OCLABNOTINSvc.get({ getTotalBilling: true, hdr_id: hdr_id }).then(function(response) {
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

    vm.transmit = function() {
        if (!vm.header.TOCLHDR) {
            return AppSvc.showSwal("Requirement", "Please select LABNOTIN Header to continue.", "warning");
        }
        var options = {
            data: { id: vm.header.TOCLHDR },
            animation: true,
            templateUrl: BILLINGURL + "oc_labnotin/transmit_billing.html?v=" + VERSION,
            controllerName: "TransmitBillingCtrl",
            viewSize: "md",
            filesToLoad: [
                BILLINGURL + "oc_labnotin/transmit_billing.html?v=" + VERSION,
                BILLINGURL + "oc_labnotin/controller.js?v=" + VERSION
            ]
        };
        AppSvc.modal(options).then(function(data){
            if(data){
                vm.header.Status = data;
            }
        });
    }

    vm.reactivate = function() {
        if (!vm.header.TOCLHDR) {
            return AppSvc.showSwal("Requirement", "Please select LABNOTIN Header to continue.", "warning");
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
                                OCLABNOTINSvc.save({ id: vm.header.TOCLHDR, reactivation: true, reactivatedBy: reactivated_by, reasonofreactivation: reason }).then(function(response) {
                                    if (response.success) {
                                        vm.header.Status = 'ACTIVE';
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

    vm.printPreview = function() {
        if (!vm.header.TOCLHDR) {
            return AppSvc.showSwal("Requirement", "Please select Header to continue.", "warning");
        }
        var options = {
            data: { id: vm.header.TOCLHDR, period_date: vm.header.period_date },
            animation: true,
            templateUrl: BILLINGURL + "oc_labnotin/print_preview.html?v=" + VERSION,
            controllerName: "OCLABNOTINPrintPreviewCtrl",
            viewSize: "lg",
            filesToLoad: [
                BILLINGURL + "oc_labnotin/print_preview.html?v=" + VERSION,
                BILLINGURL + "oc_labnotin/controller.js?v=" + VERSION
            ]
        };
        AppSvc.modal(options);
    }

    vm.clear = function() {
        vm.header = {};
        vm.data = [];
        vm.list = [];
    }
}

function OCLABNOTINHDRCTRL($scope, $ocLazyLoad, $injector, data, $uibModalInstance) {
    var modal = this;
    modal.variables = {};
    modal.variables.admin_percentage = 10;
    if (data != 'new') {
        modal.variables = angular.copy(data);
    }
    $ocLazyLoad.load([
        BILLINGURL + 'oc_labnotin/service.js?v=' + VERSION,
    ]).then(function(d) {
        OCLABNOTINSvc = $injector.get('OCLABNOTINSvc');
        modal.getUser();
    });
    modal.getUser = function() {
        AppSvc.get().then(function(response) {
            if (response.record) {
                modal.variables.Prepared_by = response.record.user;
                modal.variables.Prepared_by_desig = "User/Encoder";
            }
        })
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
                    modal.variables.Prepared_by = data.fullname;
                    modal.variables.Prepared_by_desig = data.position;
                } else if (number == 2) {
                    modal.variables.Noted_by = data.fullname;
                    modal.variables.Noted_by_desig = data.position;
                } else if (number == 3) {
                    modal.variables.Checked_by = data.fullname;
                    modal.variables.Checked_by_desig = data.position;
                } else if (number == 4) {
                    modal.variables.Approved_by = data.fullname;
                    modal.variables.Approved_by_desig = data.position;
                } else if (number == 5) {
                    modal.variables.Approved_by_2 = data.fullname;
                    modal.variables.Approved_by_2_desig = data.position;
                }
            }
        })
    }
    modal.searchPayrollPeriod = function() {
        var options = {
            data: 'menu',
            templateUrl: BILLINGURL + 'oc_slers/search_period.html?v=' + VERSION,
            controllerName: 'SearchPayrollPeriodCtrl',
            viewSize: 'md',
            filesToLoad: [
                BILLINGURL + 'oc_slers/controller.js?v=' + VERSION,
            ],
        };
        AppSvc.modal(options).then(function(data) {
            if (data) {
                modal.variables.period = data.xPeriod.toString() + data.xPhase.toString();
                modal.variables.period_date = data.period_date;
            }
        });
    }
    modal.save = function() {
        LOADING.classList.add("open");
        modal.variables.save_header = true;
        OCLABNOTINSvc.save(modal.variables).then(function(response) {
            if (response.success) {
                if (response.id) {
                    modal.variables.Status = 'ACTIVE';
                    modal.variables.TOCLHDR = response.id;
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

function OCLABNOTINSearchHdrCtrl($scope, $ocLazyLoad, $injector, data, $uibModalInstance) {
    var modal = this;
    modal.data = [];
    modal.list = [];
    var filter = $injector.get('$filter');
    $ocLazyLoad.load([
        BILLINGURL + 'oc_labnotin/service.js?v=' + VERSION,
    ]).then(function(d) {
        OCLABNOTINSvc = $injector.get('OCLABNOTINSvc');
        modal.getData();
    });

    modal.getData = function() {
        LOADING.classList.add("open");
        OCLABNOTINSvc.get({ getHeader: true }).then(function(response) {
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
            { name: "SOANo", field: "SOANo" },
            { name: "Period Date", field: "period_date" },
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
        modal.list = filter('filter')(modal.data, { SOANo: modal.search });
    }

    modal.close = function() {
        $uibModalInstance.dismiss('cancel');
    }
}

function OCLABNOTINDtlCtrl($scope, $ocLazyLoad, $injector, data, $uibModalInstance) {
    var modal = this;
    var filter = $injector.get("$filter");
    modal.variables = {};
    modal.variables.hdr_id = data.hdr_id;
    modal.variables.date = new Date();
    modal.variables.rate_hr = "188.00"
    if (data.variables.TOCLDTL) {
        modal.variables = angular.copy(data.variables);
        modal.variables.date = new Date(data.variables.date);
    }
    $ocLazyLoad.load([
        BILLINGURL + 'oc_labnotin/service.js?v=' + VERSION,
    ]).then(function(d) {
        OCLABNOTINSvc = $injector.get('OCLABNOTINSvc');
        OCLABNOTINDTLSvc = $injector.get('OCLABNOTINDTLSvc');
    });
    modal.searchCCList = function() {
        var options = {
            data: 'menu',
            animation: true,
            templateUrl: BILLINGURL + "oc_labnotin/cc_list.html?v=" + VERSION,
            controllerName: "CostCenterListCtrl",
            viewSize: "lg",
            filesToLoad: [
                BILLINGURL + "oc_labnotin/cc_list.html?v=" + VERSION,
                BILLINGURL + "oc_labnotin/controller.js?v=" + VERSION
            ]
        };
        AppSvc.modal(options).then(function(data) {
            if (data) {
                modal.variables.cc = data.costcenter;
            }
        });
    }
    modal.searchGLList = function() {
        var options = {
            data: 'menu',
            animation: true,
            templateUrl: BILLINGURL + "oc_labnotin/gl_list.html?v=" + VERSION,
            controllerName: "GLAccountListCtrl",
            viewSize: "lg",
            filesToLoad: [
                BILLINGURL + "oc_labnotin/gl_list.html?v=" + VERSION,
                BILLINGURL + "oc_labnotin/controller.js?v=" + VERSION
            ]
        };
        AppSvc.modal(options).then(function(data) {
            if (data) {
                modal.variables.gl = data.gl;
            }
        });
    }
    modal.compute = function() {
        var hrs = modal.variables.hrs ? parseFloat(AppSvc.getAmount(modal.variables.hrs)) : 0;
        var rate_hr = modal.variables.rate_hr ? parseFloat(AppSvc.getAmount(modal.variables.rate_hr)) : 0;

        var amount_billed = hrs * rate_hr;
        modal.variables.amount_billed = filter("number")(amount_billed, 2);
    }
    modal.save = function() {
        LOADING.classList.add("open");
        modal.variables.detail = true;
        var data = angular.copy(modal.variables);
        data.hrs = modal.variables.hrs ? parseFloat(AppSvc.getAmount(modal.variables.hrs.toString())) : 0;
        data.rate_hr = modal.variables.rate_hr ? parseFloat(AppSvc.getAmount(modal.variables.rate_hr.toString())) : 0;
        data.amount_billed = modal.variables.amount_billed ? parseFloat(AppSvc.getAmount(modal.variables.amount_billed.toString())) : 0;
        data.date = AppSvc.getDate(modal.variables.date);
        OCLABNOTINSvc.save(data).then(function(response) {
            if (response.success) {
                if (response.id) {
                    modal.variables.TOCLDTL = response.id;
                    data.TOCLDTL = response.id;
                }
                $uibModalInstance.close(data);
                AppSvc.showSwal('Success', response.message, 'success');
            } else {
                AppSvc.showSwal('Confirmation', response.message, 'warning');
            }
            LOADING.classList.remove("open");
        })
    }
    modal.delete = function() {
        if (!modal.variables.TOCLDTL) {
            return AppSvc.showSwal("Requirement", "Please select detail to delete.", "warning");
        }
        OCLABNOTINDTLSvc.delete(modal.variables.TOCLDTL).then(function(response) {
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

function GLAccountListCtrl($scope, $ocLazyLoad, $injector, data, $uibModalInstance) {
    var modal = this;
    modal.data = [];
    modal.list = [];
    var filter = $injector.get('$filter');
    $ocLazyLoad.load([
        BILLINGURL + 'oc_labnotin/service.js?v=' + VERSION,
    ]).then(function(d) {
        OCLABNOTINSvc = $injector.get('OCLABNOTINSvc');
        modal.getData();
    });

    modal.getData = function() {
        LOADING.classList.add("open");
        OCLABNOTINSvc.get({ getGLList: true }).then(function(response) {
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
            { name: "GL Account", field: "gl" }
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
        modal.list = filter('filter')(modal.data, { gl: modal.search });
    }

    modal.close = function() {
        $uibModalInstance.dismiss('cancel');
    }
}

function CostCenterListCtrl($scope, $ocLazyLoad, $injector, data, $uibModalInstance) {
    var modal = this;
    modal.data = [];
    modal.list = [];
    var filter = $injector.get('$filter');
    $ocLazyLoad.load([
        BILLINGURL + 'oc_labnotin/service.js?v=' + VERSION,
    ]).then(function(d) {
        OCLABNOTINSvc = $injector.get('OCLABNOTINSvc');
        modal.getData();
    });

    modal.getData = function() {
        LOADING.classList.add("open");
        OCLABNOTINSvc.get({ getCCList: true }).then(function(response) {
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
            { name: "Cost Center", field: "costcenter" }
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
        modal.list = filter('filter')(modal.data, { costcenter: modal.search });
    }

    modal.close = function() {
        $uibModalInstance.dismiss('cancel');
    }
}

function OCLABNOTINPrintPreviewCtrl($scope, $ocLazyLoad, $injector, data, $uibModalInstance) {
    var modal = this;
    modal.variables = {};
    if (data) {
        modal.variables.TOCLHDR = data.id;
        modal.variables.period_date = data.period_date;
    }
    $ocLazyLoad.load([
        BILLINGURL + 'oc_labnotin/service.js?v=' + VERSION,
    ]).then(function(d) {
        OCLABNOTINSvc = $injector.get('OCLABNOTINSvc');
        modal.getData();
    });

    modal.getData = function() {
        LOADING.classList.add("open");
        OCLABNOTINSvc.get({ getReportPreviewData: true, id: modal.variables.TOCLHDR }).then(function(response) {
            if (!response.message) {
                modal.variables = response[0];
                if (modal.variables.letter_to == '') {
                    modal.variables.letter_to = "<b>Charlotte S. Carpentero</b><br>Mindanao Accounting Services Manager<br>Del Monte Philippines, Inc.,";
                }
                if (modal.variables.Payment_for == '') {
                    modal.variables.Payment_for = "<u><b>CAMP ADMINISTRATION</b></u>";
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
        OCLABNOTINSvc.save(modal.variables).then(function(response) {
            if (response.success) {
                window.open('api/oc_labnotin?generateReport=true&id=' + modal.variables.TOCLHDR);
            } else {
                AppSvc.showSwal("Oops", "No Data Found.", "warning");
            }
            LOADING.classList.remove("open");
        })
    }

    modal.printPreviewTransmittal = function() {
        var options = {
            data: { id: modal.variables.TOCLHDR, period_date: modal.variables.period_date },
            animation: true,
            templateUrl: BILLINGURL + "oc_labnotin/print_preview_transmittal.html?v=" + VERSION,
            controllerName: "OCLABNOTINPrintPreviewTransmittalCtrl",
            viewSize: "md",
            filesToLoad: [
                BILLINGURL + "oc_labnotin/print_preview_transmittal.html?v=" + VERSION,
                BILLINGURL + "oc_labnotin/controller.js?v=" + VERSION
            ]
        };
        AppSvc.modal(options);
    }

    modal.close = function() {
        $uibModalInstance.dismiss('cancel');
    }
}

function OCLABNOTINPrintPreviewTransmittalCtrl($scope, $ocLazyLoad, $injector, data, $uibModalInstance) {
    var modal = this;
    modal.variables = {};
    if (data) {
        modal.variables.TOCLHDR = data.id;
        modal.variables.period_date = data.period_date;
    }

    $ocLazyLoad.load([
        BILLINGURL + 'oc_labnotin/service.js?v=' + VERSION,
    ]).then(function(d) {
        OCLABNOTINSvc = $injector.get('OCLABNOTINSvc');
        modal.getData();
    });

    modal.getData = function() {
        LOADING.classList.add("open");
        OCLABNOTINSvc.get({ getTransmittalNo: true, id: modal.variables.TOCLHDR }).then(function(response) {
            if (!response.message) {
                modal.variables.transmittal_no = response[0].transmittal_no;
                modal.variables.date_transmitted = response[0].date_transmitted != '0000-00-00' ? new Date(response[0].date_transmitted) : '';
                modal.variables.document_date = response[0].Date != '0000-00-00' ? new Date(response[0].Date) : '';
            } else {
                $uibModalInstance.dismiss();
            }
            LOADING.classList.remove("open");
        });
    }

    modal.generate = function() {
        var save_data = angular.copy(modal.variables);
        save_data.date_transmitted = AppSvc.getDate(modal.variables.date_transmitted);
        save_data.Date = AppSvc.getDate(modal.variables.document_date);
        save_data.saveReport = true;
        OCLABNOTINSvc.save(save_data).then(function(response) {
            if (response.success) {
                window.open('report/labnotin_transmittal?id=' + modal.variables.TOCLHDR +
                    '&period_date=' + modal.variables.period_date +
                    '&transmittal_no=' + modal.variables.transmittal_no +
                    '&date_transmitted=' + AppSvc.getDate(modal.variables.date_transmitted) +
                    '&document_date=' + AppSvc.getDate(modal.variables.document_date) +
                    '&Prepared_by=' + modal.variables.Prepared_by +
                    '&Prepared_by_desig=' + modal.variables.Prepared_by_desig +
                    '&Checked_by=' + modal.variables.Checked_by +
                    '&Checked_by_desig=' + modal.variables.Checked_by_desig +
                    '&Received_by=' + modal.variables.Received_by +
                    '&Received_by_desig=' + modal.variables.Received_by_desig +
                    '&Approved_by=' + modal.variables.Approved_by +
                    '&Approved_by_desig=' + modal.variables.Approved_by_desig +
                    '&Approved_by_2=' + modal.variables.Approved_by_2 +
                    '&Approved_by_2_desig=' + modal.variables.Approved_by_2_desig
                );
            }
        })
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
                    modal.variables.Prepared_by = data.fullname;
                    modal.variables.Prepared_by_desig = data.position;
                } else if (number == 2) {
                    modal.variables.Checked_by = data.fullname;
                    modal.variables.Checked_by_desig = data.position;
                } else if (number == 3) {
                    modal.variables.Received_by = data.fullname;
                    modal.variables.Received_by_desig = data.position;
                } else if (number == 4) {
                    modal.variables.Approved_by = data.fullname;
                    modal.variables.Approved_by_desig = data.position;
                } else if (number == 5) {
                    modal.variables.Approved_by_2 = data.fullname;
                    modal.variables.Approved_by_2_desig = data.position;
                }
            }
        })
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
        BILLINGURL + 'oc_labnotin/service.js?v=' + VERSION,
    ]).then(function(d) {
        OCLABNOTINSvc = $injector.get('OCLABNOTINSvc');
        modal.getData();
    });

    modal.getData = function (){
        OCLABNOTINSvc.get({ getHeaderID: modal.variables.id }).then(function(response) {
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
                OCLABNOTINSvc.save(data).then(function(response) {
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