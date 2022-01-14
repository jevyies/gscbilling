(function () {
	'use strict';
	angular
		.module('app')

		.factory('AppSvc', AppSvc)
		.factory('LogoutSvc', LogoutSvc)

	AppSvc.$inject = ['baseService'];
	LogoutSvc.$inject = ['baseService'];

	function AppSvc(baseService) {
		var service = new baseService();
		service.url = APIURL + 'login/user';
		return service;
	}
	function LogoutSvc(baseService) {
		var service = new baseService();
		service.url = APIURL + 'login/logout';
		return service;
	}
})();
