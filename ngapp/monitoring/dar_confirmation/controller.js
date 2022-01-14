angular
	.module('app')
	.controller('DARConfirmationCtrl', DARConfirmationCtrl)
	.controller('SOADetailsCtrl', SOADetailsCtrl);

DARConfirmationCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector', '$filter'];
SOADetailsCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector', 'data', '$uibModalInstance'];

function DARConfirmationCtrl($scope, $ocLazyLoad, $injector, filter) {
	var vm = this;
	var defaultValue = 'GSMPC-';
	vm.searchSOA = defaultValue;
	vm.variables = {};
	vm.list = [];
	vm.filtered = [];
	vm.totalAmount = 0;
	vm.sortAcctDate = [];
	$ocLazyLoad
		.load([MONURL + 'dar_confirmation/service.js?v=' + VERSION, BILLINGURL + 'dmpi_dar/service.js?v=' + VERSION])
		.then(function (d) {
			DSConfirmationSvc = $injector.get('DSConfirmationSvc');
			DMPIDARSvc = $injector.get('DMPIDARSvc');
			vm.getTransmittalNos();
		});
	vm.getTransmittalNos = function () {
		LOADING.classList.add('open');
		DMPIDARSvc.get({ autoNo: true }).then(function (response) {
			if (response.message) {
				vm.transmittalNos = [];
			} else {
				vm.transmittalNos = response;
			}
			LOADING.classList.remove('open');
		});
	};
	vm.changeTransmittal = function () {
		if (!vm.searchTrans) {
			return (vm.transmittals = vm.transmittalNos);
		}
		vm.transmittals = filter('filter')(vm.transmittalNos, { TransmittalNo: vm.searchTrans });
	};
	vm.clickTransmittal = function (row) {
		vm.transmittals = [];
		vm.searchTrans = row.TransmittalNo;
	};
	vm.searchTransmittal = function () {
		var data = {
			transmittal: true,
			search: vm.searchTrans,
		};
		LOADING.classList.add('open');
		DSConfirmationSvc.get(data).then(function (response) {
			if (response.message) {
				vm.list = [];
				vm.totalAmount = 0;
			} else {
				var no = 1;
				vm.totalAmount = 0;
				response.forEach(function (item) {
					item.No = no;
					no++;
					item.PPeriod = item.pmy + '-' + item.period;
					vm.totalAmount = vm.totalAmount + parseFloat(item.Amount);
				});
				vm.list = response;
				vm.filtered = vm.list;
			}
			LOADING.classList.remove('open');
		});
	};
	vm.checkAcctDate = function () {
		vm.sortAcctDate = [];
		var grouped = groupByKey(vm.list, 'DMPIReceivedDate');
		for (var key in grouped) {
			var soas = [];
			grouped[key].forEach(function (item) {
				soas.push(item.soaNumber);
			});
			vm.sortAcctDate.push({ length: grouped[key].length, key: key, soas: soas.join("] [") });
		}
		if (vm.sortAcctDate.length > 1) {
			return true;
		}
		return false;
	};
	function groupByKey(array, key) {
		return array.reduce((hash, obj) => {
			if (obj[key] === undefined) return hash;
			return Object.assign(hash, { [obj[key]]: (hash[obj[key]] || []).concat(obj) });
		}, {});
	}
	vm.searchControlNo = function () {
		if (vm.searchCNo) {
			return (vm.filtered = filter('filter')(vm.list, { id: vm.searchCNo }));
		}
		vm.filtered = vm.list;
		// var data = {
		//     controlNo: true,
		//     search: vm.searchCNo
		// }
		// LOADING.classList.add("open");
		// DSConfirmationSvc.get(data).then(function (response) {
		//     if (response.message) {
		//         vm.list = [];
		//     } else {
		//         var no = 1;
		//         response.forEach(function (item) {
		//             item.No = no;
		//             no++;
		//             item.PPeriod = item.pmy + '-' + item.period;
		//         })
		//         vm.list = response;
		//     }
		//     LOADING.classList.remove("open");
		// })
	};
	vm.searchSOANumber = function () {
		if (!vm.searchSOA || defaultValue !== vm.searchSOA.substring(0, 6)) {
			vm.searchSOA = defaultValue;
			vm.filtered = vm.statusFiltered;
		} else {
			return (vm.filtered = filter('filter')(vm.list, { soaNumber: vm.searchSOA }));
		}
		// var data = {
		//     soaNumber: true,
		//     search: vm.searchSOA
		// }
		// LOADING.classList.add("open");
		// DSConfirmationSvc.get(data).then(function (response) {
		//     if (response.message) {
		//         vm.list = [];
		//     } else {
		//         var no = 1;
		//         response.forEach(function (item) {
		//             item.No = no;
		//             no++;
		//             item.PPeriod = item.pmy + '-' + item.period;
		//         })
		//         vm.list = response;
		//     }
		//     LOADING.classList.remove("open");
		// })
	};
	var rowTemplate =
		'<div ng-repeat="(colRenderIndex, col) in colContainer.renderedColumns track by col.colDef.name" class="ui-grid-cell"  ui-grid-cell context-menu="grid.appScope.vm.rightClick(row.entity)"></div>';
	vm.defaultGrid = {
		enableRowSelection: true,
		enableCellEdit: false,
		enableColumnMenus: false,
		modifierKeysToMultiSelect: false,
		enableRowHeaderSelection: true,
		columnDefs: [
			{ name: 'No.', field: 'No', width: 80 },
			{ name: 'Control No.', field: 'id', width: 135 },
			{ name: 'SOA No', displayName: 'SOA No', field: 'soaNumber', width: 200 },
			{ name: 'Batch No', field: 'Batches', width: 200 },
			{ name: 'SOA Date', displayName: 'SOA Date', field: 'soaDate', width: 200 },
			{ name: 'Location', displayName: 'Location', field: 'Location', width: 200 },
			{ name: 'Period', displayName: 'Period', field: 'PPeriod', width: 200 },
			{ name: 'Status', field: 'status', width: 200 },
			{
				name: 'ST',
				displayName: 'ST',
				field: 'gtSt',
				width: 200,
				cellClass: 'text-right',
				cellFilter: 'number:2',
			},
			{
				name: 'OT',
				displayName: 'OT',
				field: 'gtOt',
				width: 200,
				cellClass: 'text-right',
				cellFilter: 'number:2',
			},
			{
				name: 'ND',
				displayName: 'ND',
				field: 'gtNd',
				width: 200,
				cellClass: 'text-right',
				cellFilter: 'number:2',
			},
			{
				name: 'NDOT',
				displayName: 'NDOT',
				field: 'gtNdot',
				width: 200,
				cellClass: 'text-right',
				cellFilter: 'number:2',
			},
			{ name: 'Amount', field: 'Amount', width: 200, cellClass: 'text-right', cellFilter: 'number:2' },
			{ name: 'Batch By', field: 'BatchedBy', width: 200 },
			{ name: 'Uploaded By', field: 'adminencodedby', width: 200 },
			{ name: 'Confirmed By', field: 'ConfirmationBy', width: 200 },
			{ name: 'Remarks', field: 'Remarks2', width: 200 },
		],
		data: 'vm.filtered',
		rowTemplate: rowTemplate,
		onRegisterApi: function (gridApi) {
			vm.gridApi = gridApi;
			// gridApi.selection.on.rowSelectionChanged(null, function (row) {
			//     vm.openDetails(row.entity);
			// });
		},
	};
	vm.rightClick = function (row) {
		var contextMenuData = [];
		contextMenuData.push([
			'View Details',
			function () {
				vm.openDetails(row);
			},
		]);
		// contextMenuData.push(['Set to transmitted', function () {
		//     vm.setToTransmitted(row);
		// }]);
		return contextMenuData;
	};
	vm.openDetails = function (row) {
		row.index = vm.list.indexOf(row);
		var options = {
			data: row,
			animation: true,
			templateUrl: MONURL + 'dar_confirmation/soa_details.html?v=' + VERSION,
			controllerName: 'SOADetailsCtrl',
			viewSize: 'full',
			filesToLoad: [
				MONURL + 'dar_confirmation/soa_details.html?v=' + VERSION,
				MONURL + 'dar_confirmation/controller.js?v=' + VERSION,
			],
		};
		AppSvc.modal(options).then(function (data) {
			if (data) {
				row.status = 'confirmed';
				row.Remarks2 = data.Remarks2;
				vm.list(row.index, 1, row);
			}
		});
	};
	vm.previewTransmittal = function () {
		if (vm.list.length == 0) {
			return AppSvc.showSwal('Confirmation', 'Search Transmittal First', 'warning');
		}
		window.open('report/dmpi_oc/transmittal_report?summary=true&copy=2&preview=true&transmitNo=' + vm.searchTrans);
	};
	vm.bulkConfirm = function () {
		vm.displaySorts = false;
		if (vm.checkAcctDate()) {
			return (vm.displaySorts = true);
		}
		var rows = vm.gridApi.selection.getSelectedRows();
		if (rows.length == 0) {
			return AppSvc.showSwal('Confirmation', 'No SOA to be confirmed', 'warning');
		}
		var allConfirmed = true;
		var user = false;
		var data = [];
		rows.forEach(function (item) {
			if (item.status !== 'transmitted') {
				allConfirmed = false;
			}
			if (parseInt(item.adminencodedById) == parseInt(vm.userID)) {
				user = true;
			}
			data.push(item.id);
		});
		if (!allConfirmed) {
			return AppSvc.showSwal('Confirmation', 'Cannot Proceed. Check details first', 'warning');
		}
		if (user) {
			return AppSvc.showSwal('Error', 'You uploaded this. Cannot proceed.', 'error');
		}
		DSConfirmationSvc.save({ rows: data, bulkConfirmation: true }).then(function (response) {
			if (response.success) {
				vm.list.forEach(function (item) {
					item.status = 'confirmed';
				});
				AppSvc.showSwal('Success', response.message, 'success');
			} else {
				AppSvc.showSwal('Error', 'Something went wrong', 'error');
			}
		});
	};
}
function SOADetailsCtrl($scope, $ocLazyLoad, $injector, data, $uibModalInstance) {
	var modal = this;
	modal.variables = angular.copy(data);
	modal.variables.soaDate = new Date(data.soaDate);
	modal.details;
	$ocLazyLoad
		.load([MONURL + 'dar_confirmation/service.js?v=' + VERSION, BILLINGURL + 'dmpi_dar/service.js?v=' + VERSION])
		.then(function (d) {
			DSConfirmationSvc = $injector.get('DSConfirmationSvc');
			DMPIDARSvc = $injector.get('DMPIDARSvc');
			modal.getDetails(modal.variables.id);
		});
	modal.getDetails = function (id) {
		DSConfirmationSvc.get({ details: true, id: id }).then(function (response) {
			if (response.message) {
				modal.details = [];
			} else {
				var No = 1;
				modal.totalRDST = 0;
				modal.totalRDOT = 0;
				modal.totalRDND = 0;
				modal.totalRDNDOT = 0;

				modal.totalSHOLST = 0;
				modal.totalSHOLOT = 0;
				modal.totalSHOLND = 0;
				modal.totalSHOLNDOT = 0;

				modal.totalSHRDST = 0;
				modal.totalSHRDOT = 0;
				modal.totalSHRDND = 0;
				modal.totalSHRDNDOT = 0;

				modal.totalRHOLST = 0;
				modal.totalRHOLOT = 0;
				modal.totalRHOLND = 0;
				modal.totalRHOLNDOT = 0;

				modal.totalRHRDST = 0;
				modal.totalRHRDOT = 0;
				modal.totalRHRDND = 0;
				modal.totalRHRDNDOT = 0;

				modal.totalST = 0;
				modal.totalOT = 0;
				modal.totalND = 0;
				modal.totalNDOT = 0;

				modal.amountST = 0;
				modal.amountOT = 0;
				modal.amountND = 0;
				modal.amountNDOT = 0;

				modal.totalAmt = 0;
				modal.totalHC = 0;
				response.forEach(function (item) {
					item.No = No++;
					modal.totalRDST = modal.totalRDST + parseFloat(item.rdst);
					modal.totalRDOT = modal.totalRDOT + parseFloat(item.rdot);
					modal.totalRDND = modal.totalRDND + parseFloat(item.rdnd);
					modal.totalRDNDOT = modal.totalRDNDOT + parseFloat(item.rdndot);

					modal.totalSHOLST = modal.totalSHOLST + parseFloat(item.sholst);
					modal.totalSHOLOT = modal.totalSHOLOT + parseFloat(item.sholot);
					modal.totalSHOLND = modal.totalSHOLND + parseFloat(item.sholnd);
					modal.totalSHOLNDOT = modal.totalSHOLNDOT + parseFloat(item.sholndot);

					modal.totalSHRDST = modal.totalSHRDST + parseFloat(item.shrdst);
					modal.totalSHRDOT = modal.totalSHRDOT + parseFloat(item.shrdot);
					modal.totalSHRDND = modal.totalSHRDND + parseFloat(item.shrdnd);
					modal.totalSHRDNDOT = modal.totalSHRDNDOT + parseFloat(item.shrdndot);

					modal.totalRTST = modal.totalSHRDST + parseFloat(item.rtst);
					modal.totalRTOT = modal.totalRTOT + parseFloat(item.rtot);
					modal.totalRTND = modal.totalRTND + parseFloat(item.rtnd);
					modal.totalRTNDOT = modal.totalRTNDOT + parseFloat(item.rtndot);

					modal.totalRHOLST = modal.totalRHOLST + parseFloat(item.rholst);
					modal.totalRHOLOT = modal.totalRHOLOT + parseFloat(item.rholot);
					modal.totalRHOLND = modal.totalRHOLND + parseFloat(item.rholnd);
					modal.totalRHOLNDOT = modal.totalRHOLNDOT + parseFloat(item.rholndot);

					modal.totalRHRDST = modal.totalRHRDST + parseFloat(item.rhrdst);
					modal.totalRHRDOT = modal.totalRHRDOT + parseFloat(item.rhrdot);
					modal.totalRHRDND = modal.totalRHRDND + parseFloat(item.rhrdnd);
					modal.totalRHRDNDOT = modal.totalRHRDNDOT + parseFloat(item.rhrdndot);

					modal.totalST =
						modal.totalRDST + modal.totalSHOLST + modal.totalSHRDST + modal.totalRHOLST + modal.totalRHRDST + modal.totalRTST;
					modal.totalOT =
						modal.totalRDOT + modal.totalSHOLOT + modal.totalSHRDOT + modal.totalRHOLOT + modal.totalRHRDOT  + modal.totalRTOT;
					modal.totalND =
						modal.totalRDND + modal.totalSHOLND + modal.totalSHRDND + modal.totalRHOLND + modal.totalRHRDND  + modal.totalRTND;
					modal.totalNDOT =
						modal.totalRDNDOT +
						modal.totalSHOLNDOT +
						modal.totalSHRDNDOT +
						modal.totalRHOLNDOT +
						modal.totalRHRDNDOT +
						modal.totalRTNDOT;

					modal.amountST = modal.amountST + parseFloat(item.c_totalst);
					modal.amountOT = modal.amountOT + parseFloat(item.c_totalot);
					modal.amountND = modal.amountND + parseFloat(item.c_totalnd);
					modal.amountNDOT = modal.amountNDOT + parseFloat(item.c_totalndot);

					modal.totalAmt = modal.totalAmt + parseFloat(item.c_totalAmt);
					modal.totalHC = modal.totalHC + parseFloat(item.headCount);
				});
				modal.details = response;
			}
		});
	};
	modal.updateStatus = function (status) {
		AppSvc.confirmation(
			'Confirmation',
			'Are You sure you want to update status to ' + status + '?',
			'Confirm',
			'Cancel'
		).then(function (data) {
			if (data) {
				DMPIDARSvc.save({
					updateStatus: true,
					status: status,
					id: modal.variables.id,
					uploadedBy: modal.variables.adminencodedById,
				}).then(function (response) {
					if (response.success) {
						$uibModalInstance.close(modal.variables);
						AppSvc.showSwal('Success', response.message, 'success');
					} else {
						if (response.message === 'Exist') {
							AppSvc.showSwal('Error', 'You uploaded this. Cannot proceed.', 'error');
						} else {
							AppSvc.showSwal('Error', 'Something went wrong', 'error');
						}
					}
				});
			}
		});
	};
	modal.saveRemarks = function () {
		DMPIDARSvc.save({ saveRemarks2: true, Remarks2: modal.variables.Remarks2, id: modal.variables.id }).then(
			function (response) {
				if (response.success) {
					AppSvc.showSwal('Success', response.message, 'success');
				} else {
					AppSvc.showSwal('Error', 'Something went wrong', 'error');
				}
			}
		);
	};
	modal.print = function () {
		window.open('report/dar_billing?excel=true&id=' + modal.variables.id);
	};
	modal.close = function () {
		$uibModalInstance.dismiss('cancel');
	};
}
