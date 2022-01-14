(function() {
	'use strict';
	angular
		.module('app')

		.factory('AuthSvc', AuthSvc);

	AuthSvc.$inject = ['baseService'];

	function AuthSvc(baseService) {
		var service = new baseService();
		service.url = APIURL + 'login/restriction';
		return service;
	}
})();
