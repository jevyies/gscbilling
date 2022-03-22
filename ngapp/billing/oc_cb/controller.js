angular.module('app')
    .controller('OCCBCTRL', OCCBCTRL)
    .controller('OCCBHDRCTRL', OCCBHDRCTRL)
    .controller('OCCBSearchHdrCtrl', OCCBSearchHdrCtrl)
    .controller('OCCBDtlCtrl', OCCBDtlCtrl)
    .controller('OCCBPrintPreviewCtrl', OCCBPrintPreviewCtrl)
    .controller('TransmitBillingCtrl', TransmitBillingCtrl)

OCCBCTRL.$inject = ['$scope', '$ocLazyLoad', '$injector'];
OCCBHDRCTRL.$inject = ['$scope', '$ocLazyLoad', '$injector', 'data', '$uibModalInstance'];
OCCBSearchHdrCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector', 'data', '$uibModalInstance'];
OCCBDtlCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector', 'data', '$uibModalInstance'];
OCCBPrintPreviewCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector', 'data', '$uibModalInstance'];
TransmitBillingCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector', 'data', '$uibModalInstance'];

function OCCBCTRL($scope, $ocLazyLoad, $injector) {
    var vm = this;
    vm.header = {};
    vm.data = [];
    vm.list = [];
    vm.dataRates = [];
    vm.listRates = [];
    var filter = $injector.get("$filter");
    $ocLazyLoad.load([
        BILLINGURL + 'oc_cb/service.js?v=' + VERSION,
    ]).then(function(d) {
        OCCBSvc = $injector.get('OCCBSvc');
    });

    vm.newHeader = function(pass_value) {
        if (pass_value == 'new') {
            data = pass_value;
        } else {
            if (!vm.header.TOCSHDR) {
                return AppSvc.showSwal("Requirement", "Please select header to update.", "warning");
            }
            data = angular.copy(vm.header);
        }
        var options = {
            data: data,
            animation: true,
            templateUrl: BILLINGURL + "oc_cb/new_header.html?v=" + VERSION,
            controllerName: "OCCBHDRCTRL",
            viewSize: "lg",
            filesToLoad: [
                BILLINGURL + "oc_cb/new_header.html?v=" + VERSION,
                BILLINGURL + "oc_cb/controller.js?v=" + VERSION
            ]
        };
        AppSvc.modal(options).then(function(data) {
            if (data) {
                if (pass_value == 'new') {
                    vm.clear();
                }
                vm.header = angular.copy(data);
                vm.getTotalBilling(vm.header.TOCSHDR);
                vm.getRatesSelected(vm.header.TOCSHDR);
            }
        });
    }

    vm.getTotalBilling = function(hdr_id) {
        LOADING.classList.add("open");
        OCCBSvc.get({ getTotalBilling: true, hdr_id: hdr_id }).then(function(response) {
            if (!response.message) {
                var TotalBilling = response[0].TotalBilling;
                vm.header.TotalGross = filter("number")(TotalBilling, 2);
                vm.header.TotalAdminfee = filter("number")(TotalBilling * (vm.header.admin_percentage / 100), 2);
                vm.header.TotalBilling = filter("number")(parseFloat(TotalBilling) + parseFloat(vm.header.TotalAdminfee), 2);
            } else {
                vm.header.TotalBilling = 0;
            }
            LOADING.classList.remove("open");
        })
    }

    vm.getRatesSelected = function(hdr_id) {
        if (hdr_id) {
            LOADING.classList.add("open");
            OCCBSvc.get({ getRatesSelected: true, hdr_id: hdr_id }).then(function(response) {
                console.log(response);
                if (response.message) {
                    vm.dataRates = [];
                } else {
                    vm.dataRates = response;
                }
                vm.listRates = vm.dataRates;
                LOADING.classList.remove("open");
            })
        }
    }

    vm.searchHeader = function() {
        var options = {
            data: 'menu',
            animation: true,
            templateUrl: BILLINGURL + "oc_cb/search_header.html?v=" + VERSION,
            controllerName: "OCCBSearchHdrCtrl",
            viewSize: "lg",
            filesToLoad: [
                BILLINGURL + "oc_cb/search_header.html?v=" + VERSION,
                BILLINGURL + "oc_cb/controller.js?v=" + VERSION
            ]
        };
        AppSvc.modal(options).then(function(data) {
            if (data) {
                vm.header = angular.copy(data);
                vm.searchDtl(vm.header.TOCSHDR);
                vm.getTotalBilling(vm.header.TOCSHDR);
                vm.getRatesSelected(vm.header.TOCSHDR);
            }
        });
    }

    vm.searchDtl = function(hdr_id) {
        if (!hdr_id) {
            return AppSvc.showSwal("Requirement", "Please select header to continue.", "warning");
        }
        LOADING.classList.add("open");
        OCCBSvc.get({ getDtl: true, hdr_id: hdr_id }).then(function(response) {
            console.log(response);
            if (response.message) {
                vm.data = [];
            } else {
                vm.data = response;
            }
            vm.list = vm.data;
            LOADING.classList.remove("open");
        })
    }

    vm.addEmployee = function(row) {
        if (!vm.header.TOCSHDR) {
            return AppSvc.showSwal("Requirement", "Please select header to continue.", "warning");
        }
        if (vm.header.Status == 'TRANSMITTED') {
            return AppSvc.showSwal("Warning", "Header was already transmitted. Cannot update.", "warning");
        }
        var data = 'menu';
        if (row) {
            row.index = vm.data.indexOf(row);
            data = angular.copy(row);
        }
        var options = {
            data: { variables: data, hdr_id: vm.header.TOCSHDR },
            animation: true,
            templateUrl: BILLINGURL + "oc_cb/add_employee.html?v=" + VERSION,
            controllerName: "OCCBDtlCtrl",
            viewSize: "lg",
            filesToLoad: [
                BILLINGURL + "oc_cb/add_employee.html?v=" + VERSION,
                BILLINGURL + "oc_cb/controller.js?v=" + VERSION
            ]
        };
        AppSvc.modal(options).then(function(data) {
            if (data) {
                if (row) {
                    if (data == 'deleted') {
                        vm.data.splice(row.index, 1);
                    } else {
                        var filtered_data = angular.copy(data);
                        filtered_data.total = data.total.replace(/,/g, '');
                        filtered_data.total_st = data.total_st.replace(/,/g, '');
                        filtered_data.total_ot = data.total_ot.replace(/,/g, '');
                        filtered_data.total_nd = data.total_nd.replace(/,/g, '');
                        filtered_data.total_ndot = data.total_ndot.replace(/,/g, '');
                        vm.data.splice(row.index, 1, filtered_data);
                    }
                } else {
                    var filtered_data = angular.copy(data);
                    filtered_data.total = data.total.replace(/,/g, '');
                    filtered_data.total_st = data.total_st.replace(/,/g, '');
                    filtered_data.total_ot = data.total_ot.replace(/,/g, '');
                    filtered_data.total_nd = data.total_nd.replace(/,/g, '');
                    filtered_data.total_ndot = data.total_ndot.replace(/,/g, '');
                    vm.data.push(filtered_data);
                }
                vm.list = vm.data;
                vm.getTotalBilling(vm.header.TOCSHDR);
                vm.getRatesSelected(vm.header.TOCSHDR);
            }
        });
    }

    vm.delete = function() {
        if (!vm.header.TOCSHDR) {
            return AppSvc.showSwal("Requirement", "Please select header to delete.", "warning");
        }
        OCCBSvc.delete(vm.header.TOCSHDR).then(function(response) {
            if (response.success) {
                vm.clear();
                LOADING.classList.remove("open");
                return AppSvc.showSwal('Success', response.message, 'success');
            } else {
                return AppSvc.showSwal('Error', 'Something went wrong', 'error');
            }
        })
    }

    vm.transmit = function() {
        if (!vm.header.TOCSHDR) {
            return AppSvc.showSwal("Requirement", "Please select header to continue.", "warning");
        }
        var options = {
            data: { id: vm.header.TOCSHDR },
            animation: true,
            templateUrl: BILLINGURL + "oc_cb/transmit_billing.html?v=" + VERSION,
            controllerName: "TransmitBillingCtrl",
            viewSize: "md",
            filesToLoad: [
                BILLINGURL + "oc_cb/transmit_billing.html?v=" + VERSION,
                BILLINGURL + "oc_cb/controller.js?v=" + VERSION
            ]
        };
        AppSvc.modal(options).then(function(data){
            if(data){
                vm.header.Status = data;
            }
        });
    }

    vm.reactivate = function() {
        if (!vm.header.TOCSHDR) {
            return AppSvc.showSwal("Requirement", "Please select header to continue.", "warning");
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
                                OCCBSvc.save({ id: vm.header.TOCSHDR, reactivation: true, reactivatedBy: reactivated_by, reasonofreactivation: reason }).then(function(response) {
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
        if (!vm.header.TOCSHDR) {
            return AppSvc.showSwal("Requirement", "Please select Header to continue.", "warning");
        }
        var options = {
            data: { id: vm.header.TOCSHDR, period_date: vm.header.period_date },
            animation: true,
            templateUrl: BILLINGURL + "oc_cb/print_preview.html?v=" + VERSION,
            controllerName: "OCCBPrintPreviewCtrl",
            viewSize: "lg",
            filesToLoad: [
                BILLINGURL + "oc_cb/print_preview.html?v=" + VERSION,
                BILLINGURL + "oc_cb/controller.js?v=" + VERSION
            ]
        };
        AppSvc.modal(options);
    }

    vm.clear = function() {
        vm.header = {};
        vm.data = [];
        vm.list = [];
        vm.dataRates = [];
        vm.listRates = [];
    }
}

function OCCBHDRCTRL($scope, $ocLazyLoad, $injector, data, $uibModalInstance) {
    var modal = this;
    modal.variables = {};
    modal.variables.admin_percentage = 0;
    if (data != 'new') {
        modal.variables = angular.copy(data);
    }
    $ocLazyLoad.load([
        BILLINGURL + 'oc_cb/service.js?v=' + VERSION,
    ]).then(function(d) {
        OCCBSvc = $injector.get('OCCBSvc');
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
                console.log(data);
                modal.variables.period = data.xPeriod.toString() + data.xPhase.toString();
                modal.variables.period_date = data.period_date;
            }
        });
    }
    modal.save = function() {
        LOADING.classList.add("open");
        modal.variables.save_header = true;
        OCCBSvc.save(modal.variables).then(function(response) {
            if (response.success) {
                if (response.id) {
                    modal.variables.Status = 'ACTIVE';
                    modal.variables.TOCSHDR = response.id;
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

function OCCBSearchHdrCtrl($scope, $ocLazyLoad, $injector, data, $uibModalInstance) {
    var modal = this;
    modal.data = [];
    modal.list = [];
    var filter = $injector.get('$filter');
    $ocLazyLoad.load([
        BILLINGURL + 'oc_cb/service.js?v=' + VERSION,
    ]).then(function(d) {
        OCCBSvc = $injector.get('OCCBSvc');
        modal.getData();
    });

    modal.getData = function() {
        LOADING.classList.add("open");
        OCCBSvc.get({ getHeader: true }).then(function(response) {
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

function OCCBDtlCtrl($scope, $ocLazyLoad, $injector, data, $uibModalInstance) {
    var modal = this;
    var filter = $injector.get("$filter");
    modal.variables = {};
    modal.rates = {};
    modal.variables.hdr_id = data.hdr_id;
    if (data.variables.TOSDTL) {
        modal.variables = angular.copy(data.variables);
        LOADING.classList.add("open");
        OCCBSvc.get({ getRates: true, activity_id: modal.variables.activity_id }).then(function(response) {
            if (!response.message) {
                modal.rates = angular.copy(response[0]);
            } else {
                modal.rates = {};
            }
            modal.compute();
            LOADING.classList.remove("open");
        })
    }
    $ocLazyLoad.load([
        BILLINGURL + 'oc_cb/service.js?v=' + VERSION,
    ]).then(function(d) {
        OCCBSvc = $injector.get('OCCBSvc');
        OCCBDtlSvc = $injector.get('OCCBDtlSvc');
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
    modal.searchActivity = function(client) {
        var options = {
            data: client,
            animation: true,
            templateUrl: SETTINGSURL + "activity_master_oc/activity_modal.html?v=" + VERSION,
            controllerName: "ActivityViewOCCtrl",
            viewSize: "md",
            filesToLoad: [
                SETTINGSURL + "activity_master_oc/activity_modal.html?v=" + VERSION,
                SETTINGSURL + "activity_master_oc/controller.js?v=" + VERSION
            ]
        };
        AppSvc.modal(options).then(function(data) {
            if (data) {
                LOADING.classList.add("open");
                modal.variables.Activity = data.activity;
                OCCBSvc.get({ getRates: true, activity_id: data.id }).then(function(response) {
                    if (!response.message) {
                        modal.variables.activity_id = response[0].id;
                        modal.rates = angular.copy(response[0]);
                    } else {
                        modal.rates = {};
                    }
                    modal.compute();
                    LOADING.classList.remove("open");
                })
            }
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
        var rhol_st2x = modal.variables.rhol_st2x ? parseFloat(AppSvc.getAmount(modal.variables.rhol_st2x)) : 0;
        var rhol_ot2x = modal.variables.rhol_ot2x ? parseFloat(AppSvc.getAmount(modal.variables.rhol_ot2x)) : 0;
        var rhol_nd2x = modal.variables.rhol_nd2x ? parseFloat(AppSvc.getAmount(modal.variables.rhol_nd2x)) : 0;
        var rhol_ndot2x = modal.variables.rhol_ndot2x ? parseFloat(AppSvc.getAmount(modal.variables.rhol_ndot2x)) : 0;
        var rholrd_st2x = modal.variables.rholrd_st2x ? parseFloat(AppSvc.getAmount(modal.variables.rholrd_st2x)) : 0;
        var rholrd_ot2x = modal.variables.rholrd_ot2x ? parseFloat(AppSvc.getAmount(modal.variables.rholrd_ot2x)) : 0;
        var rholrd_nd2x = modal.variables.rholrd_nd2x ? parseFloat(AppSvc.getAmount(modal.variables.rholrd_nd2x)) : 0;
        var rholrd_ndot2x = modal.variables.rholrd_ndot2x ? parseFloat(AppSvc.getAmount(modal.variables.rholrd_ndot2x)) : 0;

        var total = (rd_st * parseFloat(modal.rates.rd_st)) + (rd_ot * parseFloat(modal.rates.rd_ot)) + (rd_nd * parseFloat(modal.rates.rd_nd)) +
            (rd_ndot * parseFloat(modal.rates.rd_ndot)) + (shol_st * parseFloat(modal.rates.shol_st)) + (shol_ot * parseFloat(modal.rates.shol_ot)) +
            (shol_nd * parseFloat(modal.rates.shol_nd)) + (shol_ndot * parseFloat(modal.rates.shol_ndot)) + (rhol_st * parseFloat(modal.rates.rhol_st)) +
            (rhol_ot * parseFloat(modal.rates.rhol_ot)) + (rhol_nd * parseFloat(modal.rates.rhol_nd)) + (rhol_ndot * parseFloat(modal.rates.rhol_ndot)) +
            (shrd_st * parseFloat(modal.rates.shrd_st)) + (shrd_ot * parseFloat(modal.rates.shrd_ot)) + (shrd_nd * parseFloat(modal.rates.shrd_nd)) +
            (shrd_ndot * parseFloat(modal.rates.shrd_ndot)) + (rhrd_st * parseFloat(modal.rates.rhrd_st)) + (rhrd_ot * parseFloat(modal.rates.rhrd_ot)) +
            (rhrd_nd * parseFloat(modal.rates.rhrd_nd)) + (rhrd_ndot * parseFloat(modal.rates.rhrd_ndot)) + (rhol_st2x * parseFloat(modal.rates.rhol_st2x)) +
            (rhol_ot2x * parseFloat(modal.rates.rhol_ot2x)) + (rhol_nd2x * parseFloat(modal.rates.rhol_nd2x)) + (rhol_ndot2x * parseFloat(modal.rates.rhol_ndot2x)) +
            (rholrd_st2x * parseFloat(modal.rates.rholrd_st2x)) + (rholrd_ot2x * parseFloat(modal.rates.rholrd_ot2x)) + (rholrd_nd2x * parseFloat(modal.rates.rholrd_nd2x)) +
            (rholrd_ndot2x * parseFloat(modal.rates.rholrd_ndot2x));
        var total_st = (rd_st * parseFloat(modal.rates.rd_st)) + (shol_st * parseFloat(modal.rates.shol_st)) + (rhol_st * parseFloat(modal.rates.rhol_st)) + (shrd_st * parseFloat(modal.rates.shrd_st)) + (rhrd_st * parseFloat(modal.rates.rhrd_st)) + (rhol_st2x * parseFloat(modal.rates.rhol_st2x)) + (rholrd_st2x * parseFloat(modal.rates.rholrd_st2x));
        var total_ot = (rd_ot * parseFloat(modal.rates.rd_ot)) + (shol_ot * parseFloat(modal.rates.shol_ot)) + (rhol_ot * parseFloat(modal.rates.rhol_ot)) + (shrd_ot * parseFloat(modal.rates.shrd_ot)) + (rhrd_ot * parseFloat(modal.rates.rhrd_ot)) + (rhol_ot2x * parseFloat(modal.rates.rhol_ot2x)) + (rholrd_ot2x * parseFloat(modal.rates.rholrd_ot2x));
        var total_nd = (rd_nd * parseFloat(modal.rates.rd_nd)) + (shol_nd * parseFloat(modal.rates.shol_nd)) + (rhol_nd * parseFloat(modal.rates.rhol_nd)) + (shrd_nd * parseFloat(modal.rates.shrd_nd)) + (rhrd_nd * parseFloat(modal.rates.rhrd_nd)) + (rhol_nd2x * parseFloat(modal.rates.rhol_nd2x)) + (rholrd_nd2x * parseFloat(modal.rates.rholrd_nd2x));
        var total_ndot = (rd_ndot * parseFloat(modal.rates.rd_ndot)) + (shol_ndot * parseFloat(modal.rates.shol_ndot)) + (rhol_ndot * parseFloat(modal.rates.rhol_ndot)) + (shrd_ndot * parseFloat(modal.rates.shrd_ndot)) + (rhrd_ndot * parseFloat(modal.rates.rhrd_ndot)) + (rhol_ndot2x * parseFloat(modal.rates.rhol_ndot2x)) + (rholrd_ndot2x * parseFloat(modal.rates.rholrd_ndot2x));
        modal.variables.total_st = filter("number")(total_st, 2);
        modal.variables.total_ot = filter("number")(total_ot, 2);
        modal.variables.total_nd = filter("number")(total_nd, 2);
        modal.variables.total_ndot = filter("number")(total_ndot, 2);
        modal.variables.total = filter("number")(total, 2);
    }
    modal.save = function() {
        // if (!modal.variables.Chapa) {
        //     return AppSvc.showSwal('Ooops', 'Select Employee first', 'warning');
        // }
        if (!modal.rates.activity_fr_mg) {
            return AppSvc.showSwal('Ooops', 'Cannot save, no rates found.', 'warning');
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
        data.rhol_st2x = modal.variables.rhol_st2x ? parseFloat(AppSvc.getAmount(modal.variables.rhol_st2x)) : 0;
        data.rhol_ot2x = modal.variables.rhol_ot2x ? parseFloat(AppSvc.getAmount(modal.variables.rhol_ot2x)) : 0;
        data.rhol_nd2x = modal.variables.rhol_nd2x ? parseFloat(AppSvc.getAmount(modal.variables.rhol_nd2x)) : 0;
        data.rhol_ndot2x = modal.variables.rhol_ndot2x ? parseFloat(AppSvc.getAmount(modal.variables.rhol_ndot2x)) : 0;
        data.rholrd_st2x = modal.variables.rholrd_st2x ? parseFloat(AppSvc.getAmount(modal.variables.rholrd_st2x)) : 0;
        data.rholrd_ot2x = modal.variables.rholrd_ot2x ? parseFloat(AppSvc.getAmount(modal.variables.rholrd_ot2x)) : 0;
        data.rholrd_nd2x = modal.variables.rholrd_nd2x ? parseFloat(AppSvc.getAmount(modal.variables.rholrd_nd2x)) : 0;
        data.rholrd_ndot2x = modal.variables.rholrd_ndot2x ? parseFloat(AppSvc.getAmount(modal.variables.rholrd_ndot2x)) : 0;
        data.total_st = modal.variables.total_st ? parseFloat(AppSvc.getAmount(modal.variables.total_st)) : 0;
        data.total_ot = modal.variables.total_ot ? parseFloat(AppSvc.getAmount(modal.variables.total_ot)) : 0;
        data.total_nd = modal.variables.total_nd ? parseFloat(AppSvc.getAmount(modal.variables.total_nd)) : 0;
        data.total_ndot = modal.variables.total_ndot ? parseFloat(AppSvc.getAmount(modal.variables.total_ndot)) : 0;
        data.total = modal.variables.total ? parseFloat(AppSvc.getAmount(modal.variables.total)) : 0;

        // other data
        data.Location = modal.rates.location_fr_mg;
        data.GL = modal.rates.gl_fr_mg;
        data.CC = modal.rates.costcenter__;
        OCCBSvc.save(data).then(function(response) {
            if (response.success) {
                if (response.id) {
                    modal.variables.TOSDTL = response.id;
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
        if (!modal.variables.TOSDTL) {
            return AppSvc.showSwal("Requirement", "Please select detail to delete.", "warning");
        }
        OCCBDtlSvc.delete(modal.variables.TOSDTL).then(function(response) {
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

function OCCBPrintPreviewCtrl($scope, $ocLazyLoad, $injector, data, $uibModalInstance) {
    var modal = this;
    modal.variables = {};
    if (data) {
        modal.variables.TOCSHDR = data.id;
        modal.variables.period_date = data.period_date;
    }
    $ocLazyLoad.load([
        BILLINGURL + 'oc_cb/service.js?v=' + VERSION,
    ]).then(function(d) {
        OCCBSvc = $injector.get('OCCBSvc');
        modal.getData();
    });

    modal.getData = function() {
        LOADING.classList.add("open");
        OCCBSvc.get({ getReportPreviewData: true, id: modal.variables.TOCSHDR }).then(function(response) {
            if (!response.message) {
                modal.variables = response[0];
            } else {
                $uibModalInstance.dismiss();
            }
            LOADING.classList.remove("open");
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
                modal.variables.Confirmed_by = data.fullname;
                modal.variables.Confirmed_by_desig = data.position;
            }
        })
    }

    modal.generate = function() {
        LOADING.classList.add("open");
        modal.variables.printPreview = true;
        OCCBSvc.save(modal.variables).then(function(response) {
            if (response.success) {
                window.open('api/oc_cb?generateReport=true&id=' + modal.variables.TOCSHDR);
                window.open('api/oc_cb?generateReportDetails=true&id=' + modal.variables.TOCSHDR);
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
function TransmitBillingCtrl($scope, $ocLazyLoad, $injector, data, $uibModalInstance) {
    var modal = this;
    modal.variables = {};
    modal.variables.id = data.id;
    modal.variables.date_transmitted = new Date();

    $ocLazyLoad.load([
        BILLINGURL + 'oc_cb/service.js?v=' + VERSION,
    ]).then(function(d) {
        OCCBSvc = $injector.get('OCCBSvc');
        modal.getData();
    });

    modal.getData = function (){
        OCCBSvc.get({ getHeaderID: modal.variables.id }).then(function(response) {
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
                OCCBSvc.save(data).then(function(response) {
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