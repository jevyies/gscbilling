
angular.module('app')
    .controller('DARReportCtrl', DARReportCtrl)

DARReportCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector'];

function DARReportCtrl($scope, $ocLazyLoad, $injector) {
    var vm = this;
    var dateNow = new Date();
    vm.years = [];
    vm.months = [
        { value: '01', name: 'January' },
        { value: '02', name: 'February' },
        { value: '03', name: 'March' },
        { value: '04', name: 'April' },
        { value: '05', name: 'May' },
        { value: '06', name: 'June' },
        { value: '07', name: 'July' },
        { value: '08', name: 'August' },
        { value: '09', name: 'September' },
        { value: '10', name: 'October' },
        { value: '11', name: 'November' },
        { value: '12', name: 'December' },
    ]
    vm.variables = {};
    vm.variables.month = '';
    vm.variables.phase = '';
    $ocLazyLoad.load([
        REPURL + 'dar_reports/service.js?v=' + VERSION,
    ]).then(function (d) {
        DARReportSvc = $injector.get('DARReportSvc');
        vm.displayYears();
    });
    vm.displayYears = function () {
        var year = dateNow.getFullYear();
        vm.years.push({ year: year - 2 });
        vm.years.push({ year: year - 1 });
        vm.years.push({ year: year });
        // vm.years.push({ year: year + 1 });
        // vm.years.push({ year: year + 2 });
        vm.variables.year = dateNow.getFullYear().toString();
    }

    vm.generate = function () {
        vm.Paystations = "";
        vm.Totals = "";
        vm.TotalsAmount = "";
        vm.color = "";
        vm.TotalAverageHeadCount = 0;
        vm.TotalNetAmount = 0;
        LOADING.classList.add("open");
        DARReportSvc.get(vm.variables).then(function (response) {
            if (!response.message) {
                response.forEach(function (item) {
                    vm.Paystations = item.PayStation + ',' + vm.Paystations;
                    vm.Totals = item.Total + ',' + vm.Totals;
                    vm.TotalsAmount = item.TotalAmount + ',' + vm.TotalsAmount;
                    vm.TotalAverageHeadCount = parseFloat(item.Total) + vm.TotalAverageHeadCount;
                    vm.TotalNetAmount = parseFloat(item.TotalAmount) + vm.TotalNetAmount;
                })
                vm.data = response;
                vm.fillData();
            } else {
                vm.data = [];
            }
            LOADING.classList.remove("open");
        })
    }
    vm.fillData = function () {
        vm.FinalViewTotalAverageHeadCount = parseFloat(vm.TotalAverageHeadCount) / vm.data.length;
        var labels = vm.Paystations.replace(/,\s*$/, '').split(',');
        var data = vm.Totals.replace(/,\s*$/, '').split(',');
        var data2 = vm.TotalsAmount.replace(/,\s*$/, '').split(',');

        document.getElementById("myChart").remove();
        var canvas = document.createElement("canvas");
        canvas.id = "myChart";
        var div = document.getElementById("parent");
        div.appendChild(canvas);
        var ctx = document.getElementById("myChart").getContext("2d");
        new Chart(ctx, {
            type: "line",
            data: {
                labels: labels,
                datasets: [{
                    label: "PayStations",
                    data: data,
                    backgroundColor: [
                        "rgba(54, 162, 235, 0.2)",
                    ],
                    borderColor: [
                        "rgba(54, 162, 235, 1)",
                    ],
                    borderWidth: 1,
                },],
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                        },
                    },],
                    xAxes: [{
                        ticks: {
                            autoSkip: false
                        }
                    }]
                },
                tooltips: {
                    callbacks: {
                        label: function (tooltipItem, data) {
                            return "PayStations: " + tooltipItem.yLabel.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
                        }
                    }
                }
            },
        });

        document.getElementById("myChart2").remove();
        var canvas = document.createElement("canvas");
        canvas.id = "myChart2";
        var div = document.getElementById("parent2");
        div.appendChild(canvas);
        var ctx = document.getElementById("myChart2").getContext("2d");
        new Chart(ctx, {
            type: "line",
            data: {
                labels: labels,
                datasets: [{
                    label: "PayStations",
                    data: data2,
                    backgroundColor: [
                        "rgba(54, 162, 235, 0.2)",
                    ],
                    borderColor: [
                        "rgba(54, 162, 235, 1)",
                    ],
                    borderWidth: 1,
                },],
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                        },
                    },],
                    xAxes: [{
                        ticks: {
                            autoSkip: false
                        }
                    }]
                },
                tooltips: {
                    callbacks: {
                        label: function (tooltipItem, data) {
                            return "PayStations: " + tooltipItem.yLabel.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
                        }
                    }
                }
            },
        });
    }
}