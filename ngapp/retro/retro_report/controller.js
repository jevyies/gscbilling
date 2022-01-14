angular.module('app')
    .controller('RetroReport', RetroReport)

RetroReport.$inject = ['$scope', '$ocLazyLoad', '$injector'];

function RetroReport($scope, $ocLazyLoad, $injector) {
    var vm = this;
    vm.variables = {};
    vm.variables.from = new Date();
    vm.variables.to = new Date();
    vm.variables.client = 'DAR';
    vm.details = [];
    $ocLazyLoad.load([RETROURL + 'retro_report/service.js?v=' + VERSION]).then(function (d) {
        RTSvc = $injector.get('RTSvc');
    });
    vm.generate = function () {
        var data = angular.copy(vm.variables);
        data.from = vm.variables.from ? AppSvc.getDate(vm.variables.from) : '0000-00-00';
        data.to = vm.variables.to ? AppSvc.getDate(vm.variables.to) : '0000-00-00';
        LOADING.classList.add('open');
        RTSvc.save(data).then(function (response) {
            if (response.message) {
                vm.details = [];
                AppSvc.showSwal('Confirmation', 'No data found', 'warning');
            } else {
                vm.details = response;
            }
            LOADING.classList.remove('open');
        })
    }
    vm.darGrid = {
        enableRowSelection: true,
        enableCellEdit: false,
        enableColumnMenus: false,
        modifierKeysToMultiSelect: false,
        enableRowHeaderSelection: false,
        enableFiltering: true,
        columnDefs: [
            { name: "Doc Date", field: "soaDate", width: 180 },
            { name: "Reference Doc Number", field: "soaNumber", width: 180 },
            { name: "Activity", field: "activity", width: 180 },
            { name: "GL", displayName: "GL", field: "gl", width: 180 },
            { name: "CC", displayName: "C/C", field: "cc", width: 180 },
            // Hrs 
            { name: "RDST(Hrs)", displayName: "RDST(Hrs)",field: "rdst_hrs", width: 180 },
            { name: "RDOT(Hrs)", displayName: "RDOT(Hrs)", field: "rdot_hrs", width: 180 },
            { name: "RDND(Hrs)", displayName: "RDND(Hrs)", field: "rdnd_hrs", width: 180 },
            { name: "RDNDOT(Hrs)", displayName: "RDNDOT(Hrs)", field: "rdndot_hrs", width: 180 },
            { name: "SHOLST(Hrs)", displayName: "SHOLST(Hrs)", field: "sholst_hrs", width: 180 },
            { name: "SHOLOT(Hrs)", displayName: "SHOLOT(Hrs)", field: "sholot_hrs", width: 180 },
            { name: "SHOLND(Hrs)", displayName: "SHOLND(Hrs)", field: "sholnd_hrs", width: 180 },
            { name: "SHOLNDOT(Hrs)", displayName: "SHOLNDOT(Hrs)", field: "sholndot_hrs", width: 180 },
            { name: "SHRDST(Hrs)", displayName: "SHRDST(Hrs)", field: "shrdst_hrs", width: 180 },
            { name: "SHRDOT(Hrs)", displayName: "SHRDOT(Hrs)", field: "shrdot_hrs", width: 180 },
            { name: "SHRDND(Hrs)", displayName: "SHRDND(Hrs)", field: "shrdnd_hrs", width: 180 },
            { name: "SHRDNDOT(Hrs)", displayName: "SHRDNDOT(Hrs)", field: "shrdndot_hrs", width: 180 },
            { name: "RHOLST(Hrs)", displayName: "RHOLST(Hrs)", field: "rholst_hrs", width: 180 },
            { name: "RHOLOT(Hrs)", displayName: "RHOLOT(Hrs)", field: "rholot_hrs", width: 180 },
            { name: "RHOLND(Hrs)", displayName: "RHOLND(Hrs)", field: "rholnd_hrs", width: 180 },
            { name: "RHOLNDOT(Hrs)", displayName: "RHOLNDOT(Hrs)", field: "rholndot_hrs", width: 180 },
            { name: "RHRDST(Hrs)", displayName: "RHRDST(Hrs)", field: "rhrdst_hrs", width: 180 },
            { name: "RHRDOT(Hrs)", displayName: "RHRDOT(Hrs)", field: "rhrdot_hrs", width: 180 },
            { name: "RHRDND(Hrs)", displayName: "RHRDND(Hrs)", field: "rhrdnd_hrs", width: 180 },
            { name: "RHRDNDOT(Hrs)", displayName: "RHRDNDOT(Hrs)", field: "rhrdndot_hrs", width: 180 },
            // OLD 
            { name: "RDST(Old)", displayName: "RDST(Old)",field: "rdst_old", width: 180 },
            { name: "RDOT(Old)", displayName: "RDOT(Old)", field: "rdot_old", width: 180 },
            { name: "RDND(Old)", displayName: "RDND(Old)", field: "rdnd_old", width: 180 },
            { name: "RDNDOT(Old)", displayName: "RDNDOT(Old)", field: "rdndot_old", width: 180 },
            { name: "SHOLST(Old)", displayName: "SHOLST(Old)", field: "sholst_old", width: 180 },
            { name: "SHOLOT(Old)", displayName: "SHOLOT(Old)", field: "sholot_old", width: 180 },
            { name: "SHOLND(Old)", displayName: "SHOLND(Old)", field: "sholnd_old", width: 180 },
            { name: "SHOLNDOT(Old)", displayName: "SHOLNDOT(Old)", field: "sholndot_old", width: 180 },
            { name: "SHRDST(Old)", displayName: "SHRDST(Old)", field: "shrdst_old", width: 180 },
            { name: "SHRDOT(Old)", displayName: "SHRDOT(Old)", field: "shrdot_old", width: 180 },
            { name: "SHRDND(Old)", displayName: "SHRDND(Old)", field: "shrdnd_old", width: 180 },
            { name: "SHRDNDOT(Old)", displayName: "SHRDNDOT(Old)", field: "shrdndot_old", width: 180 },
            { name: "RHOLST(Old)", displayName: "RHOLST(Old)", field: "rholst_old", width: 180 },
            { name: "RHOLOT(Old)", displayName: "RHOLOT(Old)", field: "rholot_old", width: 180 },
            { name: "RHOLND(Old)", displayName: "RHOLND(Old)", field: "rholnd_old", width: 180 },
            { name: "RHOLNDOT(Old)", displayName: "RHOLNDOT(Old)", field: "rholndot_old", width: 180 },
            { name: "RHRDST(Old)", displayName: "RHRDST(Old)", field: "rhrdst_old", width: 180 },
            { name: "RHRDOT(Old)", displayName: "RHRDOT(Old)", field: "rhrdot_old", width: 180 },
            { name: "RHRDND(Old)", displayName: "RHRDND(Old)", field: "rhrdnd_old", width: 180 },
            { name: "RHRDNDOT(Old)", displayName: "RHRDNDOT(Old)", field: "rhrdndot_old", width: 180 },
            // New 
            { name: "RDST(New)", displayName: "RDST(New)",field: "rdst_new", width: 180 },
            { name: "RDOT(New)", displayName: "RDOT(New)", field: "rdot_new", width: 180 },
            { name: "RDND(New)", displayName: "RDND(New)", field: "rdnd_new", width: 180 },
            { name: "RDNDOT(New)", displayName: "RDNDOT(New)", field: "rdndot_new", width: 180 },
            { name: "SHOLST(New)", displayName: "SHOLST(New)", field: "sholst_new", width: 180 },
            { name: "SHOLOT(New)", displayName: "SHOLOT(New)", field: "sholot_new", width: 180 },
            { name: "SHOLND(New)", displayName: "SHOLND(New)", field: "sholnd_new", width: 180 },
            { name: "SHOLNDOT(New)", displayName: "SHOLNDOT(New)", field: "sholndot_new", width: 180 },
            { name: "SHRDST(New)", displayName: "SHRDST(New)", field: "shrdst_new", width: 180 },
            { name: "SHRDOT(New)", displayName: "SHRDOT(New)", field: "shrdot_new", width: 180 },
            { name: "SHRDND(New)", displayName: "SHRDND(New)", field: "shrdnd_new", width: 180 },
            { name: "SHRDNDOT(New)", displayName: "SHRDNDOT(New)", field: "shrdndot_new", width: 180 },
            { name: "RHOLST(New)", displayName: "RHOLST(New)", field: "rholst_new", width: 180 },
            { name: "RHOLOT(New)", displayName: "RHOLOT(New)", field: "rholot_new", width: 180 },
            { name: "RHOLND(New)", displayName: "RHOLND(New)", field: "rholnd_new", width: 180 },
            { name: "RHOLNDOT(New)", displayName: "RHOLNDOT(New)", field: "rholndot_new", width: 180 },
            { name: "RHRDST(New)", displayName: "RHRDST(New)", field: "rhrdst_new", width: 180 },
            { name: "RHRDOT(New)", displayName: "RHRDOT(New)", field: "rhrdot_new", width: 180 },
            { name: "RHRDND(New)", displayName: "RHRDND(New)", field: "rhrdnd_new", width: 180 },
            { name: "RHRDNDOT(New)", displayName: "RHRDNDOT(New)", field: "rhrdndot_new", width: 180 },
            // Diff 
            { name: "RDST(Diff)", displayName: "RDST(Diff)",field: "rdst_diff", width: 180 },
            { name: "RDOT(Diff)", displayName: "RDOT(Diff)", field: "rdot_diff", width: 180 },
            { name: "RDND(Diff)", displayName: "RDND(Diff)", field: "rdnd_diff", width: 180 },
            { name: "RDNDOT(Diff)", displayName: "RDNDOT(Diff)", field: "rdndot_diff", width: 180 },
            { name: "SHOLST(Diff)", displayName: "SHOLST(Diff)", field: "sholst_diff", width: 180 },
            { name: "SHOLOT(Diff)", displayName: "SHOLOT(Diff)", field: "sholot_diff", width: 180 },
            { name: "SHOLND(Diff)", displayName: "SHOLND(Diff)", field: "sholnd_diff", width: 180 },
            { name: "SHOLNDOT(Diff)", displayName: "SHOLNDOT(Diff)", field: "sholndot_diff", width: 180 },
            { name: "SHRDST(Diff)", displayName: "SHRDST(Diff)", field: "shrdst_diff", width: 180 },
            { name: "SHRDOT(Diff)", displayName: "SHRDOT(Diff)", field: "shrdot_diff", width: 180 },
            { name: "SHRDND(Diff)", displayName: "SHRDND(Diff)", field: "shrdnd_diff", width: 180 },
            { name: "SHRDNDOT(Diff)", displayName: "SHRDNDOT(Diff)", field: "shrdndot_diff", width: 180 },
            { name: "RHOLST(Diff)", displayName: "RHOLST(Diff)", field: "rholst_diff", width: 180 },
            { name: "RHOLOT(Diff)", displayName: "RHOLOT(Diff)", field: "rholot_diff", width: 180 },
            { name: "RHOLND(Diff)", displayName: "RHOLND(Diff)", field: "rholnd_diff", width: 180 },
            { name: "RHOLNDOT(Diff)", displayName: "RHOLNDOT(Diff)", field: "rholndot_diff", width: 180 },
            { name: "RHRDST(Diff)", displayName: "RHRDST(Diff)", field: "rhrdst_diff", width: 180 },
            { name: "RHRDOT(Diff)", displayName: "RHRDOT(Diff)", field: "rhrdot_diff", width: 180 },
            { name: "RHRDND(Diff)", displayName: "RHRDND(Diff)", field: "rhrdnd_diff", width: 180 },
            { name: "RHRDNDOT(Diff)", displayName: "RHRDNDOT(Diff)", field: "rhrdndot_diff", width: 180 },
            // Adjustment
            { name: "Adjustment", field: "rhrdndot_diff", width: 180 },
            { name: "VAT", field: "rhrdndot_diff", width: 180 },
            { name: "Total Adjustment", field: "rhrdndot_diff", width: 180 },
            { name: "Actual Soa Amount", field: "rhrdndot_diff", width: 180 },
            
        ],
        data: "vm.details"
    };
    vm.downloadExcel = function () {
        window.open('report/retro_report?from=' + AppSvc.getDate(vm.variables.from) + '&to=' + AppSvc.getDate(vm.variables.to) + '&client='+vm.variables.client);
    }
    vm.searchLocation = function(){
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
                vm.variables.locationID = data.LocationID
                vm.variables.location = data.Location
            }
        });
    }
    // other client
    vm.searchPayrollPeriod = function() {
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
                vm.variables.period = data.xPeriod.toString() + data.xPhase.toString();
                vm.variables.period_date = data.period_date;
            }
        });
    }
    vm.getSlersUploads = function(){
        RTSvc.get({type: 'slers', uploads: true}).then(function(response) {
            if (response) {
                vm.slersUploads = response;
                console.log(response);
            }
        })
    }
    vm.generateOC = function () {
        // var data = {};
        // RTSvc.save(data).then(function (response) {
        //     if (response.message) {
        //         vm.details = [];
        //         AppSvc.showSwal('Confirmation', 'No data found', 'warning');
        //     } else {
        //         vm.details = response;
        //     }
        // })
    }
}