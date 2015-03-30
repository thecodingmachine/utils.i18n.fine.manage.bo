<?php
namespace Mouf\Utils\I18n\Fine\Manage\Bo\Controller;

use Mouf\Mvc\Splash\Controllers\Controller;
use Mouf\Html\Template\TemplateInterface;
use Mouf\Html\HtmlElement\HtmlBlock;
use Mouf\Html\Utils\WebLibraryManager\WebLibrary;
use Mouf\Utils\I18n\Fine\Common\Ui\EditTranslationProxyTrait;
use Mouf\Utils\I18n\Fine\Common\Ui\EditTranslationUtils;

/**
 * Class to display the list of translation
 * There is method to add, edit or remove a translation
 */
class ManageBoController extends Controller
{
    use EditTranslationProxyTrait;

    /**
     * The template used by the Splash page.
     *
     * @var TemplateInterface
     */
    public $template;

    /**
     *
     * @var HtmlBlock
     */
    public $content;

    protected $selfedit;
    protected $sourceDirectory;
    protected $controllerNamespace;
    protected $autoloadDetected;

    /**
     * Displays the create controller page.
     *
     * @Action
     * @param string $name     Instance name
     * @param string $selfedit Edit mouf or instance project
     */
    public function index($name = null, $selfedit = "false")
    {
        $this->selfedit = $selfedit;
        $this->instanceName = $name;

        $this->template->getWebLibraryManager()->addLibrary(new WebLibrary(
                array(
                        "../utils.i18n.fine.manage.bo/src/views/js/angular.min.js",
                        "../utils.i18n.fine.manage.bo/src/views/js/angular-ui-router.min.js",
                        "../utils.i18n.fine.manage.bo/src/views/js/app.js",
                        "../utils.i18n.fine.manage.bo/src/views/js/services/manageService.js",
                        "../utils.i18n.fine.manage.bo/src/views/js/controllers/manage.js",
                        "../utils.i18n.fine.manage.bo/src/views/js/angular-resource.min.js",
                ),
                array(
                        "../utils.i18n.fine.manage.bo/src/views/css/manage.css",
                )));
        $this->possibleLanguages = EditTranslationUtils::getAllPossibleLanguages();

        $this->content->addFile(dirname(__FILE__)."/../views/manageList.php", $this);
        $this->template->toHtml();
    }

    /**
     * @Action
     * @param unknown $instanceName
     * @param string  $selfedit
     */
    public function getAllTranslation($instanceName, $selfedit = "false")
    {
        $translations = json_decode($this->getAllMessagesFromService($selfedit, $instanceName));
        $invertTranslations = [];
        $languages = [];
        foreach ($translations as $language => $translation) {
            $languages[$language] = $language;
            foreach ($translation as $key => $value) {
                $invertTranslations[$key][$language] = $value;
            }
        }
        echo json_encode(['languages' => $languages, 'translations' => $invertTranslations]);
    }

    /**
     * @Action
     * @param unknown $instanceName
     * @param string  $selfedit
     */
    public function getTranslationsOfKey($key, $instanceName, $selfedit = "false")
    {
        $translations = $this->getTranslationsForKeyFromService($selfedit, $instanceName, $key);
        echo json_encode($translations);
    }

    /**
     * @Action
     * @param unknown $instanceName
     * @param string  $selfedit
     */
    public function setTranslationsOfKey($key, $translations, $instanceName, $selfedit = "false")
    {
        $translations = json_decode($translations, true);
        $this->setTranslationsForKeyFromService($selfedit, $instanceName, $key, $translations);
        echo json_encode(true);
    }

    /**
     * @Action
     * @param unknown $instanceName
     * @param string  $selfedit
     */
    public function deleteTranslation($key, $instanceName, $selfedit = "false", $language = null)
    {
        $this->deleteTranslationFromService($selfedit, $instanceName, $key, $language);
    }
}
