<script type="text/javascript">
	var ROOT_URL = '<?php echo ROOT_URL?>';
	var instanceName = '<?php echo $this->instanceName?>';
	var selfedit = '<?php echo $this->selfedit?>';
	var possibleLanguages = <?php echo json_encode($this->possibleLanguages)?>;
</script>
<h1>Manage translation</h1>
<div ng-app="manageApp">
	<div ng-controller="ManageListCtrl">
		<button ng-click="addNewTranslation()" class="btn btn-primary">Add new translation</button>
		<div class="pull-right">
			Select language to display translation in edit mode:
			
			<select name="displayDefaultLanguage" ng-model="displayDefaultLanguage" ng-options="myValue for (key, myValue) in languages">
				<option value="">--</option>
			</select>
		</div>
		<table class="table table-striped table-condensed">
	    	<tr>
	    		<th></th>
	    		<th ng-repeat="language in languages">{{language}}</th>
	    	</tr>
	    	<tr ng-repeat="(key, messages) in translations">
	    		<td>
	    			<a href="#" ng-click="setupTranslation(key)">{{key}}</a>
    			</td>
    			<td ng-repeat="language in languages">
    				<a href="#" ng-click="setupTranslation(key); $parent.$parent.selectLanguage = language" class="translationValue" title="{{messages[language]}}">
	    				{{messages[language] | limitTo: $parent.limitDisplay}}
	    				<span ng-if="messages[language] == ''" class="translationEmpty">Empty</span>
	    				<span ng-if="messages[language] == undefined" class="translationNoValue">No value</span>
    				</a>
    			</td>
    		</tr>
  		</table>
		<div id="editTranslationModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h3 id="myModalLabel">Edit: <span ng-show="!newTranslation">{{keyEdit}}</span><input ng-show="newTranslation" type="text" name="keyEdit" ng-model="keyEdit" value="" class="form-control" required="required"/></h3>
				
			</div>
			<div class="modal-body">
				<div ng-show="confirmRemove != null">
					<div class="alert alert-error">
						Are you sure you want to delete the translation link to the key : {{keyEdit}} and the language {{confirmRemove}} ?<br />
						<button ng-click="confirmRemove = null" class="btn btn-default">No</button>
						<button ng-click="confirmRemoveTranslation()" class="btn btn-danger">Yes</button>
					</div>
				</div>
				<div ng-show="confirmRemoveKey">
					<div class="alert alert-error">
						Are you sure you want to delete the translation link to the key : {{keyEdit}} ?<br />
						<button ng-click="confirmRemoveKey = false" class="btn btn-default">No</button>
						<button ng-click="removeKeyTranslation()" class="btn btn-danger">Yes</button>
					</div>
				</div>
				<div class="lg-col-12" id="modal-body-content">
					<ul class="nav nav-tabs" id="languageList">
						<li ng-repeat="language in languages" ng-class="{emptyTranslation: $parent.editTranslations[language] == '', noTranslation: $parent.editTranslations[language] == undefined, active: language == $parent.selectLanguage}">
							<a href="#" ng-click="$parent.selectLanguage = language">{{language}}</a>
							<a href="#" ng-click="removeTranslation(language)" class="removeLanguage"><i class="icon-remove"></i></a>
						</li>
						<li>
							<a href="#" ng-click="selectLanguage = 'new'">Add</a>
						</li>
					</ul>
					<textarea id="editTranslation" ng-show="selectLanguage != 'new'" name="editTranslation" ng-model="editTranslations[selectLanguage]">{{editTranslations[selectLanguage]}}</textarea>
					<div class="alert alert-warning" ng-show="selectLanguage == 'new'">
						Add a new language to your transaltion :<br />
						<select name="addLanguage" ng-model="addLanguage">
							<option ng-repeat="(key, value) in possibleLanguages" value="{{key}}" ng-if="!languages[key]">{{value}}</option>
						</select><br />
						<button class="btn btn-primary" ng-click="addLanguageToList()">Add</button>	
					</div>
					<span class="label label-warning">Empty</span>
					<span class="label label-important">No translation</span>
					<div ng-show="editTranslations[displayDefaultLanguage]">
						<span style="font-weight: bold; font-size: 14px">Translation for {{displayDefaultLanguage}}:</span><br />
						{{editTranslations[displayDefaultLanguage]}}
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button ng-click="confirmRemoveKey = true" ng-show="!newTranslation" class="btn btn-danger pull-left">Remove key</button>
				<button ng-click="saveEditTranslation()" id="saveTranslation" ng-show="keyEdit" class="btn btn-success pull-left">Save all translations</button>
				<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
			</div>
		</div>
		
	</div>
</div>
