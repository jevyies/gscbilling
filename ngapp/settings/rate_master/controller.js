angular.module('app')
    .controller('RateCtrl', RateCtrl)
    .controller('DARRateCtrl', DARRateCtrl)
    .controller('UploadDARRateCtrl', UploadDARRateCtrl)
    .controller('SARRateCtrl', SARRateCtrl)
    .controller('BCCRateCtrl', BCCRateCtrl)
    .controller('SlersRateCtrl', SlersRateCtrl)
    .controller('ClubHouseRateCtrl', ClubHouseRateCtrl)
    .controller('ConstructionRateCtrl', ConstructionRateCtrl)
    .controller('ReactivateRateCtrl', ReactivateRateCtrl)

RateCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector'];
DARRateCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector', 'data', '$uibModalInstance'];
UploadDARRateCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector', 'data', '$uibModalInstance', '$q'];
SARRateCtrl = ['$scope', '$ocLazyLoad', '$injector', 'data', '$uibModalInstance'];
BCCRateCtrl = ['$scope', '$ocLazyLoad', '$injector', 'data', '$uibModalInstance'];
SlersRateCtrl = ['$scope', '$ocLazyLoad', '$injector', 'data', '$uibModalInstance'];
ClubHouseRateCtrl = ['$scope', '$ocLazyLoad', '$injector', 'data', '$uibModalInstance'];
ConstructionRateCtrl = ['$scope', '$ocLazyLoad', '$injector', 'data', '$uibModalInstance'];
ReactivateRateCtrl = ['$scope', '$ocLazyLoad', '$injector', 'data', '$uibModalInstance'];

