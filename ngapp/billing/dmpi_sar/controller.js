angular
	.module('app')
	.controller('DMPISARCtrl', DMPISARCtrl)
	.controller('DMPISARTransmittalCtrl', DMPISARTransmittalCtrl)
	.controller('DMPISARHeaderCtrl', DMPISARHeaderCtrl)
	.controller('DMPISARSearchHeaderCtrl', DMPISARSearchHeaderCtrl)
	.controller('DMPISARDetailCtrl', DMPISARDetailCtrl)
	.controller('ReactivateSARCtrl', ReactivateSARCtrl)
	.controller('DMPISARTransmittalSearchCtrl', DMPISARTransmittalSearchCtrl)
	.controller('SARTransmittalDetails', SARTransmittalDetails);

DMPISARCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector', '$q', '$filter'];
DMPISARTransmittalCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector', '$q', '$filter'];
DMPISARHeaderCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector', 'data', '$uibModalInstance'];
DMPISARSearchHeaderCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector', 'data', '$uibModalInstance', '$filter'];
DMPISARDetailCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector', 'data', '$uibModalInstance'];
ReactivateSARCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector', 'data', '$uibModalInstance'];
DMPISARTransmittalSearchCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector', 'data', '$uibModalInstance'];
SARTransmittalDetails.$inject = ['$scope', '$ocLazyLoad', '$injector', 'data', '$uibModalInstance', '$filter'];

