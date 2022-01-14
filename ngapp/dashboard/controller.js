//main.js
angular.module('app')
	.controller('DashboardCtrl', DashboardCtrl)
	.controller('MenuCtrl', MenuCtrl)

DashboardCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector'];
MenuCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector', '$state', '$filter'];

function DashboardCtrl($scope, $ocLazyLoad, $injector) {
	var vm = this;
	vm.title = 'PGHAI Dashboard';
	var date = new Date();
	vm.fd = {
		start_date: new Date(date.getFullYear(), date.getMonth(), 1),
		end_date: new Date(date.getFullYear(), date.getMonth() + 1, 0),
	};
}
function MenuCtrl($scope, $ocLazyLoad, $injector, $state, filter) {
	var vm = this;
	var registry = $state.router.stateRegistry.states;
	vm.filtered = [];
	vm.menuList = [];
	vm.states = [];
	vm.variables = {};
	vm.menuGrid = {
		enableRowSelection: true,
		enableCellEdit: false,
		enableColumnMenus: false,
		modifierKeysToMultiSelect: true,
		enableRowHeaderSelection: false,
		enableHorizontalScrollbar: false,
		columnDefs: [
			{ name: 'Menu Name', field: 'FormName' },
			{ name: 'Menu Group', field: 'FormGroup' },
		],
		data: 'vm.filtered',
		onRegisterApi: function (gridApi) {
			gridApi.selection.on.rowSelectionChanged(null, function (row) {
				vm.gridClick(row.entity);
			});
		},
	}
	for (var key in registry) {
		if (registry[key].params.urlGroup) {
			vm.states.push({
				FormStates: registry[key].params.urlName.config.value,
				FormGroup: registry[key].params.urlGroup.config.value,
				FormName: registry[key].params.formName.config.value,
				FormLocation: key,
				FormURL: registry[key].self.url
			});
		}
	}
	$ocLazyLoad
		.load([APPURL + "dashboard/service.js?v=" + VERSION]).then(function (d) {
			MenuSvc = $injector.get("MenuSvc");
			vm.getMenus();
		});
	vm.getMenus = function () {
		MenuSvc.get().then(function (response) {
			if (response.message) {
				vm.menuList = [];
			} else {
				vm.menuList = response;
			}
			vm.filtered = vm.menuList;
		})
	}
	vm.gridClick = function (row) {
		vm.variables = angular.copy(row);
		vm.variables.index = vm.menuList.indexOf(row);
	}
	vm.save = function () {
		if (!vm.variables.FormName) {
			return AppSvc.showSwal('Ooops', "Form Name is required", 'warning');
		}
		LOADING.classList.add("open");
		var data = angular.copy(vm.variables);
		MenuSvc.save(data).then(function (response) {
			if (response.success) {
				if (response.id) {
					vm.variables.FormID = response.id;
					vm.menuList.push(vm.variables);
				} else {
					vm.menuList.splice(vm.variables.index, 1, vm.variables);
				}
				vm.filtered = vm.menuList;
				vm.clearFunction();
				AppSvc.showSwal('Success', response.message, 'success');
			} else {
				AppSvc.showSwal('Ooops', "Nothing has changed. Failed Saving", 'warning');
			}
			LOADING.classList.remove("open");
		})
	}
	vm.delete = function () {
		if (!vm.variables.FormID) {
			return AppSvc.showSwal('Ooops', "Select Menu First to Proceed", 'warning');
		}
		MenuSvc.delete(vm.variables.FormID).then(function (response) {
			if (response.success) {
				vm.menuList.splice(vm.variables.index, 1);
				vm.filtered = vm.menuList;
				vm.clearFunction();
				LOADING.classList.remove("open");
				AppSvc.showSwal('Success', response.message, 'success');
			} else {
				AppSvc.showSwal('Error', response.message, 'error');
			}
		})
	}
	vm.clearFunction = function () {
		vm.variables = {}
	}
	vm.changeLocation = function () {
		var l = filter('filter')(vm.states, { FormStates: vm.variables.FormStates }, true);
		vm.variables = angular.copy(l[0]);
	}
}
