angular.module('app')
    .controller('DARSOAMonitoringCtrl', DARSOAMonitoringCtrl)

DARSOAMonitoringCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector', '$filter'];

function DARSOAMonitoringCtrl($scope, $ocLazyLoad, $injector, filter) {
    var vm = this;
    var stop;
    var $interval = $injector.get('$interval');
    var defaultValue = 'GSMPC-';
    vm.variables = {};
    vm.variables.period = 1;
    vm.variables.status = 'PENDING';
    vm.variables.from = new Date();
    vm.variables.to = new Date();
    vm.variables.month = new Date();
    vm.statusFiltered = [];
    vm.filtered = [];
    vm.soaNumber = defaultValue;
    vm.supervisorOnly = false;
    $ocLazyLoad.load([
        MONURL + 'dar_soa/service.js?v=' + VERSION,
    ]).then(function (d) {
        DSMonitoringSvc = $injector.get('DSMonitoringSvc');
        vm.displayPMY();
    });
    vm.displayPMY = function () {
        var dateNow = new Date();
        vm.variables.pmy = dateNow.getFullYear() + "" + DSMonitoringSvc.pad(dateNow.getMonth() + 1, 2);
    }
    vm.searchPP = function () {
        vm.searchBy = 'PP';
        vm.variables.pmy = vm.variables.month.getFullYear() + AppSvc.pad(vm.variables.month.getMonth() + 1, 2);
        var data = angular.copy(vm.variables);
        data.searchPP = true;
        LOADING.classList.add("open");
        DSMonitoringSvc.get(data).then(function (response) {
            vm.totalAmount = 0;
            if (response.message) {
                vm.list = [];
            } else {
                var no = 1;
                var sum = 0;
                response.forEach(function (item) {
                    item.No = no++;
                    item.status = item.Status ? item.Status.toUpperCase() : 'PENDING';
                    item.amount = item.Amount ? parseFloat(item.Amount) : 0;
                    sum = sum + item.amount;
                })
                vm.totalAmount = angular.copy(sum);
                vm.list = response;
            }
            vm.filtered = vm.list;
            LOADING.classList.remove("open");
        })
    }
    vm.searchDateRange = function () {
        vm.searchBy = 'DR';
        var data = angular.copy(vm.variables);
        data.from = AppSvc.getDate(vm.variables.from);
        data.to = AppSvc.getDate(vm.variables.to);
        data.searchDR = true;
        LOADING.classList.add("open");
        DSMonitoringSvc.get(data).then(function (response) {
            vm.totalAmount = 0;
            if (response.message) {
                vm.list = [];
            } else {
                var no = 1;
                var sum = 0;
                response.forEach(function (item) {
                    item.No = no++;
                    item.status = item.Status ? item.Status.toUpperCase() : 'PENDING';
                    item.amount = item.Amount ? parseFloat(item.Amount) : 0;
                    sum = sum + item.amount;
                })
                vm.totalAmount = angular.copy(sum);
                vm.list = response;
            }
            vm.filtered = vm.list;
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
            { name: " ", cellTemplate: '<div class="d-flex-center pointer" ng-click="grid.appScope.vm.detailsClick(row.entity)"><span ng-class="grid.appScope.vm.checkFlag( row.entity.checkFlag )"></span></div>', width: 20 },
            { name: "No.", field: "No", width: 100 },
            { name: "SOA No", displayName: 'SOA No', field: "SOANumber", width: 200 },
            { name: "Batch No", field: "Batches", width: 200 },
            { name: "SOA Date", displayName: 'SOA Date', field: "soaDate", width: 200, cellFilter: 'date:MM/dd/yyyy' },
            { name: "Location", displayName: 'Location', field: "Location", width: 200 },
            { name: "Period", displayName: 'Period', field: "PPeriod", width: 200 },
            { name: "Status", field: "status", width: 200 },
            { name: "ST", displayName: 'ST', field: "STSum", width: 200, cellClass: 'text-right', cellFilter: 'number:2' },
            { name: "OT", displayName: 'OT', field: "OTSum", width: 200, cellClass: 'text-right', cellFilter: 'number:2' },
            { name: "ND", displayName: 'ND', field: "NDSum", width: 200, cellClass: 'text-right', cellFilter: 'number:2' },
            { name: "NDOT", displayName: 'NDOT', field: "NDOTSum", width: 200, cellClass: 'text-right', cellFilter: 'number:2' },
            { name: "Amount", field: "Amount", width: 200, cellClass: 'text-right', cellFilter: 'number:2' },
            { name: "Transmittal No", field: "TransmittalNo", width: 200 },
            { name: "Date Transmitted to Accounting", field: "DateTransmitted", cellFilter: 'date:MM/dd/yyyy', width: 200 },
            { name: "Remarks", field: "Remarks", width: 200 },
            { name: "Batch By", field: "BatchedBy", width: 200 },
            { name: "Uploaded By", field: "UploadedBy", width: 200 },
            { name: "Confirmed By", field: "ConfirmedBy", width: 200 },
        ],
        data: "vm.filtered",
        exporterMenuCsv: false,
        exporterMenuExcel: false,
        exporterMenuPdf: false,
        exporterExcelFilename: 'SOA Monitoring.xlsx',
        exporterExcelSheetName: 'Sheet1',
        onRegisterApi: function (gridApi) {
            vm.gridApi = gridApi;
        }
    }
    vm.detailsClick = function(row){
        if(row.BID == 0){
            return AppSvc.showSwal('Confirmation', 'Cannot Edit this batch', 'warning');
        }
        var index = vm.list.indexOf(row);
        row.checkFlag = row.checkFlag == 0 ? 1 : 0;
        DSMonitoringSvc.save({id: row.BID, checkFlag: row.checkFlag}).then(function (response) {
            if(response.success){
                vm.list.splice(index, 1, row);
                vm.filtered = vm.list;
            }else{
                return AppSvc.showSwal('Confirmation', response.message, 'warning');
            }
        })
        
    }
    vm.checkFlag = function(flag){
        if(flag == 0){
            return 'fa fa-times text-danger';
        }else{
            return 'fa fa-check text-success';
        }
    }
    vm.changeStatus = function (status) {
        vm.supervisorOnly = false;
        vm.list = [];
        if(vm.searchBy === 'PP'){
            vm.searchPP();
        }else{
            vm.searchDateRange();
        }
        vm.searchSOA(true);
    }
    vm.searchSOA = function (bool) {
        if (bool) {
            vm.filtered = vm.list;
        } else {
            if (defaultValue !== vm.soaNumber.substring(0, 6)) {
                vm.soaNumber = defaultValue;
                vm.filtered = vm.list;
            } else {
                return vm.filtered = filter('filter')(vm.list, { SOANumber: vm.soaNumber });
            }
        }
    }
    vm.checkSupervisorOnly = function () {
        if (vm.supervisorOnly) {
            return vm.filtered = filter('filter')(vm.statusFiltered, { detailType: "2" });
        } else {
            vm.filtered = vm.statusFiltered;
        }
    }
    vm.exportExcel = function () {
        vm.gridApi.exporter.excelExport('visible', 'visible', 'all');
    }
    vm.exportSupervisorExcel = function () {
        if (vm.filtered.lenth < 1) {
            return AppSvc.showSwal("Warning", "Nothing to print.", "warning");
        }
        if (!vm.supervisorOnly) {
            return AppSvc.showSwal("Requirement", "Please check the 'Supervisor Entry Only' to see if there are data to print.", "warning");
        }
        vm.filtered.forEach(function (item) {
            window.open('api/dar_soa_monitoring?ExcelSupervisor=true&SOANumber=' + item.SOANumber);
        })
    }
    vm.changeCheckedPending = function(type){
        if(type === 'all'){
            vm.filtered = vm.list;
        }else {
            vm.filtered = filter('filter')(vm.list, { checkFlag: type });
        }
    }
}