function DMPISARCtrl($scope, $ocLazyLoad, $injector, $q, filter) {
	var vm = this;
	vm.data = [];
	vm.list = [];
	vm.details = [];
	vm.locations = [];
	vm.variables = {};
	vm.variables.status = 'active';
	vm.totalAmount = filter('number')(0, 2);
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
	];
	$ocLazyLoad.load([BILLINGURL + 'dmpi_sar/service.js?v=' + VERSION]).then(function (d) {
		DMPISARSvc = $injector.get('DMPISARSvc');
		vm.getLocations();
	});
	vm.getLocations = function () {
		DMPISARSvc.get({ location: true }).then(function (response) {
			if (!response.message) {
				vm.locations = response;
			} else {
				vm.locations = [];
			}
		});
	};
	var rowTemplate =
		'<div ng-repeat="(colRenderIndex, col) in colContainer.renderedColumns track by col.colDef.name" class="ui-grid-cell"  ui-grid-cell context-menu="grid.appScope.vm.rightClick()"></div>';
	vm.defaultGrid = {
		enableRowSelection: true,
		enableCellEdit: false,
		enableColumnMenus: false,
		modifierKeysToMultiSelect: false,
		enableRowHeaderSelection: false,
		columnDefs: [
			{ name: 'Date Performed', field: 'datePerformed', width: 180 },
			{ name: 'Activity', field: 'activity', width: 180 },
			{ name: 'PO Number', field: 'poNumber', width: 180 },
			{ name: 'GL Account', field: 'gl', width: 180 },
			{ name: 'Cost Center', field: 'costCenter', width: 180 },
			{ name: 'Quantity', field: 'qty', width: 180, cellFilter: 'number:2', cellClass: 'text-right' },
			{ name: 'Unit', field: 'unit', width: 180 },
			{ name: 'Rate', field: 'rate', width: 180, cellFilter: 'number:2', cellClass: 'text-right' },
			{ name: 'Amount', field: 'amount', width: 180, cellFilter: 'number:2', cellClass: 'text-right' },
			{ name: 'Entry Sheet Number', field: 'entrySheetNumber', width: 180 },
			{ name: 'GR Doc. Number', field: 'serviceNumber', width: 180 },
		],
		data: 'vm.details',
		rowTemplate: rowTemplate,
		onRegisterApi: function (gridApi) {
			vm.gridApi = gridApi;
		},
	};
	vm.rightClick = function () {
		var l = angular.copy(vm.gridApi.selection.getSelectedRows());
		var contextMenuData = [];
		if (l.length > 0) {
			contextMenuData.push([
				'Edit',
				function () {
					vm.addDetails(l[0]);
				},
			]);
			contextMenuData.push([
				'Copy',
				function () {
					delete l[0].id;
					vm.addDetails(l[0], 'Copy');
				},
			]);
			contextMenuData.push([
				'Delete',
				function () {
					vm.deleteDetails(l[0]);
				},
			]);
		}
		return contextMenuData;
	};
	vm.deleteDetails = function (row) {
		AppSvc.confirmation(
			'Are You Sure?',
			'Are you sure you want to delete this record?',
			'Delete',
			'Cancel',
			true
		).then(function (data) {
			if (data) {
				DMPISARSvc.save({ deleteDetails: true, id: row.id }).then(function (response) {
					if (response.success) {
						vm.details.splice(row.index, 1);
						return AppSvc.showSwal('Success', response.message, 'success');
					} else {
						return AppSvc.showSwal('Error', 'Something went wrong', 'error');
					}
				});
			}
		});
	};
	vm.searchHeader = function () {
		var options = {
			data: 'menu',
			animation: true,
			templateUrl: BILLINGURL + 'dmpi_sar/search_header.html?v=' + VERSION,
			controllerName: 'DMPISARSearchHeaderCtrl',
			viewSize: 'lg',
			filesToLoad: [
				BILLINGURL + 'dmpi_sar/search_header.html?v=' + VERSION,
				BILLINGURL + 'dmpi_sar/controller.js?v=' + VERSION,
			],
		};
		AppSvc.modal(options).then(function (data) {
			if (data) {
				vm.variables = angular.copy(data);
				vm.variables.periodCoveredFrom = new Date(data.periodCoveredFrom);
				vm.variables.periodCoveredTo = new Date(data.periodCoveredTo);
				vm.variables.soaDate = new Date(data.soaDate);
				vm.variables.DateTransmitted = new Date(data.DateTransmitted);
				vm.getDetails(data.id);
			}
		});
	};
	vm.newHeader = function (row) {
		var data = { locations: vm.locations };
		if (row) {
			if (vm.variables.status !== 'active') {
				return AppSvc.showSwal('Confirmation', 'Cannot Proceed. Status is not active', 'warning');
			}
			data.variables = angular.copy(row);
		}
		var options = {
			data: data,
			animation: true,
			templateUrl: BILLINGURL + 'dmpi_sar/new_header.html?v=' + VERSION,
			controllerName: 'DMPISARHeaderCtrl',
			viewSize: 'lg',
			filesToLoad: [
				BILLINGURL + 'dmpi_sar/new_header.html?v=' + VERSION,
				BILLINGURL + 'dmpi_sar/controller.js?v=' + VERSION,
			],
		};
		AppSvc.modal(options).then(function (data) {
			if (data) {
				vm.variables = angular.copy(data);
				vm.variables.periodCoveredFrom = new Date(data.periodCoveredFrom);
				vm.variables.periodCoveredTo = new Date(data.periodCoveredTo);
				vm.variables.soaDate = new Date(data.soaDate);
				vm.variables.DateTransmitted = new Date(data.DateTransmitted);
				vm.getDetails(data.id);
			}
		});
	};
	vm.addDetails = function (row, type) {
		if (vm.variables.status !== 'active') {
			return AppSvc.showSwal('Confirmation', 'Cannot Proceed. Status is not active', 'warning');
		}
		data = { type: vm.variables.volumeType, hdr_id: vm.variables.id };
		if (row) {
			data.variables = angular.copy(row);
		}
		var options = {
			data: data,
			animation: true,
			templateUrl: BILLINGURL + 'dmpi_sar/add_details.html?v=' + VERSION,
			controllerName: 'DMPISARDetailCtrl',
			viewSize: 'lg',
			filesToLoad: [
				BILLINGURL + 'dmpi_sar/add_details.html?v=' + VERSION,
				BILLINGURL + 'dmpi_sar/controller.js?v=' + VERSION,
			],
		};
		AppSvc.modal(options).then(function (data) {
			if (data) {
				if (type) {
					vm.details.push(data);
				} else {
					if (row) {
						vm.details.splice(row.index, 1, data);
					} else {
						vm.details.push(data);
					}
				}
			}
		});
	};
	vm.getDetails = function (id) {
		DMPISARSvc.get({ details: true, id: id }).then(function (response) {
			if (response.message) {
				vm.details = [];
			} else {
				index = 0;
				response.forEach(function (item) {
					item.index = index;
					index++;
				});
				vm.details = response;
				vm.calculateTotal();
			}
		});
	};
	vm.calculateTotal = function () {
		var sum = 0;
		vm.details.forEach(function (item) {
			sum += parseFloat(item.amount);
		});
		vm.totalAmount = filter('number')(sum, 2);
	};
	vm.updateStatus = function (status) {
		AppSvc.confirmation(
			'Confirmation',
			'Are You sure you want to update status to ' + status + '?',
			'Confirm',
			'Cancel'
		).then(function (data) {
			if (data) {
				DMPISARSvc.save({ updateStatus: true, status: status, id: vm.variables.id }).then(function (response) {
					if (response.success) {
						vm.variables.status = status;
						AppSvc.showSwal('Success', response.message, 'success');
					} else {
						AppSvc.showSwal('Error', 'Something went wrong', 'error');
					}
				});
			}
		});
	};
	vm.reactivate = function () {
		var authOptions = {
			data: 'menu',
			animation: true,
			templateUrl: AUTHURL + 'auth.html?v=' + VERSION,
			controllerName: 'AuthCtrl',
			viewSize: 'sm',
			filesToLoad: [AUTHURL + 'auth.html?v=' + VERSION, AUTHURL + 'auth.controller.js?v=' + VERSION],
		};
		AppSvc.modal(authOptions).then(function (data) {
			if (data) {
				var options = {
					data: vm.variables.id,
					animation: true,
					templateUrl: BILLINGURL + 'dmpi_sar/reactivate.html?v=' + VERSION,
					controllerName: 'ReactivateSARCtrl',
					viewSize: 'sm',
					filesToLoad: [
						BILLINGURL + 'dmpi_sar/reactivate.html?v=' + VERSION,
						BILLINGURL + 'dmpi_sar/controller.js?v=' + VERSION,
					],
				};
				AppSvc.modal(options).then(function (data) {
					if (data) {
						vm.variables.status = 'active';
					}
				});
			}
		});
	};
	vm.delete = function () {
		DMPISARSvc.delete(vm.variables.id).then(function (response) {
			if (response.success) {
				vm.clearFunction();
				AppSvc.showSwal('Success', response.message, 'success');
			} else {
				AppSvc.showSwal('Error', 'Something went wrong', 'error');
			}
			LOADING.classList.remove('open');
		});
	};
	vm.printPDF = function () {
		if (vm.details.length > 0) {
			window.open('report/sar_report?type=' + vm.variables.volumeType + '&id=' + vm.variables.id);
		} else {
			AppSvc.showSwal('Error', "There's Nothing to Print", 'error');
		}
	};
	vm.printExcel = function () {
		if (vm.details.length > 0) {
			window.open('report/sar_report?excel=true&type=' + vm.variables.volumeType + '&id=' + vm.variables.id);
		} else {
			AppSvc.showSwal('Error', "There's Nothing to Print", 'error');
		}
	};
	vm.clearFunction = function () {
		vm.variables = {};
		vm.variables.status = 'active';
		vm.details = [];
	};
}
function DMPISARTransmittalCtrl($scope, $ocLazyLoad, $injector, $q, filter) {
	var vm = this;
	vm.details = [];
	vm.variables = {};
	vm.variables.date = new Date();
	$ocLazyLoad.load([BILLINGURL + 'dmpi_sar/service.js?v=' + VERSION]).then(function (d) {
		DMPISARSvc = $injector.get('DMPISARSvc');
	});
	var cellTemplate =
		'<div class="text-center pointer justify-center" ng-click="grid.appScope.vm.removeSOA(row.entity)"><span class="fa fa-trash text-danger"></span></div>';
	vm.defaultGrid = {
		enableRowSelection: true,
		enableCellEdit: false,
		enableColumnMenus: false,
		modifierKeysToMultiSelect: true,
		enableRowHeaderSelection: false,
		columnDefs: [
			{ name: ' ', cellTemplate: cellTemplate, width: 20 },
			{ name: 'SOA Number', displayName: 'SOA Number', field: 'controlNo', width: 200 },
			{ name: 'SOA Date', displayName: 'SOA Date', field: 'soaDate', width: 200 },
			{
				name: 'Amount',
				displayName: 'Amount',
				field: 'amount',
				width: 200,
				cellFilter: 'number: 2',
				cellClass: 'text-right',
			},
			{ name: 'Encoded By', displayName: 'Encoded By', field: 'adminencodedby', width: 200 },
			{ name: 'Created', displayName: 'Created', field: 'created_at', width: 200 },
			{ name: 'Last Updated', displayName: 'Last Updated', field: 'updated_at', width: 200 },
		],
		data: 'vm.details',
		// onRegisterApi: function (gridApi) {
		//     gridApi.selection.on.rowSelectionChanged(null, function (row) {
		//         $uibModalInstance.close(row.entity)
		//     });
		// }
	};
	vm.removeSOA = function (row) {
		AppSvc.confirmation(
			'Are You Sure?',
			'Are you sure you want to remove this record?',
			'Remove',
			'Cancel',
			true
		).then(function (data) {
			if (data) {
				DMPISARSvc.save({ id: row.id, updateTransmittal: true, TID: 0 }).then(function (response) {
					if (response.success) {
						var index = vm.details.indexOf(row);
						vm.details.splice(index, 1);
						return AppSvc.showSwal('Success', 'Successfully removed', 'success');
					} else {
						return AppSvc.showSwal('Error', 'Something went wrong', 'error');
					}
				});
			}
		});
	};
	vm.searchHeader = function () {
		var options = {
			data: 'menu',
			animation: true,
			templateUrl: BILLINGURL + 'dmpi_sar/search_transmittal.html?v=' + VERSION,
			controllerName: 'DMPISARTransmittalSearchCtrl',
			viewSize: 'lg',
			filesToLoad: [
				BILLINGURL + 'dmpi_sar/search_transmittal.html?v=' + VERSION,
				BILLINGURL + 'dmpi_sar/controller.js?v=' + VERSION,
			],
		};
		AppSvc.modal(options).then(function (data) {
			if (data) {
				vm.variables = angular.copy(data);
				vm.variables.date = new Date(data.date);
				vm.getDetails(data.id);
			}
		});
	};
	vm.getDetails = function (id) {
		DMPISARSvc.get({ id: id, getTDetails: true }).then(function (response) {
			if (!response.message) {
				vm.details = response;
			} else {
				vm.details = [];
			}
		});
	};
	vm.addSOA = function () {
		var options = {
			data: vm.variables.id,
			animation: true,
			templateUrl: BILLINGURL + 'dmpi_sar/add_transmittal.html?v=' + VERSION,
			controllerName: 'SARTransmittalDetails',
			viewSize: 'lg',
			filesToLoad: [
				BILLINGURL + 'dmpi_sar/add_transmittal.html?v=' + VERSION,
				BILLINGURL + 'dmpi_sar/controller.js?v=' + VERSION,
			],
		};
		AppSvc.modal(options).then(function (data) {
			if (data) {
				vm.details.push(data);
			}
		});
	};
	vm.save = function () {
		var data = angular.copy(vm.variables);
		data.date = AppSvc.getDate(vm.variables.date);
		data.transmittalHeader = true;
		DMPISARSvc.save(data).then(function (response) {
			if (response.success) {
				if (response.id) {
					vm.variables.id = response.id;
				}
				AppSvc.showSwal('Success', response.message, 'success');
			} else {
				AppSvc.showSwal('Confirmation', 'Nothing changed. Saving failed', 'warning');
			}
		});
	};
	vm.clearFunction = function () {
		vm.variables = {};
		vm.variables.date = new Date();
		vm.details = [];
	};
	vm.delete = function () {
		AppSvc.confirmation(
			'Are You Sure?',
			'Are you sure you want to delete this record?',
			'Delete',
			'Cancel',
			true
		).then(function (data) {
			if (data) {
				DMPISARSvc.save({ deleteTransmittal: true, id: vm.variables.id }).then(function (response) {
					if (response.success) {
						vm.clearFunction();
						return AppSvc.showSwal('Success', response.message, 'success');
					} else {
						return AppSvc.showSwal('Error', 'Something went wrong', 'error');
					}
				});
			}
		});
	};
	vm.print = function (type) {
		if (vm.details.length == 0) {
			return AppSvc.showSwal('Confirmation', 'Nothing to print', 'error');
		}
		if (type === 'excel') {
			window.open('report/dmpi_oc/sar_transmittal?excel=true&id=' + vm.variables.id);
		} else {
			window.open('report/dmpi_oc/sar_transmittal?id=' + vm.variables.id);
		}
	};
	vm.searchSignatory = function (number) {
		var options = {
			data: 'menu',
			animation: true,
			templateUrl: SETTINGSURL + 'billing_signatories/signatory_modal.html?v=' + VERSION,
			controllerName: 'SearchSignatoryCtrl',
			viewSize: 'md',
			filesToLoad: [
				SETTINGSURL + 'billing_signatories/signatory_modal.html?v=' + VERSION,
				SETTINGSURL + 'billing_signatories/controller.js?v=' + VERSION,
			],
		};
		AppSvc.modal(options).then(function (data) {
			if (data) {
				if (number == 1) {
					vm.variables.PreparedBy = data.fullname;
					vm.variables.PreparedByPos = data.position;
				} else if (number == 2) {
					vm.variables.CheckedBy = data.fullname;
					vm.variables.CheckedByPos = data.position;
				} else if (number == 3) {
					vm.variables.ApprovedBy = data.fullname;
					vm.variables.ApprovedByPos = data.position;
				} else if (number == 4) {
					vm.variables.NotedBy = data.fullname;
					vm.variables.NotedByPos = data.position;
				}
			}
		});
	};
}
function DMPISARHeaderCtrl($scope, $ocLazyLoad, $injector, data, $uibModalInstance) {
	var modal = this;
	var filter = $injector.get('$filter');
	var dateNow = new Date();
	modal.variables = {};
	modal.variables.status = 'active';
	modal.locations = data.locations;
	modal.months = [
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
	];
	modal.variables.cutoff_month = (dateNow.getMonth() + 1).toString();
	displayYears();
	if (data.variables) {
		modal.variables = angular.copy(data.variables);
		modal.variables.periodCoveredFrom = new Date(data.variables.periodCoveredFrom);
		modal.variables.periodCoveredTo = new Date(data.variables.periodCoveredTo);
		modal.variables.soaDate = new Date(data.variables.soaDate);
		modal.variables.DateTransmitted = new Date(data.variables.DateTransmitted);
	}
	function displayYears() {
		modal.years = [];
		var year = dateNow.getFullYear();
		modal.years.push({ year: year - 2 });
		modal.years.push({ year: year - 1 });
		modal.years.push({ year: year });
		modal.years.push({ year: year + 1 });
		modal.years.push({ year: year + 2 });
		modal.variables.cutoff_year = dateNow.getFullYear().toString();
	}
	modal.searchSig = function (number) {
		var options = {
			data: 'menu',
			animation: true,
			templateUrl: SETTINGSURL + 'billing_signatories/signatory_modal.html?v=' + VERSION,
			controllerName: 'SearchSignatoryCtrl',
			viewSize: 'md',
			filesToLoad: [
				SETTINGSURL + 'billing_signatories/signatory_modal.html?v=' + VERSION,
				SETTINGSURL + 'billing_signatories/controller.js?v=' + VERSION,
			],
		};
		AppSvc.modal(options).then(function (data) {
			if (data) {
				if (number == 1) {
					modal.variables.preparedBy = data.fullname;
					modal.variables.preparedByPosition = data.position;
				} else if (number == 2) {
					modal.variables.verifiedBy = data.fullname;
					modal.variables.verifiedByPosition = data.position;
				} else if (number == 3) {
					modal.variables.notedBy = data.fullname;
					modal.variables.notedByPosition = data.position;
				} else if (number == 4) {
					modal.variables.approvedBy1 = data.fullname;
					modal.variables.approvedByPosition1 = data.position;
				} else if (number == 5) {
					modal.variables.approvedBy2 = data.fullname;
					modal.variables.approvedByPosition2 = data.position;
				} else if (number == 6) {
					modal.variables.approvedBy3 = data.fullname;
					modal.variables.approvedByPosition3 = data.position;
				}
			}
		});
	};
	modal.save = function (id) {
		// var location = filter('filter')(modal.locations, { LocationID: modal.variables.locationID }, true);
		var data = angular.copy(modal.variables);
		data.periodCoveredFrom = modal.variables.periodCoveredFrom
			? AppSvc.getDate(modal.variables.periodCoveredFrom)
			: '0000-00-00';
		data.periodCoveredTo = modal.variables.periodCoveredTo
			? AppSvc.getDate(modal.variables.periodCoveredTo)
			: '0000-00-00';
		data.soaDate = modal.variables.soaDate ? AppSvc.getDate(modal.variables.soaDate) : '0000-00-00';
		data.docDate = modal.variables.docDate ? AppSvc.getDate(modal.variables.docDate) : '0000-00-00';
		data.DateTransmitted = modal.variables.DateTransmitted
			? AppSvc.getDate(modal.variables.DateTransmitted)
			: '0000-00-00';
		// data.Location = location[0].Location;
		data.header = true;
		DMPISARSvc.save(data).then(function (response) {
			if (response.success) {
				if (response.id) {
					data.id = response.id;
				}
				$uibModalInstance.close(data);
				AppSvc.showSwal('Success', response.message, 'success');
			} else {
				AppSvc.showSwal('Confirmation', response.message, 'warning');
			}
		});
	};
	modal.close = function () {
		$uibModalInstance.dismiss('cancel');
	};
}
function DMPISARSearchHeaderCtrl($scope, $ocLazyLoad, $injector, data, $uibModalInstance, filter) {
	var modal = this;
	var dateNow = new Date();
	modal.data = [];
	modal.list = [];
    modal.years = [];
    modal.filtered = [];
	$ocLazyLoad.load([BILLINGURL + 'dmpi_sar/service.js?v=' + VERSION]).then(function (d) {
		DMPISARSvc = $injector.get('DMPISARSvc');
		modal.startSearch(dateNow.getFullYear());
        modal.displayYears();
	});
    modal.displayYears = function () {
		var year = dateNow.getFullYear();
		modal.years.push({ year: year - 2 });
		modal.years.push({ year: year - 1 });
		modal.years.push({ year: year });
		modal.years.push({ year: year + 1 });
		modal.years.push({ year: year + 2 });
		modal.year = dateNow.getFullYear().toString();
	};
	modal.startSearch = function (year) {
		DMPISARSvc.get({ search: true, year: year }).then(function (response) {
			if (response.message) {
				modal.list = [];
			} else {
				modal.list = response;
			}
			modal.filtered = modal.list;
		});
	};
	modal.defaultGrid = {
		enableRowSelection: true,
		enableCellEdit: false,
		enableColumnMenus: false,
		modifierKeysToMultiSelect: true,
		enableRowHeaderSelection: false,
		columnDefs: [
			{ name: 'SOA Number', displayName: 'Control No', field: 'controlNo', width: 200 },
			{ name: 'SOA Date', displayName: 'SOA Date', field: 'soaDate', width: 200 },
			{ name: 'Encoded By', displayName: 'Encoded By', field: 'adminencodedby', width: 200 },
			{ name: 'Created', displayName: 'Created', field: 'created_at', width: 200 },
			{ name: 'Last Updated', displayName: 'Last Updated', field: 'updated_at', width: 200 },
		],
		data: 'modal.filtered',
		onRegisterApi: function (gridApi) {
			gridApi.selection.on.rowSelectionChanged(null, function (row) {
				$uibModalInstance.close(row.entity);
			});
		},
	};

	modal.searching = function (type) {
		if (type == 1) {
			modal.filtered = filter('filter')(modal.list, { soaNumber: modal.statementNumber });
		} else if (type == 2) {
			modal.filtered = filter('filter')(modal.list, { controlNo: modal.controlNo });
		}
	};

	modal.getActive = function () {
		DMPISARSvc.get({ active: true }).then(function (response) {
			if (response.message) {
				modal.list = [];
			} else {
				modal.list = response;
			}
			modal.filtered = modal.list;
		});
	};
	modal.close = function () {
		$uibModalInstance.dismiss('cancel');
	};
}
function DMPISARDetailCtrl($scope, $ocLazyLoad, $injector, data, $uibModalInstance) {
	var modal = this;
	var filter = $injector.get('$filter');
	modal.variables = {};
	modal.variables.link = 0;
	modal.volumeType = data.type;
	modal.hdr_id = data.hdr_id;
	modal.rates = [];
	modal.activities = [];
	modal.batches = [];
	modal.dayBatch = [
		{ id: 1, batchDay: 'REGULAR DAY' },
		{ id: 2, batchDay: 'SPECIAL HOLIDAY' },
		{ id: 3, batchDay: 'SPECIAL HOLIDAY ON REST DAY' },
		{ id: 4, batchDay: 'REGULAR HOLIDAY' },
		{ id: 5, batchDay: 'REGULAR HOLIDAY ON REST DAY' },
	];
	var dateNow = new Date();
	modal.years = [];
	$ocLazyLoad
		.load([BILLINGURL + 'dmpi_sar/service.js?v=' + VERSION, BILLINGURL + 'dmpi_dar/service.js?v=' + VERSION])
		.then(function (d) {
			DMPISARSvc = $injector.get('DMPISARSvc');
			DMPIDARSvc = $injector.get('DMPIDARSvc');
			modal.getActivities();
			modal.displayYears();
		});
	modal.displayYears = function () {
		var year = dateNow.getFullYear();
		modal.years.push({ year: year - 2 });
		modal.years.push({ year: year - 1 });
		modal.years.push({ year: year });
		modal.years.push({ year: year + 1 });
		modal.years.push({ year: year + 2 });
		modal.variables.year = dateNow.getFullYear().toString();
	};
	modal.getActivities = function () {
		DMPISARSvc.get({ activity: true }).then(function (response) {
			if (response.message) {
				modal.rates = [];
				modal.activities = [];
			} else {
				angular.forEach(response.groupBy('activity'), function (key, value) {
					modal.activities.push({ activity: value });
				});
				modal.rates = response;
			}
			if (data.variables) {
				modal.variables = angular.copy(data.variables);
				modal.getUnits();
			}
		});
		modal.getGL();
	};
	modal.getGL = function () {
		DMPISARSvc.get({ gl: true }).then(function (response) {
			if (response.message) {
				modal.gls = [];
			} else {
				modal.gls = response;
			}
		});
	};
	modal.getBatch = function () {
		modal.variables.pmy = modal.variables.year + AppSvc.pad(modal.variables.month, 2);
		var data = { batch: true, period: modal.variables.pmy, phase: modal.variables.period };
		if (modal.variables.year && modal.variables.month && modal.variables.period) {
			modal.batchIsLoading = true;
			DMPIDARSvc.get(data).then(function (response) {
				if (response.message) {
					modal.batches = [];
				} else {
					modal.batches = response;
				}
				modal.batchIsLoading = false;
			});
		}
	};
	modal.searchPO = function () {
		var options = {
			data: 'menu',
			animation: true,
			templateUrl: SETTINGSURL + 'po_sar_master/sar_view.html?v=' + VERSION,
			controllerName: 'SARPOViewCtrl',
			viewSize: 'lg',
			filesToLoad: [
				SETTINGSURL + 'po_sar_master/sar_view.html?v=' + VERSION,
				SETTINGSURL + 'po_sar_master/controller.js?v=' + VERSION,
			],
		};
		AppSvc.modal(options).then(function (data) {
			if (data) {
				modal.variables.poNumber = data.poNumber;
				modal.variables.poID = data.id;
				// modal.variables.rate = data.rate;
			}
		});
	};
	modal.getUnits = function () {
		if (modal.rates.length > 0) {
			var l = filter('filter')(modal.rates, { activity: modal.variables.activity }, true);
			modal.units = l;
		} else {
			modal.units = [];
		}
	};
	modal.changeRate = function () {
		if (modal.variables.batchDaytypeID) {
			if (modal.variables.unit) {
				var type = filter('filter')(modal.dayBatch, { id: parseInt(modal.variables.batchDaytypeID) }, true);
				var unit = filter('filter')(
					modal.rates,
					{ activity: modal.variables.activity, unit: modal.variables.unit },
					true
				);
				modal.variables.batchDaytype = type[0].batchDay;
				if (modal.variables.batchDaytypeID == 1) {
					modal.variables.rate = unit[0].rd_rate;
				} else if (modal.variables.batchDaytypeID == 2) {
					modal.variables.rate = unit[0].shol_rate;
				} else if (modal.variables.batchDaytypeID == 3) {
					modal.variables.rate = unit[0].shrd_rate;
				} else if (modal.variables.batchDaytypeID == 4) {
					modal.variables.rate = unit[0].rhol_rate;
				} else if (modal.variables.batchDaytypeID == 5) {
					modal.variables.rate = unit[0].rhrd_rate;
				} else {
					modal.variables.rate = 0;
				}
			} else {
				modal.variables.rate = 0;
				modal.variables.rate_id = 0;
			}
		} else {
			modal.variables.rate = 0;
		}
		modal.calculateAmount();
	};
	modal.changeGL = function () {
		if (modal.variables.glID) {
			var gl = filter('filter')(modal.gls, { id: modal.variables.glID }, true);
			modal.variables.gl = gl[0].gl;
		}
	};
	modal.calculateAmount = function () {
		if (modal.variables.qty && modal.variables.rate) {
			var rate = parseFloat(AppSvc.getAmount(modal.variables.rate));
			var qty = parseFloat(AppSvc.getAmount(modal.variables.qty));
			modal.variables.amount = rate * qty;
		} else {
			modal.variables.amount = 0;
		}
	};
	modal.save = function () {
		var data = angular.copy(modal.variables);
		data.rate = AppSvc.getAmount('' + modal.variables.rate);
		data.qty = AppSvc.getAmount('' + modal.variables.qty);
		data.amount = AppSvc.getAmount('' + modal.variables.amount);
		data.hdr_id = modal.hdr_id;
		data.details = true;
		DMPISARSvc.save(data).then(function (response) {
			if (response.success) {
				if (response.id) {
					data.id = response.id;
				}
				$uibModalInstance.close(data);
				AppSvc.showSwal('Success', response.message, 'success');
			} else {
				AppSvc.showSwal('Confirmation', 'Nothing to Update', 'warning');
			}
		});
	};
	modal.close = function () {
		$uibModalInstance.dismiss('cancel');
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
function ReactivateSARCtrl($scope, $ocLazyLoad, $injector, data, $uibModalInstance) {
	var modal = this;
	modal.variables = {};
	modal.variables.id = data;
	modal.reactivate = function () {
		modal.variables.reactivate = true;
		DMPISARSvc.save(modal.variables).then(function (response) {
			if (response.success) {
				$uibModalInstance.close(true);
				AppSvc.showSwal('Success', response.message, 'success');
			} else {
				AppSvc.showSwal('Error', response.message, 'error');
			}
		});
	};
	modal.close = function () {
		$uibModalInstance.dismiss('cancel');
	};
}
function DMPISARTransmittalSearchCtrl($scope, $ocLazyLoad, $injector, data, $uibModalInstance) {
	var modal = this;
	modal.data = [];
	modal.list = [];
	$ocLazyLoad.load([BILLINGURL + 'dmpi_sar/service.js?v=' + VERSION]).then(function (d) {
		DMPISARSvc = $injector.get('DMPISARSvc');
	});
	modal.defaultGrid = {
		enableRowSelection: true,
		enableCellEdit: false,
		enableColumnMenus: false,
		modifierKeysToMultiSelect: true,
		enableRowHeaderSelection: false,
		columnDefs: [
			{ name: 'Date', field: 'date', width: 200 },
			{ name: 'Transmittal No', field: 'TransmittalNo', width: 200 },
			{ name: 'Period Covered', field: 'period', width: 200 },
			{ name: 'Transmitted By', field: 'transmitted_by', width: 200 },
		],
		data: 'modal.list',
		onRegisterApi: function (gridApi) {
			gridApi.selection.on.rowSelectionChanged(null, function (row) {
				$uibModalInstance.close(row.entity);
			});
		},
	};
	modal.searching = function () {
		DMPISARSvc.get({ searchTransmittal: true, transmittalNo: modal.search }).then(function (response) {
			if (response.message) {
				modal.list = [];
			} else {
				modal.list = response;
			}
		});
	};
	modal.close = function () {
		$uibModalInstance.dismiss('cancel');
	};
}
function SARTransmittalDetails($scope, $ocLazyLoad, $injector, data, $uibModalInstance, filter) {
	var modal = this;
	modal.TID = angular.copy(data);
	var dateNow = new Date();
	modal.data = [];
	modal.list = [];
    modal.years = [];
    modal.filtered = [];
	$ocLazyLoad.load([BILLINGURL + 'dmpi_sar/service.js?v=' + VERSION]).then(function (d) {
		DMPISARSvc = $injector.get('DMPISARSvc');
		modal.startSearch(dateNow.getFullYear());
		modal.displayYears();
	});
	modal.displayYears = function () {
		var year = dateNow.getFullYear();
		modal.years.push({ year: year - 2 });
		modal.years.push({ year: year - 1 });
		modal.years.push({ year: year });
		modal.years.push({ year: year + 1 });
		modal.years.push({ year: year + 2 });
		modal.year = dateNow.getFullYear().toString();
	};
	modal.startSearch = function (year) {
		DMPISARSvc.get({ search: true, year: year }).then(function (response) {
			if (response.message) {
				modal.list = [];
			} else {
				modal.list = response;
			}
			modal.filtered = modal.list;
		});
	};
	modal.defaultGrid = {
		enableRowSelection: true,
		enableCellEdit: false,
		enableColumnMenus: false,
		modifierKeysToMultiSelect: true,
		enableRowHeaderSelection: false,
		columnDefs: [
			{ name: 'SOA Number', displayName: 'SOA Number', field: 'controlNo', width: 200 },
			{ name: 'SOA Date', displayName: 'SOA Date', field: 'soaDate', width: 200 },
			{ name: 'Encoded By', displayName: 'Encoded By', field: 'adminencodedby', width: 200 },
			{ name: 'Created', displayName: 'Created', field: 'created_at', width: 200 },
			{ name: 'Last Updated', displayName: 'Last Updated', field: 'updated_at', width: 200 },
		],
		data: 'modal.list',
		onRegisterApi: function (gridApi) {
			gridApi.selection.on.rowSelectionChanged(null, function (row) {
				modal.saveRow(row.entity);
			});
		},
	};
	modal.saveRow = function (row) {
		AppSvc.confirmation('Are You Sure?', 'Are you sure you want to add this record?', 'Proceed', 'Cancel').then(
			function (data) {
				if (data) {
					DMPISARSvc.save({ id: row.id, updateTransmittal: true, TID: modal.TID }).then(function (response) {
						if (response.success) {
							$uibModalInstance.close(row);
						} else {
							return AppSvc.showSwal('Error', 'Already in the transmittal', 'error');
						}
					});
				}
			}
		);
	};
	modal.searching = function (type) {
		if (type == 1) {
			modal.filtered = filter('filter')(modal.list, { soaNumber: modal.statementNumber });
		} else if (type == 2) {
			modal.filtered = filter('filter')(modal.list, { controlNo: modal.controlNo });
		}
	};

	modal.getActive = function () {
		DMPISARSvc.get({ active: true }).then(function (response) {
			if (response.message) {
				modal.list = [];
			} else {
				modal.list = response;
			}
		});
	};
	modal.close = function () {
		$uibModalInstance.dismiss('cancel');
	};
}
