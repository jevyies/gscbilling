angular.module('app')
    .controller('DMPIDARCtrl', DMPIDARCtrl)
    .controller('DMPIDARHeaderCtrl', DMPIDARHeaderCtrl)
    .controller('ReactivateDARCtrl', ReactivateDARCtrl)
    .controller('TransmittalDARCtrl', TransmittalDARCtrl)
    .controller('DARLogCtrl', DARLogCtrl)

DMPIDARCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector', '$q', '$filter'];
DMPIDARHeaderCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector', 'data', '$uibModalInstance'];
ReactivateDARCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector', 'data', '$uibModalInstance'];
TransmittalDARCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector', 'data', '$uibModalInstance'];
DARLogCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector', 'data', '$uibModalInstance'];

function DMPIDARCtrl($scope, $ocLazyLoad, $injector, $q, filter) {
    var vm = this;
    vm.saveChoice = 1;
    vm.variables = {};
    vm.years = [];
    vm.batches = [];
    vm.warnings = [];
    vm.details = [];
    vm.supervisorDetails = {};
    vm.incentiveDetails = {};
    vm.listSupervisor = [];
    vm.listIncentive = [];
    vm.role = '';
    vm.months = [
        { name: 'January', value: '1' },
        { name: 'February', value: '2' },
        { name: 'March', value: '3' },
        { name: 'April', value: '4' },
        { name: 'May', value: '5' },
        { name: 'June', value: '6' },
        { name: 'July', value: '7' },
        { name: 'August', value: '8' },
        { name: 'September', value: '9' },
        { name: 'October', value: '10' },
        { name: 'November', value: '11' },
        { name: 'December', value: '12' },
    ]
    vm.OverAllTotal = 0;
    vm.OverAllTotalIncentive = 0;
    var dateNow = new Date();
    vm.variables.month = (dateNow.getMonth() + 1).toString();
    vm.variables.cutoff_month = (dateNow.getMonth() + 1).toString();
    if (dateNow.getDate() < 16) {
        vm.variables.period = '1';
    } else {
        vm.variables.period = '2';
    }
    vm.variables.status = 'active';
    vm.variables.isClubhouse = 0;
    vm.variables.nonBatch = 0;
    var defaultValue = 'GSMPC-';
    vm.soaNumber = defaultValue;
    $ocLazyLoad.load([
        BILLINGURL + 'dmpi_dar/service.js?v=' + VERSION,
    ]).then(function (d) {
        AppSvc = $injector.get('AppSvc');
        DMPIDARSvc = $injector.get('DMPIDARSvc');
        DMPIDARDetailDetailSvc = $injector.get('DMPIDARDetailDetailSvc');
        DMPIDARDetailIncentiveSvc = $injector.get('DMPIDARDetailIncentiveSvc');
        vm.getTransmittalNos();
        vm.displayYears();
        vm.getUser();
    });
    vm.getUser = function(){
        AppSvc.get().then(function (response) {
			if (response) {
				vm.role = response.record.role;
			}
		});
    }
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
        vm.transmittalExist = false;
        if (!vm.variables.TransmittalNo) {
            return vm.transmittals = vm.transmittalNos;
        }
        vm.transmittals = filter('filter')(vm.transmittalNos, { TransmittalNo: vm.variables.TransmittalNo });
    }
    vm.clickTransmittal = function (row) {
        vm.transmittals = [];
        vm.variables.TransmittalNo = row.TransmittalNo;
    }
    vm.defaultSOA = function () {
        if (!vm.soaNumber || defaultValue !== vm.soaNumber.substring(0, 6)) {
            vm.soaNumber = defaultValue;
        }
    }
    vm.displayYears = function () {
        vm.years = [];
        var year = dateNow.getFullYear();
        vm.years.push({ year: year - 2 });
        vm.years.push({ year: year - 1 });
        vm.years.push({ year: year });
        vm.years.push({ year: year + 1 });
        vm.years.push({ year: year + 2 });
        vm.variables.year = dateNow.getFullYear().toString();
        vm.variables.cutoff_year = dateNow.getFullYear().toString();
    }
    vm.searchLocation = function () {
        var options = {
            data: 'menu',
            animation: true,
            templateUrl: SETTINGSURL + "location_master/location_modal.html?v=" + VERSION,
            controllerName: "LocationViewCtrl",
            viewSize: "md",
            filesToLoad: [
                SETTINGSURL + "location_master/location_modal.html?v=" + VERSION,
                SETTINGSURL + "location_master/controller.js?v=" + VERSION
            ]
        };
        AppSvc.modal(options).then(function (data) {
            if (data) {
                vm.variables.locationID = data.LocationID;
                vm.variables.location = data.Location;
            }
        });
    }
    vm.searchHeader = function () {
        var options = {
            data: 'menu',
            animation: true,
            templateUrl: BILLINGURL + "dmpi_dar/search_header.html?v=" + VERSION,
            controllerName: "DMPIDARHeaderCtrl",
            viewSize: "lg",
            filesToLoad: [
                BILLINGURL + "dmpi_dar/search_header.html?v=" + VERSION,
                BILLINGURL + "dmpi_dar/controller.js?v=" + VERSION
            ]
        };
        AppSvc.modal(options).then(function (data) {
            if (data) {
                vm.variables = angular.copy(data);
                vm.variables.totalAmount = filter('number')(data.total_amount, 2);
                vm.variables.year = data.pmy.slice(0, 4);
                vm.variables.month = parseInt(data.pmy.slice(4, 6)).toString();
                vm.variables.soaDate = new Date(data.soaDate + ' 00:00:00');
                vm.variables.TransmittedDate = new Date(data.TransmittedDate + ' 00:00:00');
                vm.variables.SupervisorDate = new Date(data.SupervisorDate + ' 00:00:00');
                vm.variables.ManagerDate = new Date(data.ManagerDate + ' 00:00:00');
                vm.variables.DataControllerDate = new Date(data.DataControllerDate + ' 00:00:00');
                vm.variables.BillingClerkDate = new Date(data.BillingClerkDate + ' 00:00:00');
                vm.variables.DMPIReceivedDate = new Date(data.DMPIReceivedDate + ' 00:00:00');
                vm.variables.batcIDLink = parseInt(data.batcIDLink);
                vm.variables.nonBatch = parseInt(data.nonBatch);
                vm.batchNo = data.batchNo;
                vm.soaNumber = data.soaNumber;
                vm.saveChoice = parseFloat(vm.variables.detailType);
                // vm.getBatch();
                vm.getBatchInfoSoaNumber();
                vm.getDetails(data.id);
                vm.getRates(data.id);
                vm.getWarnings(data.id);
            }
        })
    }
    vm.getDetails = function (id) {
        if (vm.saveChoice == 2) {
            DMPIDARSvc.get({ detailsSupervisor: true, id: id }).then(function (response) {
                if (response.message) {
                    var OverAllTotal = 0;
                    vm.listSupervisor = [];
                } else {
                    var OverAllTotal = 0;
                    response.forEach(function (item) {
                        OverAllTotal = OverAllTotal + parseFloat(item.c_totalAmt);
                    })
                    vm.OverAllTotal = filter('number')(OverAllTotal, 2);
                    vm.listSupervisor = response;
                }
            })
        } else if (vm.saveChoice == 3) {
            DMPIDARSvc.get({ detailsIncentive: true, id: id }).then(function (response) {
                if (response.message) {
                    var OverAllTotalIncentive = 0;
                    vm.listIncentive = [];
                } else {
                    var OverAllTotalIncentive = 0;
                    response.forEach(function (item) {
                        OverAllTotalIncentive = OverAllTotalIncentive + parseFloat(item.c_totalAmt);
                    })
                    vm.OverAllTotalIncentive = filter('number')(OverAllTotalIncentive, 2);
                    vm.listIncentive = response;
                }
            })
        } else {
            DMPIDARSvc.get({ details: true, id: id }).then(function (response) {
                if (response.message) {
                    vm.details = [];
                } else {
                    var No = 1;
                    response.forEach(function (item) {
                        item.No = No++;
                    })
                    vm.details = response;
                }
            })
        }
    }
    vm.calculateTotalAmt = function(){
        var sum = 0;
        if (vm.saveChoice == 2) {
            vm.listSupervisor.forEach(function(item){
                sum += item.amount;
            })
        }else if(vm.saveChoice == 3){
            vm.listIncentive.forEach(function(item){
                sum += item.amount;
            })
        }else{
            vm.details.forEach(function(item){
                sum += item.amount;
            })
        }
        vm.variables.totalAmount = filter('number')(sum, 2);
    }
    vm.getRates = function (id) {
        DMPIDARSvc.get({ rates: true, id: id }).then(function (response) {
            if (response.message) {
                vm.rates = [];
            } else {
                response.forEach(function (item) {
                    item.matched = true;
                })
                vm.rates = response;
            }
        })
    }
    vm.getWarnings = function (id) {
        DMPIDARSvc.get({ warnings: true, id: id }).then(function (response) {
            if (response.message) {
                vm.warnings = [];
            } else {
                response.forEach(function (item) {
                    item.error = item.title;
                })
                vm.warnings = response;
                vm.showWarnings = true;
            }
        })
    }
    vm.searchSignatory = function (number) {
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
                    vm.variables.preparedBy = data.fullname;
                    vm.variables.preparedByPosition = data.position;
                } else if (number == 2) {
                    vm.variables.confirmedBy = data.fullname;
                    vm.variables.confirmedByPosition = data.position;
                } else if (number == 3) {
                    vm.variables.approvedBy = data.fullname;
                    vm.variables.approvedByPosition = data.position;
                } else {
                    vm.variables.approvedBy2 = data.fullname;
                    vm.variables.approvedByPosition2 = data.position;
                }
            }
        })
    }
    vm.getBatch = function () {
        vm.variables.pmy = vm.variables.year + AppSvc.pad(vm.variables.month, 2);
        var data = { batch: true, period: vm.variables.pmy, phase: vm.variables.period }
        if (vm.variables.year && vm.variables.month && vm.variables.period) {
            vm.batchIsLoading = true;
            DMPIDARSvc.get(data).then(function (response) {
                if (response.message) {
                    vm.batches = [];
                } else {
                    vm.batches = response;
                }
                vm.batchIsLoading = false;
            })
        }
    }
    vm.getBatchInfo = function () {
        vm.batchIsLoading = true;
        vm.variables.pmy = vm.variables.year + AppSvc.pad(vm.variables.month, 2);
        var data = {
            batchNo: vm.batchNo,
            bInfoBNo: true,
            Phase: vm.variables.period,
            Period: vm.variables.pmy,
        }
        DMPIDARSvc.get(data).then(function (response) {
            if (response.message) {
                vm.batchInfo = {};
                vm.batchTable = [];
                vm.variables.soaNumber = '';
                vm.variables.location = '';
                // vm.variables.batchNo = '';
                // vm.variables.batcIDLink = '';
                vm.soaNumber = 'GSMPC-';
                vm.soaCheck = -1;
                vm.batchesFetch = [];
                vm.batchCheck = -1;
            } else {
                vm.batchTable = response;
                vm.batchInfo = response[0];
                vm.variables.soaNumber = vm.batchInfo.Code_Location + vm.batchInfo.Code_Date + vm.batchInfo.Code_Series;
                vm.soaNumber = vm.batchInfo.Code_Location + vm.batchInfo.Code_Date + vm.batchInfo.Code_Series;
                vm.variables.location = vm.batchInfo.Location;
                // vm.variables.batchNo = vm.batchInfo.BNo;
                // vm.variables.batcIDLink = vm.batchInfo.BID;
                vm.batchesFetch = [vm.batchInfo.BID];
                vm.soaNumberCheck();
                vm.batchNoCheck();
            }
            vm.batchIsLoading = false;
        })
    }
    vm.redoSearch = function () {
        vm.batchInfo = {};
        vm.batchTable = [];
        vm.variables.soaNumber = '';
        vm.variables.location = '';
        // vm.variables.batchNo = '';
        // vm.variables.batcIDLink = '';
        vm.soaNumber = 'GSMPC-';
        vm.batchNo = '';
        vm.soaCheck = -1;
    }
    vm.getBatchInfoSoaNumber = function () {
        vm.variables.pmy = vm.variables.year + AppSvc.pad(vm.variables.month, 2);
        vm.batchIsLoading = true;
        var data = {
            soaNumber: vm.soaNumber,
            bInfoSNo: true,
            Phase: vm.variables.period,
            Period: vm.variables.pmy,
        }
        DMPIDARSvc.get(data).then(function (response) {
            if (response.message) {
                vm.batchInfo = {};
                vm.batchTable = [];
                vm.variables.soaNumber = '';
                vm.variables.location = '';
                // vm.variables.batchNo = '';
                // vm.variables.batcIDLink = '';
                vm.batchNo = '';
                vm.soaCheck = -1;
                vm.batchesFetch = [];
                vm.batchCheck = -1;
            } else {
                var batchNo = '';
                var batches = [];
                response.forEach(function (item) {
                    batchNo = item.BNo + ', ' + batchNo;
                    batches.push(item.BID);
                })
                vm.batchNo = batchNo.replace(/,\s*$/, "");
                vm.batchesFetch = batches;
                vm.batchTable = response;
                vm.batchInfo = response[0];
                vm.variables.soaNumber = vm.batchInfo.Code_Location + vm.batchInfo.Code_Date + vm.batchInfo.Code_Series;
                vm.variables.location = vm.batchInfo.Location;
                // vm.variables.batchNo = vm.batchInfo.BNo;
                // vm.batchNo = vm.batchInfo.BNo;
                // vm.variables.batcIDLink = vm.batchInfo.BID;
                vm.soaNumberCheck();
                vm.batchNoCheck();
            }
            vm.batchIsLoading = false;
        })
    }
    vm.batchNoCheck = function () {
        vm.batchIsLoading = true;
        var data = {
            id: vm.variables.id ? vm.variables.id : 0,
            batches: vm.batchesFetch,
            checkBatch: true
        }
        DMPIDARSvc.get(data).then(function (response) {
            if (response.message) {
                vm.batchCheck = 0;
            } else {
                vm.batchCheck = 1;
            }
            vm.batchIsLoading = false;
        })
    }
    vm.checkExcel = function () {
        if (!vm.excelFile) {
            return DMPIDARSvc.showSwal('Confirmation', 'Select Excel File to Proceed', 'warning');
        }
        if (!vm.variables.location && vm.variables.nonBatch != 1) {
            return DMPIDARSvc.showSwal('Confirmation', 'Select Batch First', 'warning');
        }
        vm.getDataFromExcel().then(function (response) {
            if (!response.details) {
                vm.details = [];
                vm.rates = [];
            } else {
                if (response.details.length == 0) {
                    return AppSvc.showSwal('Error', 'Check the excel you want to upload', 'error');
                }
                vm.getActualRate(response);
            }
        })
    }

    vm.getActualRate = function (data) {
        LOADING.classList.add("open");
        DMPIDARSvc.save({ row: data.rates, location: vm.variables.location, rate: true }).then(function (response) {
            if (response.success) {
                data.details.forEach(function (item) {
                    var rate = filter('filter')(response.row, { activity_fr_mg: "" + item.activity + "", gl_fr_mg: "" + item.gl + "", costcenter__: item.cc + "" }, true);
                    if (rate.length > 0) {
                        item.rate_id = rate[0].matchID;
                    }
                })
                vm.rates = response.row;
                vm.details = data.details;
            } else {
                AppSvc.showSwal('Error', 'Something went wrong', 'error');
            }
            LOADING.classList.remove("open");
        })
    }
    vm.checkErrors = function () {
        vm.warnings = [];
        vm.showWarnings = false;
        vm.saveNot = false;
        var gtSt = 0;
        var gtOt = 0;
        var gtNd = 0;
        var gtNdot = 0;
        var THW_ST = 0;
        var THW_OT = 0;
        var THW_ND = 0;
        var THW_NDOT = 0;
        var totalAmt = 0;
        vm.batchTable.forEach(function (item) {
            THW_ST = THW_ST + parseFloat(item.THW_ST);
            THW_OT = THW_OT + parseFloat(item.THW_OT);
            THW_ND = THW_ND + parseFloat(item.THW_ND);
            THW_NDOT = THW_NDOT + parseFloat(item.THW_NDOT);
        })
        if (vm.details.length > 0) {
            vm.details.forEach(function (item) {
                if (filter('number')(item.c_totalst, 2) != filter('number')(item.totalst, 2)) {
                    vm.warnings.push({ type: 'error', error: 'ST amt error[' + item.No + ']', description: 'Amount: ' + item.totalst + ', Computed Amount: ' + item.c_totalst });
                }
                if (filter('number')(item.c_totalot, 2) != filter('number')(item.totalot, 2)) {
                    vm.warnings.push({ type: 'error', error: 'OT amt error[' + item.No + ']', description: 'Amount: ' + item.totalot + ', Computed Amount: ' + item.c_totalot });
                }
                if (filter('number')(item.c_totalnd, 2) != filter('number')(item.totalnd, 2)) {
                    vm.warnings.push({ type: 'error', error: 'ND amt error[' + item.No + ']', description: 'Amount: ' + item.totalnd + ', Computed Amount: ' + item.c_totalnd });

                }
                if (filter('number')(item.c_totalndot, 2) != filter('number')(item.totalndot, 2)) {
                    vm.warnings.push({ type: 'error', error: 'NDOT amt error[' + item.No + ']', description: 'Amount: ' + item.totalndot + ', Computed Amount: ' + item.c_totalndot });
                }
                if (filter('number')(item.c_totalAmt, 2) != filter('number')(item.totalAmt, 2)) {
                    vm.warnings.push({ type: 'error', error: 'Total amt error[' + item.No + ']', description: 'Amount: ' + item.totalAmt + ', Computed Amount: ' + item.c_totalAmt });
                }
                gtSt = gtSt + parseFloat(item.rdst) + parseFloat(item.rtst) + parseFloat(item.sholst) + parseFloat(item.shrdst) + parseFloat(item.rholst) + parseFloat(item.rhrdst);
                gtOt = gtOt + parseFloat(item.rdot) + parseFloat(item.rtot) + parseFloat(item.sholot) + parseFloat(item.shrdot) + parseFloat(item.rholot) + parseFloat(item.rhrdot);
                gtNd = gtNd + parseFloat(item.rdnd) + parseFloat(item.rtnd) + parseFloat(item.sholnd) + parseFloat(item.shrdnd) + parseFloat(item.rholnd) + parseFloat(item.rhrdnd);
                gtNdot = gtNdot + parseFloat(item.rdndot) + parseFloat(item.rtndot) + parseFloat(item.sholndot) + parseFloat(item.shrdndot) + parseFloat(item.rholndot) + parseFloat(item.rhrdndot);
                totalAmt = totalAmt + parseFloat(item.c_totalAmt);
            })
            if (filter('number')(gtSt, 2) !== filter('number')(THW_ST, 2)) {
                vm.warnings.push({ type: 'warning', error: 'Batch st hrs does not match', description: 'Batch ST: ' + THW_ST + ', Uploaded ST: ' + gtSt });
            }
            if (filter('number')(gtOt, 2) !== filter('number')(THW_OT, 2)) {
                vm.warnings.push({ type: 'warning', error: 'Batch ot hrs does not match', description: 'Batch OT: ' + THW_OT + ', Uploaded OT: ' + gtOt });
            }
            if (filter('number')(gtNd, 2) !== filter('number')(THW_ND, 2)) {
                vm.warnings.push({ type: 'warning', error: 'Batch nd hrs does not match', description: 'Batch ND: ' + THW_ND + ', Uploaded ND: ' + gtNd });
            }
            if (filter('number')(gtNdot, 2) !== filter('number')(THW_NDOT, 2)) {
                vm.warnings.push({ type: 'warning', error: 'Batch ndot hrs does not match', description: 'Batch NDOT: ' + THW_NDOT + ', Uploaded NDOT: ' + gtNdot });
            }
            vm.variables.gtSt = gtSt;
            vm.variables.gtOt = gtOt;
            vm.variables.gtNd = gtNd;
            vm.variables.gtNdot = gtNdot;
        }
        vm.variables.totalCAmount = totalAmt;
        if (vm.rates.length > 0) {
            vm.rates.forEach(function (item) {
                if (!item.matched) {
                    vm.saveNot = true;
                    vm.warnings.push({ type: 'error', error: 'Rate Error', description: item.activity_fr_mg + ' rate/s doesn\'t match the active rate in rate master file' });
                }
            })
        }
        if (vm.warnings.length > 0) {
            if (vm.saveNot) {
                vm.fixable = false;
                return { error: true, fix: true };
            } else {
                vm.fixable = true;
                return { error: true, fix: false };
            }
        } else {
            vm.fixable = false;
            return { error: false, fix: false };
        }
    }
    vm.eraseWarning = function (index) {
        vm.warnings.splice(index, 1);
    }
    vm.getDataFromExcel = function () {
        var deferred = $q.defer();
        var reader = new FileReader();
        reader.onload = function () {
            var fileData = reader.result;
            var workbook = XLSX.read(fileData, { type: 'binary' });
            vm.rowObject = workbook.Sheets[workbook.SheetNames[0]];
            var partialData = [];
            var partialRate = [];
            var range = 111;
            var columns = [
                'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
                'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ',
                'BA', 'BB', 'BC', 'BD', 'BE', 'BF', 'BG', 'BH', 'BI', 'BJ', 'BK', 'BL', 'BM',
            ]
            for (x = 11; x < range; x++) {
                var data = {};
                var rate = {};
                for (i = 0; i < columns.length; i++) {
                    var column = columns[i];
                    var row = x;
                    var cell = column + '' + row;
                    // karaan
                    // if (column === 'A') {
                    //     data.No = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    // }
                    // if (column === 'B') {
                    //     data.activity = vm.rowObject[cell] ? vm.rowObject[cell].v : '';
                    // }
                    // if (column === 'C') {
                    //     data.field = vm.rowObject[cell] ? vm.rowObject[cell].v : '';
                    // }
                    // if (column === 'D') {
                    //     data.accomplished = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    // }
                    // if (column === 'E') {
                    //     data.gl = vm.rowObject[cell] ? vm.rowObject[cell].v : '';
                    // }
                    // if (column === 'F') {
                    //     data.cc = vm.rowObject[cell] ? vm.rowObject[cell].v : '';
                    // }
                    // if (column === 'G') {
                    //     data.rdst = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    // }
                    // if (column === 'H') {
                    //     data.rdot = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    // }
                    // if (column === 'I') {
                    //     data.rdnd = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    // }
                    // if (column === 'J') {
                    //     data.rdndot = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    // }
                    // if (column === 'K') {
                    //     data.sholst = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    // }
                    // if (column === 'L') {
                    //     data.sholot = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    // }
                    // if (column === 'M') {
                    //     data.sholnd = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    // }
                    // if (column === 'N') {
                    //     data.sholndot = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    // }
                    // if (column === 'O') {
                    //     data.rholst = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    // }
                    // if (column === 'P') {
                    //     data.rholot = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    // }
                    // if (column === 'Q') {
                    //     data.rholnd = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    // }
                    // if (column === 'R') {
                    //     data.rholndot = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    // }
                    // if (column === 'S') {
                    //     data.shrdst = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    // }
                    // if (column === 'T') {
                    //     data.shrdot = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    // }
                    // if (column === 'U') {
                    //     data.shrdnd = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    // }
                    // if (column === 'V') {
                    //     data.shrdndot = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    // }
                    // if (column === 'W') {
                    //     data.rhrdst = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    // }
                    // if (column === 'X') {
                    //     data.rhrdot = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    // }
                    // if (column === 'Y') {
                    //     data.rhrdnd = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    // }
                    // if (column === 'Z') {
                    //     data.rhrdndot = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    // }
                    // if (column === 'AA') {
                    //     rate.rd_st = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    // }
                    // if (column === 'AB') {
                    //     rate.rd_ot = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    // }
                    // if (column === 'AC') {
                    //     rate.rd_nd = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    // }
                    // if (column === 'AD') {
                    //     rate.rd_ndot = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    // }
                    // if (column === 'AE') {
                    //     rate.shol_st = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    // }
                    // if (column === 'AF') {
                    //     rate.shol_ot = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    // }
                    // if (column === 'AG') {
                    //     rate.shol_nd = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    // }
                    // if (column === 'AH') {
                    //     rate.shol_ndot = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    // }
                    // if (column === 'AI') {
                    //     rate.rhol_st = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    // }
                    // if (column === 'AJ') {
                    //     rate.rhol_ot = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    // }
                    // if (column === 'AK') {
                    //     rate.rhol_nd = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    // }
                    // if (column === 'AL') {
                    //     rate.rhol_ndot = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    // }
                    // if (column === 'AM') {
                    //     rate.shrd_st = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    // }
                    // if (column === 'AN') {
                    //     rate.shrd_ot = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    // }
                    // if (column === 'AO') {
                    //     rate.shrd_nd = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    // }
                    // if (column === 'AP') {
                    //     rate.shrd_ndot = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    // }
                    // if (column === 'AQ') {
                    //     rate.rhrd_st = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    // }
                    // if (column === 'AR') {
                    //     rate.rhrd_ot = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    // }
                    // if (column === 'AS') {
                    //     rate.rhrd_nd = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    // }
                    // if (column === 'AT') {
                    //     rate.rhrd_ndot = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    // }
                    // if (column === 'AU') {
                    //     data.totalst = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    // }
                    // if (column === 'AV') {
                    //     data.totalot = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    // }
                    // if (column === 'AW') {
                    //     data.totalnd = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    // }
                    // if (column === 'AX') {
                    //     data.totalndot = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    // }
                    // if (column === 'AY') {
                    //     data.totalAmt = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    // }
                    // if (column === 'AZ') {
                    //     data.headCount = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    // }
                    
                    // bag-o
                    if (column === 'A') {
                        data.No = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    }
                    if (column === 'B') {
                        data.activity = vm.rowObject[cell] ? vm.rowObject[cell].v : '';
                    }
                    if (column === 'C') {
                        data.field = vm.rowObject[cell] ? vm.rowObject[cell].v : '';
                    }
                    if (column === 'D') {
                        data.accomplished = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    }
                    if (column === 'E') {
                        data.gl = vm.rowObject[cell] ? vm.rowObject[cell].v : '';
                    }
                    if (column === 'F') {
                        data.cc = vm.rowObject[cell] ? vm.rowObject[cell].v : '';
                    }
                    if (column === 'G') {
                        data.ccc = vm.rowObject[cell] ? vm.rowObject[cell].v : '';
                    }
                    if (column === 'H') {
                        data.ioa = vm.rowObject[cell] ? vm.rowObject[cell].v : '';
                    }
                    if (column === 'I') {
                        data.ioc = vm.rowObject[cell] ? vm.rowObject[cell].v : '';
                    }
                    if (column === 'J') {
                        data.rdst = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    }
                    if (column === 'K') {
                        data.rdot = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    }
                    if (column === 'L') {
                        data.rdnd = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    }
                    if (column === 'M') {
                        data.rdndot = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    }
                    if (column === 'N') {
                        data.sholst = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    }
                    if (column === 'O') {
                        data.sholot = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    }
                    if (column === 'P') {
                        data.sholnd = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    }
                    if (column === 'Q') {
                        data.sholndot = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    }
                    if (column === 'R') {
                        data.rholst = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    }
                    if (column === 'S') {
                        data.rholot = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    }
                    if (column === 'T') {
                        data.rholnd = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    }
                    if (column === 'U') {
                        data.rholndot = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    }

                    if (column === 'V') {
                        data.rtst = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    }
                    if (column === 'W') {
                        data.rtot = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    }
                    if (column === 'X') {
                        data.rtnd = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    }
                    if (column === 'Y') {
                        data.rtndot = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    }

                    if (column === 'Z') {
                        data.shrdst = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    }
                    if (column === 'AA') {
                        data.shrdot = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    }
                    if (column === 'AB') {
                        data.shrdnd = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    }
                    if (column === 'AC') {
                        data.shrdndot = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    }
                    if (column === 'AD') {
                        data.rhrdst = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    }
                    if (column === 'AE') {
                        data.rhrdot = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    }
                    if (column === 'AF') {
                        data.rhrdnd = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    }
                    if (column === 'AG') {
                        data.rhrdndot = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    }
                    if (column === 'AH') {
                        rate.rd_st = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    }
                    if (column === 'AI') {
                        rate.rd_ot = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    }
                    if (column === 'AJ') {
                        rate.rd_nd = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    }
                    if (column === 'AK') {
                        rate.rd_ndot = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    }
                    if (column === 'AL') {
                        rate.shol_st = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    }
                    if (column === 'AM') {
                        rate.shol_ot = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    }
                    if (column === 'AN') {
                        rate.shol_nd = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    }
                    if (column === 'AO') {
                        rate.shol_ndot = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    }
                    if (column === 'AP') {
                        rate.rhol_st = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    }
                    if (column === 'AQ') {
                        rate.rhol_ot = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    }
                    if (column === 'AR') {
                        rate.rhol_nd = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    }
                    if (column === 'AS') {
                        rate.rhol_ndot = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    }

                    if (column === 'AT') {
                        rate.rt_st = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    }
                    if (column === 'AU') {
                        rate.rt_ot = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    }
                    if (column === 'AV') {
                        rate.rt_nd = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    }
                    if (column === 'AW') {
                        rate.rt_ndot = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    }
                    
                    if (column === 'AX') {
                        rate.shrd_st = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    }
                    if (column === 'AY') {
                        rate.shrd_ot = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    }
                    if (column === 'AZ') {
                        rate.shrd_nd = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    }
                    if (column === 'BA') {
                        rate.shrd_ndot = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    }
                    if (column === 'BB') {
                        rate.rhrd_st = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    }
                    if (column === 'BC') {
                        rate.rhrd_ot = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    }
                    if (column === 'BD') {
                        rate.rhrd_nd = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    }
                    if (column === 'BE') {
                        rate.rhrd_ndot = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    }
                    if (column === 'BF') {
                        data.vat_rate = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    }
                    if (column === 'BG') {
                        data.totalst = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    }
                    if (column === 'BH') {
                        data.totalot = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    }
                    if (column === 'BI') {
                        data.totalnd = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    }
                    if (column === 'BJ') {
                        data.totalndot = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    }
                    if (column === 'BK') {
                        data.vat = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    }
                    if (column === 'BL') {
                        data.totalAmt = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    }
                    if (column === 'BM') {
                        data.headCount = vm.rowObject[cell] ? vm.rowObject[cell].v : 0;
                    }
                }
                rate.activity_fr_mg = angular.copy(data.activity);
                rate.gl_fr_mg = angular.copy(data.gl);
                rate.costcenter__ = angular.copy(data.cc);
                rate.No = angular.copy(data.No);
                data.c_totalst =
                    (data.rdst * rate.rd_st) +
                    (data.sholst * rate.shol_st) +
                    (data.shrdst * rate.shrd_st) +
                    (data.rholst * rate.rhol_st) +
                    (data.rhrdst * rate.rhrd_st) +
                    (data.rtst * rate.rt_st) 
                data.c_totalot =
                    (data.rdot * rate.rd_ot) +
                    (data.sholot * rate.shol_ot) +
                    (data.shrdot * rate.shrd_ot) +
                    (data.rholot * rate.rhol_ot) +
                    (data.rhrdot * rate.rhrd_ot)  +
                    (data.rtot * rate.rt_ot) 
                data.c_totalnd =
                    (data.rdnd * rate.rd_nd) +
                    (data.sholnd * rate.shol_nd) +
                    (data.shrdnd * rate.shrd_nd) +
                    (data.rholnd * rate.rhol_nd) +
                    (data.rhrdnd * rate.rhrd_nd)  +
                    (data.rtnd * rate.rt_nd) 
                data.c_totalndot =
                    (data.rdndot * rate.rd_ndot) +
                    (data.sholndot * rate.shol_ndot) +
                    (data.shrdndot * rate.shrd_ndot) +
                    (data.rholndot * rate.rhol_ndot) +
                    (data.rhrdndot * rate.rhrd_ndot) +
                    (data.rtndot * rate.rt_ndot) 
                data.c_totalAmt = data.c_totalst + data.c_totalot + data.c_totalnd + data.c_totalndot;
                partialData.push(data);
                partialRate.push(rate);
            }
            var rows = [];
            var rates = [];
            partialData.forEach(function (item) {
                if (item.No > 0) {
                    rows.push(item);
                }
            })
            partialRate.forEach(function (item) {
                if (item.No > 0) {
                    rates.push(item);
                }
            })
            deferred.resolve({ details: rows, rates: rates });
        };
        reader.readAsBinaryString(vm.excelFile);
        return deferred.promise;
    }
    vm.clearBatch = function () {
        if (!vm.variables.id && vm.soaCheck == 0) {
            return AppSvc.showSwal('Confirmation', 'SOA Number is invalid', 'warning');
        }
        DMPIDARSvc.save({ clearBatch: true, id: vm.variables.id, soaNumber: vm.soaNumber }).then(function (response) {
            if (response.success) {
                return AppSvc.showSwal('Success', 'Successfully deleted', 'success');
            } else {
                return AppSvc.showSwal('Confirmation', 'Nothing to delete', 'warning');
            }
        })
    }
    vm.save = function (type) {
        var TDMSD = vm.variables.TransmittedDate - vm.variables.SupervisorDate;
        var TDMMD = vm.variables.TransmittedDate - vm.variables.ManagerDate;
        var TDMDCD = vm.variables.TransmittedDate - vm.variables.DataControllerDate;
        var TDMBCD = vm.variables.TransmittedDate - vm.variables.BillingClerkDate;
        var TDMDRD = vm.variables.TransmittedDate - vm.variables.DMPIReceivedDate;
        if (Math.ceil(TDMSD / (1000 * 60 * 60 * 24)) > 0) {
            return AppSvc.showSwal('Confirmation', 'Date Transmitted to Operation is greater than Date Signed by Supervisor', 'warning');
        }
        if (Math.ceil(TDMMD / (1000 * 60 * 60 * 24)) > 0) {
            return AppSvc.showSwal('Confirmation', 'Date Transmitted to Operation is greater than Date Signed by Manager', 'warning');
        }
        if (Math.ceil(TDMDCD / (1000 * 60 * 60 * 24)) > 0) {
            return AppSvc.showSwal('Confirmation', 'Date Transmitted to Operation is greater than Date Received by Data Controller', 'warning');
        }
        if (Math.ceil(TDMBCD / (1000 * 60 * 60 * 24)) > 0) {
            return AppSvc.showSwal('Confirmation', 'Date Transmitted to Operation is greater than Date Received by Billing Clerk', 'warning');
        }
        if (Math.ceil(TDMDRD / (1000 * 60 * 60 * 24)) > 0) {
            return AppSvc.showSwal('Confirmation', 'Date Transmitted to Operation is greater than Date Received by DMPI Account', 'warning');
        }
        if (vm.variables.nonBatch != 1) {
            if (!vm.batchInfo.BID) {
                return AppSvc.showSwal('Confirmation', 'Select Valid SOA First', 'warning');
            }
        }
        if (vm.variables.nonBatch != 1) {
            if (!datesAreOnSameDay(new Date(vm.batchInfo.xDate), vm.variables.soaDate)) {
                AppSvc.showSwal('Confirmation', 'Your SOA Date does not match to the batched SOA Date', 'warning');
            }
        }
        if (vm.batchCheck > 0) {
            return AppSvc.showSwal('Confirmation', 'Cannot Proceed. Batch Number already exists', 'error');
        }
        if (vm.soaCheck > 0) {
            return AppSvc.showSwal('Confirmation', 'Cannot Proceed. SOA Number already exists', 'error');
        }
        if (vm.saveChoice == 1) {
            if (!vm.variables.id && !vm.excelFile) {
                return AppSvc.showSwal('Confirmation', 'Select Excel File to Proceed', 'warning');
            }
            if (vm.details.length == 0) {
                return AppSvc.showSwal('Confirmation', "There's no uploaded DAR details", 'warning');
            }
            if (vm.variables.nonBatch != 1) {
                var errors = vm.checkErrors();
                if (errors.error) {
                    $(window).scrollTop($('#scrollTop').offset().top);
                    if (errors.fix) {
                        AppSvc.showSwal('Confirmation', 'Rate Error', 'warning');
                    } else {
                        AppSvc.showSwal('Confirmation', 'There are some Errors', 'warning');
                    }
                    if (type == 0) {
                        return vm.showWarnings = true;
                    }
                }
            }
        }
        if (vm.variables.nonBatch == 1) {
            vm.variables.soaNumber = vm.soaNumber;
        }
        vm.variables.pmy = vm.variables.year + AppSvc.pad(vm.variables.month, 2);
        var data = angular.copy(vm.variables);
        data.soaDate = vm.variables.soaDate ? AppSvc.getDate(vm.variables.soaDate) : '0000-00-00';
        data.TransmittedDate = vm.variables.TransmittedDate ? AppSvc.getDate(vm.variables.TransmittedDate) : '0000-00-00';
        data.SupervisorDate = vm.variables.SupervisorDate ? AppSvc.getDate(vm.variables.SupervisorDate) : '0000-00-00';
        data.ManagerDate = vm.variables.ManagerDate ? AppSvc.getDate(vm.variables.ManagerDate) : '0000-00-00';
        data.DataControllerDate = vm.variables.DataControllerDate ? AppSvc.getDate(vm.variables.DataControllerDate) : '0000-00-00';
        data.BillingClerkDate = vm.variables.BillingClerkDate ? AppSvc.getDate(vm.variables.BillingClerkDate) : '0000-00-00';
        data.DMPIReceivedDate = vm.variables.DMPIReceivedDate ? AppSvc.getDate(vm.variables.DMPIReceivedDate) : '0000-00-00';
        data.header = true;
        data.detailType = vm.saveChoice;
        LOADING.classList.add("open");
        DMPIDARSvc.get({ transmittalExist: true, transmittal: vm.variables.TransmittalNo }).then(function (response) {
            if (!response.message) {
                LOADING.classList.remove("open");
                $(window).scrollTop($('#scrollTop').offset().top);
                return vm.transmittalExist = true;
            } else {
                vm.soaCheck = 0;
                DMPIDARSvc.save(data).then(function (response) {
                    if(response.error){
                        vm.soaIsLoading = false;
                        vm.soaCheck = 1;
                        $(window).scrollTop($('#scrollTop').offset().top);
                        LOADING.classList.remove("open");
                    }else{
                        if (response.success) {
                            if (response.id) {
                                vm.variables.id = response.id;
                            }
                            if (vm.variables.nonBatch == 1 && vm.saveChoice == 1) {
                                vm.saveDetails(vm.variables.id);
                            }
                            if (vm.variables.nonBatch == 0) {
                                vm.saveBatches(vm.variables.id);
                            }
                            if (vm.saveChoice == 2 && vm.variables.nonBatch == 1) {
                                LOADING.classList.remove("open");
                            }
                            if (vm.saveChoice == 3 && vm.variables.nonBatch == 1) {
                                LOADING.classList.remove("open");
                            }
                            AppSvc.showSwal('Success', response.message, 'success');
                        } else {
                            if (vm.variables.nonBatch == 1 && vm.saveChoice == 1) {
                                vm.saveDetails(vm.variables.id);
                            }
                            if (vm.variables.nonBatch == 0) {
                                vm.saveBatches(vm.variables.id);
                            }
                            if (vm.saveChoice == 2 && vm.variables.nonBatch == 1) {
                                LOADING.classList.remove("open");
                            }
                            if (vm.saveChoice == 3 && vm.variables.nonBatch == 1) {
                                LOADING.classList.remove("open");
                            }
                            AppSvc.showSwal('Confirmation', 'Nothing to Update', 'warning');
                        }
                        vm.calculateTotalAmt();
                    }
                })
            }
        })

    }
    vm.saveBatches = function (id) {
        DMPIDARSvc.save({ id: id, rows: vm.batchTable, batches: true }).then(function (response) {
            if (response.success) {
                AppSvc.showSwal('Success', response.message + ' batches', 'success');
            } else {
                AppSvc.showSwal('Error', 'Something went wrong', 'error');
            }
            if (vm.saveChoice == 1) {
                vm.saveDetails(id);
            } else {
                LOADING.classList.remove("open");
            }
        })
    }
    vm.saveDetails = function (id) {
        DMPIDARSvc.save({ id: id, rows: vm.details, details: true }).then(function (response) {
            if (response.success) {
                AppSvc.showSwal('Success', response.message + ' details', 'success');
            } else {
                AppSvc.showSwal('Error', 'Something went wrong', 'error');
            }
            vm.saveWarnings(id);
        })
    }
    vm.saveDetailsSupervisor = function () {
        if (!vm.variables.id) {
            return AppSvc.showSwal("Requirement", "No saved header selected.", "warning");
        }
        var data = angular.copy(vm.supervisorDetails);
        data.rdst = vm.supervisorDetails.rdst ? parseFloat(AppSvc.getAmount(vm.supervisorDetails.rdst)) : 0;
        data.rdnd = vm.supervisorDetails.rdnd ? parseFloat(AppSvc.getAmount(vm.supervisorDetails.rdnd)) : 0;
        data.c_totalst = vm.supervisorDetails.c_totalst ? parseFloat(AppSvc.getAmount(vm.supervisorDetails.c_totalst)) : 0;
        data.c_totalnd = vm.supervisorDetails.c_totalnd ? parseFloat(AppSvc.getAmount(vm.supervisorDetails.c_totalnd)) : 0;
        data.leaveNoPayHrs = vm.supervisorDetails.leaveNoPayHrs ? parseFloat(AppSvc.getAmount(vm.supervisorDetails.leaveNoPayHrs)) : 0;
        data.TotalLeave = vm.supervisorDetails.TotalLeave ? parseFloat(AppSvc.getAmount(vm.supervisorDetails.TotalLeave)) : 0;
        data.c_totalAmt = vm.supervisorDetails.c_totalAmt ? parseFloat(AppSvc.getAmount(vm.supervisorDetails.c_totalAmt)) : 0;
        data.hdr_id = vm.variables.id;
        data.detailType = vm.saveChoice;
        data.detailsSupervisor = true;
        DMPIDARSvc.save(data).then(function (response) {
            if (response.success) {
                vm.supervisorDetails = {};
                vm.getDetails(vm.variables.id);
                AppSvc.showSwal('Success', response.message, 'success');
            } else {
                AppSvc.showSwal('Warning', 'Nothing to update.', 'warning');
            }
        })
    }
    vm.saveDetailsIncentive = function () {
        if (!vm.variables.id) {
            return AppSvc.showSwal("Requirement", "No saved header selected.", "warning");
        }
        var data = angular.copy(vm.incentiveDetails);
        data.c_totalAmt = vm.incentiveDetails.c_totalAmt ? parseFloat(AppSvc.getAmount(vm.incentiveDetails.c_totalAmt)) : 0;
        data.hdr_id = vm.variables.id;
        data.detailType = vm.saveChoice;
        data.detailsIncentive = true;
        DMPIDARSvc.save(data).then(function (response) {
            if (response.success) {
                vm.incentiveDetails = {};
                vm.getDetails(vm.variables.id);
                AppSvc.showSwal('Success', response.message, 'success');
            } else {
                AppSvc.showSwal('Warning', 'Nothing to update.', 'warning');
            }
        })
    }

    // vm.saveRates = function (id) {
    //     DMPIDARSvc.save({ id: id, rows: vm.rates, rates: true }).then(function (response) {
    //         if (response.success) {
    //             AppSvc.showSwal('Success', response.message, 'success');
    //         } else {
    //             AppSvc.showSwal('Error', 'Something went wrong', 'error');
    //         }
    //         vm.saveWarnings(id);
    //     })
    // }

    vm.saveWarnings = function (id) {
        if (vm.warnings.length > 0) {
            DMPIDARSvc.save({ id: id, rows: vm.warnings, warnings: true }).then(function (response) {
                if (response.success) {
                    AppSvc.showSwal('Success', response.message + ' warnings', 'success');
                } else {
                    AppSvc.showSwal('Error', 'Something went wrong', 'error');
                }
            })
        }
        vm.saveAccounting(id);
    }
    vm.saveAccounting = function (id) {
        DMPIDARSvc.save({ id: id, amount: vm.variables.totalCAmount, accounting: true }).then(function (response) {
            if (response.success) {
                AppSvc.showSwal('Success', response.message + ' for accounting', 'success');
            } else {
                AppSvc.showSwal('Error', 'Something went wrong', 'error');
            }
            LOADING.classList.remove("open");
        })
    }
    vm.updateStatus = function (status) {
        if (status == 'submitted' && vm.listSupervisor.length < 1 && vm.saveChoice == 2) {
            return AppSvc.showSwal("Warning", "Please save Supervisor Entry Detail to continue.", "warning");
        }
        if (status == 'submitted' && vm.listIncentive.length < 1 && vm.saveChoice == 3) {
            return AppSvc.showSwal("Warning", "Please save Incentive Entry Detail to continue.", "warning");
        }
        if (vm.variables.nonBatch != 1 && vm.saveChoice == 1) {
            var errors = vm.checkErrors();
            if (errors.error) {
                $(window).scrollTop($('#scrollTop').offset().top);
                vm.showWarnings = true;
                if (errors.fix) {
                    return AppSvc.showSwal('Confirmation', 'Fix the Rate Error first', 'warning');
                } else {
                    AppSvc.showSwal('Confirmation', 'There are some Errors', 'warning');
                }
            }
        }
        AppSvc.confirmation('Confirmation', 'Are You sure you want to update status to ' + status + '?', 'Confirm', 'Cancel').then(function (data) {
            if (data) {
                DMPIDARSvc.save({ updateStatus: true, status: status, id: vm.variables.id }).then(function (response) {
                    if (response.success) {
                        vm.variables.status = status;
                        AppSvc.showSwal('Success', response.message, 'success');
                    } else {
                        AppSvc.showSwal('Error', 'Something went wrong', 'error');
                    }
                })
            }
        })
    }
    vm.redirectTransmittal = function(id){
        AppSvc.confirmation('Confirmation', 'Are You sure you want to update status to PRINTED TRANSMITTAL?', 'Confirm', 'Cancel').then(function (data) {
            if (data) {
                var variables = angular.copy(vm.variables);
                variables.soaDate = vm.variables.soaDate ? AppSvc.getDate(vm.variables.soaDate) : '0000-00-00';
                variables.TransmittedDate = vm.variables.TransmittedDate ? AppSvc.getDate(vm.variables.TransmittedDate) : '0000-00-00';
                variables.SupervisorDate = vm.variables.SupervisorDate ? AppSvc.getDate(vm.variables.SupervisorDate) : '0000-00-00';
                variables.ManagerDate = vm.variables.ManagerDate ? AppSvc.getDate(vm.variables.ManagerDate) : '0000-00-00';
                variables.DataControllerDate = vm.variables.DataControllerDate ? AppSvc.getDate(vm.variables.DataControllerDate) : '0000-00-00';
                variables.BillingClerkDate = vm.variables.BillingClerkDate ? AppSvc.getDate(vm.variables.BillingClerkDate) : '0000-00-00';
                variables.DMPIReceivedDate = vm.variables.DMPIReceivedDate ? AppSvc.getDate(vm.variables.DMPIReceivedDate) : '0000-00-00';
                variables.updateStatus = true;
                variables.status = 'PRINTED TRANSMITTAL';
                variables.updateHeader = true;
                DMPIDARSvc.save(variables).then(function (response) {
                    if (response.success) {
                        if (vm.variables.nonBatch == 1 && vm.saveChoice == 1) {
                            vm.saveDetails(vm.variables.id);
                        }
                        if (vm.variables.nonBatch == 0) {
                            vm.saveBatches(vm.variables.id);
                        }
                        if (vm.saveChoice == 2 && vm.variables.nonBatch == 1) {
                            LOADING.classList.remove("open");
                        }
                        if (vm.saveChoice == 3 && vm.variables.nonBatch == 1) {
                            LOADING.classList.remove("open");
                        }
                        vm.variables.status = 'PRINTED TRANSMITTAL';
                        AppSvc.showSwal('Success', response.message, 'success');
                    } else {
                        AppSvc.showSwal('Error', 'Already set on that status', 'error');
                    }
                })
            }
        })
    }
    vm.reactivate = function () {
        var authOptions = {
            data: 'menu',
            animation: true,
            templateUrl: AUTHURL + "auth.html?v=" + VERSION,
            controllerName: "AuthCtrl",
            viewSize: "sm",
            filesToLoad: [
                AUTHURL + "auth.html?v=" + VERSION,
                AUTHURL + "auth.controller.js?v=" + VERSION
            ]
        };
        AppSvc.modal(authOptions).then(function (data) {
            if (data) {
                var options = {
                    data: vm.variables.id,
                    animation: true,
                    templateUrl: BILLINGURL + "dmpi_dar/reactivate.html?v=" + VERSION,
                    controllerName: "ReactivateDARCtrl",
                    viewSize: "sm",
                    filesToLoad: [
                        BILLINGURL + "dmpi_dar/reactivate.html?v=" + VERSION,
                        BILLINGURL + "dmpi_dar/controller.js?v=" + VERSION
                    ]
                };
                AppSvc.modal(options).then(function (data) {
                    if (data) {
                        vm.variables.status = 'active';
                    }
                })
            }
        })

    }
    vm.delete = function () {
        if (vm.variables.status !== 'active' && vm.variables.status !== 'submitted') {
            return AppSvc.showSwal('Confirmation', 'This SOA needs to be reactivate before deletion', 'danger');
        }
        DMPIDARSvc.delete(vm.variables.id).then(function (response) {
            if (response.success) {
                vm.clearFunction();
                AppSvc.showSwal('Success', response.message, 'success');
            } else {
                AppSvc.showSwal('Error', 'Something went wrong', 'error');
            }
            LOADING.classList.remove("open");
        })
    }
    vm.deleteSupervisor = function () {
        if (!vm.supervisorDetails.id) {
            return AppSvc.showSwal("Requirement", "Please select detail record to delete.", "warning");
        }
        DMPIDARDetailDetailSvc.delete(vm.supervisorDetails.id).then(function (response) {
            if (response.success) {
                vm.supervisorDetails = {};
                vm.getDetails(vm.variables.id);
                AppSvc.showSwal('Success', response.message, 'success');
            } else {
                AppSvc.showSwal('Error', 'Something went wrong', 'error');
            }
            LOADING.classList.remove("open");
        })
    }
    vm.deleteIncentive = function () {
        if (!vm.incentiveDetails.id) {
            return AppSvc.showSwal("Requirement", "Please select detail record to delete.", "warning");
        }
        DMPIDARDetailIncentiveSvc.delete(vm.incentiveDetails.id).then(function (response) {
            if (response.success) {
                vm.incentiveDetails = {};
                vm.getDetails(vm.variables.id);
                AppSvc.showSwal('Success', response.message, 'success');
            } else {
                AppSvc.showSwal('Error', 'Something went wrong', 'error');
            }
            LOADING.classList.remove("open");
        })
    }

    vm.soaNumberCheck = function () {
        vm.soaIsLoading = true;
        var data = {
            id: vm.variables.id ? vm.variables.id : 0,
            soaNumber: vm.variables.soaNumber,
            checkSoa: true
        }
        DMPIDARSvc.get(data).then(function (response) {
            if (response.message) {
                vm.soaCheck = 0;
            } else {
                vm.soaCheck = 1;
            }
            vm.soaIsLoading = false;
        })
    }
    vm.clearFunction = function () {
        if (vm.saveChoice == 1) {
            document.getElementById("file-input").value = "";
        }
        vm.saveChoice = 1;
        vm.variables = {};
        vm.variables.month = (dateNow.getMonth() + 1).toString();
        vm.variables.cutoff_month = (dateNow.getMonth() + 1).toString();
        vm.variables.status = 'active';
        vm.variables.isClubhouse = 0;
        vm.variables.nonBatch = 0;
        vm.displayYears();
        vm.warnings = [];
        vm.details = [];
        vm.rates = [];
        vm.excelFile = '';
        vm.soaCheck = -1;
        vm.batchTable = [];
        vm.redoSearch();
        vm.supervisorDetails = {};
        vm.incentiveDetails = {};
        if (dateNow.getDate() < 16) {
            vm.variables.period = '1';
        } else {
            vm.variables.period = '2';
        }
        $(window).scrollTop($('#scrollTop').offset().top);
    }
    vm.removeFile = function () {
        vm.warnings = [];
        vm.details = [];
        vm.rates = [];
        vm.excelFile = '';
        document.getElementById("file-input").value = "";
    }
    vm.showLogs = function(id){
        var options = {
            data: {id: id},
            animation: true,
            templateUrl: BILLINGURL + "dmpi_dar/logs.html?v=" + VERSION,
            controllerName: "DARLogCtrl",
            viewSize: "md",
            filesToLoad: [
                BILLINGURL + "dmpi_dar/logs.html?v=" + VERSION,
                BILLINGURL + "dmpi_dar/controller.js?v=" + VERSION
            ]
        };
        AppSvc.modal(options)
    }
    vm.print = function (type) {
        if (vm.details.length == 0) {
            return AppSvc.showSwal('Confirmation', "There's no uploaded DAR details", 'warning');
        }
        if (type === 'pdf') {
            window.open('report/dar_billing?pdf=true&id=' + vm.variables.id);
        } else {
            window.open('report/dar_billing?excel=true&id=' + vm.variables.id);
        }
    }
    vm.printTransmittal = function () {
        var options = {
            data: 'menu',
            animation: true,
            templateUrl: BILLINGURL + "dmpi_dar/transmittal.html?v=" + VERSION,
            controllerName: "TransmittalDARCtrl",
            viewSize: "sm",
            filesToLoad: [
                BILLINGURL + "dmpi_dar/transmittal.html?v=" + VERSION,
                BILLINGURL + "dmpi_dar/controller.js?v=" + VERSION
            ]
        };
        AppSvc.modal(options)
    }
    vm.saveRemarks = function () {
        var data = angular.copy(vm.variables);
        data.saveRemarks = true;
        LOADING.classList.add("open");
        DMPIDARSvc.save(data).then(function (response) {
            if (response.success) {
                AppSvc.showSwal('Success', response.message, 'success');
            } else {
                AppSvc.showSwal('Confirmation', 'Nothing to Update', 'warning');
            }
            LOADING.classList.remove("open");
        })
    }
    Array.prototype.groupBy = function (prop) {
        return this.reduce(function (groups, item) {
            var val = item[prop];
            groups[val] = groups[val] || [];
            groups[val].push(item);
            return groups;
        }, {});
    };
    // Supervisor
    vm.supervisorGrid = {
        enableRowSelection: true,
        enableCellEdit: false,
        enableColumnMenus: false,
        modifierKeysToMultiSelect: true,
        enableRowHeaderSelection: false,
        columnDefs: [
            { name: "Activity", field: "activity", width: "25%" },
            { name: "Name", field: "Name", width: "25%" },
            { name: "Fixed Quin.", field: "c_totalst", width: "10%", cellClass: "text-right", cellFilter: "number:2" },
            { name: "Total ND", field: "c_totalnd", width: "10%", cellClass: "text-right", cellFilter: "number:2" },
            { name: "Leave w/out Pay", field: "TotalLeave", width: "10%", cellClass: "text-right", cellFilter: "number:2" },
            { name: "Total Billing", field: "c_totalAmt", width: "20%", cellClass: "text-right", cellFilter: "number:2" },
        ],
        data: "vm.listSupervisor",
        onRegisterApi: function (gridApi) {
            gridApi.selection.on.rowSelectionChanged(null, function (row) {
                vm.clickSupervisor(row.entity);
            });
        }
    }
    vm.clickSupervisor = function (row) {
        vm.supervisorDetails = angular.copy(row);
        vm.supervisorDetails.c_totalst = filter('number')(row.c_totalst, 2);
        vm.supervisorDetails.c_totalnd = filter('number')(row.c_totalnd, 2);
        vm.supervisorDetails.TotalLeave = filter('number')(row.TotalLeave, 2);
        vm.supervisorDetails.c_totalAmt = filter('number')(row.c_totalAmt, 2);
    }
    vm.calculateSupervisorDetails = function () {
        var c_totalst = vm.supervisorDetails.c_totalst ? parseFloat(AppSvc.getAmount(vm.supervisorDetails.c_totalst)) : 0;
        var c_totalnd = vm.supervisorDetails.c_totalnd ? parseFloat(AppSvc.getAmount(vm.supervisorDetails.c_totalnd)) : 0;
        var TotalLeave = vm.supervisorDetails.TotalLeave ? parseFloat(AppSvc.getAmount(vm.supervisorDetails.TotalLeave)) : 0;
        var c_totalAmt = (c_totalst + c_totalnd) - TotalLeave;
        vm.supervisorDetails.c_totalAmt = filter("number")(c_totalAmt, 2);
    }
    vm.searchEmployee = function () {
        var options = {
            data: 'menu',
            templateUrl: BILLINGURL + 'oc_dearbc/employee_list.html?v=' + VERSION,
            controllerName: 'SearchEmployeeCtrl',
            viewSize: 'lg',
            filesToLoad: [
                BILLINGURL + 'oc_dearbc/controller.js?v=' + VERSION,
            ],
        };
        AppSvc.modal(options).then(function (data) {
            if (data) {
                vm.supervisorDetails.Chapa = data.ChapaID_New;
                var ExtName = data.ExtName != '' ? data.ExtName + " " : "";
                vm.supervisorDetails.Name = data.LName + ", " + ExtName + data.FName + " " + data.MName;
            }
        });
    }

    // Incentives
    vm.incentiveGrid = {
        enableRowSelection: true,
        enableCellEdit: false,
        enableColumnMenus: false,
        modifierKeysToMultiSelect: true,
        enableRowHeaderSelection: false,
        columnDefs: [
            { name: "Activity", field: "activity", width: "25%" },
            { name: "GL", field: "gl", width: "25%" },
            { name: "Cost Center", field: "cc", width: "25%" },
            { name: "Total Billing", field: "c_totalAmt", width: "25%", cellClass: "text-right", cellFilter: "number:2" },
        ],
        data: "vm.listIncentive",
        onRegisterApi: function (gridApi) {
            gridApi.selection.on.rowSelectionChanged(null, function (row) {
                vm.clickIncentive(row.entity);
            });
        }
    }
    vm.clickIncentive = function (row) {
        vm.incentiveDetails = angular.copy(row);
        vm.incentiveDetails.c_totalAmt = filter('number')(row.c_totalAmt, 2);
    }

    function datesAreOnSameDay(first, second) {
        return first.getFullYear() === second.getFullYear() &&
            first.getMonth() === second.getMonth() &&
            first.getDate() === second.getDate()
    }
}

