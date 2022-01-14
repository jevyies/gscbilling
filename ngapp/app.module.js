const BASEURL = document.getElementById('base_url').value;
const APPURL = document.getElementById('app_url').value;
const VERSION = document.getElementById('version').value;
const COMURL = APPURL + 'common/';
const AUTHURL = APPURL + 'auth/';
const BILLINGURL = APPURL + 'billing/';
const PAYURL =  APPURL + 'payments/';
const REPURL = APPURL + 'reports/';
const SETTINGSURL = APPURL + 'settings/';
const MONURL = APPURL + 'monitoring/';
const RETROURL = APPURL + 'retro/';
const APIURL = '';
const LOADING = document.getElementById('loading-screen');
// Default colors

angular
    .module('app', [
        'ui.router',
        'oc.lazyLoad',
        'angular-loading-bar',
        'ngSanitize',
        'ngIdle',
        'sharedMod',
        'ui.bootstrap',
        'ngAria',
        'ui.grid',
        'ui.grid.cellNav',
        'ui.grid.selection',
        'ui.grid.resizeColumns',
        'ui.grid.exporter',
        'ui.grid.pinning',
        'ui.bootstrap.contextMenu',
        'ngMask',
        'toastr',
        'textAngular',
    ])
    .config([
        'cfpLoadingBarProvider',
        'IdleProvider',
        function(cfpLoadingBarProvider, IdleProvider) {
            cfpLoadingBarProvider.includeSpinner = false;
            cfpLoadingBarProvider.latencyThreshold = 1;
            IdleProvider.idle(10);
            IdleProvider.timeout(600);
        },
    ])
    .run([
        '$rootScope',
        '$state',
        '$stateParams',
        'Idle',
        '$ocLazyLoad',
        '$injector',
        '$location',
        function($rootScope, $state, $stateParams, Idle) {
            Idle.watch();
            $rootScope.$on('IdleTimeout', function() {
                angular.element(document.getElementById('idle-page')).addClass('open');
            });
            $rootScope.$on("$locationChangeStart", function() {})
            $rootScope.$state = $state;
            return ($rootScope.$stateParams = $stateParams);
        },
    ]);