function RateCtrl($scope, $ocLazyLoad, $injector) {
    var vm = this;
    vm.data = [];
    vm.list = [];
    vm.listSAR = [];
    vm.dataBCC = [];
    vm.listBCC = [];
    vm.dataSlers = [];
    vm.listSlers = [];
    vm.dataClubhouse = [];
    vm.listClubhouse = [];
    vm.dataConstruction = [];
    vm.listConstruction = [];
    vm.type = 'DAR';
    $ocLazyLoad.load([
        SETTINGSURL + 'rate_master/service.js?v=' + VERSION,
    ]).then(function (d) {
        RateSvc = $injector.get('RateSvc');
        vm.getRates()
    });
    vm.changeType = function () {
        if (vm.type === 'DAR' && !vm.loadedDAR) {
            vm.getRates();
        }
        if (vm.type === 'SAR' && !vm.loadedSAR) {
            vm.getSARRates()
        }
        if (vm.type === 'BCC' && !vm.loadedBCC) {
            vm.getBCCRates()
        }
        if (vm.type === 'SLERS' && !vm.loadedSlers) {
            vm.getSlersRates()
        }
        if (vm.type === 'CLUBHOUSE' && !vm.loadedSlers) {
            vm.getClubhouseRates()
        }
        if (vm.type === 'CONSTRUCTION' && !vm.loadedSlers) {
            vm.getConstructionRates()
        }
    }
    vm.getRates = function () {
        LOADING.classList.add("open");
        RateSvc.get().then(function (response) {
            if (response.message) {
                vm.data = [];
            } else {
                response.forEach(function(item){
                    item.dateUploaded = item.created_at ? new Date(item.created_at) : '';
                })
                vm.data = response;
            }
            vm.list = vm.data;
            vm.loadedDAR = true;
            LOADING.classList.remove("open");
        })
    }
    vm.getSARRates = function () {
        LOADING.classList.add("open");
        RateSvc.get({ sar: true }).then(function (response) {
            if (response.message) {
                vm.listSAR = [];
            } else {
                vm.listSAR = response;
            }
            vm.loadedSAR = true;
            LOADING.classList.remove("open");
        })
    }
    vm.getBCCRates = function () {
        LOADING.classList.add("open");
        RateSvc.get({ bcc: true }).then(function (response) {
            if (response.message) {
                vm.listBCC = [];
            } else {
                vm.listBCC = response;
            }
            vm.dataBCC = vm.listBCC;
            vm.loadedBCC = true;
            LOADING.classList.remove("open");
        })
    }
    vm.getSlersRates = function () {
        LOADING.classList.add("open");
        RateSvc.get({ slers: true }).then(function (response) {
            if (response.message) {
                vm.listSlers = [];
            } else {
                vm.listSlers = response;
            }
            vm.dataSlers = vm.listSlers;
            vm.loadedSlers = true;
            LOADING.classList.remove("open");
        })
    }
    vm.getClubhouseRates = function () {
        LOADING.classList.add("open");
        RateSvc.get({ clubhouse: true }).then(function (response) {
            if (response.message) {
                vm.listClubhouse = [];
            } else {
                vm.listClubhouse = response;
            }
            vm.dataClubhouse = vm.listClubhouse;
            vm.loadedClubhouse = true;
            LOADING.classList.remove("open");
        })
    }
    vm.getConstructionRates = function () {
        LOADING.classList.add("open");
        RateSvc.get({ construction: true }).then(function (response) {
            if (response.message) {
                vm.listConstruction = [];
            } else {
                vm.listConstruction = response;
            }
            vm.dataConstruction = vm.listConstruction;
            vm.loadedConstruction = true;
            LOADING.classList.remove("open");
        })
    }
    vm.defaultGrid = {
        enableRowSelection: true,
        enableCellEdit: false,
        enableColumnMenus: false,
        modifierKeysToMultiSelect: true,
        enableRowHeaderSelection: false,
        enableFiltering: true,
        enableGridMenu: true,
        exporterMenuCsv: false,
        exporterMenuExcel: true,
        exporterMenuPdf: false,
        exporterExcelFilename: 'DAR Rate List.xlsx',
        exporterExcelSheetName: 'Sheet1',
        columnDefs: [
            { name: "Location", field: "location_fr_mg", width: 300, hidePinLeft: false },
            { name: "Activity", field: "activity_fr_mg", width: 280, pinnedLeft: true },
            { name: "gl", field: "gl_fr_mg", displayName: 'gl', width: 140 },
            { name: "costcenter", field: "costcenter__", displayName: 'costcenter', width: 140 },
            { name: "status", field: "status", displayName: 'status', width: 120 },
            { name: "rd-st", field: "rd_st", displayName: 'rd-st', width: 120 },
            { name: "rd-ot", field: "rd_ot", displayName: 'rd-ot', width: 120 },
            { name: "rd-nd", field: "rd_nd", displayName: 'rd-nd', width: 120 },
            { name: "rd-ndot", field: "rd_ndot", displayName: 'rd-ndot', width: 120 },
            { name: "shol-st", field: "shol_st", displayName: 'shol-st', width: 120 },
            { name: "shol-ot", field: "shol_ot", displayName: 'shol-ot', width: 120 },
            { name: "shol-nd", field: "shol_nd", displayName: 'shol-nd', width: 120 },
            { name: "shol-ndot", field: "shol_ndot", displayName: 'shol-ndot', width: 120 },
            { name: "rhol-st", field: "rhol_st", displayName: 'rhol-st', width: 120 },
            { name: "rhol-ot", field: "rhol_ot", displayName: 'rhol-ot', width: 120 },
            { name: "rhol-nd", field: "rhol_nd", displayName: 'rhol-nd', width: 120 },
            { name: "rhol-ndot", field: "rhol_ndot", displayName: 'rhol-ndot', width: 120 },
            { name: "rt-st", field: "rt_st", displayName: 'rt-st', width: 120 },
            { name: "rt-ot", field: "rt_ot", displayName: 'rt-ot', width: 120 },
            { name: "rt-nd", field: "rt_nd", displayName: 'rt-nd', width: 120 },
            { name: "rt-ndot", field: "rt_ndot", displayName: 'rt-ndot', width: 120 },
            { name: "shrd-st", field: "shrd_st", displayName: 'shrd-st', width: 120 },
            { name: "shrd-ot", field: "shrd_ot", displayName: 'shrd-ot', width: 120 },
            { name: "shrd-nd", field: "shrd_nd", displayName: 'shrd-nd', width: 120 },
            { name: "shrd-ndot", field: "shrd_ndot", displayName: 'shrd-ndot', width: 120 },
            { name: "rhrd-st", field: "rhrd_st", displayName: 'rhrd-st', width: 120 },
            { name: "rhrd-ot", field: "rhrd_ot", displayName: 'rhrd-ot', width: 120 },
            { name: "rhrd-nd", field: "rhrd_nd", displayName: 'rhrd-nd', width: 120 },
            { name: "rhrd-ndot", field: "rhrd_ndot", displayName: 'rhrd-ndot', width: 120 },
            { name: "Uploaded By", field: "UploadedBy", width: 180 },
            { name: "Upload Date", field: "dateUploaded", width: 180, cellFilter: 'date:"MMM d, y hh:mm a"' },
        ],
        data: "vm.list",
        onRegisterApi: function (gridApi) {
            vm.DARGrid = gridApi;
            gridApi.selection.on.rowSelectionChanged(null, function (row) {
                vm.DarRate(row.entity);
            });
        }
    };
    vm.defaultGridBCC = {
        enableRowSelection: true,
        enableCellEdit: false,
        enableColumnMenus: false,
        modifierKeysToMultiSelect: true,
        enableRowHeaderSelection: false,
        columnDefs: [
            { name: "gl", field: "gl_fr_mg", displayName: 'gl', width: 140, hidePinLeft: false, },
            { name: "Activity", field: "activity_fr_mg", width: 300, pinnedLeft: true },
            { name: "costcenter", field: "costcenter__", displayName: 'costcenter', width: 140 },
            { name: "status", field: "status", displayName: 'status', width: 120 },
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
            { name: "2xrhol-st", field: "rhol_st2x", displayName: '2xrhol-st', width: 120 },
            { name: "2xrhol-ot", field: "rhol_ot2x", displayName: '2xrhol-ot', width: 120 },
            { name: "2xrhol-nd", field: "rhol_nd2x", displayName: '2xrhol-nd', width: 120 },
            { name: "2xrhol-ndot", field: "rhol_ndot2x", displayName: '2xrhol-ndot', width: 120 },
            { name: "2xrholrd-st", field: "rholrd_st2x", displayName: '2xrholrd-st', width: 120 },
            { name: "2xrholrd-ot", field: "rholrd_ot2x", displayName: '2xrholrd-ot', width: 120 },
            { name: "2xrholrd-nd", field: "rholrd_nd2x", displayName: '2xrholrd-nd', width: 120 },
            { name: "2xrholrd-ndot", field: "rholrd_ndot2x", displayName: '2xrholrd-ndot', width: 120 },
        ],
        data: "vm.listBCC",
        onRegisterApi: function (gridApi) {
            gridApi.selection.on.rowSelectionChanged(null, function (row) {
                vm.BCCRate(row.entity);
            });
        }
    };
    vm.defaultGridSlers = {
        enableRowSelection: true,
        enableCellEdit: false,
        enableColumnMenus: false,
        modifierKeysToMultiSelect: true,
        enableRowHeaderSelection: false,
        columnDefs: [
            { name: "gl", field: "gl_fr_mg", displayName: 'gl', width: 140, hidePinLeft: false, },
            { name: "Activity", field: "activity_fr_mg", width: 300, pinnedLeft: true },
            { name: "costcenter", field: "costcenter__", displayName: 'costcenter', width: 140 },
            { name: "status", field: "status", displayName: 'status', width: 120 },
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
            { name: "2xrhol-st", field: "rhol_st2x", displayName: 'rhol-st2x', width: 120 },
            { name: "2xrhol-ot", field: "rhol_ot2x", displayName: 'rhol-ot2x', width: 120 },
            { name: "2xrhol-nd", field: "rhol_nd2x", displayName: 'rhol-nd2x', width: 120 },
            { name: "2xrhol-ndot", field: "rhol_ndot2x", displayName: 'rhol-ndot2x', width: 120 },
            { name: "2xrholrd-st", field: "rholrd_st2x", displayName: 'rholrd-st2x', width: 120 },
            { name: "2xrholrd-ot", field: "rholrd_ot2x", displayName: 'rholrd-ot2x', width: 120 },
            { name: "2xrholrd-nd", field: "rholrd_nd2x", displayName: 'rholrd-nd2x', width: 120 },
            { name: "2xrholrd-ndot", field: "rholrd_ndot2x", displayName: 'rholrd-ndot2x', width: 120 },
        ],
        data: "vm.listSlers",
        onRegisterApi: function (gridApi) {
            gridApi.selection.on.rowSelectionChanged(null, function (row) {
                vm.SlersRate(row.entity);
            });
        }
    };
    vm.defaultGridClubhouse = {
        enableRowSelection: true,
        enableCellEdit: false,
        enableColumnMenus: false,
        modifierKeysToMultiSelect: true,
        enableRowHeaderSelection: false,
        columnDefs: [
            { name: "gl", field: "gl_fr_mg", displayName: 'gl', width: 140, hidePinLeft: false, },
            { name: "Activity", field: "activity_fr_mg", width: 300, pinnedLeft: true },
            { name: "costcenter", field: "costcenter__", displayName: 'costcenter', width: 140 },
            { name: "status", field: "status", displayName: 'status', width: 120 },
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
            { name: "2xrhol-st", field: "rhol_st2x", displayName: 'rhol-st2x', width: 120 },
            { name: "2xrhol-ot", field: "rhol_ot2x", displayName: 'rhol-ot2x', width: 120 },
            { name: "2xrhol-nd", field: "rhol_nd2x", displayName: 'rhol-nd2x', width: 120 },
            { name: "2xrhol-ndot", field: "rhol_ndot2x", displayName: 'rhol-ndot2x', width: 120 },
            { name: "2xrholrd-st", field: "rholrd_st2x", displayName: 'rholrd-st2x', width: 120 },
            { name: "2xrholrd-ot", field: "rholrd_ot2x", displayName: 'rholrd-ot2x', width: 120 },
            { name: "2xrholrd-nd", field: "rholrd_nd2x", displayName: 'rholrd-nd2x', width: 120 },
            { name: "2xrholrd-ndot", field: "rholrd_ndot2x", displayName: 'rholrd-ndot2x', width: 120 },
        ],
        data: "vm.listClubhouse",
        onRegisterApi: function (gridApi) {
            gridApi.selection.on.rowSelectionChanged(null, function (row) {
                vm.ClubhouseRate(row.entity);
            });
        }
    };
    vm.defaultGridConstruction = {
        enableRowSelection: true,
        enableCellEdit: false,
        enableColumnMenus: false,
        modifierKeysToMultiSelect: true,
        enableRowHeaderSelection: false,
        columnDefs: [
            { name: "gl", field: "gl_fr_mg", displayName: 'gl', width: 140, hidePinLeft: false, },
            { name: "Activity", field: "activity_fr_mg", width: 300, pinnedLeft: true },
            { name: "costcenter", field: "costcenter__", displayName: 'costcenter', width: 140 },
            { name: "status", field: "status", displayName: 'status', width: 120 },
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
            { name: "2xrhol-st", field: "rhol_st2x", displayName: 'rhol-st2x', width: 120 },
            { name: "2xrhol-ot", field: "rhol_ot2x", displayName: 'rhol-ot2x', width: 120 },
            { name: "2xrhol-nd", field: "rhol_nd2x", displayName: 'rhol-nd2x', width: 120 },
            { name: "2xrhol-ndot", field: "rhol_ndot2x", displayName: 'rhol-ndot2x', width: 120 },
            { name: "2xrholrd-st", field: "rholrd_st2x", displayName: 'rholrd-st2x', width: 120 },
            { name: "2xrholrd-ot", field: "rholrd_ot2x", displayName: 'rholrd-ot2x', width: 120 },
            { name: "2xrholrd-nd", field: "rholrd_nd2x", displayName: 'rholrd-nd2x', width: 120 },
            { name: "2xrholrd-ndot", field: "rholrd_ndot2x", displayName: 'rholrd-ndot2x', width: 120 },
        ],
        data: "vm.listConstruction",
        onRegisterApi: function (gridApi) {
            gridApi.selection.on.rowSelectionChanged(null, function (row) {
                vm.ConstructionRate(row.entity);
            });
        }
    };
    vm.defaultSARGrid = {
        enableRowSelection: true,
        enableCellEdit: false,
        enableColumnMenus: false,
        modifierKeysToMultiSelect: true,
        enableRowHeaderSelection: false,
        columnDefs: [
            { name: "Activity", field: "activity", width: 300 },
            { name: "rd-rate", field: "rd_rate", width: 300 },
            { name: "shol-rate", field: "shol_rate", width: 300 },
            { name: "shrd-rate", field: "shrd_rate", width: 300 },
            { name: "rhol-rate", field: "rhol_rate", width: 300 },
            { name: "rhrd-rate", field: "rhrd_rate", width: 300 },
        ],
        data: "vm.listSAR",
        onRegisterApi: function (gridApi) {
            gridApi.selection.on.rowSelectionChanged(null, function (row) {
                vm.SarRate(row.entity);
            });
        }
    }
    vm.DarRate = function (row) {
        var data = 'menu';
        if (row) {
            row.index = vm.data.indexOf(row);
            data = angular.copy(row);
        }
        var options = {
            data: data,
            animation: true,
            templateUrl: SETTINGSURL + "rate_master/add_rate_dar.html?v=" + VERSION,
            controllerName: "DARRateCtrl",
            viewSize: "lg",
            filesToLoad: [
                SETTINGSURL + "rate_master/add_rate_dar.html?v=" + VERSION,
                SETTINGSURL + "rate_master/controller.js?v=" + VERSION
            ]
        };
        AppSvc.modal(options).then(function (data) {
            if (data) {
                if (row) {
                    if (data.delete) {
                        vm.data.splice(row.index, 1);
                    } else {
                        vm.data.splice(row.index, 1, data);
                    }
                } else {
                    vm.data.push(data);
                }
                vm.list = vm.data;
            }
        });
    }
    vm.SarRate = function (row) {
        var data = 'menu';
        if (row) {
            row.index = vm.data.indexOf(row);
            data = angular.copy(row);
        }
        var options = {
            data: data,
            animation: true,
            templateUrl: SETTINGSURL + "rate_master/add_rate_sar.html?v=" + VERSION,
            controllerName: "SARRateCtrl",
            viewSize: "lg",
            filesToLoad: [
                SETTINGSURL + "rate_master/add_rate_sar.html?v=" + VERSION,
                SETTINGSURL + "rate_master/controller.js?v=" + VERSION
            ]
        };
        AppSvc.modal(options).then(function (data) {
            if (data) {
                if (row) {
                    vm.listSAR.splice(row.index, 1, data);
                } else {
                    vm.listSAR.push(data);
                }
            }
        });
    }
    vm.BCCRate = function (row) {
        var data = 'menu';
        if (row) {
            row.index = vm.data.indexOf(row);
            data = angular.copy(row);
        }
        var options = {
            data: data,
            animation: true,
            templateUrl: SETTINGSURL + "rate_master/add_rate_bcc.html?v=" + VERSION,
            controllerName: "BCCRateCtrl",
            viewSize: "lg",
            filesToLoad: [
                SETTINGSURL + "rate_master/add_rate_bcc.html?v=" + VERSION,
                SETTINGSURL + "rate_master/controller.js?v=" + VERSION
            ]
        };
        AppSvc.modal(options).then(function (data) {
            if (data) {
                vm.getBCCRates();
            }
        });
    }
    vm.SlersRate = function (row) {
        var data = 'menu';
        if (row) {
            row.index = vm.data.indexOf(row);
            data = angular.copy(row);
        }
        var options = {
            data: data,
            animation: true,
            templateUrl: SETTINGSURL + "rate_master/add_rate_slers.html?v=" + VERSION,
            controllerName: "SlersRateCtrl",
            viewSize: "lg",
            filesToLoad: [
                SETTINGSURL + "rate_master/add_rate_slers.html?v=" + VERSION,
                SETTINGSURL + "rate_master/controller.js?v=" + VERSION
            ]
        };
        AppSvc.modal(options).then(function (data) {
            if (data) {
                vm.getSlersRates();
            }
        });
    }
    vm.ClubhouseRate = function (row) {
        var data = 'menu';
        if (row) {
            row.index = vm.data.indexOf(row);
            data = angular.copy(row);
        }
        var options = {
            data: data,
            animation: true,
            templateUrl: SETTINGSURL + "rate_master/add_rate_clubhouse.html?v=" + VERSION,
            controllerName: "ClubHouseRateCtrl",
            viewSize: "lg",
            filesToLoad: [
                SETTINGSURL + "rate_master/add_rate_clubhouse.html?v=" + VERSION,
                SETTINGSURL + "rate_master/controller.js?v=" + VERSION
            ]
        };
        AppSvc.modal(options).then(function (data) {
            if (data) {
                vm.getClubhouseRates();
            }
        });
    }
    vm.ConstructionRate = function (row) {
        var data = 'menu';
        if (row) {
            row.index = vm.data.indexOf(row);
            data = angular.copy(row);
        }
        var options = {
            data: data,
            animation: true,
            templateUrl: SETTINGSURL + "rate_master/add_rate_construction.html?v=" + VERSION,
            controllerName: "ConstructionRateCtrl",
            viewSize: "lg",
            filesToLoad: [
                SETTINGSURL + "rate_master/add_rate_construction.html?v=" + VERSION,
                SETTINGSURL + "rate_master/controller.js?v=" + VERSION
            ]
        };
        AppSvc.modal(options).then(function (data) {
            if (data) {
                vm.getConstructionRates();
            }
        });
    }
    vm.reactivateRate = function () {
        var options = {
            data: 'menu',
            animation: true,
            templateUrl: SETTINGSURL + "rate_master/reactivate_rate.html?v=" + VERSION,
            controllerName: "ReactivateRateCtrl",
            viewSize: "md",
            filesToLoad: [
                SETTINGSURL + "rate_master/reactivate_rate.html?v=" + VERSION,
                SETTINGSURL + "rate_master/controller.js?v=" + VERSION
            ]
        };
        AppSvc.modal(options);
    }
}

