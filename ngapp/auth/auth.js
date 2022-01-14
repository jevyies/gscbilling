(function() {
	'use strict';
	angular.module('app').factory('authService', authService);

	authService.$inject = ['$uibModal', '$ocLazyLoad', '$filter', '$q'];

	function authService($uibModal, $ocLazyLoad, $filter, $q) {
		var AuthService = function() {
			var service = {
				modal: modal,
				formList: formList,
				records: [],
			};
			return service;

			function formList(menuID) {
				var exists = service.records.indexOf(menuID);
				var deferred = $q.defer();
				if (exists < 0) {
					service.modal().then(function(data) {
						if (data) {
							if (data.message) {
								deferred.resolve(true);
							}
						} else {
							deferred.resolve(false);
						}
					});
				} else {
					deferred.resolve(true);
				}
				return deferred.promise;
			}
			function modal() {
				var filesToLoad = [AUTHURL + 'auth.html?v=' + VERSION, AUTHURL + 'auth.controller.js?v=' + VERSION];
				return $ocLazyLoad.load(filesToLoad).then(function() {
					var modalInstance = $uibModal.open({
						animation: false,
						templateUrl: AUTHURL + 'auth.html?v=' + VERSION,
						controller: 'AuthCtrl',
						controllerAs: 'modal',
						size: 'sm',
						backdrop: 'static',
					});
					return modalInstance.result.then(
						function(data) {
							return data;
						},
						function() {
							console.log('Modal Closed');
						}
					);
				});
			}
		};
		return AuthService;
	}
})();
