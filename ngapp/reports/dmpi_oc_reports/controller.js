
angular.module('app')
    .controller('DMPIOCCtrl', DMPIOCCtrl)
    .controller('BillingTransmittalCtrl', BillingTransmittalCtrl)
    .controller('ReactivatedSOACtrl', ReactivatedSOACtrl)
    .controller('BandCCtrl', BandCCtrl)
    .controller('SOAStatusCtrl', SOAStatusCtrl)
    .controller('AgingReportCtrl', AgingReportCtrl)
    .controller('YearToDateCtrl', YearToDateCtrl)
    .controller('PerClientCtrl', PerClientCtrl)
    .controller('AnnualReportCtrl', AnnualReportCtrl)
    .controller('WeeklyReportCtrl', WeeklyReportCtrl)
    .controller('MonthlyReportCtrl', MonthlyReportCtrl)
    .controller('AccrualReportCtrl', AccrualReportCtrl)
    .controller('OCLedgerReportCtrl', OCLedgerReportCtrl)

DMPIOCCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector'];
BillingTransmittalCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector', 'data', '$uibModalInstance'];
ReactivatedSOACtrl.$inject = ['$scope', '$ocLazyLoad', '$injector', 'data', '$uibModalInstance'];
BandCCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector', 'data', '$uibModalInstance'];
SOAStatusCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector', 'data', '$uibModalInstance'];
AgingReportCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector', 'data', '$uibModalInstance'];
YearToDateCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector', 'data', '$uibModalInstance'];
PerClientCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector', 'data', '$uibModalInstance'];
AnnualReportCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector', 'data', '$uibModalInstance'];
WeeklyReportCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector', 'data', '$uibModalInstance'];
MonthlyReportCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector', 'data', '$uibModalInstance'];
AccrualReportCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector', 'data', '$uibModalInstance'];
OCLedgerReportCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector', 'data', '$uibModalInstance'];