function DARRateCtrl($scope, $ocLazyLoad, $injector, data, $uibModalInstance) {
    var modal = this;
    modal.variables = {};
    if (data.id) {
        modal.variables = angular.copy(data);
    }
    $ocLazyLoad.load([
        SETTINGSURL + 'rate_master/service.js?v=' + VERSION,
    ]).then(function (d) {
        RateSvc = $injector.get('RateSvc');
    });

    modal.searchLocation = function () {
        var options = {
            data: data,
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
                modal.variables.locationID = data.LocationID
                modal.variables.location_fr_mg = data.Location
            }
        });
    }

    modal.searchActivity = function () {
        var options = {
            data: 'menu',
            animation: true,
            templateUrl: SETTINGSURL + "activity_master/activity_modal.html?v=" + VERSION,
            controllerName: "ActivityViewCtrl",
            viewSize: "md",
            filesToLoad: [
                SETTINGSURL + "activity_master/activity_modal.html?v=" + VERSION,
                SETTINGSURL + "activity_master/controller.js?v=" + VERSION
            ]
        };
        AppSvc.modal(options).then(function (data) {
            if (data) {
                modal.variables.activityID = data.id;
                modal.variables.activity_fr_mg = data.activity;
            }
        });
    }

    modal.searchGL = function () {
        var options = {
            data: 'dar',
            animation: true,
            templateUrl: SETTINGSURL + "gl_master/gl_modal.html?v=" + VERSION,
            controllerName: "GLViewCtrl",
            viewSize: "md",
            filesToLoad: [
                SETTINGSURL + "gl_master/gl_modal.html?v=" + VERSION,
                SETTINGSURL + "gl_master/controller.js?v=" + VERSION
            ]
        };
        AppSvc.modal(options).then(function (data) {
            if (data) {
                modal.variables.glID = data.id;
                modal.variables.gl_fr_mg = data.gl;
            }
        });
    }

    modal.searchCC = function () {
        var options = {
            data: 'menu',
            animation: true,
            templateUrl: SETTINGSURL + "cost_center_master/cost_center_modal.html?v=" + VERSION,
            controllerName: "CostCenterViewCtrl",
            viewSize: "md",
            filesToLoad: [
                SETTINGSURL + "cost_center_master/cost_center_modal.html?v=" + VERSION,
                SETTINGSURL + "cost_center_master/controller.js?v=" + VERSION
            ]
        };
        AppSvc.modal(options).then(function (data) {
            if (data) {
                modal.variables.costCenterID = data.id;
                modal.variables.costcenter__ = data.costcenter;
            }
        });
    }
    modal.save = function () {
        if (modal.variables.status === 'previous') {
            return AppSvc.showSwal('Ooops', 'Cannot Update this Rate', 'warning');
        }
        if (!modal.variables.locationID) {
            return AppSvc.showSwal('Ooops', 'Select Location first', 'warning');
        }
        if (!modal.variables.activityID) {
            return AppSvc.showSwal('Ooops', 'Select Activity first', 'warning');
        }
        if (!modal.variables.glID) {
            return AppSvc.showSwal('Ooops', 'Select GL first', 'warning');
        }
        if (!modal.variables.costCenterID) {
            return AppSvc.showSwal('Ooops', 'Select Cost Center first', 'warning');
        }
        LOADING.classList.add("open");
        RateSvc.save(modal.variables).then(function (response) {
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
    modal.upload = function () {
        var options = {
            data: 'menu',
            animation: true,
            templateUrl: SETTINGSURL + "rate_master/upload_excel_dar.html?v=" + VERSION,
            controllerName: "UploadDARRateCtrl",
            viewSize: "md",
            filesToLoad: [
                SETTINGSURL + "rate_master/upload_excel_dar.html?v=" + VERSION,
                SETTINGSURL + "rate_master/controller.js?v=" + VERSION
            ]
        };
        AppSvc.modal(options);
    }
    modal.delete = function () {
        AppSvc.confirmation('Confirm Deletion?', 'Are you sure you want to delete this record?', 'Delete', 'Cancel', true).then(function (data) {
            if (data) {
                RateSvc.save({ deleteDAR: true, id: modal.variables.id }).then(function (response) {
                    if (response.success) {
                        $uibModalInstance.close({ delete: true });
                        AppSvc.showSwal('Success', response.message, 'success');
                    } else {
                        AppSvc.showSwal('Error', response.message, 'error');
                    }
                })
            }
        })
    }
    modal.close = function () {
        $uibModalInstance.dismiss('cancel');
    }
}
function UploadDARRateCtrl($scope, $ocLazyLoad, $injector, data, $uibModalInstance, $q) {
    var modal = this;
    modal.list = [];
    $ocLazyLoad.load([
        SETTINGSURL + 'rate_master/service.js?v=' + VERSION,
    ]).then(function (d) {
        RateSvc = $injector.get('RateSvc');
    });
    modal.checkExcel = function () {
        if (!modal.excelFile) {
            return AppSvc.showSwal('Confirmation', 'Select Excel File to Proceed', 'warning');
        }
        LOADING.classList.add("open");
        modal.getDataFromExcel().then(function (response) {
            modal.list = response;
            LOADING.classList.remove("open");
        })
    }
    modal.getDataFromExcel = function () {
        var deferred = $q.defer();
        var reader = new FileReader();
        reader.onload = function () {
            var fileData = reader.result;
            var workbook = XLSX.read(fileData, { type: 'binary' });
            workbook.SheetNames.forEach(function (sheetName) {
                modal.rowObject = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheetName]);
                modal.rowObject.forEach(function (item) {
                    item.gl = item.gl ? item.gl : '';
                    item.activity = item.activity ? item.activity : '';
                    item.location = item.location ? item.location : '';
                    item.costcenter = item.costcenter ? item.costcenter : '';

                    item.rd_st = item.rd_st ? item.rd_st : 0;
                    item.rd_ot = item.rd_ot ? item.rd_ot : 0;
                    item.rd_nd = item.rd_nd ? item.rd_nd : 0;
                    item.rd_ndot = item.rd_ndot ? item.rd_ndot : 0;

                    item.shol_st = item.shol_st ? item.shol_st : 0;
                    item.shol_ot = item.shol_ot ? item.shol_ot : 0;
                    item.shol_nd = item.shol_nd ? item.shol_nd : 0;
                    item.shol_ndot = item.shol_ndot ? item.shol_ndot : 0;

                    item.shrd_st = item.shrd_st ? item.shrd_st : 0;
                    item.shrd_ot = item.shrd_ot ? item.shrd_ot : 0;
                    item.shrd_nd = item.shrd_nd ? item.shrd_nd : 0;
                    item.shrd_ndot = item.shrd_ndot ? item.shrd_ndot : 0;

                    item.rt_st = item.rt_st ? item.rt_st : 0;
                    item.rt_ot = item.rt_ot ? item.rt_ot : 0;
                    item.rt_nd = item.rt_nd ? item.rt_nd : 0;
                    item.rt_ndot = item.rt_ndot ? item.rt_ndot : 0;

                    item.rhol_st = item.rhol_st ? item.rhol_st : 0;
                    item.rhol_ot = item.rhol_ot ? item.rhol_ot : 0;
                    item.rhol_nd = item.rhol_nd ? item.rhol_nd : 0;
                    item.rhol_ndot = item.rhol_ndot ? item.rhol_ndot : 0;

                    item.rhrd_st = item.rhrd_st ? item.rhrd_st : 0;
                    item.rhrd_ot = item.rhrd_ot ? item.rhrd_ot : 0;
                    item.rhrd_nd = item.rhrd_nd ? item.rhrd_nd : 0;
                    item.rhrd_ndot = item.rhrd_ndot ? item.rhrd_ndot : 0;
                })
            });
            deferred.resolve(modal.rowObject);
        };
        reader.readAsBinaryString(modal.excelFile);
        return deferred.promise;
    }
    modal.uploadExcel = function (start, end) {
        if (!modal.excelFile) {
            return AppSvc.showSwal('Confirmation', 'Select Excel File to Proceed', 'warning');
        }
        LOADING.classList.add("open");
        var list = [];
        var totalArray = modal.list.length;
        if (totalArray < 100) {
            list = modal.list.slice(start, totalArray);
            RateSvc.save({ uploadDAR: true, list: list }).then(function (response) {
                if (response.success) {
                    modal.finalizeUpload();
                } else {
                    LOADING.classList.remove("open");
                    return AppSvc.showSwal('Error', 'Something went wrong', 'error');
                }
            })
        } else {
            if (end <= totalArray) {
                if ((end + 100) > totalArray) {
                    list = modal.list.slice(start, totalArray);
                    modal.redoSubmit(list, totalArray);
                } else {
                    list = modal.list.slice(start, end);
                    modal.redoSubmit(list, end);
                }
            } else {
                modal.finalizeUpload();
                AppSvc.showSwal('Success', 'Successfully inserted. Wait for finalization', 'success');
            }
        }

    }
    modal.redoSubmit = function (list, end) {
        RateSvc.save({ uploadDAR: true, list: list }).then(function (response) {
            if (response.success) {
                modal.uploadExcel(end, end + 100);
            } else {
                LOADING.classList.remove("open");
                return AppSvc.showSwal('Error', 'Something went wrong', 'error');
            }
        })
    }
    modal.finalizeUpload = function () {
        RateSvc.save({ finalizeDAR: true }).then(function (response) {
            if (response.success) {
                $uibModalInstance.dismiss('cancel');
                LOADING.classList.remove("open");
                return AppSvc.showSwal('Success', response.message, 'success');
            } else {
                LOADING.classList.remove("open");
                return AppSvc.showSwal('Error', 'Something went wrong', 'error');
            }
        })
    }
    modal.close = function () {
        $uibModalInstance.dismiss('cancel');
    }
}

