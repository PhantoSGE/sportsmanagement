<?php
/** SportsManagement ein Programm zur Verwaltung für alle Sportarten
 * @version   1.0.05
 * @file      mod_sportsmanagement_top_tipper.php
 * @author    diddipoeler, stony, svdoldie und donclumsy (diddipoeler@gmx.de)
 * @copyright Copyright: © 2013 Fussball in Europa http://fussballineuropa.de/ All rights reserved.
 * @license   This file is part of SportsManagement.
 * @package   sportsmanagement
 * @subpackage mod_sportsmanagement_top_tipper
 */

// no direct access
defined('_JEXEC') or die('Restricted access');
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\MVC\Model\BaseDatabaseModel;
use Joomla\CMS\Helper\ModuleHelper;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Factory;

if ( !defined('DS') )
{
    define('DS', DIRECTORY_SEPARATOR);
}

if ( !defined('JSM_PATH') )
{
    DEFINE('JSM_PATH', 'components/com_sportsmanagement');
}

/**
 * prüft vor Benutzung ob die gewünschte Klasse definiert ist
 */
if (!class_exists('JSMModelList')) 
{
JLoader::import('components.com_sportsmanagement.libraries.sportsmanagement.model', JPATH_SITE);
}
if (!class_exists('JSMModelLegacy')) 
{
JLoader::import('components.com_sportsmanagement.libraries.sportsmanagement.model', JPATH_SITE);
}
if ( !class_exists('sportsmanagementHelper') )
{
/**
 * add the classes for handling
 */
    $classpath = JPATH_ADMINISTRATOR . DS . JSM_PATH . DS . 'helpers' . DS . 'sportsmanagement.php';
    JLoader::register('sportsmanagementHelper', $classpath);
    BaseDatabaseModel::getInstance("sportsmanagementHelper", "sportsmanagementModel");
}

require_once( JPATH_SITE . DS . JSM_PATH . DS . 'helpers' . DS . 'route.php' );
require_once( JPATH_SITE . DS . JSM_PATH . DS . 'helpers' . DS . 'predictionroute.php' );
require_once( JPATH_SITE . DS . JSM_PATH . DS . 'models' . DS . 'predictionranking.php' );
require_once( JPATH_SITE . DS . JSM_PATH . DS . 'models' . DS . 'prediction.php' );

/**
 * get helper
 */
require_once( dirname(__FILE__) . DS . 'helper.php' );

$document = Factory::getDocument();
$mainframe = Factory::getApplication();
$config    = array();

/**
 * sprachdatei aus dem frontend laden
 */
$langtag = Factory::getLanguage();
$lang = Factory::getLanguage();
$extension = 'com_sportsmanagement';
$base_dir = JPATH_SITE;
$language_tag = $langtag->getTag();
$reload = true;
$lang->load($extension, $base_dir, $language_tag, $reload);

/**
 * add css file
 */
$document->addStyleSheet(Uri::base() . 'modules' . DS . $module->module . DS . 'css' . DS . $module->module . '.css');

$pg_id = $params->get('pg');

$config['limit']                      = $params->get('limit');
$config['show_project_name']          = $params->get('show_project_name');
$config['show_project_name_selector'] = $params->get('show_project_name_selector');
$config['show_rankingnav'] = $params->get('show_rankingnav');
$config['show_all_user']   = $params->get('show_all_user');
$config['show_user_icon']  = $params->get('show_user_icon');
$config['show_user_link'] = $params->get('show_user_link');
$config['show_tip_details'] = $params->get('show_tip_details');
$config['show_tip_ranking'] = $params->get('show_tip_ranking');
$config['show_tip_ranking_text'] = $params->get('show_tip_ranking_text');
$config['show_tip_ranking_round']      = $params->get('show_tip_ranking_round');
$config['show_tip_link_ranking_round'] = $params->get('show_tip_link_ranking_round');
$config['show_average_points']  = $params->get('show_average_points');
$config['show_count_tips']      = $params->get('show_count_tips');
$config['show_count_joker']     = $params->get('show_count_joker');
$config['show_count_topptips']  = $params->get('show_count_topptips');
$config['show_count_difftips']  = $params->get('show_count_difftips');
$config['show_count_tendtipps'] = $params->get('show_count_tendtipps');
$config['show_debug_modus'] = $params->get('show_debug_modus');


/**
 * das model laden
 */
$modelpg = BaseDatabaseModel::getInstance('PredictionRanking', 'sportsmanagementModel');

sportsmanagementModelPrediction::$predictionGameID = $pg_id;
/**
 * jetzt noch das overall template nachladen
 * dadurch erhalten wir die sortierung aus dem backend
 */
$overallConfig        = sportsmanagementModelPrediction::getPredictionOverallConfig();
$config               = array_merge($overallConfig, $config);
$configavatar         = sportsmanagementModelPrediction::getPredictionTemplateConfig('predictionusers');
$predictionGame[]     = sportsmanagementModelPrediction::getPredictionGame();
$predictionMember[]   = sportsmanagementModelPrediction::getPredictionMember($configavatar);
$predictionProjectS[] = sportsmanagementModelPrediction::getPredictionProjectS();
$actJoomlaUser[]      = Factory::getUser();
$roundID              = sportsmanagementModelPrediction::$roundID;

$type_array    = array();
$type_array[]  = HTMLHelper::_('select.option', '0', Text::_('COM_SPORTSMANAGEMENT_RANKING_FULL_RANKING'));
$type_array[]  = HTMLHelper::_('select.option', '1', Text::_('COM_SPORTSMANAGEMENT_RANKING_FIRST_HALF_RANKING'));
$type_array[]  = HTMLHelper::_('select.option', '2', Text::_('COM_SPORTSMANAGEMENT_RANKING_SECOND_HALF_RANKING'));
$lists['type'] = $type_array;
unset($type_array);

?>
<div class="<?php echo $params->get('moduleclass_sfx'); ?>" id="<?php echo $module->module; ?>-<?php echo $module->id; ?>">
<?PHP
require(ModuleHelper::getLayoutPath($module->module));
?>
</div>
