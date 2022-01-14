angular.module('app').config([
    '$stateProvider',
    '$urlRouterProvider',
    '$ocLazyLoadProvider',
    '$locationProvider',
    '$injector',
    function ($stateProvider, $urlRouterProvider, $ocLazyLoadProvider, $locationProvider) {
        $urlRouterProvider.otherwise('/');
        $ocLazyLoadProvider.config({
            debug: false,
        });
        var formList = JSON.parse(localStorage.getItem('formlist'));
        $stateProvider
            .state('app', {
                abstract: true,
                templateUrl: COMURL + 'full.html?v=' + VERSION,
            })
            .state('app.main', {
                url: '/',
                templateUrl: APPURL + 'dashboard/view.html?v=' + VERSION,
                resolve: {
                    loadMyCtrl: [
                        '$ocLazyLoad',
                        function ($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                files: [APPURL + 'dashboard/controller.js?v=' + VERSION],
                            });
                        },
                    ],
                },
                params: {
                    urlName: 'Dashboard',
                },
            })
            .state('app.profile', {
                url: '/view-profile',
                templateUrl: COMURL + 'profile/view.html?v=' + VERSION,
                resolve: {
                    loadMyCtrl: [
                        '$ocLazyLoad',
                        function ($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                files: [COMURL + 'profile/controller.js?v=' + VERSION],
                            });
                        },
                    ],
                },
                params: {
                    urlName: 'View Profile',
                },
            })
            // BILLING
            .state('app.billing', {
                abstract: true,
            })
            .state('app.billing.dmpi-dar', {
                url: '/dmpi-dar',
                templateUrl: BILLINGURL + 'dmpi_dar/view.html?v=' + VERSION,
                resolve: {
                    loadMyCtrl: [
                        '$ocLazyLoad',
                        function ($ocLazyLoad) {

                            return $ocLazyLoad.load({
                                files: [BILLINGURL + 'dmpi_dar/controller.js?v=' + VERSION],
                            });
                        },
                    ],
                },
                params: {
                    urlName: 'Billing > DMPI > DAR',
                    urlGroup: 'billing',
                },
            })
            .state('app.billing.dmpi-sar', {
                url: '/dmpi-sar',
                templateUrl: BILLINGURL + 'dmpi_sar/view.html?v=' + VERSION,
                resolve: {
                    loadMyCtrl: [
                        '$ocLazyLoad',
                        function ($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                files: [BILLINGURL + 'dmpi_sar/controller.js?v=' + VERSION],
                            });
                        },
                    ],
                },
                params: {
                    urlName: 'Billing > DMPI > SAR',
                    urlGroup: 'billing',
                },
            })
            .state('app.billing.dmpi-sar-transmittal', {
                url: '/dmpi-sar-transmittal',
                templateUrl: BILLINGURL + 'dmpi_sar/sar_transmittal.html?v=' + VERSION,
                resolve: {
                    loadMyCtrl: [
                        '$ocLazyLoad',
                        function ($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                files: [BILLINGURL + 'dmpi_sar/controller.js?v=' + VERSION],
                            });
                        },
                    ],
                },
                params: {
                    urlName: 'Billing > DMPI > SAR Transmittal',
                    urlGroup: 'billing',
                },
            })
            .state('app.billing.oc-bcc', {
                url: '/oc-bcc',
                templateUrl: BILLINGURL + 'oc_bcc/view.html?v=' + VERSION,
                resolve: {
                    loadMyCtrl: [
                        '$ocLazyLoad',
                        function ($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                files: [BILLINGURL + 'oc_bcc/controller.js?v=' + VERSION],
                            });
                        },
                    ],
                },
                params: {
                    urlName: 'Billing > Other Client > BCC',
                    urlGroup: 'billing',
                },
            })
            .state('app.billing.oc-dearbc', {
                url: '/oc-dearbc',
                templateUrl: BILLINGURL + 'oc_dearbc/view.html?v=' + VERSION,
                resolve: {
                    loadMyCtrl: [
                        '$ocLazyLoad',
                        function ($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                files: [BILLINGURL + 'oc_dearbc/controller.js?v=' + VERSION],
                            });
                        },
                    ],
                },
                params: {
                    urlName: 'Billing > Other Client > DEARBC',
                    urlGroup: 'billing',
                },
            })
            .state('app.billing.oc-slers', {
                url: '/oc-slers',
                templateUrl: BILLINGURL + 'oc_slers/view.html?v=' + VERSION,
                resolve: {
                    loadMyCtrl: [
                        '$ocLazyLoad',
                        function ($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                files: [BILLINGURL + 'oc_slers/controller.js?v=' + VERSION],
                            });
                        },
                    ],
                },
                params: {
                    urlName: 'Billing > Other Client > SLERS',
                    urlGroup: 'billing',
                },
            })
            .state('app.billing.oc-labnotin', {
                url: '/oc-labnotin',
                templateUrl: BILLINGURL + 'oc_labnotin/view.html?v=' + VERSION,
                resolve: {
                    loadMyCtrl: [
                        '$ocLazyLoad',
                        function ($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                files: [BILLINGURL + 'oc_labnotin/controller.js?v=' + VERSION],
                            });
                        },
                    ],
                },
                params: {
                    urlName: 'Billing > Other Client > LABNOTIN',
                    urlGroup: 'billing',
                },
            })
            .state('app.billing.oc-clubhouse', {
                url: '/oc-clubhouse',
                templateUrl: BILLINGURL + 'oc_cb/view.html?v=' + VERSION,
                resolve: {
                    loadMyCtrl: [
                        '$ocLazyLoad',
                        function ($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                files: [BILLINGURL + 'oc_cb/controller.js?v=' + VERSION],
                            });
                        },
                    ],
                },
                params: {
                    urlName: 'Billing > Other Client > CLUBHOUSE',
                    urlGroup: 'billing',
                },
            })
	    .state('app.billing.construction', {
                url: '/oc-construction',
                templateUrl: BILLINGURL + 'oc_construction/view.html?v=' + VERSION,
                resolve: {
                    loadMyCtrl: [
                        '$ocLazyLoad',
                        function ($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                files: [BILLINGURL + 'oc_construction/controller.js?v=' + VERSION],
                            });
                        },
                    ],
                },
                params: {
                    urlName: 'Billing > CONSTRUCTION',
                    urlGroup: 'billing',
                },
            })
            // BILLING
            .state('app.monitoring', {
                abstract: true,
            })
            .state('app.monitoring.dar-soa', {
                url: '/dar-soa',
                templateUrl: MONURL + 'dar_soa/view.html?v=' + VERSION,
                resolve: {
                    loadMyCtrl: [
                        '$ocLazyLoad',
                        function ($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                files: [MONURL + 'dar_soa/controller.js?v=' + VERSION],
                            });
                        },
                    ],
                },
                params: {
                    urlName: 'Monitoring > DAR SOA',
                    urlGroup: 'monitoring',
                },
            })
            .state('app.monitoring.dar-confirmation', {
                url: '/dar-confirmation',
                templateUrl: MONURL + 'dar_confirmation/view.html?v=' + VERSION,
                resolve: {
                    loadMyCtrl: [
                        '$ocLazyLoad',
                        function ($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                files: [MONURL + 'dar_confirmation/controller.js?v=' + VERSION],
                            });
                        },
                    ],
                },
                params: {
                    urlName: 'Monitoring > DAR SOA Confirmation',
                    urlGroup: 'monitoring',
                },
            })
            .state('app.monitoring.dar-transmittal', {
                url: '/dar-transmittal',
                templateUrl: MONURL + 'dar_transmittal/view.html?v=' + VERSION,
                resolve: {
                    loadMyCtrl: [
                        '$ocLazyLoad',
                        function ($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                files: [MONURL + 'dar_transmittal/controller.js?v=' + VERSION],
                            });
                        },
                    ],
                },
                params: {
                    urlName: 'Monitoring > DAR SOA Create Transmittal',
                    urlGroup: 'monitoring',
                },
            })
            .state('app.monitoring.dar-for-transmittal', {
                url: '/dar-for-transmittal',
                templateUrl: MONURL + 'dar_for_transmittal/view.html?v=' + VERSION,
                resolve: {
                    loadMyCtrl: [
                        '$ocLazyLoad',
                        function ($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                files: [MONURL + 'dar_for_transmittal/controller.js?v=' + VERSION],
                            });
                        },
                    ],
                },
                params: {
                    urlName: 'Monitoring > DAR SOA For Transmittal',
                    urlGroup: 'monitoring',
                },
            })
            .state('app.monitoring.other-billing', {
                url: '/monitoring-other-billing',
                templateUrl: MONURL + 'other_billing/view.html?v=' + VERSION,
                resolve: {
                    loadMyCtrl: [
                        '$ocLazyLoad',
                        function ($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                files: [MONURL + 'other_billing/controller.js?v=' + VERSION],
                            });
                        },
                    ],
                },
                params: {
                    urlName: 'Monitoring > Other Billing',
                    urlGroup: 'monitoring',
                },
            })
            // PAYMENTS
            .state('app.payments', {
                url: '/billing-payments',
                templateUrl: PAYURL + 'view.html?v=' + VERSION,
                resolve: {
                    loadMyCtrl: [
                        '$ocLazyLoad',
                        function ($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                files: [PAYURL + 'controller.js?v=' + VERSION],
                            });
                        },
                    ],
                },
                params: {
                    urlName: 'Billing Payments',
                    urlGroup: 'payments',
                },
            })
            // REPORTS
            .state('app.reports', {
                abstract: true,
            })
            .state('app.reports.dar-reports', {
                url: '/dar-reports',
                templateUrl: REPURL + 'dar_reports/view.html?v=' + VERSION,
                resolve: {
                    loadMyCtrl: [
                        '$ocLazyLoad',
                        function ($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                files: [REPURL + 'dar_reports/controller.js?v=' + VERSION],
                            });
                        },
                    ],
                },
                params: {
                    urlName: 'Reports > DAR Reports',
                    urlGroup: 'reports',
                },
            })
            .state('app.reports.per-pay-station', {
                url: '/per-pay-station',
                templateUrl: REPURL + 'per_pay_station/view.html?v=' + VERSION,
                resolve: {
                    loadMyCtrl: [
                        '$ocLazyLoad',
                        function ($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                files: [REPURL + 'per_pay_station/controller.js?v=' + VERSION],
                            });
                        },
                    ],
                },
                params: {
                    urlName: 'Reports > DAR Per Pay Station',
                    urlGroup: 'reports',
                },
            })
            .state('app.reports.sar-volume-report', {
                url: '/sar-volume-report',
                templateUrl: REPURL + 'sar_volume_report/view.html?v=' + VERSION,
                resolve: {
                    loadMyCtrl: [
                        '$ocLazyLoad',
                        function ($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                files: [REPURL + 'sar_volume_report/controller.js?v=' + VERSION],
                            });
                        },
                    ],
                },
                params: {
                    urlName: 'Reports > SAR Volume Report',
                    urlGroup: 'reports',
                },
            })
            .state('app.reports.dmpi-oc-report', {
                url: '/dmpi-oc-report',
                templateUrl: REPURL + 'dmpi_oc_reports/view.html?v=' + VERSION,
                resolve: {
                    loadMyCtrl: [
                        '$ocLazyLoad',
                        function ($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                files: [REPURL + 'dmpi_oc_reports/controller.js?v=' + VERSION],
                            });
                        },
                    ],
                },
                params: {
                    urlName: 'Reports > DMPI & Other Client Reports',
                    urlGroup: 'reports',
                },
            })
            // SETTINGS
            .state('app.settings', {
                abstract: true,
            })
            .state('app.settings.billing-signatories', {
                url: '/billing-signatories',
                templateUrl: SETTINGSURL + 'billing_signatories/view.html?v=' + VERSION,
                resolve: {
                    loadMyCtrl: [
                        '$ocLazyLoad',
                        function ($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                files: [SETTINGSURL + 'billing_signatories/controller.js?v=' + VERSION],
                            });
                        },
                    ],
                },
                params: {
                    urlName: 'Settings > Billing Signatories',
                    urlGroup: 'settings',
                },
            })
            .state('app.settings.rate-master', {
                url: '/rate-master',
                templateUrl: SETTINGSURL + 'rate_master/view.html?v=' + VERSION,
                resolve: {
                    loadMyCtrl: [
                        '$ocLazyLoad',
                        function ($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                files: [SETTINGSURL + 'rate_master/controller.js?v=' + VERSION],
                            });
                        },
                    ],
                },
                params: {
                    urlName: 'Settings > Rate Masterfile',
                    urlGroup: 'settings',
                },
            })
            .state('app.settings.location-master', {
                url: '/location-master',
                templateUrl: SETTINGSURL + 'location_master/view.html?v=' + VERSION,
                resolve: {
                    loadMyCtrl: [
                        '$ocLazyLoad',
                        function ($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                files: [SETTINGSURL + 'location_master/controller.js?v=' + VERSION],
                            });
                        },
                    ],
                },
                params: {
                    urlName: 'Settings > Location Masterfile',
                    urlGroup: 'settings',
                },
            })
            .state('app.settings.cost-center-master', {
                url: '/cost-center-master',
                templateUrl: SETTINGSURL + 'cost_center_master/view.html?v=' + VERSION,
                resolve: {
                    loadMyCtrl: [
                        '$ocLazyLoad',
                        function ($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                files: [SETTINGSURL + 'cost_center_master/controller.js?v=' + VERSION],
                            });
                        },
                    ],
                },
                params: {
                    urlName: 'Settings > Cost Center Masterfile',
                    urlGroup: 'settings',
                },
            })
            .state('app.settings.gl-master', {
                url: '/gl-master',
                templateUrl: SETTINGSURL + 'gl_master/view.html?v=' + VERSION,
                resolve: {
                    loadMyCtrl: [
                        '$ocLazyLoad',
                        function ($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                files: [SETTINGSURL + 'gl_master/controller.js?v=' + VERSION],
                            });
                        },
                    ],
                },
                params: {
                    urlName: 'Settings > GL Masterfile',
                    urlGroup: 'settings',
                },
            })
            .state('app.settings.activity-master', {
                url: '/activity-master',
                templateUrl: SETTINGSURL + 'activity_master/view.html?v=' + VERSION,
                resolve: {
                    loadMyCtrl: [
                        '$ocLazyLoad',
                        function ($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                files: [SETTINGSURL + 'activity_master/controller.js?v=' + VERSION],
                            });
                        },
                    ],
                },
                params: {
                    urlName: 'Settings > Activity Masterfile',
                    urlGroup: 'settings',
                },
            })
            .state('app.settings.activity-master-oc', {
                url: '/activity-master-oc',
                templateUrl: SETTINGSURL + 'activity_master_oc/view.html?v=' + VERSION,
                resolve: {
                    loadMyCtrl: [
                        '$ocLazyLoad',
                        function ($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                files: [SETTINGSURL + 'activity_master_oc/controller.js?v=' + VERSION],
                            });
                        },
                    ],
                },
                params: {
                    urlName: 'Settings > Activity Masterfile Other Client',
                    urlGroup: 'settings',
                },
            })
            .state('app.settings.sar-po-master', {
                url: '/sar-po-master',
                templateUrl: SETTINGSURL + 'po_sar_master/view.html?v=' + VERSION,
                resolve: {
                    loadMyCtrl: [
                        '$ocLazyLoad',
                        function ($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                files: [SETTINGSURL + 'po_sar_master/controller.js?v=' + VERSION],
                            });
                        },
                    ],
                },
                params: {
                    urlName: 'Settings > PO SAR Masterfile',
                    urlGroup: 'settings',
                },
            })
            .state('app.settings.users', {
                url: '/users',
                templateUrl: SETTINGSURL + 'users/view.html?v=' + VERSION,
                resolve: {
                    loadMyCtrl: [
                        '$ocLazyLoad',
                        function ($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                files: [SETTINGSURL + 'users/controller.js?v=' + VERSION],
                            });
                        },
                    ],
                },
                params: {
                    urlName: 'Settings > Users List',
                    urlGroup: 'settings',
                },
            })

            // RETRO
            .state('app.retro', {
                abstract: true,
            })
            .state('app.retro.retro-rates', {
                url: '/retro-rates',
                templateUrl: RETROURL + 'retro_rates/view.html?v=' + VERSION,
                resolve: {
                    loadMyCtrl: [
                        '$ocLazyLoad',
                        function ($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                files: [RETROURL + 'retro_rates/controller.js?v=' + VERSION],
                            });
                        },
                    ],
                },
                params: {
                    urlName: 'Retro > Retro Rates',
                    urlGroup: 'retro',
                },
            })
            .state('app.retro.retro-reports', {
                url: '/retro-reports',
                templateUrl: RETROURL + 'retro_report/view.html?v=' + VERSION,
                resolve: {
                    loadMyCtrl: [
                        '$ocLazyLoad',
                        function ($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                files: [RETROURL + 'retro_report/controller.js?v=' + VERSION],
                            });
                        },
                    ],
                },
                params: {
                    urlName: 'Retro > Retro Reports',
                    urlGroup: 'retro',
                },
            })
        $locationProvider.hashPrefix('');
    },
]);