function SARRateCtrl($scope, $ocLazyLoad, $injector, data, $uibModalInstance) {
    var modal = this;
    modal.variables = {};
    modal.variables.status = 'active';
    if (data.id) {
        modal.variables = angular.copy(data);
    }
    $ocLazyLoad.load([
        SETTINGSURL + 'rate_master/service.js?v=' + VERSION,
    ]).then(function (d) {
        RateSvc = $injector.get('RateSvc');
    });

    modal.searchLocation = function () {
        var options = {
            data: data,
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
                modal.variables.locationID = data.LocationID
                modal.variables.location_fr_mg = data.Location
            }
        });
    }

    modal.searchActivity = function () {
        var options = {
            data: 'menu',
            animation: true,
            templateUrl: SETTINGSURL + "activity_master/activity_modal.html?v=" + VERSION,
            controllerName: "ActivityViewCtrl",
            viewSize: "md",
            filesToLoad: [
                SETTINGSURL + "activity_master/activity_modal.html?v=" + VERSION,
                SETTINGSURL + "activity_master/controller.js?v=" + VERSION
            ]
        };
        AppSvc.modal(options).then(function (data) {
            if (data) {
                modal.variables.activityID = data.id;
                modal.variables.activity = data.activity;
            }
        });
    }
    modal.searchGL = function () {
        var options = {
            data: 'dar',
            animation: true,
            templateUrl: SETTINGSURL + "gl_master/gl_modal.html?v=" + VERSION,
            controllerName: "GLViewCtrl",
            viewSize: "md",
            filesToLoad: [
                SETTINGSURL + "gl_master/gl_modal.html?v=" + VERSION,
                SETTINGSURL + "gl_master/controller.js?v=" + VERSION
            ]
        };
        AppSvc.modal(options).then(function (data) {
            if (data) {
                modal.variables.glID = data.id;
                modal.variables.gl_fr_mg = data.gl;
            }
        });
    }

    modal.searchCC = function () {
        var options = {
            data: 'menu',
            animation: true,
            templateUrl: SETTINGSURL + "cost_center_master/cost_center_modal.html?v=" + VERSION,
            controllerName: "CostCenterViewCtrl",
            viewSize: "md",
            filesToLoad: [
                SETTINGSURL + "cost_center_master/cost_center_modal.html?v=" + VERSION,
                SETTINGSURL + "cost_center_master/controller.js?v=" + VERSION
            ]
        };
        AppSvc.modal(options).then(function (data) {
            if (data) {
                modal.variables.costCenterID = data.id;
                modal.variables.costcenter__ = data.costcenter;
            }
        });
    }
    modal.save = function () {
        if (modal.variables.status === 'previous') {
            return AppSvc.showSwal('Ooops', 'Cannot Update this Rate', 'warning');
        }
        if (!modal.variables.activityID) {
            return AppSvc.showSwal('Ooops', 'Select Activity first', 'warning');
        }
        modal.variables.sar = true;
        LOADING.classList.add("open");
        RateSvc.save(modal.variables).then(function (response) {
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

function BCCRateCtrl($scope, $ocLazyLoad, $injector, data, $uibModalInstance) {
    var modal = this;
    modal.variables = {};
    modal.variables.status = 'active';
    if (data.id) {
        modal.variables = angular.copy(data);
    }
    $ocLazyLoad.load([
        SETTINGSURL + 'rate_master/service.js?v=' + VERSION,
    ]).then(function (d) {
        RateSvc = $injector.get('RateSvc');
    });

    modal.searchLocation = function () {
        var options = {
            data: data,
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
                modal.variables.locationID = data.LocationID
                modal.variables.location_fr_mg = data.Location
            }
        });
    }
    modal.searchActivity = function (client) {
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
        AppSvc.modal(options).then(function (data) {
            if (data) {
                modal.variables.activityID = data.id;
                modal.variables.activity_fr_mg = data.activity;
            }
        });
    }
    modal.searchGL = function () {
        var options = {
            data: 'dar',
            animation: true,
            templateUrl: SETTINGSURL + "gl_master/gl_modal.html?v=" + VERSION,
            controllerName: "GLViewCtrl",
            viewSize: "md",
            filesToLoad: [
                SETTINGSURL + "gl_master/gl_modal.html?v=" + VERSION,
                SETTINGSURL + "gl_master/controller.js?v=" + VERSION
            ]
        };
        AppSvc.modal(options).then(function (data) {
            if (data) {
                modal.variables.glID = data.id;
                modal.variables.gl_fr_mg = data.gl;
            }
        });
    }

    modal.searchCC = function () {
        var options = {
            data: 'menu',
            animation: true,
            templateUrl: SETTINGSURL + "cost_center_master/cost_center_modal.html?v=" + VERSION,
            controllerName: "CostCenterViewCtrl",
            viewSize: "md",
            filesToLoad: [
                SETTINGSURL + "cost_center_master/cost_center_modal.html?v=" + VERSION,
                SETTINGSURL + "cost_center_master/controller.js?v=" + VERSION
            ]
        };
        AppSvc.modal(options).then(function (data) {
            if (data) {
                modal.variables.costCenterID = data.id;
                modal.variables.costcenter__ = data.costcenter;
            }
        });
    }
    modal.save = function () {
        if (!modal.variables.activityID) {
            return AppSvc.showSwal('Ooops', 'Select Activity first', 'warning');
        }
        modal.variables.bcc = true;
        LOADING.classList.add("open");
        RateSvc.save(modal.variables).then(function (response) {
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

function SlersRateCtrl($scope, $ocLazyLoad, $injector, data, $uibModalInstance) {
    var modal = this;
    modal.variables = {};
    modal.variables.status = 'active';
    if (data.id) {
        modal.variables = angular.copy(data);
    }
    $ocLazyLoad.load([
        SETTINGSURL + 'rate_master/service.js?v=' + VERSION,
    ]).then(function (d) {
        RateSvc = $injector.get('RateSvc');
    });
    modal.searchLocation = function () {
        var options = {
            data: data,
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
                modal.variables.locationID = data.LocationID
                modal.variables.location_fr_mg = data.Location
            }
        });
    }
    modal.searchActivity = function (client) {
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
        AppSvc.modal(options).then(function (data) {
            if (data) {
                modal.variables.activityID = data.id;
                modal.variables.activity_fr_mg = data.activity;
            }
        });
    }

    modal.save = function () {
        if (!modal.variables.activityID) {
            return AppSvc.showSwal('Ooops', 'Select Activity first', 'warning');
        }
        modal.variables.slers = true;
        LOADING.classList.add("open");
        RateSvc.save(modal.variables).then(function (response) {
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
    modal.searchGL = function () {
        var options = {
            data: 'dar',
            animation: true,
            templateUrl: SETTINGSURL + "gl_master/gl_modal.html?v=" + VERSION,
            controllerName: "GLViewCtrl",
            viewSize: "md",
            filesToLoad: [
                SETTINGSURL + "gl_master/gl_modal.html?v=" + VERSION,
                SETTINGSURL + "gl_master/controller.js?v=" + VERSION
            ]
        };
        AppSvc.modal(options).then(function (data) {
            if (data) {
                modal.variables.glID = data.id;
                modal.variables.gl_fr_mg = data.gl;
            }
        });
    }

    modal.searchCC = function () {
        var options = {
            data: 'menu',
            animation: true,
            templateUrl: SETTINGSURL + "cost_center_master/cost_center_modal.html?v=" + VERSION,
            controllerName: "CostCenterViewCtrl",
            viewSize: "md",
            filesToLoad: [
                SETTINGSURL + "cost_center_master/cost_center_modal.html?v=" + VERSION,
                SETTINGSURL + "cost_center_master/controller.js?v=" + VERSION
            ]
        };
        AppSvc.modal(options).then(function (data) {
            if (data) {
                modal.variables.costCenterID = data.id;
                modal.variables.costcenter__ = data.costcenter;
            }
        });
    }
    modal.close = function () {
        $uibModalInstance.dismiss('cancel');
    }
}

function ClubHouseRateCtrl($scope, $ocLazyLoad, $injector, data, $uibModalInstance) {
    var modal = this;
    modal.variables = {};
    modal.variables.status = 'active';
    if (data.id) {
        modal.variables = angular.copy(data);
    }
    $ocLazyLoad.load([
        SETTINGSURL + 'rate_master/service.js?v=' + VERSION,
    ]).then(function (d) {
        RateSvc = $injector.get('RateSvc');
    });
    modal.searchLocation = function () {
        var options = {
            data: data,
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
                modal.variables.locationID = data.LocationID
                modal.variables.location_fr_mg = data.Location
            }
        });
    }
    modal.searchActivity = function (client) {
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
        AppSvc.modal(options).then(function (data) {
            if (data) {
                modal.variables.activityID = data.id;
                modal.variables.activity_fr_mg = data.activity;
            }
        });
    }

    modal.save = function () {
        if (!modal.variables.activityID) {
            return AppSvc.showSwal('Ooops', 'Select Activity first', 'warning');
        }
        modal.variables.clubhouse = true;
        LOADING.classList.add("open");
        RateSvc.save(modal.variables).then(function (response) {
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
    modal.searchGL = function () {
        var options = {
            data: 'dar',
            animation: true,
            templateUrl: SETTINGSURL + "gl_master/gl_modal.html?v=" + VERSION,
            controllerName: "GLViewCtrl",
            viewSize: "md",
            filesToLoad: [
                SETTINGSURL + "gl_master/gl_modal.html?v=" + VERSION,
                SETTINGSURL + "gl_master/controller.js?v=" + VERSION
            ]
        };
        AppSvc.modal(options).then(function (data) {
            if (data) {
                modal.variables.glID = data.id;
                modal.variables.gl_fr_mg = data.gl;
            }
        });
    }

    modal.searchCC = function () {
        var options = {
            data: 'menu',
            animation: true,
            templateUrl: SETTINGSURL + "cost_center_master/cost_center_modal.html?v=" + VERSION,
            controllerName: "CostCenterViewCtrl",
            viewSize: "md",
            filesToLoad: [
                SETTINGSURL + "cost_center_master/cost_center_modal.html?v=" + VERSION,
                SETTINGSURL + "cost_center_master/controller.js?v=" + VERSION
            ]
        };
        AppSvc.modal(options).then(function (data) {
            if (data) {
                modal.variables.costCenterID = data.id;
                modal.variables.costcenter__ = data.costcenter;
            }
        });
    }
    modal.close = function () {
        $uibModalInstance.dismiss('cancel');
    }
}
function ConstructionRateCtrl($scope, $ocLazyLoad, $injector, data, $uibModalInstance) {
    var modal = this;
    modal.variables = {};
    modal.variables.status = 'active';
    if (data.id) {
        modal.variables = angular.copy(data);
    }
    $ocLazyLoad.load([
        SETTINGSURL + 'rate_master/service.js?v=' + VERSION,
    ]).then(function (d) {
        RateSvc = $injector.get('RateSvc');
    });
    modal.searchLocation = function () {
        var options = {
            data: data,
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
                modal.variables.locationID = data.LocationID
                modal.variables.location_fr_mg = data.Location
            }
        });
    }
    modal.searchActivity = function (client) {
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
        AppSvc.modal(options).then(function (data) {
            if (data) {
                modal.variables.activityID = data.id;
                modal.variables.activity_fr_mg = data.activity;
            }
        });
    }

    modal.save = function () {
        if (!modal.variables.activityID) {
            return AppSvc.showSwal('Ooops', 'Select Activity first', 'warning');
        }
        modal.variables.construction = true;
        LOADING.classList.add("open");
        RateSvc.save(modal.variables).then(function (response) {
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
    modal.searchGL = function () {
        var options = {
            data: 'dar',
            animation: true,
            templateUrl: SETTINGSURL + "gl_master/gl_modal.html?v=" + VERSION,
            controllerName: "GLViewCtrl",
            viewSize: "md",
            filesToLoad: [
                SETTINGSURL + "gl_master/gl_modal.html?v=" + VERSION,
                SETTINGSURL + "gl_master/controller.js?v=" + VERSION
            ]
        };
        AppSvc.modal(options).then(function (data) {
            if (data) {
                modal.variables.glID = data.id;
                modal.variables.gl_fr_mg = data.gl;
            }
        });
    }

    modal.searchCC = function () {
        var options = {
            data: 'menu',
            animation: true,
            templateUrl: SETTINGSURL + "cost_center_master/cost_center_modal.html?v=" + VERSION,
            controllerName: "CostCenterViewCtrl",
            viewSize: "md",
            filesToLoad: [
                SETTINGSURL + "cost_center_master/cost_center_modal.html?v=" + VERSION,
                SETTINGSURL + "cost_center_master/controller.js?v=" + VERSION
            ]
        };
        AppSvc.modal(options).then(function (data) {
            if (data) {
                modal.variables.costCenterID = data.id;
                modal.variables.costcenter__ = data.costcenter;
            }
        });
    }

    modal.delete = function () {
        AppSvc.confirmation('Confirm Deletion?', 'Are you sure you want to delete this record?', 'Delete', 'Cancel', true).then(function (data) {
            if (data) {
                RateSvc.save({ deleteCONSTRUCTION: true, id: modal.variables.id }).then(function (response) {
                    if (response.success) {
                        $uibModalInstance.close({ delete: true });
                        AppSvc.showSwal('Success', response.message, 'success');
                    } else {
                        AppSvc.showSwal('Error', response.message, 'error');
                    }
                })
            }
        })
    }

    modal.close = function () {
        $uibModalInstance.dismiss('cancel');
    }
}
function ReactivateRateCtrl($scope, $ocLazyLoad, $injector, data, $uibModalInstance) {
    var modal = this;
    var filter = $injector.get('$filter');
    modal.display = [];
    modal.filtered = [];
    modal.variables = {};
    $ocLazyLoad.load([
        SETTINGSURL + 'rate_master/service.js?v=' + VERSION,
    ]).then(function (d) {
        RateSvc = $injector.get('RateSvc');
        modal.displayUploads();
    });

    modal.displayUploads = function () {
        RateSvc.get({ displayUploads: true }).then(function (response) {
            if (response.message) {
                modal.display = [];
            } else {
                response.forEach(function (item) {
                    item.dateUploaded = filter('date')(new Date(item.created_at), 'medium');
                })
                modal.display = response;
            }
            modal.filtered = modal.display;
        })
    }

    modal.defaultGrid = {
        enableRowSelection: true,
        enableCellEdit: false,
        enableColumnMenus: false,
        modifierKeysToMultiSelect: true,
        enableRowHeaderSelection: false,
        enableFiltering: true,
        columnDefs: [
            { name: "Date Uploaded", field: "dateUploaded" },
            { name: "Status", field: "status", enableFiltering: false },
        ],
        data: "modal.display",
        onRegisterApi: function (gridApi) {
            gridApi.selection.on.rowSelectionChanged(null, function (row) {
                modal.variables = angular.copy(row.entity);
            });
        }
    }
    modal.reactivate = function () {

        RateSvc.save({ reactivateRate: true, id: modal.variables.id }).then(function (response) {
            if (response.success) {
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
