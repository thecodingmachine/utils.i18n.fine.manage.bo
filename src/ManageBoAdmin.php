<?php
use Mouf\MoufUtils;
use Mouf\MoufManager;
/*
 * Copyright (c) 2012-2015 Marc TEYSSIER
*
* See the file LICENSE.txt for copying permission.
*/
require('../../utils.i18n.fine.common/src/Ui/EditTranslationInterface.php');
require('Controller/ManageBoController.php');

MoufUtils::registerMainMenu('htmlMainMenu', 'HTML', null, 'mainMenu', 40);
MoufUtils::registerMenuItem('htmlFineMainMenu', 'Fine', null, 'htmlMainMenu', 10);
MoufUtils::registerChooseInstanceMenuItem('htmlFineManageBoMenuItem', 'Manage translations', 'manageBo/', "Mouf\\Utils\\I18n\\Fine\\Common\\Ui\\EditTranslationInterface", 'htmlFineMainMenu', 20);


// Controller declaration
$moufManager = MoufManager::getMoufManager();
$moufManager->declareComponent('manageBo', 'Mouf\\Utils\\I18n\\Fine\\Manage\\Bo\\Controller\\ManageBoController', true);
$moufManager->bindComponents('manageBo', 'template', 'moufTemplate');
$moufManager->bindComponents('manageBo', 'content', 'block.content');
?>
