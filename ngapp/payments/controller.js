angular
	.module('app')
	.controller('PaymentCtrl', PaymentCtrl)
	.controller('PaymentHDRCtrl', PaymentHDRCtrl)
	.controller('ClientHDRCtrl', ClientHDRCtrl)
	.controller('PaymentDetailsCtrl', PaymentDetailsCtrl)
	.controller('PaymentUploadCtrl', PaymentUploadCtrl)
	.controller('UploadSOAPerCheckCtrl', UploadSOAPerCheckCtrl)
	.controller('InspectSOACtrl', InspectSOACtrl)
	.controller('OverPaymentCtrl', OverPaymentCtrl)

PaymentCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector'];
PaymentHDRCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector', 'data', '$uibModalInstance'];
ClientHDRCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector', 'data', '$uibModalInstance'];
PaymentDetailsCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector', 'data', '$uibModalInstance'];
PaymentUploadCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector', 'data', '$uibModalInstance', '$q', '$filter'];
UploadSOAPerCheckCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector', 'data', '$uibModalInstance', '$q', '$filter'];
InspectSOACtrl.$inject = ['$scope', '$ocLazyLoad', '$injector', 'data', '$uibModalInstance', '$q', '$filter'];
OverPaymentCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector', 'data', '$uibModalInstance', '$q', '$filter'];

