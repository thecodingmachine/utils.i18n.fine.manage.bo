var manageServices = angular.module('manageServices', ['ngResource']);

manageServices.service('ManageService', ['$http',
  function($http){
	this.getAllTranslation = function (instanceName, selfedit) {
		return $http.get(ROOT_URL + "manageBo/getAllTranslation", {
				params: {
					'instanceName': instanceName,
					'selfedit': selfedit
				}
			});
	}
	
	this.getTranslationsOfKey = function (key, instanceName, selfedit) {
		return $http.get(ROOT_URL + "manageBo/getTranslationsOfKey", {
			params: {
				'key': key,
				'instanceName': instanceName,
				'selfedit': selfedit
			}
		});
	}
	
	this.setTranslationsOfKey = function (key, translations, instanceName, selfedit) {
		return $http({method: 'POST', 
  					url: ROOT_URL + "manageBo/setTranslationsOfKey",
  					params: {
  						'key': key,
  						'translations': translations,
  						'instanceName': instanceName,
  						'selfedit': selfedit
  				}
		});
	}
	
	this.deleteTranslation = function (key, language, instanceName, selfedit) {
		return $http({method: 'POST', 
  					url: ROOT_URL + "manageBo/deleteTranslation",
  					params: {
  						'key': key,
  						'language': language,
  						'instanceName': instanceName,
  						'selfedit': selfedit
  				}
		});
	}
}]);