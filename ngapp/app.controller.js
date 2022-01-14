angular.module('app').controller('AppCtrl', AppCtrl);

AppCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector', '$state', '$window', 'Idle', 'authService'];

function AppCtrl($scope, $ocLazyLoad, $injector, $state, $window, Idle, authService) {
	var vm = this;
	vm.openMenu = '';
	vm.userName = '';
	vm.showSide = true;
	vm.formList = [];
	$ocLazyLoad.load([APPURL + 'app.service.js?v=' + VERSION]).then(function (d) {
		AppSvc = $injector.get('AppSvc');
		LogoutSvc = $injector.get('LogoutSvc');
		vm.openMenu = $state.current.params.urlGroup;
		vm.getUserCredentials();
		authService = new authService();
	});
	vm.getUserCredentials = function () {
		LOADING.classList.add('open');
		AppSvc.get().then(function (response) {
			if (response) {
				vm.userName = response.record.user;
				vm.role = response.record.role;
				vm.formList = response.record.formlist;
				setUserData();
			} else {
				vm.logout();
			}
			LOADING.classList.remove('open');
		});
	};
	function setUserData() {
		authService.records = vm.formList;
		localStorage.setItem('formlist', JSON.stringify(vm.formList));
		return authService;
	}
	vm.doQuery = function () {
		AppSvc.confirmation(
			'Confirmation',
			'Are You sure you want to load this query?',
			'Yes',
			'No'
		).then(function (data) {
			if (data) {
				Idle.unwatch();
				LOADING.classList.add('open');
				AppSvc.get({ query: true }).then(function (response) {
					if (response) {
						AppSvc.showSwal('Success', response.message, 'success');
					} else {
						AppSvc.showSwal('Error', response.message, 'error');
					}
					LOADING.classList.remove('open');
					Idle.watch();
				});
			}
		});
	};
	vm.dashboard = function () {
		vm.openMenu = '';
	};
	vm.openSubMenu = function (number) {
		var currentMenu = vm.openMenu;
		vm.openMenu = currentMenu === number ? '' : number;
	};
	vm.openSideMenu = function () {
		var body = angular.element(document.querySelector('body'));
		if (vm.showSide) {
			body.addClass('sidebar-mobile-show sidebar-hidden');
			vm.showSide = false;
		} else {
			body.removeClass('sidebar-mobile-show sidebar-hidden');
			vm.showSide = true;
		}
	};
	vm.okayButton = function (type) {
		if (type === 'idle') {
			$window.location.reload();
		} else {
			angular.element(document.getElementById('page-not-allowed')).removeClass('open');
		}
	};
	vm.goToPage = function(id, url){
		// return $state.go(url);
		authService.formList(id).then(function(response) {
			if (response) {
				return $state.go(url);
			}
		})
	}
	vm.sarPOReport = function () {
		authService.formList('18').then(function(response) {
			if (response) {
				var options = {
					data: 'menu',
					animation: true,
					templateUrl: REPURL + 'sar_po_report/view.html?v=' + VERSION,
					controllerName: 'SARPOReportCtrl',
					viewSize: 'md',
					filesToLoad: [
						REPURL + 'sar_po_report/view.html?v=' + VERSION,
						REPURL + 'sar_po_report/controller.js?v=' + VERSION,
					],
				};
				AppSvc.modal(options);
			}
		})
	};
	vm.sarPerDept = function () {
		authService.formList('17').then(function(response) {
			if (response) {
				var options = {
					data: 'menu',
					animation: true,
					templateUrl: REPURL + 'sar_per_dept/view.html?v=' + VERSION,
					controllerName: 'SARPerDeptReportCtrl',
					viewSize: 'md',
					filesToLoad: [
						REPURL + 'sar_per_dept/view.html?v=' + VERSION,
						REPURL + 'sar_per_dept/controller.js?v=' + VERSION,
					],
				};
				AppSvc.modal(options);
			}
		})
	};
	vm.logout = function () {
		localStorage.removeItem('formlist');
		LogoutSvc.get().then(function (response) {
			window.location.reload();
		});
	};
	Array.prototype.groupBy = function (prop) {
		return this.reduce(function (groups, item) {
			var val = item[prop];
			groups[val] = groups[val] || [];
			groups[val].push(item);
			return groups;
		}, {});
	};
}