function PaymentCtrl($scope, $ocLazyLoad, $injector) {
	var vm = this;
	vm.variables = {};
	vm.checkDetails = {};
	vm.variables.Date = new Date();
	vm.payments = [];
	vm.notSaved = [];
	vm.soas = [];
	vm.excelTitle = 'DAR Collection';
	$ocLazyLoad.load([PAYURL + 'service.js?v=' + VERSION]).then(function (d) {
		PaymentSvc = $injector.get('PaymentSvc');
	});
	vm.getDetails = function (id) {
		PaymentSvc.get({ details: true, id: id }).then(function (response) {
			if (response.message) {
				vm.payments = [];
			} else {
				vm.payments = response;
				vm.calculateTotalAmount();
			}
		});
	};
	var cellTemplate1 =
		'<div class="text-center pointer" style="display: flex;height: 100%;justify-content: center;align-items: center;" ng-click="grid.appScope.vm.addPayment(row.entity)"><span class="fa fa-edit text-success"></span></div>';
	var cellTemplate2 =
		'<div class="text-center pointer" style="display: flex;height: 100%;justify-content: center;align-items: center;" ng-click="grid.appScope.vm.deleteDetails(row.entity)"><span class="fa fa-trash text-danger"></span></div>';
	vm.paymentGrid = {
		enableRowSelection: true,
		enableCellEdit: false,
		enableColumnMenus: false,
		modifierKeysToMultiSelect: true,
		enableRowHeaderSelection: false,
		columnDefs: [
			{ name: '  ', cellTemplate: cellTemplate1, width: 20 },
			{ name: ' ', cellTemplate: cellTemplate2, width: 20 },
			{ name: 'Mode', field: 'Mode', width: 200 },
			{ name: 'Payment Date', field: 'PayDate', width: 200 },
			{ name: 'ORNo/RefNo', displayName: 'ORNo/RefNo', field: 'ORNo', width: 200 },
			{ name: 'CardNo', displayName: 'CardNo', field: 'CardNo', width: 200 },
			{ name: 'BankName', displayName: 'BankName', field: 'BankName', width: 200 },
			{ name: 'Amount', field: 'Amount', width: 200, cellClass: 'text-right', cellFilter: 'number: 2' },
			{ name: 'Remarks', field: 'Remarks', width: 200 },
			{ name: 'UploadedBy', field: 'UploadedBy', width: 200 },
			{ name: 'UploadDate', field: 'UploadedDate', width: 200, cellFilter: "date: 'MMM dd, yyyy'" },
		],
		data: 'vm.payments',
		onRegisterApi: function (gridApi) {
			gridApi.selection.on.rowSelectionChanged(null, function (row) {
				vm.checkDetails = angular.copy(row.entity);
				vm.excelTitle = row.entity.CardNo + '-' + vm.payments.indexOf(row.entity);
				vm.getSOAS(row.entity.PDTLID, vm.variables.Client);
			});
		},
	};
	vm.deleteDetails = function (row) {
		var dataPass = { deleteDtls: true, id: row.PDTLID, client: vm.variables.Client };
		var index = vm.payments.indexOf(row);
		AppSvc.confirmation(
			'Confirm Deletion?',
			'Are you sure you want to delete this record?',
			'Delete',
			'Cancel',
			true
		).then(function (data) {
			if (data) {
				PaymentSvc.save(dataPass).then(function (response) {
					if (response.success) {
						vm.payments.splice(index, 1);
						vm.soas = [];
						AppSvc.showSwal('Success', response.message, 'success');
					} else {
						AppSvc.showSwal('Error', 'Something went wrong', 'error');
					}
				});
			}
		});
	};
	vm.soaGrid = {
		enableRowSelection: true,
		enableCellEdit: false,
		enableColumnMenus: false,
		modifierKeysToMultiSelect: true,
		enableRowHeaderSelection: false,
		enableGridMenu: true,
		exporterMenuCsv: false,
		exporterMenuExcel: true,
		exporterMenuPdf: false,
		exporterExcelFilename: vm.excelTitle + '.xlsx',
		exporterExcelSheetName: 'Sheet1',
		columnDefs: [
			{ name: 'SOA Date', displayName: 'SOA Date', field: 'soaDate', cellFilter: "date: 'MMM dd, yyyy'" },
			{ name: 'SOA Number', displayName: 'SOA Number', field: 'soaNumber' },
			{
				name: 'SOA Amount',
				displayName: 'SOA Amount',
				field: 'Amount',
				cellClass: 'text-right',
				cellFilter: 'number: 2',
			},
			{ name: 'Amount Paid', field: 'AmountPaid', cellClass: 'text-right', cellFilter: 'number: 2' },
			{ name: 'Balance Amt.', field: 'Balance', cellClass: 'text-right', cellFilter: 'number: 2' },
		],
		data: 'vm.soas',
		onRegisterApi: function (gridApi) {
			gridApi.selection.on.rowSelectionChanged(null, function (row) {
				// $uibModalInstance.close(row.entity)
			});
		},
	};
	vm.searchHeader = function () {
		var options = {
			data: vm.variables.Client,
			animation: true,
			templateUrl: PAYURL + 'payment_hdr.html?v=' + VERSION,
			controllerName: 'PaymentHDRCtrl',
			viewSize: 'lg',
			filesToLoad: [PAYURL + 'payment_hdr.html?v=' + VERSION, PAYURL + 'controller.js?v=' + VERSION],
		};
		AppSvc.modal(options).then(function (data) {
			if (data) {
				vm.variables = angular.copy(data);
				vm.variables.Date = new Date(data.Date);
				vm.notSaved = [];
				vm.soas = [];
				vm.getDetails(data.PHDRID);
			}
		});
	};
	vm.getSOAS = function (id, client) {
		PaymentSvc.get({ id: id, client: client, paymentSOA: true }).then(function (response) {
			if (response.message) {
				vm.soas = [];
			} else {
				response.forEach(function (item) {
					item.Balance = parseFloat(item.Amount) - parseFloat(item.AmountPaid);
				});
				vm.soas = response;
				vm.getBalances();
			}
		});
	};
	vm.getBalances = function () {
		var payment = angular.copy(vm.variables.TotalAmount);
		var totalAmtPaid = 0;
		var totalBalance = 0;
		vm.soas.forEach(function (item) {
			totalAmtPaid = totalAmtPaid + parseFloat(item.AmountPaid);
			totalBalance = totalBalance + parseFloat(item.Balance);
		});
		vm.TotalPaid = totalAmtPaid;
		vm.BalancePayment = totalBalance;
	};
	vm.searchSOA = function () {
		if (!vm.variables.PHDRID) {
			return AppSvc.showSwal('Confirmation', 'Save Header First', 'warning');
		}
		var options = {
			data: vm.variables.Client,
			animation: true,
			templateUrl: PAYURL + 'search_hdr.html?v=' + VERSION,
			controllerName: 'ClientHDRCtrl',
			viewSize: 'lg',
			filesToLoad: [PAYURL + 'search_hdr.html?v=' + VERSION, PAYURL + 'controller.js?v=' + VERSION],
		};
		AppSvc.modal(options).then(function (data) {
			if (data) {
				vm.soas.push(data);
			}
		});
	};
	vm.inspectSOA = function () {
		var options = {
			data: '',
			animation: true,
			templateUrl: PAYURL + 'inspect_soa.html?v=' + VERSION,
			controllerName: 'InspectSOACtrl',
			viewSize: 'lg',
			filesToLoad: [PAYURL + 'inspect_soa.html?v=' + VERSION, PAYURL + 'controller.js?v=' + VERSION],
		};
		AppSvc.modal(options);
	};
	vm.addOverPayment = function () {
		var options = {
			data: '',
			animation: true,
			templateUrl: PAYURL + 'over_payment.html?v=' + VERSION,
			controllerName: 'OverPaymentCtrl',
			viewSize: 'md',
			filesToLoad: [PAYURL + 'over_payment.html?v=' + VERSION, PAYURL + 'controller.js?v=' + VERSION],
		};
		AppSvc.modal(options);
	}
	vm.calculateTotalAmount = function () {
		var sum = 0;
		var payment = angular.copy(vm.variables.TotalAmount);
		vm.payments.forEach(function (item) {
			sum = sum + parseFloat(item.Amount);
		});
		vm.variables.TotalAmount = sum;
	};
	vm.addPayment = function (row) {
		if (!vm.variables.PHDRID) {
			return AppSvc.showSwal('Confirmation', 'Save Header First', 'warning');
		}
		var data = { variables: vm.variables, payment: vm.payments.length > 0 ? vm.payments[0] : null };
		if (row) {
			action = true;
			row.index = vm.payments.indexOf(row);
			data.details = angular.copy(row);
		}
		var options = {
			data: data,
			animation: true,
			templateUrl: PAYURL + 'add_payment.html?v=' + VERSION,
			controllerName: 'PaymentDetailsCtrl',
			viewSize: 'lg',
			filesToLoad: [PAYURL + 'add_payment.html?v=' + VERSION, PAYURL + 'controller.js?v=' + VERSION],
		};
		AppSvc.modal(options).then(function (data) {
			if (data) {
				if (row) {
					vm.payments.splice(row.index, 1, data);
				} else {
					vm.payments.push(data);
				}
				vm.calculateTotalAmount();
			}
		});
	};
	vm.save = function () {
		var data = angular.copy(vm.variables);
		data.Date = AppSvc.getDate(vm.variables.Date);
		data.hdr = true;
		PaymentSvc.save(data).then(function (response) {
			if (response.success) {
				if (response.id) {
					vm.variables.PHDRID = response.id;
					vm.variables.PayNo = response.PayNo;
				}
				AppSvc.showSwal('Success', response.message, 'success');
			} else {
				AppSvc.showSwal('Confirmation', response.message, 'error');
			}
		});
	};
	vm.clearFunction = function () {
		vm.variables = {};
		vm.variables.Date = new Date();
		vm.payments = [];
		vm.soas = [];
		vm.notSaved = [];
		vm.TotalPaid = 0;
		vm.BalancePayment = 0;
		vm.excelTitle = 'No data';
	};
	vm.delete = function () {
		if (!vm.variables.PHDRID) {
			return AppSvc.showSwal('Confirmation', 'Save Header First', 'warning');
		}
		PaymentSvc.delete(vm.variables.PHDRID).then(function (response) {
			if (response.success) {
				vm.clearFunction();
				AppSvc.showSwal('Success', response.message, 'success');
			} else {
				AppSvc.showSwal('Error', response.message, 'error');
			}
			LOADING.classList.remove('open');
		});
	};
	vm.applyPayment = function () {
		var payment = angular.copy(vm.variables.TotalAmount);
		vm.soas.forEach(function (item) {
			if (item.Amount > payment) {
				item.AmountPaid = payment;
				item.Balance = parseFloat(item.Amount) - parseFloat(item.AmountPaid);
				payment = 0;
			} else {
				item.AmountPaid = parseFloat(item.Amount);
				item.Balance = parseFloat(item.Amount) - parseFloat(item.AmountPaid);
				payment = payment - parseFloat(item.Amount);
			}
		});
		vm.getBalances();
	};
	vm.savePayment = function () {
		if (!vm.variables.PHDRID) {
			return AppSvc.showSwal('Confirmation', 'Create Header First', 'warning');
		}
		if (!vm.checkDetails.PDTLID) {
			return AppSvc.showSwal('Confirmation', 'Select Check Details to Proceed', 'warning');
		}
		if (vm.soas.length == 0) {
			return AppSvc.showSwal('Confirmation', 'No SOA added', 'warning');
		}
		var rows = [];
		vm.soas.forEach(function (item) {
			rows.push({ SOAID: item.SOAID, PID: vm.variables.PHDRID, AmountPaid: item.AmountPaid, PDTLID: vm.checkDetails.PDTLID });
		});
		LOADING.classList.add('open');
		PaymentSvc.save({ savePayment: true, rows: rows, client: vm.variables.Client }).then(function (response) {
			if (response.success) {
				AppSvc.showSwal('Success', response.message, 'success');
			} else {
				AppSvc.showSwal('Error', response.message, 'error');
			}
			LOADING.classList.remove('open');
		});
	};
	vm.uploadPayment = function () {
		if (!vm.variables.PHDRID) {
			return AppSvc.showSwal('Confirmation', 'Save Header First', 'warning');
		}
		var ORNo = '';
		var CardNo = '';
		var PayDate = new Date();
		if (vm.payments.length > 0) {
			ORNo = vm.payments[0].ORNo;
			CardNo = vm.payments[0].CardNo;
			PayDate = new Date(vm.payments[0].PayDate);
		}
		var data = { variables: vm.variables, ORNo: ORNo, CardNo: CardNo, PayDate: PayDate };
		var options = {
			data: data,
			animation: true,
			templateUrl: PAYURL + 'payment_upload.html?v=' + VERSION,
			controllerName: 'PaymentUploadCtrl',
			viewSize: 'lg',
			filesToLoad: [PAYURL + 'payment_upload.html?v=' + VERSION, PAYURL + 'controller.js?v=' + VERSION],
		};
		AppSvc.modal(options).then(function (data) {
			if (data) {
				vm.notSaved = angular.copy(data.rows);
				vm.getDetails(vm.variables.PHDRID);
				vm.getSOAS(vm.variables.PHDRID, vm.variables.Client);
			}
		});
	};
	vm.uploadSOA = function () {
		if (!vm.checkDetails.PDTLID) {
			return AppSvc.showSwal('Confirmation', 'Select Check Details to Proceed', 'warning');
		}
		var options = {
			data: vm.checkDetails,
			animation: true,
			templateUrl: PAYURL + 'upload_check.html?v=' + VERSION,
			controllerName: 'UploadSOAPerCheckCtrl',
			viewSize: 'lg',
			filesToLoad: [PAYURL + 'upload_check.html?v=' + VERSION, PAYURL + 'controller.js?v=' + VERSION],
		};
		AppSvc.modal(options).then(function (data) {
			if (data) {
				vm.notSaved = angular.copy(data.rows);
				vm.getDetails(vm.variables.PHDRID);
				vm.getSOAS(vm.variables.PHDRID, vm.variables.Client);
			}
		});
	};
}

