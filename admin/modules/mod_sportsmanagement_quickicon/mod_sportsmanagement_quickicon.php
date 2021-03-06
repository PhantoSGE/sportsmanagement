<?php 
/** SportsManagement ein Programm zur Verwaltung f�r alle Sportarten
 * @version   1.0.05
 * @file      mod_sportsmanagement_quickicon.php
 * @author    diddipoeler, stony, svdoldie und donclumsy (diddipoeler@gmx.de)
 * @copyright Copyright: � 2013 Fussball in Europa http://fussballineuropa.de/ All rights reserved.
 * @license   This file is part of SportsManagement.
 * @package   sportsmanagement
 * @subpackage mod_sportsmanagement_quickicon
 */

defined('_JEXEC') or die('Restricted Access'); // Protect from unauthorized access
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\Component\ComponentHelper;
// Make sure Sportsmanagement is enabled
jimport( 'joomla.application.component.helper' );
if ( !ComponentHelper::isEnabled( 'com_sportsmanagement', true) )
{
	JError::raiseError( 'E_SMNOTENABLED', JText( 'SM_NOT_ENABLED' ) );
	return;
}

if (! defined('DS'))
{
	define('DS', DIRECTORY_SEPARATOR);
}

//require_once __DIR__ . '/helper.php';
require_once (dirname(__FILE__).DS.'helper.php'); 
$position = ModSportsmanagementQuickIconHelper::getModPosition(); 


$document = Factory::getDocument();
$document->addStyleSheet(JURI::base(true).'/modules/mod_sportsmanagement_quickicon/tmpl/css/style.css');

if( version_compare(JVERSION,'1.6.0','ge') ) 
{
$jsm_version = '';    
}    
else
{
$jsm_version = '15';    
}

// joomla versionen
if( version_compare(JVERSION,'3.0.0','ge') && $position == 'icon' ) 
{
//require_once __DIR__ . '/helper.php'; 
$buttons = ModSportsmanagementQuickIconHelper::getButtons($params);   
$html = HTMLHelper::_('links.linksgroups', ModSportsmanagementQuickIconHelper::groupButtons($buttons));
    
if (!empty($html)) : ?>
	<div class="sidebar-nav quick-icons">
		<?php echo $html;?>
	</div>
<?php endif;
}
else
{
?>
<div id="jsmQuickIcons<?php echo $jsm_version; ?>" class="jsmNoLogo">	     
  <div class="icon-wrapper">      
    <div class="icon">           
      <a title="<?php echo Text::_('MOD_SPORTSMANAGEMENT_QUICKICON_PANEL_LINK')?>" href="index.php?option=com_sportsmanagement">               
        <img src="<?php echo JURI::base( false ) ?>/components/com_sportsmanagement/assets/icons/transparent_schrift_48.png">               
        <span>            
          <?php echo Text::_('MOD_SPORTSMANAGEMENT_QUICKICON_PANEL_LABEL')?>               
        </span></a>		        
    </div>    
  </div>    
  <div class="icon-wrapper">      
    <div class="icon">           
      <a title="<?php echo Text::_('MOD_SPORTSMANAGEMENT_QUICKICON_EXTENSIONS_LINK')?>" href="index.php?option=com_sportsmanagement&view=extensions">               
        <img src="<?php echo JURI::base( false ) ?>/components/com_sportsmanagement/assets/icons/extensions.png">               
        <span>            
          <?php echo Text::_('MOD_SPORTSMANAGEMENT_QUICKICON_EXTENSIONS_LABEL')?>               
        </span></a>		        
    </div>    
  </div>    
  <div class="icon-wrapper">      
    <div class="icon">           
      <a title="<?php echo Text::_('MOD_SPORTSMANAGEMENT_QUICKICON_PROJECTS_LINK')?>" href="index.php?option=com_sportsmanagement&view=projects">               
        <img src="<?php echo JURI::base( false ) ?>/components/com_sportsmanagement/assets/icons/projekte.png">               
        <span>            
          <?php echo Text::_('MOD_SPORTSMANAGEMENT_QUICKICON_PROJECTS_LABEL')?>               
        </span></a>		        
    </div>    
  </div>    
  <div class="icon-wrapper">      
    <div class="icon">           
      <a title="<?php echo Text::_('MOD_SPORTSMANAGEMENT_QUICKICON_PREDICTIONS_LINK')?>" href="index.php?option=com_sportsmanagement&view=predictions">               
        <img src="<?php echo JURI::base( false ) ?>/components/com_sportsmanagement/assets/icons/tippspiele.png">               
        <span>            
          <?php echo Text::_('MOD_SPORTSMANAGEMENT_QUICKICON_PREDICTIONS_LABEL')?>               
        </span></a>		        
    </div>    
  </div>    
  <div class="icon-wrapper">      
    <div class="icon">           
      <a title="<?php echo Text::_('MOD_SPORTSMANAGEMENT_QUICKICON_CURRENT_SAISON_LINK')?>" href="index.php?option=com_sportsmanagement&view=currentseasons">               
        <img src="<?php echo JURI::base( false ) ?>/components/com_sportsmanagement/assets/icons/aktuellesaison.png">               
        <span>            
          <?php echo Text::_('MOD_SPORTSMANAGEMENT_QUICKICON_CURRENT_SAISON_LABEL')?>               
        </span></a>		        
    </div>    
  </div>	    
</div>
<?PHP
}
?>