var manageControllers = angular.module('manageControllers', []);

manageControllers.controller('ManageListCtrl', ['$scope', 'ManageService', function ($scope, ManageService) {
  $scope.modal = false;
  $scope.keyEdit = null;
  $scope.possibleLanguages = possibleLanguages;
  $scope.selectLanguage = '';
  $scope.newTranslation = false;
  $scope.confirmRemove = null;
  $scope.limitDisplay = 10;
  $scope.confirmRemoveKey = false;
  $scope.displayDefaultLanguage = window.localStorage['languageSelect'];

  $scope.$watch('displayDefaultLanguage', function(newVal, oldVal){
	  window.localStorage['languageSelect'] = newVal;
  });
  
  ManageService.getAllTranslation(instanceName, selfedit).then(function(res) {
      if(res.data.translations.length != 0) {
    	  $scope.translations = res.data.translations;
      }
      else {
    	  $scope.translations = {};
      }
      if(res.data.languages.length != 0) {
    	  $scope.languages = res.data.languages;
      }
      else {
    	  $scope.languages = {};
      }
  });
  
  
  $scope.setupTranslation = function(key) {
	  $scope.modal = true;
	  $scope.newTranslation = false;
	  $scope.confirmRemoveKey = false;
	  $('#editTranslationModal').modal();
	  if($scope.selectLanguage == '') {
	  	$scope.selectLanguage = getFirstObject($scope.languages);
  	  }
	  ManageService.getTranslationsOfKey(key, instanceName, selfedit).then(function(res) {
		  $scope.keyEdit = key;
		  if(res.data.length != 0) {
			  $scope.editTranslations = res.data;
		  }
		  else {
			  $scope.editTranslations = {};
		  }
		  updateTranslation($scope.keyEdit, $scope.editTranslations);
	  });
  }
  
  $scope.saveEditTranslation = function() {
	  if($scope.keyEdit) {
		  updateTranslation($scope.keyEdit, $scope.editTranslations);
		  ManageService.setTranslationsOfKey($scope.keyEdit, $scope.editTranslations, instanceName, selfedit).then(function(res) {
			  $('#editTranslationModal').modal('hide');
		  });
	  }
	  else {
	  }
  }
  
  $scope.removeTranslation = function(language) {
	  $scope.confirmRemove = language;
  }
  
  $scope.removeKeyTranslation = function() {
	  var key = $scope.keyEdit;
	  ManageService.deleteTranslation(key, null, instanceName, selfedit).then(function(res) {
		  delete $scope.translations[key];
		  $scope.confirmRemoveKey = false;
		  $('#editTranslationModal').modal('hide');
		  checkLanguage();
	  });
  }
  
  $scope.confirmRemoveTranslation = function() {
	  var key = $scope.keyEdit;
	  var language = $scope.confirmRemove;
	  ManageService.deleteTranslation(key, language, instanceName, selfedit).then(function(res) {
		  $scope.confirmRemove = null;
		  delete $scope.editTranslations[language];
		  delete $scope.translations[key][language];
		  
		  checkLanguage();
	  });
  }
  
  $scope.addNewTranslation = function() {
	  $scope.newTranslation = true;
	  $scope.keyEdit = '';
	  var lang = getFirstObject($scope.languages);
	  if(lang == undefined) {
		  $scope.selectLanguage = 'new';
	  }
	  else {
		  $scope.selectLanguage = getFirstObject($scope.languages);
	  }
	  $scope.editTranslations = {};
	  $('#editTranslationModal').modal();
	  $scope.confirmRemoveKey = false;
  }
  
  $scope.addLanguageToList = function() {
	  $scope.languages[$scope.addLanguage] = $scope.addLanguage;
	  $scope.editTranslations[$scope.addLanguage] = '';
	  $scope.selectLanguage = $scope.addLanguage;
  }
  
  function getFirstObject(array) {
	  return array[Object.keys(array)[0]];
  }
  
  function checkLanguage() {
	  var languageEmpty = [];
	  for(lang in $scope.languages) {
		  languageEmpty[lang] = false;
	  }
	  for(keyTranslation in $scope.translations) {
		  for(lang in $scope.translations[keyTranslation]) {
			  if($scope.translations[keyTranslation][lang]) {
				  languageEmpty[lang] = true;
			  }
		  }
	  }
	  for(lang in languageEmpty) {
		  if(languageEmpty[lang] == false) {
			  delete $scope.languages[lang];
		  }
	  }
  }
  
  function updateTranslation(key, table) {
	  if($scope.translations[key] == undefined) {
		  $scope.translations[key] = {};
	  }
	  for(language in table) {
		  $scope.translations[key][language] = table[language];
		  if(!$scope.languages[language]) {
			  $scope.languages[language] = language;
		  }
	  }
  }
}]);