function PaymentHDRCtrl($scope, $ocLazyLoad, $injector, data, $uibModalInstance) {
	var modal = this;
	modal.searchBy = 'ORNo';
	modal.list = [];
	modal.defaultGrid = {
		enableRowSelection: true,
		enableCellEdit: false,
		enableColumnMenus: false,
		modifierKeysToMultiSelect: true,
		enableRowHeaderSelection: false,
		enableGridMenu: true,
		exporterMenuCsv: false,
		exporterMenuExcel: true,
		exporterMenuPdf: false,
		exporterExcelFilename: 'Payment Headers.xlsx',
		exporterExcelSheetName: 'Sheet1',
		columnDefs: [
			{ name: 'Date Created', field: 'Date', width: 200, cellFilter: "date: 'MMM dd, yyyy'" },
			{ name: 'Client', field: 'Client', width: 200 },
			{ name: 'OR No', displayName: 'OR No', field: 'ORNo', width: 200 },
			{ name: 'OR Date', displayName: 'OR Date', field: 'PayDate', width: 200, cellFilter: "date: 'MMM dd, yyyy'" },
			{ name: 'Check No', displayName: 'Check No', field: 'CardNo', width: 200 },
			{ name: 'Ref. No.', displayName: 'Ref. No.', field: 'PayNo', width: 200 },
			{ name: 'Total Amount', field: 'TotalAmount', width: 200, cellFilter: 'number:2', cellClass: 'text-right' },
		],
		data: 'modal.list',
		onRegisterApi: function (gridApi) {
			gridApi.selection.on.rowSelectionChanged(null, function (row) {
				$uibModalInstance.close(row.entity);
			});
		},
	};
	modal.searching = function () {
		var data = { field: modal.searchBy, payNo: modal.search, searchPayment: true };
		PaymentSvc.get(data).then(function (response) {
			if (response.message) {
				modal.list = [];
			} else {
				response.forEach(function (item) {
					item.TotalAmount = item.TotalAmount ? item.TotalAmount : 0;
				});
				modal.list = response;
			}
		});
	};
	modal.close = function () {
		$uibModalInstance.dismiss('cancel');
	};
}