function DMPIDARHeaderCtrl($scope, $ocLazyLoad, $injector, data, $uibModalInstance) {
    var modal = this;
    modal.data = [];
    modal.list = [];
    var defaultValue = 'GSMPC-';
    modal.variables = {};
    modal.search = defaultValue;
    modal.searchOptions = 1;
    $ocLazyLoad.load([
        BILLINGURL + 'dmpi_dar/service.js?v=' + VERSION,
    ]).then(function (d) {
        DMPIDARSvc = $injector.get('DMPIDARSvc');
        modal.displayPMY();
    });
    modal.displayPMY = function () {
        var dateNow = new Date();
        // modal.variables.month = new Date();
        if (dateNow.getDate() < 16) {
            modal.variables.period = 1;
        } else {
            modal.variables.period = 2;
        }
    }
    modal.getDefault = function () {
        if (!modal.search || defaultValue !== modal.search.substring(0, 6)) {
            modal.search = defaultValue;
        }
    }
    modal.defaultGrid = {
        enableRowSelection: true,
        enableCellEdit: false,
        enableColumnMenus: false,
        modifierKeysToMultiSelect: true,
        enableRowHeaderSelection: false,
        columnDefs: [
            { name: "SOA Number", displayName: 'SOA Number', field: "soaNumber", width: 200 },
            { name: "Batch Number", field: "batchNo", width: 200 },
            { name: "Period", field: "period", width: 200 },
            { name: "SOA Date", displayName: 'SOA Date', field: "soaDate", width: 200 },
            { name: "Encoded By", displayName: 'Encoded By', field: "adminencodedby", width: 200 },
            { name: "Created", displayName: 'Created', field: "created_at", width: 200 },
            { name: "Last Updated", displayName: 'Last Updated', field: "updated_at", width: 200 },
        ],
        data: "modal.list",
        onRegisterApi: function (gridApi) {
            gridApi.selection.on.rowSelectionChanged(null, function (row) {
                $uibModalInstance.close(row.entity)
            });
        }
    };

    modal.searching = function () {
        modal.variables.pmy = modal.variables.month.getFullYear() + "" + DMPIDARSvc.pad(modal.variables.month.getMonth() + 1, 2);
        var data = {};
        if (modal.searchOptions == 1) {
            data = {
                search: true,
                soaNumber: modal.search,
                pmy: modal.variables.pmy,
                period: modal.variables.period
            }
        } else {
            data = {
                searchByBatch: true,
                BatNo: modal.batchSearch,
                pmy: modal.variables.pmy,
                period: modal.variables.period
            }
        }
        DMPIDARSvc.get(data).then(function (response) {
            if (response.message) {
                modal.list = [];
            } else {
                modal.list = response;
            }
        })
    }

    modal.getActive = function () {
        DMPIDARSvc.get({ active: true }).then(function (response) {
            if (response.message) {
                modal.list = [];
            } else {
                modal.list = response;
            }
        })
    }

    modal.close = function () {
        $uibModalInstance.dismiss('cancel');
    }
}

