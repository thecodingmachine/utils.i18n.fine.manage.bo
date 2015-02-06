<?php
use Mouf\MoufUtils;
use Mouf\MoufManager;
/*
 * Copyright (c) 2012-2015 Marc TEYSSIER
*
* See the file LICENSE.txt for copying permission.
*/
require('Mouf/Utils/I18n/Fine/Common/EditLabelController.php');
require('Mouf/Utils/I18n/Fine/Manage/Bo/ManageBoController.php');

MoufUtils::registerMainMenu('htmlMainMenu', 'HTML', null, 'mainMenu', 40);
MoufUtils::registerMenuItem('htmlFineMainMenu', 'Fine', null, 'htmlMainMenu', 10);
MoufUtils::registerChooseInstanceMenuItem('htmlFineEditTranslationMenuItem', 'Manage translations', 'manageFine', "Mouf\\Utils\\I18n\\Fine\\Common\\EditTranslationInterface", 'htmlFineMainMenu', 20);


// Controller declaration
$moufManager = MoufManager::getMoufManager();
$moufManager->declareComponent('manageFine', 'Mouf\\Utils\\I18n\\Fine\\Manage\\Bo\\Controllers\\ManageBoController', true);
$moufManager->bindComponents('manageFine', 'template', 'moufTemplate');
$moufManager->bindComponents('manageFine', 'content', 'block.content');

?>

?>