function ClientHDRCtrl($scope, $ocLazyLoad, $injector, data, $uibModalInstance) {
	var modal = this;
	modal.Client = angular.copy(data);
	modal.list = [];
	modal.defaultGrid = {
		enableRowSelection: true,
		enableCellEdit: false,
		enableColumnMenus: false,
		modifierKeysToMultiSelect: true,
		enableRowHeaderSelection: false,
		columnDefs: [
			{ name: 'SOA Number', displayName: 'SOA Number', field: 'soaNumber', width: 200 },
			{ name: 'SOA Amount', field: 'Amount', width: 200, cellClass: 'text-right', cellFilter: 'number:2' },
			{ name: 'Amount Paid', field: 'AmountPaid', width: 200, cellClass: 'text-right', cellFilter: 'number:2' },
			{ name: 'Balance Amt.', field: 'Balance', width: 200, cellClass: 'text-right', cellFilter: 'number:2' },
		],
		data: 'modal.list',
		onRegisterApi: function (gridApi) {
			gridApi.selection.on.rowSelectionChanged(null, function (row) {
				$uibModalInstance.close(row.entity);
			});
		},
	};
	modal.searching = function () {
		var data = { soaNumber: modal.search };
		if (modal.Client === 'DAR') {
			data.dar = true;
		} else if (modal.Client === 'SAR') {
			data.sar = true;
		} else if (modal.Client === 'BCC') {
			data.bcc = true;
		} else if (modal.Client === 'SLERS') {
			data.slers = true;
		} else if (modal.Client === 'DEARBC') {
			data.dearbc = true;
		} else if (modal.Client === 'LABNOTIN') {
			data.labnotin = true;
		} else if (modal.Client === 'CLUBHOUSE') {
			data.clubhouse = true;
		}
		PaymentSvc.get(data).then(function (response) {
			if (response.message) {
				modal.list = [];
			} else {
				response.forEach(function (item) {
					item.AmountPaid = item.AmountPaid ? item.AmountPaid : 0;
					item.Balance = item.Amount - item.AmountPaid;
				});
				modal.list = response;
			}
		});
	};
	modal.close = function () {
		$uibModalInstance.dismiss('cancel');
	};
}
function InspectSOACtrl($scope, $ocLazyLoad, $injector, data, $uibModalInstance) {
	var modal = this;
	modal.variables = {};
	modal.variables.Type = 'Summary';
	modal.list = [];
	modal.defaultGrid = {
		enableRowSelection: true,
		enableCellEdit: false,
		enableColumnMenus: false,
		modifierKeysToMultiSelect: true,
		enableRowHeaderSelection: false,
		columnDefs: [
			{ name: 'SOA Number', displayName: 'SOA Number', field: 'soaNumber', width: 200 },
			{ name: 'SOA Amount', field: 'Amount', width: 200, cellClass: 'text-right', cellFilter: 'number:2' },
			{ name: 'Amount Paid', field: 'AmountPaid', width: 200, cellClass: 'text-right', cellFilter: 'number:2' },
			{ name: 'Balance Amt.', field: 'Balance', width: 200, cellClass: 'text-right', cellFilter: 'number:2' },
			{ name: 'OR No.', field: 'ORNo', width: 200 },
			{ name: 'OR Date', field: 'ORDate', width: 200 },
			{ name: 'Check No.', field: 'CheckNo', width: 200 },
			{ name: 'Ref No.', field: 'RefNo', width: 200 },
		],
		data: 'modal.list'
	};
	modal.detailedGrid = {
		enableRowSelection: true,
		enableCellEdit: false,
		enableColumnMenus: false,
		modifierKeysToMultiSelect: true,
		enableRowHeaderSelection: false,
		columnDefs: [
			{ name: 'SOA Number', displayName: 'SOA Number', field: 'soaNumber', width: 200 },
			{ name: 'OR No.', field: 'ORNo', width: 200 },
			{ name: 'OR Date', field: 'PayDate', width: 200 },
			{ name: 'Check No.', field: 'CardNo', width: 200 },
			{ name: 'Ref No.', field: 'Remarks', width: 200 },
		],
		data: 'modal.list'
	};
	modal.searching = function () {
		var data = { soaNumber: modal.search, type: modal.variables.Type };
		if (modal.variables.Client === 'DAR') {
			data.dar = true;
		} else if (modal.variables.Client === 'SAR') {
			data.sar = true;
		} else if (modal.variables.Client === 'BCC') {
			data.bcc = true;
		} else if (modal.variables.Client === 'SLERS') {
			data.slers = true;
		} else if (modal.variables.Client === 'DEARBC') {
			data.dearbc = true;
		} else if (modal.variables.Client === 'LABNOTIN') {
			data.labnotin = true;
		} else if (modal.variables.Client === 'CLUBHOUSE') {
			data.clubhouse = true;
		}
		PaymentSvc.get(data).then(function (response) {
			if (response.message) {
				modal.list = [];
			} else {
				if(modal.variables.Type === 'Summary'){
					response.forEach(function (item) {
						item.AmountPaid = item.AmountPaid ? item.AmountPaid : 0;
						item.Balance = item.Amount - item.AmountPaid;
					});
				}else{
					response.forEach(function(item){
						item.Remarks = item.referenceNo;
					})
				}
				modal.list = response;
			}
		});
	};
	modal.close = function () {
		$uibModalInstance.dismiss('cancel');
	};
}
function PaymentDetailsCtrl($scope, $ocLazyLoad, $injector, data, $uibModalInstance) {
	var modal = this;
	modal.variables = {};
	modal.updates = false;
	modal.modes = [{ name: 'CASH' }, { name: 'CHECK' }, { name: 'CREDIT' }, { name: 'BANK DEPOSIT' }];
	if (data.details) {
		modal.updates = true;
		modal.variables = angular.copy(data.details);
		modal.variables.PayDate = new Date(data.details.PayDate);
	} else {
		modal.updates = false;
		modal.variables.HDRID = data.variables.PHDRID;
		modal.variables.PayDate = new Date();
		modal.variables.Mode = 'CHECK';
		if (data.payment) {
			modal.variables.PayDate = new Date(data.payment.PayDate);
			modal.variables.ORNo = data.payment.ORNo;
			modal.variables.CardNo = data.payment.CardNo;
		}
	}

	modal.save = function () {
		var data = angular.copy(modal.variables);
		data.PayDate = AppSvc.getDate(modal.variables.PayDate);
		data.Amount = AppSvc.getAmount(modal.variables.Amount);
		data.dtl = true;
		PaymentSvc.save(data).then(function (response) {
			if (response.success) {
				if (response.id) {
					data.PDTLID = response.id;
				}
				$uibModalInstance.close(data);
				AppSvc.showSwal('Success', response.message, 'success');
			} else {
				AppSvc.showSwal('Confirmation', 'Nothing to Update. Saving failed', 'warning');
			}
		});
	};
	modal.close = function () {
		$uibModalInstance.dismiss('cancel');
	};
}

