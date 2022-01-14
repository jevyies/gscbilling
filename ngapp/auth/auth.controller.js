angular.module('app').controller('AuthCtrl', AuthCtrl);

AuthCtrl.$inject = ['$scope', '$ocLazyLoad', '$injector', '$uibModalInstance'];

function AuthCtrl($scope, $ocLazyLoad, $injector, $uibModalInstance) {
	var modal = this;
	modal.variables = {};
	$ocLazyLoad.load([AUTHURL + 'service.js?v=' + VERSION]).then(function(d) {
		AuthSvc = $injector.get('AuthSvc');
	});

	modal.submit = function() {
		AuthSvc.save(modal.variables).then(function(response) {
			var data;
			if (response.authorized) {
				data = {
					message: 'open',
				};
				$uibModalInstance.close(data);
				AuthSvc.showSwal('Success', response.message, 'success');
			} else {
				AuthSvc.showSwal('Error', response.message, 'error');
			}
		});
	};
	modal.close = function() {
		$uibModalInstance.dismiss('cancel');
	};
}