function DMPIOCCtrl($scope, $ocLazyLoad, $injector) {
    var vm = this;
    vm.billingTransmittal = function () {
        var options = {
            data: 'menu',
            animation: true,
            templateUrl: REPURL + "dmpi_oc_reports/billing_transmittal.html?v=" + VERSION,
            controllerName: "BillingTransmittalCtrl",
            viewSize: "md",
            filesToLoad: [
                REPURL + "dmpi_oc_reports/billing_transmittal.html?v=" + VERSION,
                REPURL + "dmpi_oc_reports/controller.js?v=" + VERSION
            ]
        };
        AppSvc.modal(options);
    }
    vm.reactivatedSOA = function () {
        var options = {
            data: 'menu',
            animation: true,
            templateUrl: REPURL + "dmpi_oc_reports/reactivated_soa.html?v=" + VERSION,
            controllerName: "ReactivatedSOACtrl",
            viewSize: "md",
            filesToLoad: [
                REPURL + "dmpi_oc_reports/reactivated_soa.html?v=" + VERSION,
                REPURL + "dmpi_oc_reports/controller.js?v=" + VERSION
            ]
        };
        AppSvc.modal(options);
    }
    vm.bandCReport = function () {
        var options = {
            data: 'menu',
            animation: true,
            templateUrl: REPURL + "dmpi_oc_reports/b_and_c_report.html?v=" + VERSION,
            controllerName: "BandCCtrl",
            viewSize: "md",
            filesToLoad: [
                REPURL + "dmpi_oc_reports/b_and_c_report.html?v=" + VERSION,
                REPURL + "dmpi_oc_reports/controller.js?v=" + VERSION
            ]
        };
        AppSvc.modal(options);
    }
    vm.soaStatus = function () {
        var options = {
            data: 'menu',
            animation: true,
            templateUrl: REPURL + "dmpi_oc_reports/soa_status.html?v=" + VERSION,
            controllerName: "SOAStatusCtrl",
            viewSize: "md",
            filesToLoad: [
                REPURL + "dmpi_oc_reports/soa_status.html?v=" + VERSION,
                REPURL + "dmpi_oc_reports/controller.js?v=" + VERSION
            ]
        };
        AppSvc.modal(options);
    }
    vm.agingReport = function () {
        var options = {
            data: 'menu',
            animation: true,
            templateUrl: REPURL + "dmpi_oc_reports/aging_report.html?v=" + VERSION,
            controllerName: "AgingReportCtrl",
            viewSize: "md",
            filesToLoad: [
                REPURL + "dmpi_oc_reports/aging_report.html?v=" + VERSION,
                REPURL + "dmpi_oc_reports/controller.js?v=" + VERSION
            ]
        };
        AppSvc.modal(options);
    }
    vm.yearToDate = function () {
        var options = {
            data: 'menu',
            animation: true,
            templateUrl: REPURL + "dmpi_oc_reports/year_to_date.html?v=" + VERSION,
            controllerName: "YearToDateCtrl",
            viewSize: "md",
            filesToLoad: [
                REPURL + "dmpi_oc_reports/year_to_date.html?v=" + VERSION,
                REPURL + "dmpi_oc_reports/controller.js?v=" + VERSION
            ]
        };
        AppSvc.modal(options);
    }
    vm.perClientReport = function () {
        var options = {
            data: 'menu',
            animation: true,
            templateUrl: REPURL + "dmpi_oc_reports/per_client_report.html?v=" + VERSION,
            controllerName: "PerClientCtrl",
            viewSize: "md",
            filesToLoad: [
                REPURL + "dmpi_oc_reports/per_client_report.html?v=" + VERSION,
                REPURL + "dmpi_oc_reports/controller.js?v=" + VERSION
            ]
        };
        AppSvc.modal(options);
    }
    vm.annualReport = function () {
        var options = {
            data: 'menu',
            animation: true,
            templateUrl: REPURL + "dmpi_oc_reports/annual_report.html?v=" + VERSION,
            controllerName: "AnnualReportCtrl",
            viewSize: "md",
            filesToLoad: [
                REPURL + "dmpi_oc_reports/annual_report.html?v=" + VERSION,
                REPURL + "dmpi_oc_reports/controller.js?v=" + VERSION
            ]
        };
        AppSvc.modal(options);
    }
    vm.weeklyReport = function () {
        var options = {
            data: 'menu',
            animation: true,
            templateUrl: REPURL + "dmpi_oc_reports/weekly_report.html?v=" + VERSION,
            controllerName: "WeeklyReportCtrl",
            viewSize: "md",
            filesToLoad: [
                REPURL + "dmpi_oc_reports/weekly_report.html?v=" + VERSION,
                REPURL + "dmpi_oc_reports/controller.js?v=" + VERSION
            ]
        };
        AppSvc.modal(options);
    }
    vm.monthlyReport = function () {
        var options = {
            data: 'menu',
            animation: true,
            templateUrl: REPURL + "dmpi_oc_reports/monthly_report.html?v=" + VERSION,
            controllerName: "MonthlyReportCtrl",
            viewSize: "md",
            filesToLoad: [
                REPURL + "dmpi_oc_reports/monthly_report.html?v=" + VERSION,
                REPURL + "dmpi_oc_reports/controller.js?v=" + VERSION
            ]
        };
        AppSvc.modal(options);
    }
    vm.accrualReport = function () {
        var options = {
            data: 'menu',
            animation: true,
            templateUrl: REPURL + "dmpi_oc_reports/accrual_report.html?v=" + VERSION,
            controllerName: "AccrualReportCtrl",
            viewSize: "md",
            filesToLoad: [
                REPURL + "dmpi_oc_reports/accrual_report.html?v=" + VERSION,
                REPURL + "dmpi_oc_reports/controller.js?v=" + VERSION
            ]
        };
        AppSvc.modal(options);
    }
    vm.OCLedgerReport = function () {
        var options = {
            data: 'menu',
            animation: true,
            templateUrl: REPURL + "dmpi_oc_reports/oc_ledger_report.html?v=" + VERSION,
            controllerName: "OCLedgerReportCtrl",
            viewSize: "md",
            filesToLoad: [
                REPURL + "dmpi_oc_reports/oc_ledger_report.html?v=" + VERSION,
                REPURL + "dmpi_oc_reports/controller.js?v=" + VERSION
            ]
        };
        AppSvc.modal(options);
    }
}
function BillingTransmittalCtrl($scope, $ocLazyLoad, $injector, data, $uibModalInstance) {
    var modal = this;
    modal.variables = {};
    $ocLazyLoad.load([
        REPURL + 'dmpi_oc_reports/service.js?v=' + VERSION,
    ]).then(function (d) {
        TransmittalReportSvc = $injector.get('TransmittalReportSvc');
    });
    modal.generate = function () {
        var from = AppSvc.getDate(modal.variables.from);
        var to = AppSvc.getDate(modal.variables.to);
        TransmittalReportSvc.get({ from: from, to: to, exists: true }).then(function (response) {
            if (response.message) {
                return AppSvc.showSwal('Error', 'Nothing to Display', 'error');
            }
            window.open('report/dmpi_oc/transmittal_report?from=' + from + '&to=' + to);
        })
    }
    modal.close = function () {
        $uibModalInstance.dismiss('cancel');
    }
}
function ReactivatedSOACtrl($scope, $ocLazyLoad, $injector, data, $uibModalInstance) {
    var modal = this;
    modal.variables = {};
    $ocLazyLoad.load([
        REPURL + 'dmpi_oc_reports/service.js?v=' + VERSION,
    ]).then(function (d) {
        ReactivatedSOASvc = $injector.get('ReactivatedSOASvc');
    });
    modal.generate = function (type) {
        var from = AppSvc.getDate(modal.variables.from);
        var to = AppSvc.getDate(modal.variables.to);
        if (type === 'SAR') {
            ReactivatedSOASvc.get({ from: from, to: to, exists: true, SAR: true }).then(function (response) {
                if (response.message) {
                    return AppSvc.showSwal('Sorry!', 'No Data Found.', 'warning');
                }
                window.open('report/dmpi_oc/reactivated_soa?SAR=true&from=' + from + '&to=' + to);
                window.open('report/dmpi_oc/reactivated_soa?Excel=true&SAR=true&from=' + from + '&to=' + to);
            })
        }else if (type === 'OTHER CLIENT') {
            ReactivatedSOASvc.get({ from: from, to: to, exists: true, OtherClient: true }).then(function (response) {
                if (response.message) {
                    return AppSvc.showSwal('Sorry!', 'No Data Found.', 'warning');
                }
                window.open('report/dmpi_oc/reactivated_soa?OtherClient=true&from=' + from + '&to=' + to);
                window.open('report/dmpi_oc/reactivated_soa?Excel=true&OtherClient=true&from=' + from + '&to=' + to);
            })
        } else if (type === 'OTHER INCOME') {
            ReactivatedSOASvc.get({ from: from, to: to, exists: true, OtherIncome: true }).then(function (response) {
                if (response.message) {
                    return AppSvc.showSwal('Sorry!', 'No Data Found.', 'warning');
                }
                window.open('report/dmpi_oc/reactivated_soa?OtherIncome=true&from=' + from + '&to=' + to);
                window.open('report/dmpi_oc/reactivated_soa?Excel=true&OtherIncome=true&from=' + from + '&to=' + to);
            })
        }else {
            ReactivatedSOASvc.get({ from: from, to: to, exists: true, DAR: true }).then(function (response) {
                if (response.message) {
                    return AppSvc.showSwal('Sorry!', 'No Data Found.', 'warning');
                }
                window.open('report/dmpi_oc/reactivated_soa?DAR=true&from=' + from + '&to=' + to);
                window.open('report/dmpi_oc/reactivated_soa?Excel=true&DAR=true&from=' + from + '&to=' + to);
            })
        }
    }
    modal.close = function () {
        $uibModalInstance.dismiss('cancel');
    }
}
function BandCCtrl($scope, $ocLazyLoad, $injector, data, $uibModalInstance) {
    var modal = this;
    var dateNow = new Date();
    modal.variables = {};
    modal.variables.from = new Date();
    modal.variables.to = new Date();
    modal.variables.generation = 1;
    $ocLazyLoad.load([
        REPURL + 'dmpi_oc_reports/service.js?v=' + VERSION,
    ]).then(function (d) {
        BANDSvc = $injector.get('BANDSvc');
    });
    modal.generate = function () {
        var from = AppSvc.getDate(modal.variables.from);
        var to = AppSvc.getDate(modal.variables.to);
        BANDSvc.get({ generation: modal.variables.generation, from: from, to: to, exists: true }).then(function (response) {
            if (response.message) {
                return AppSvc.showSwal('Error', 'Nothing to Display', 'error');
            }
            window.open('report/dmpi_oc/billing_and_collection?generation=' + modal.variables.generation + '&from=' + from + '&to=' + to);
        })
    }

    modal.close = function () {
        $uibModalInstance.dismiss('cancel');
    }
}
function SOAStatusCtrl($scope, $ocLazyLoad, $injector, data, $uibModalInstance) {
    var modal = this;
    var dateNow = new Date();
    modal.variables = {};
    modal.variables.month = (dateNow.getMonth() + 1).toString();
    modal.years = [];
    modal.variables.from = new Date();
    modal.variables.to = new Date();
    $ocLazyLoad.load([
        REPURL + 'dmpi_oc_reports/service.js?v=' + VERSION,
    ]).then(function (d) {
        SOAStatusSvc = $injector.get('SOAStatusSvc');
        modal.displayYears();
        modal.displayPeriod();
    });
    modal.displayYears = function () {
        var year = dateNow.getFullYear();
        modal.years.push({ year: year - 2 });
        modal.years.push({ year: year - 1 });
        modal.years.push({ year: year });
        modal.years.push({ year: year + 1 });
        modal.years.push({ year: year + 2 });
        modal.variables.year = dateNow.getFullYear().toString();
    }
    modal.displayPeriod = function () {
        if (dateNow.getDate() > 15) {
            modal.variables.period = '2';
        } else {
            modal.variables.period = '1';
        }
    }
    modal.generate = function () {
        var from = AppSvc.getDate(modal.variables.from);
        var to = AppSvc.getDate(modal.variables.to);
        SOAStatusSvc.get({ from: from, to: to, exists: true }).then(function (response) {
            if (response.message) {
                return AppSvc.showSwal('Error', 'Nothing to Display', 'error');
            }
            window.open('report/dmpi_oc/soa_status?from=' + from + '&to=' + to);
        })
    }

    modal.close = function () {
        $uibModalInstance.dismiss('cancel');
    }
}
function AgingReportCtrl($scope, $ocLazyLoad, $injector, data, $uibModalInstance) {
    var modal = this;
    modal.variables = {};
    modal.variables.from = new Date();
    modal.variables.to = new Date();
    modal.variables.aging = new Date();
    modal.variables.category = 'ALL';
    modal.reportOption = 'Details';
    $ocLazyLoad.load([
        REPURL + 'dmpi_oc_reports/service.js?v=' + VERSION,
    ]).then(function (d) {
        AgingReportSvc = $injector.get('AgingReportSvc');
    });

    modal.generate = function (type) {
        if(modal.reportOption === 'Details'){
            var data = angular.copy(modal.variables);
            data.from =  AppSvc.getDate(modal.variables.from);
            data.to = AppSvc.getDate(modal.variables.to);
            data.aging = AppSvc.getDate(modal.variables.aging);
            data.exists = true;
            data.summary = false;
            AgingReportSvc.get(data).then(function (response) {
                if (response.message) {
                    return AppSvc.showSwal('Error', 'Nothing to Display', 'error');
                }
                delete data.exists;
                var query = '';
                for(var key in data){
                    if(data[key]){
                        query += key+'='+data[key]+'&';
                    }
                }
                if (type === 'PDF') {
                    window.open('report/dmpi_oc/aging_report?'+query);
                } else {
                    window.open('report/dmpi_oc/aging_report?excel=true&'+query);
                }
            })
        }else{
            var data = angular.copy(modal.variables);
            data.from =  AppSvc.getDate(modal.variables.from);
            data.to = AppSvc.getDate(modal.variables.to);
            data.aging = AppSvc.getDate(modal.variables.aging);
            data.exists = true;
            data.summary = true;
            AgingReportSvc.get(data).then(function (response) {
                if (response.message) {
                    return AppSvc.showSwal('Error', 'Nothing to Display', 'error');
                }
                delete data.exists;
                var query = '';
                for(var key in data){
                    if(data[key]){
                        query += key+'='+data[key]+'&';
                    }
                }
                if (type === 'PDF') {
                    window.open('report/dmpi_oc/aging_report?'+query);
                } else {
                    window.open('report/dmpi_oc/aging_report?excel=true&'+query);
                }
            })
        }
        
    }

    modal.close = function () {
        $uibModalInstance.dismiss('cancel');
    }
}
function YearToDateCtrl($scope, $ocLazyLoad, $injector, data, $uibModalInstance) {
    var modal = this;
    modal.variables = {};
    $ocLazyLoad.load([
        REPURL + 'dmpi_oc_reports/service.js?v=' + VERSION,
    ]).then(function (d) {
        YearToDateSvc = $injector.get('YearToDateSvc');
    });

    modal.generate = function (type) {
        var from = AppSvc.getDate(modal.variables.from);
        var to = AppSvc.getDate(modal.variables.to);
        YearToDateSvc.get({ from: from, to: to, exists: true }).then(function (response) {
            if (response.message) {
                return AppSvc.showSwal('Error', 'Nothing to Display', 'error');
            }
            if (type === 'PDF') {
                window.open('report/dmpi_oc/year_to_date?from=' + from + '&to=' + to);
            } else {
                window.open('report/dmpi_oc/year_to_date?excel=true&from=' + from + '&to=' + to);
            }
        })
    }

    modal.close = function () {
        $uibModalInstance.dismiss('cancel');
    }
}
function PerClientCtrl($scope, $ocLazyLoad, $injector, data, $uibModalInstance) {
    var modal = this;
    modal.variables = {};
    $ocLazyLoad.load([
        REPURL + 'dmpi_oc_reports/service.js?v=' + VERSION,
    ]).then(function (d) {
        AllClientReportSvc = $injector.get('AllClientReportSvc');
    });
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
                if (number == 1) {
                    modal.variables.preparedBy = data.fullname;
                    modal.variables.preparedByPosition = data.position;
                } else if (number == 2) {
                    modal.variables.checkedBy = data.fullname;
                    modal.variables.checkedByPosition = data.position;
                } else {
                    modal.variables.approvedBy = data.fullname;
                    modal.variables.approvedByPosition = data.position;
                }
            }
        })
    }
    modal.generate = function (type) {
        var from = AppSvc.getDate(modal.variables.from);
        var to = AppSvc.getDate(modal.variables.to);
        AllClientReportSvc.get({ from: from, to: to, exists: true }).then(function (response) {
            if (response.message) {
                return AppSvc.showSwal('Error', 'Nothing to Display', 'error');
            }
            if (type === 'PDF') {
                window.open(
                    'report/dmpi_oc/per_client_report?from=' + from +
                    '&to=' + to +
                    '&preparedBy=' + modal.variables.preparedBy +
                    '&checkedBy=' + modal.variables.checkedBy +
                    '&approvedBy=' + modal.variables.approvedBy
                );
            } else {
                window.open(
                    'report/dmpi_oc/per_client_report?excel=truefrom=' + from +
                    '&to=' + to +
                    '&preparedBy=' + modal.variables.preparedBy +
                    '&checkedBy=' + modal.variables.checkedBy +
                    '&approvedBy=' + modal.variables.approvedBy
                );
            }
        })
    }

    modal.close = function () {
        $uibModalInstance.dismiss('cancel');
    }
}
function AnnualReportCtrl($scope, $ocLazyLoad, $injector, data, $uibModalInstance) {
    var modal = this;
    modal.variables = {};
    $ocLazyLoad.load([
        REPURL + 'dmpi_oc_reports/service.js?v=' + VERSION,
    ]).then(function (d) {
        AllClientReportSvc = $injector.get('AllClientReportSvc');
    });

    modal.generate = function (type) {
        var from = AppSvc.getDate(modal.variables.from);
        var to = AppSvc.getDate(modal.variables.to);
        AllClientReportSvc.get({ from: from, to: to, exists: true }).then(function (response) {
            if (response.message) {
                return AppSvc.showSwal('Error', 'Nothing to Display', 'error');
            }
            if (type === 'PDF') {
                window.open('report/dmpi_oc/annual_report?from=' + from + '&to=' + to);
            } else {
                window.open('report/dmpi_oc/annual_report?excel=true&from=' + from + '&to=' + to);
            }
        })
    }

    modal.close = function () {
        $uibModalInstance.dismiss('cancel');
    }
}
function WeeklyReportCtrl($scope, $ocLazyLoad, $injector, data, $uibModalInstance) {
    var modal = this;
    var dateNow = new Date();
    modal.variables = {};
    modal.variables.searchBy = 'soaDate';
    modal.variables.from = new Date();
    modal.variables.to = new Date();
    modal.variables.monthYear = new Date();
    if (dateNow.getDate() < 16) {
        modal.variables.period = '1';
    } else {
        modal.variables.period = '2';
    }
    $ocLazyLoad.load([
        REPURL + 'dmpi_oc_reports/service.js?v=' + VERSION,
    ]).then(function (d) {
        WeeklyReportSvc = $injector.get('WeeklyReportSvc');
    });

    modal.generate = function (type) {
        var month = AppSvc.pad(parseInt(modal.variables.monthYear.getMonth()) + 1, 2);
        var year = modal.variables.monthYear.getFullYear();
        var data = {
            from: AppSvc.getDate(modal.variables.from),
            to: AppSvc.getDate(modal.variables.to),
            period: modal.variables.period,
            searchBy: modal.variables.searchBy,
            pmy: year + "" + month,
            exists: true
        }
        WeeklyReportSvc.get(data).then(function (response) {
            if (response.message) {
                return AppSvc.showSwal('Error', 'Nothing to Display', 'error');
            }
            window.open('report/dmpi_oc/weekly_report?excel=true&from=' + data.from + '&to=' + data.to + '&period=' + data.period + '&pmy=' + data.pmy + '&searchBy=' + data.searchBy);
        })
    }

    modal.close = function () {
        $uibModalInstance.dismiss('cancel');
    }
}
function MonthlyReportCtrl($scope, $ocLazyLoad, $injector, data, $uibModalInstance) {
    var modal = this;
    modal.variables = {};
    modal.variables.searchBy = 'soaDate';
    $ocLazyLoad.load([
        REPURL + 'dmpi_oc_reports/service.js?v=' + VERSION,
    ]).then(function (d) {
        MonthlyReportSvc = $injector.get('MonthlyReportSvc');
    });

    modal.generate = function (type) {
        var from = AppSvc.getDate(modal.variables.from);
        var to = AppSvc.getDate(modal.variables.to);
        MonthlyReportSvc.get({ summary: true, from: from, to: to, exists: true, searchBy: modal.variables.searchBy }).then(function (response) {
            if (response.message) {
                return AppSvc.showSwal('Error', 'Nothing to Display', 'error');
            }
            if (type == 1) {
                window.open('report/dmpi_oc/monthly_report?summary=true&from=' + from + '&to=' + to + '&searchBy=' + data.searchBy);
            } else {
                window.open('report/dmpi_oc/monthly_report?summary=true&excel=true&from=' + from + '&to=' + to + '&searchBy=' + data.searchBy);
            }

        })
    }
    modal.monthly = function (type) {
        var from = AppSvc.getDate(modal.variables.from);
        var to = AppSvc.getDate(modal.variables.to);
        MonthlyReportSvc.get({ monthlyTransmittal: true, from: from, to: to, exists: true, searchBy: modal.variables.searchBy }).then(function (response) {
            if (response.message) {
                return AppSvc.showSwal('Error', 'Nothing to Display', 'error');
            }
            if (type == 1) {
                window.open('report/dmpi_oc/monthly_report?monthlyTransmittal=true&from=' + from + '&to=' + to + '&searchBy=' + modal.variables.searchBy);
            } else {
                window.open('report/dmpi_oc/monthly_report?monthlyTransmittal=true&excel=true&from=' + from + '&to=' + to + '&searchBy=' + modal.variables.searchBy);
            }

        })
    }
    modal.hrReport = function (type) {
        var from = AppSvc.getDate(modal.variables.from);
        var to = AppSvc.getDate(modal.variables.to);
        MonthlyReportSvc.get({ monthly: true, from: from, to: to, exists: true }).then(function (response) {
            if (response.message) {
                return AppSvc.showSwal('Error', 'Nothing to Display', 'error');
            }
            if (type == 1) {
                window.open('report/dmpi_oc/monthly_report?monthly=true&from=' + from + '&to=' + to);
            } else {
                window.open('report/dmpi_oc/monthly_report?monthly=true&excel=true&from=' + from + '&to=' + to);
            }

        })
    }
    modal.close = function () {
        $uibModalInstance.dismiss('cancel');
    }
}
function AccrualReportCtrl($scope, $ocLazyLoad, $injector, data, $uibModalInstance) {
    var modal = this;
    modal.variables = {};
    modal.variables.from = new Date();
    modal.variables.to = new Date();
    $ocLazyLoad.load([
        REPURL + 'dmpi_oc_reports/service.js?v=' + VERSION,
    ]).then(function (d) {
        AccrualReportSvc = $injector.get('AccrualReportSvc');
    });

    modal.print = function (type) {
        var from = AppSvc.getDate(modal.variables.from);
        var to = AppSvc.getDate(modal.variables.to);
        AccrualReportSvc.get({ summary: true, from: from, to: to, exists: true }).then(function (response) {
            if (response.message) {
                return AppSvc.showSwal('Error', 'Nothing to Display', 'error');
            }
            window.open('report/dmpi_oc/accrual_report?' + type + '=true&from=' + from + '&to=' + to);
        })
    }
    modal.close = function () {
        $uibModalInstance.dismiss('cancel');
    }
}
function OCLedgerReportCtrl($scope, $ocLazyLoad, $injector, data, $uibModalInstance) {
    var modal = this;
    modal.variables = {};
    modal.variables.client = '';
    $ocLazyLoad.load([
        REPURL + 'dmpi_oc_reports/service.js?v=' + VERSION,
    ]).then(function (d) {
        OCLedgerReportSvc = $injector.get('OCLedgerReportSvc');
    });

    modal.print = function () {
        if(!modal.variables.client){
            return AppSvc.showSwal('Requirement', 'Please select client.', 'warning');
        }
        OCLedgerReportSvc.get({ exists: true, client: modal.variables.client }).then(function (response) {
            if (response.message) {
                return AppSvc.showSwal('Error', 'Nothing to Display', 'error');
            }
            console.log('here');
            window.open('report/dmpi_oc/oc_ledger_report?excel=true&client=' + modal.variables.client);
        })
    }
    modal.close = function () {
        $uibModalInstance.dismiss('cancel');
    }
}