function ReactivateDARCtrl($scope, $ocLazyLoad, $injector, data, $uibModalInstance) {
    var modal = this;
    modal.variables = {};
    modal.variables.id = data;
    modal.reactivate = function () {
        modal.variables.reactivate = true;
        DMPIDARSvc.save(modal.variables).then(function (response) {
            if (response.success) {
                $uibModalInstance.close(true);
                AppSvc.showSwal('Success', response.message, 'success');
            } else {
                AppSvc.showSwal('Error', response.message, 'error');
            }
        })
    }
    modal.close = function () {
        $uibModalInstance.dismiss('cancel');
    }
}

function TransmittalDARCtrl($scope, $ocLazyLoad, $injector, data, $uibModalInstance) {
    var modal = this;
    modal.variables = {};
    $ocLazyLoad.load([
        REPURL + 'dmpi_oc_reports/service.js?v=' + VERSION,
    ]).then(function (d) {
        TransmittalReportSvc = $injector.get('TransmittalReportSvc');
    });
    modal.printTransmittal = function () {
        modal.variables.exists = true;
        TransmittalReportSvc.get(modal.variables).then(function (response) {
            if (response.message) {
                return AppSvc.showSwal('Error', 'Nothing to Display', 'error');
            }
            window.open('report/dmpi_oc/transmittal_report?transmittalNo=' + modal.variables.transmittalNo);
        })
    }
    modal.close = function () {
        $uibModalInstance.dismiss('cancel');
    }
}