function PaymentUploadCtrl($scope, $ocLazyLoad, $injector, data, $uibModalInstance, $q, filter) {
	var modal = this;
	modal.variables = {};
	modal.variables.HDRID = data.variables.PHDRID;
	modal.variables.ORNo = data.ORNo;
	modal.variables.CardNo = data.CardNo;
	modal.rowObject = [];
	modal.list = [];
	modal.uploaded = [];
	modal.modes = [{ name: 'CASH' }, { name: 'CHECK' }, { name: 'CREDIT' }, { name: 'BANK DEPOSIT' }];
	modal.variables.Mode = 'CHECK'
	modal.variables.PayDate = data.PayDate;
	$ocLazyLoad.load([PAYURL + 'service.js?v=' + VERSION]).then(function (d) {
		PaymentSvc = $injector.get('PaymentSvc');
	});
	modal.soaGrid = {
		enableRowSelection: true,
		enableCellEdit: false,
		enableColumnMenus: false,
		modifierKeysToMultiSelect: true,
		enableRowHeaderSelection: false,
		columnDefs: [
			{ name: 'SOA Number', displayName: 'SOA Number', field: 'SOA_Number' },
			{ name: 'Amount', field: 'Amount', cellClass: 'text-right', cellFilter: 'number: 2' },
		],
		data: 'modal.notFetched',
		onRegisterApi: function (gridApi) {
			gridApi.selection.on.rowSelectionChanged(null, function (row) {
				// $uibModalInstance.close(row.entity)
			});
		},
	};
	modal.removeFile = function () {
		modal.excelFile = '';
		document.getElementById('file-input').value = '';
		modal.uploaded = [];
		modal.fetched = [];
		modal.notFetched = [];
	};
	modal.fileNameChanged = function () {
		modal.disableSave = true;
	}
	modal.checkExcel = function () {
		LOADING.classList.add('open');
		modal.getDataFromExcel().then(function (response) {
			modal.list = angular.copy(response);
			PaymentSvc.save({ erasePrevious: true }).then(function (response) {
				if (response.success) {
					modal.uploadExcel(0, 99);
					modal.disableSave = false;
					LOADING.classList.remove('open');
				} else {
					LOADING.classList.remove('open');
					modal.disableSave = false;
					return AppSvc.showSwal('Error', 'Something went wrong', 'error');
				}
			});
		});
	};
	modal.getDataFromExcel = function () {
		var deferred = $q.defer();
		var reader = new FileReader();
		reader.onload = function () {
			var fileData = reader.result;
			var workbook = XLSX.read(fileData, { type: 'binary' });
			workbook.SheetNames.forEach(function (sheetName) {
				modal.rowObject = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheetName]);
				modal.rowObject.forEach(function (item) {
					item.DocDate = filter('date')(ExcelDateToJSDate(item.DOC_DATE), 'yyyy-MM-dd');
					item.SOA_Number = item.SOA_NUMBER;
					item.Amount = Math.abs(item.AMOUNT);
				});
			});
			deferred.resolve(modal.rowObject);
		};
		reader.readAsBinaryString(modal.excelFile);
		return deferred.promise;
	};
	modal.uploadExcel = function (start, end) {
		LOADING.classList.add('open');
		var list = [];
		var totalArray = modal.list.length;
		if (totalArray < 100) {
			list = modal.list.slice(start, totalArray);
			PaymentSvc.save({ uploadPayment: true, list: list }).then(function (response) {
				if (response.success) {
					modal.finalizeUpload();
				} else {
					LOADING.classList.remove('open');
					return AppSvc.showSwal('Error', 'Something went wrong', 'error');
				}
			});
		} else {
			if (end <= totalArray) {
				if (end + 100 > totalArray) {
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
	};
	modal.redoSubmit = function (list, end) {
		PaymentSvc.save({ uploadPayment: true, list: list }).then(function (response) {
			if (response.success) {
				modal.uploadExcel(end, end + 100);
			} else {
				LOADING.classList.remove('open');
				return AppSvc.showSwal('Error', 'Something went wrong', 'error');
			}
		});
	};
	modal.finalizeUpload = function () {
		modal.uploaded = [];
		modal.notFetched = [];
		modal.fetched = [];
		PaymentSvc.get({ uploadedDAR: true }).then(function (response) {
			if (response.message) {
				LOADING.classList.remove('open');
				modal.uploaded = [];
				modal.fetched = [];
				modal.notFetched = [];
				return AppSvc.showSwal('Error', 'There are no uploaded', 'error');
			} else {
				modal.uploaded = response;
				var sum = 0;
				modal.uploaded.forEach(function (item) {
					if (item.DARID > 0) {
						modal.fetched.push(item);
					} else {
						modal.notFetched.push(item);
					}
					sum = sum + parseFloat(item.Amount);
					modal.variables.Amount = sum;
				});
				LOADING.classList.remove('open');
				return AppSvc.showSwal('Success', 'Successfully uploaded', 'success');
			}
		});
	};
	modal.save = function () {
		if (modal.uploaded.length == 0) {
			return AppSvc.showSwal('Confirmation', "There's no payment to be saved", 'warning');
		}
		var update = angular.copy(modal.variables);
		update.PayDate = AppSvc.getDate(modal.variables.PayDate);
		update.uploadingSave = true;
		if (modal.notFetched.length > 0) {
			AppSvc.confirmation(
				'Confirmation',
				'There are SOA that was not inserted in the system. Do you want to continue?',
				'Yes',
				'No'
			).then(function (data) {
				if (data) {
					LOADING.classList.add('open');
					PaymentSvc.save(update).then(function (response) {
						if (response.success) {
							$uibModalInstance.close({ update: update, rows: response.rows });
							AppSvc.showSwal('Success', response.message, 'success');
						} else {
							AppSvc.showSwal('Confirmation', 'Nothing to Update. Saving failed', 'warning');
						}
						LOADING.classList.remove('open');
					});
				}
			});
		} else {
			AppSvc.confirmation('Confirmation', 'Are you sure you want to update the payment?', 'Yes', 'No').then(
				function (data) {
					if (data) {
						LOADING.classList.add('open');
						PaymentSvc.save(update).then(function (response) {
							if (response.success) {
								$uibModalInstance.close({ update: update, rows: response.rows });
								AppSvc.showSwal('Success', response.message, 'success');
							} else {
								AppSvc.showSwal('Confirmation', 'Nothing to Update. Saving failed', 'warning');
							}
							LOADING.classList.remove('open');
						});
					}
				}
			);
		}
	};
	modal.printReport = function (type) {
		window.open('api/payment?report=true&' + type + '=true');
	};
	modal.close = function () {
		$uibModalInstance.dismiss('cancel');
	};

	function ExcelDateToJSDate(serial) {
		var utc_days = Math.floor(serial - 25569);
		var utc_value = utc_days * 86400;
		var date_info = new Date(utc_value * 1000);

		var fractional_day = serial - Math.floor(serial) + 0.0000001;

		var total_seconds = Math.floor(86400 * fractional_day);

		var seconds = total_seconds % 60;

		total_seconds -= seconds;

		var hours = Math.floor(total_seconds / (60 * 60));
		var minutes = Math.floor(total_seconds / 60) % 60;

		return new Date(date_info.getFullYear(), date_info.getMonth(), date_info.getDate(), hours, minutes, seconds);
	}
}
function UploadSOAPerCheckCtrl($scope, $ocLazyLoad, $injector, data, $uibModalInstance, $q, filter) {
	var modal = this;
	modal.variables = angular.copy(data);
	$ocLazyLoad.load([PAYURL + 'service.js?v=' + VERSION]).then(function (d) {
		PaymentSvc = $injector.get('PaymentSvc');
	});
	modal.soaGrid = {
		enableRowSelection: true,
		enableCellEdit: false,
		enableColumnMenus: false,
		modifierKeysToMultiSelect: true,
		enableRowHeaderSelection: false,
		columnDefs: [
			{ name: 'SOA Number', displayName: 'SOA Number', field: 'SOA_Number' },
			{ name: 'Amount', field: 'Amount', cellClass: 'text-right', cellFilter: 'number: 2' },
		],
		data: 'modal.notFetched',
		onRegisterApi: function (gridApi) {
			gridApi.selection.on.rowSelectionChanged(null, function (row) {
				// $uibModalInstance.close(row.entity)
			});
		},
	};
	modal.removeFile = function () {
		modal.excelFile = '';
		document.getElementById('file-input').value = '';
		modal.uploaded = [];
		modal.fetched = [];
		modal.notFetched = [];
	};
	modal.checkExcel = function () {
		LOADING.classList.add('open');
		modal.getDataFromExcel().then(function (response) {
			modal.list = angular.copy(response);
			PaymentSvc.save({ erasePrevious: true }).then(function (response) {
				if (response.success) {
					modal.uploadExcel(0, 99);
					LOADING.classList.remove('open');
				} else {
					LOADING.classList.remove('open');
					return AppSvc.showSwal('Error', 'Something went wrong', 'error');
				}
			});
		});
	};
	modal.getDataFromExcel = function () {
		var deferred = $q.defer();
		var reader = new FileReader();
		reader.onload = function () {
			var fileData = reader.result;
			var workbook = XLSX.read(fileData, { type: 'binary' });
			workbook.SheetNames.forEach(function (sheetName) {
				modal.rowObject = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheetName]);
				modal.rowObject.forEach(function (item) {
					item.DocDate = filter('date')(ExcelDateToJSDate(item.DOC_DATE), 'yyyy-MM-dd');
					item.SOA_Number = item.SOA_NUMBER;
					item.Amount = Math.abs(item.AMOUNT);
				});
			});
			deferred.resolve(modal.rowObject);
		};
		reader.readAsBinaryString(modal.excelFile);
		return deferred.promise;
	};
	modal.uploadExcel = function (start, end) {
		LOADING.classList.add('open');
		var list = [];
		var totalArray = modal.list.length;
		if (totalArray < 100) {
			list = modal.list.slice(start, totalArray);
			PaymentSvc.save({ uploadPayment: true, list: list }).then(function (response) {
				if (response.success) {
					modal.finalizeUpload();
				} else {
					LOADING.classList.remove('open');
					return AppSvc.showSwal('Error', 'Something went wrong', 'error');
				}
			});
		} else {
			if (end <= totalArray) {
				if (end + 100 > totalArray) {
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
	};
	modal.redoSubmit = function (list, end) {
		PaymentSvc.save({ uploadPayment: true, list: list }).then(function (response) {
			if (response.success) {
				modal.uploadExcel(end, end + 100);
			} else {
				LOADING.classList.remove('open');
				return AppSvc.showSwal('Error', 'Something went wrong', 'error');
			}
		});
	};
	modal.finalizeUpload = function () {
		modal.uploaded = [];
		modal.notFetched = [];
		modal.fetched = [];
		PaymentSvc.get({ uploadedDAR: true }).then(function (response) {
			if (response.message) {
				LOADING.classList.remove('open');
				modal.uploaded = [];
				modal.fetched = [];
				modal.notFetched = [];
				return AppSvc.showSwal('Error', 'There are no uploaded', 'error');
			} else {
				modal.uploaded = response;
				var sum = 0;
				modal.uploaded.forEach(function (item) {
					if (item.DARID > 0) {
						modal.fetched.push(item);
					} else {
						modal.notFetched.push(item);
					}
					sum = sum + parseFloat(item.Amount);
					modal.variables.Amount = sum;
				});
				LOADING.classList.remove('open');
				return AppSvc.showSwal('Success', 'Successfully uploaded', 'success');
			}
		});
	};
	modal.save = function () {
		if (modal.uploaded.length == 0) {
			return AppSvc.showSwal('Confirmation', "There's no payment to be saved", 'warning');
		}
		var update = angular.copy(modal.variables);
		update.PayDate = AppSvc.getDate(modal.variables.PayDate);
		update.uploadingSave = true;
		if (modal.notFetched.length > 0) {
			AppSvc.confirmation(
				'Confirmation',
				'There are SOA that was not inserted in the system. Do you want to continue?',
				'Yes',
				'No'
			).then(function (data) {
				if (data) {
					PaymentSvc.save(update).then(function (response) {
						if (response.success) {
							$uibModalInstance.close({ update: update, rows: response.rows });
							AppSvc.showSwal('Success', response.message, 'success');
						} else {
							AppSvc.showSwal('Confirmation', 'Nothing to Update. Saving failed', 'warning');
						}
					});
				}
			});
		} else {
			AppSvc.confirmation('Confirmation', 'Are you sure you want to update the payment?', 'Yes', 'No').then(
				function (data) {
					if (data) {
						PaymentSvc.save(update).then(function (response) {
							if (response.success) {
								$uibModalInstance.close({ update: update, rows: response.rows });
								AppSvc.showSwal('Success', response.message, 'success');
							} else {
								AppSvc.showSwal('Confirmation', 'Nothing to Update. Saving failed', 'warning');
							}
						});
					}
				}
			);
		}
	};
	modal.printReport = function (type) {
		window.open('api/payment?report=true&' + type + '=true');
	};
	modal.close = function () {
		$uibModalInstance.dismiss('cancel');
	};

	function ExcelDateToJSDate(serial) {
		var utc_days = Math.floor(serial - 25569);
		var utc_value = utc_days * 86400;
		var date_info = new Date(utc_value * 1000);

		var fractional_day = serial - Math.floor(serial) + 0.0000001;

		var total_seconds = Math.floor(86400 * fractional_day);

		var seconds = total_seconds % 60;

		total_seconds -= seconds;

		var hours = Math.floor(total_seconds / (60 * 60));
		var minutes = Math.floor(total_seconds / 60) % 60;

		return new Date(date_info.getFullYear(), date_info.getMonth(), date_info.getDate(), hours, minutes, seconds);
	}
}
function OverPaymentCtrl($scope, $ocLazyLoad, $injector, data, $uibModalInstance) {
	var modal = this;
	modal.variables = {};
	modal.variables.soaNumber = 'GSMPC-';
	$ocLazyLoad.load([PAYURL + 'service.js?v=' + VERSION]).then(function (d) {
		PaymentSvc = $injector.get('PaymentSvc');
	});
	modal.defaultSOA = function () {
		if (!modal.variables.soaNumber || defaultValue !== modal.variables.soaNumber.substring(0, 6)) {
			modal.variables.soaNumber = defaultValue;
		}
	}
	modal.save = function () {
		var data = angular.copy(modal.variables);
		data.overpayment = true;
		data.Amount = AppSvc.getAmount(modal.variables.Amount);
		PaymentSvc.save(data).then(function (response) {
			if (response.success) {
				modal.variables = {};
				modal.variables.soaNumber = 'GSMPC-';
				AppSvc.showSwal('Success', response.message, 'success');
			} else {
				if (response.error) {
					AppSvc.showSwal('Confirmation', 'SOA Number does not exist', 'warning');
				} else {
					AppSvc.showSwal('Confirmation', 'Nothing to Update. Saving failed', 'warning');
				}
			}
		})
	};
	modal.close = function () {
		$uibModalInstance.dismiss('cancel');
	};
}