function DARLogCtrl($scope, $ocLazyLoad, $injector, data, $uibModalInstance){
    var modal = this;
    modal.id = data.id;
    modal.logs = [];
    $ocLazyLoad.load([
        BILLINGURL + 'dmpi_dar/service.js?v=' + VERSION,
    ]).then(function (d) {
        DMPIDARSvc = $injector.get('DMPIDARSvc');
        modal.getLogs();
    });
    modal.getLogs = function(){
        DMPIDARSvc.get({logs: true, id: modal.id}).then(function(response){
            if(!response.message){
                response.forEach(function(item){
                    item.date = new Date(item.log_date)
                })
                modal.logs = response;
            }else{
                modal.logs = [];
            }
        })
    }
    modal.defaultGrid = {
        enableRowSelection: true,
        enableCellEdit: false,
        enableColumnMenus: false,
        modifierKeysToMultiSelect: true,
        enableRowHeaderSelection: false,
        columnDefs: [
            { name: "Activity", field: "activity"},
            { name: "User", field: "user" },
            { name: "Date Time", field: "date", cellFilter: 'date:"MMM d, y hh:mm a"' },
        ],
        data: "modal.logs",
        onRegisterApi: function (gridApi) {
            // gridApi.selection.on.rowSelectionChanged(null, function (row) {
            //     vm.openDetails(row.entity);
            // });
        }
    }

    modal.close = function(){
        $uibModalInstance.dismiss('cancel');
    }
}