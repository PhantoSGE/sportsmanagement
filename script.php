<?php
/** SportsManagement ein Programm zur Verwaltung f�r alle Sportarten
* @version         1.0.05
* @file                agegroup.php
* @author                diddipoeler, stony, svdoldie und donclumsy (diddipoeler@arcor.de)
* @copyright        Copyright: � 2013 Fussball in Europa http://fussballineuropa.de/ All rights reserved.
* @license                This file is part of SportsManagement.
*
* SportsManagement is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* SportsManagement is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with SportsManagement.  If not, see <http://www.gnu.org/licenses/>.
*
* Diese Datei ist Teil von SportsManagement.
*
* SportsManagement ist Freie Software: Sie k�nnen es unter den Bedingungen
* der GNU General Public License, wie von der Free Software Foundation,
* Version 3 der Lizenz oder (nach Ihrer Wahl) jeder sp�teren
* ver�ffentlichten Version, weiterverbreiten und/oder modifizieren.
*
* SportsManagement wird in der Hoffnung, dass es n�tzlich sein wird, aber
* OHNE JEDE GEW�HELEISTUNG, bereitgestellt; sogar ohne die implizite
* Gew�hrleistung der MARKTF�HIGKEIT oder EIGNUNG F�R EINEN BESTIMMTEN ZWECK.
* Siehe die GNU General Public License f�r weitere Details.
*
* Sie sollten eine Kopie der GNU General Public License zusammen mit diesem
* Programm erhalten haben. Wenn nicht, siehe <http://www.gnu.org/licenses/>.
*
* Note : All ini files need to be saved as UTF-8 without BOM
*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

if (! defined('DS'))
{
	define('DS', DIRECTORY_SEPARATOR);
}

jimport('joomla.installer.installer');
 

/**
 * com_sportsmanagementInstallerScript
 * 
 * @package   
 * @author 
 * @copyright diddi
 * @version 2014
 * @access public
 */
class com_sportsmanagementInstallerScript
{
	/*
     * The release value would ideally be extracted from <version> in the manifest file,
     * but at preflight, the manifest file exists only in the uploaded temp folder.
     */
    //private $release = '1.0.00';
    
    /**
	 * method to install the component
	 *
	 * @return void
	 */
	function install($parent) 
	{
		// $parent is the class calling this method
		$parent->getParent()->setRedirectURL('index.php?option=com_sportsmanagement');
	}
 
	/**
	 * method to uninstall the component
	 *
	 * @return void
	 */
	function uninstall($parent) 
	{
		// $parent is the class calling this method
		echo '<p>' . JText::_('COM_SPORTSMANAGEMENT_UNINSTALL_TEXT') . '</p>';
	}
 
	/**
	 * method to update the component
	 *
	 * @return void
	 */
	function update($parent) 
	{
		// $parent is the class calling this method
		echo '<p>' . JText::_('COM_SPORTSMANAGEMENT_UPDATE_TEXT') . $parent->get('manifest')->version . '</p>';
	}
 
	/**
	 * method to run before an install/update/uninstall method
	 *
	 * @return void
	 */
	function preflight($type, $parent) 
	{
	   if(version_compare(JVERSION,'3.0.0','ge')) 
        {
            echo JHtml::_('bootstrap.startTabSet', 'JSMTab', array('active' => 'Component'));
            $image = '<img src="../media/com_sportsmanagement/jl_images/ext_com.png">';
            echo JHtml::_('bootstrap.addTab', 'JSMTab', 'Component', JText::_(' Component', true)); 
             
            }
            else
            {
	   echo JHtml::_('sliders.start','steps',array(
						'allowAllClose' => true,
						'startTransition' => true,
						true));
       $image = '<img src="../media/com_sportsmanagement/jl_images/ext_com.png">';
		echo JHtml::_('sliders.panel', $image.' Component', 'panel-component');
        }                      
		// $parent is the class calling this method
		// $type is the type of change (install, update or discover_install)
		
        
        echo '<h2>' . JText::_('COM_SPORTSMANAGEMENT_DESCRIPTION') .'</h2>';
        ?>
		
		<img
			src="../administrator/components/com_sportsmanagement/assets/icons/logo_transparent.png"
			alt="JoomLeague" title="JoomLeague" width="180"/>
		<?php
        echo '<h1>' . sprintf(JText::_('COM_SPORTSMANAGEMENT_JOOMLA_VERSION'),'') .'</h1>';
        ?>
        <img
			src="../media/com_sportsmanagement/jl_images/compat_25.png"
			alt="JoomLeague" title="JoomLeague" width="auto"/>
        <img
			src="../media/com_sportsmanagement/jl_images/compat_30.png"
			alt="JoomLeague" title="JoomLeague" width="auto"/>
            <br />
         <?php       
        echo '<p>' . JText::_('COM_SPORTSMANAGEMENT_PREFLIGHT_' . $type . '_TEXT' ) . $parent->get('manifest')->version . '</p>';
        
        
        
        
        
	}
 
	/**
	 * method to run after an install/update/uninstall method
	 *
	 * @return void
	 */
	function postflight($type, $parent) 
	{
	$mainframe = JFactory::getApplication();
    $db = JFactory::getDbo();
    
    if(version_compare(JVERSION,'3.0.0','ge')) 
        {
            echo '<p>' . JText::_('COM_SPORTSMANAGEMENT_POSTFLIGHT_' . $type . '_TEXT' ) . $parent->get('manifest')->version . '</p>';
            echo JHtml::_('bootstrap.endTab'); 
            switch ($type)        
    {
    case "install":
//    self::setParams($newparams);
//    self::installComponentLanguages();

echo JHtml::_('bootstrap.addTab', 'JSMTab', ' Modules', JText::_(' Modules', true));  
$image = '<img src="../media/com_sportsmanagement/jl_images/ext_mod.png">';
    self::installModules($parent);
    echo JHtml::_('bootstrap.endTab'); 
    
    echo JHtml::_('bootstrap.addTab', 'JSMTab', ' Plugins', JText::_(' Plugins', true));  
    $image = '<img src="../media/com_sportsmanagement/jl_images/ext_plugin.png">';
    self::installPlugins($parent);
    echo JHtml::_('bootstrap.endTab'); 
    
    echo JHtml::_('bootstrap.addTab', 'JSMTab', $fieldset->name, JText::_($fieldset->label, true));  
    $image = '<img src="../media/com_sportsmanagement/jl_images/ext_esp.png">';
    self::createImagesFolder();
    echo JHtml::_('bootstrap.endTab'); 
    
//    self::migratePicturePath();
//    self::deleteInstallFolders();
//    self::sendInfoMail();
    break;
    case "update":
//    self::installComponentLanguages();
echo JHtml::_('bootstrap.addTab', 'JSMTab', ' Modules', JText::_(' Modules', true));  
$image = '<img src="../media/com_sportsmanagement/jl_images/ext_mod.png">';
    self::installModules($parent);
    echo JHtml::_('bootstrap.endTab'); 
    
    echo JHtml::_('bootstrap.addTab', 'JSMTab', ' Plugins', JText::_(' Plugins', true));  
    $image = '<img src="../media/com_sportsmanagement/jl_images/ext_plugin.png">';
    self::installPlugins($parent);
    echo JHtml::_('bootstrap.endTab'); 
    
    echo JHtml::_('bootstrap.addTab', 'JSMTab', ' Create/Update Images Folders', JText::_(' Create/Update Images Folders', true));  
    $image = '<img src="../media/com_sportsmanagement/jl_images/ext_esp.png">';
    self::createImagesFolder();
    echo JHtml::_('bootstrap.endTab'); 
    
//    self::migratePicturePath();
//      self::setParams($newparams);
//    self::deleteInstallFolders();
//    self::sendInfoMail();
    break;
    case "discover_install":
    break;
        
    }
            
            
            echo JHtml::_('bootstrap.endTabSet');
            }
            else
            {
//    echo JHtml::_('sliders.start','steps',array(
//						'allowAllClose' => true,
//						'startTransition' => true,
//						true));
//       $image = '<img src="../media/com_sportsmanagement/jl_images/ext_com.png">';
//		echo JHtml::_('sliders.panel', $image.' Component', 'panel-component');
             
    //echo JHtml::_('sliders.start','steps',array(
//						'allowAllClose' => true,
//						'startTransition' => true,
//						true));
                   
        // $parent is the class calling this method
		// $type is the type of change (install, update or discover_install)
		echo '<p>' . JText::_('COM_SPORTSMANAGEMENT_POSTFLIGHT_' . $type . '_TEXT' ) . $parent->get('manifest')->version . '</p>';
    
//$db->setQuery('SELECT params FROM #__extensions WHERE name = "com_sportsmanagement" and type ="component"');
//$paramsdata = json_decode( $db->loadResult(), true );

//$mainframe->enqueueMessage(JText::_('postflight paramsdata<br><pre>'.print_r($paramsdata,true).'</pre>'   ),'');

//$params = JComponentHelper::getParams('com_sportsmanagement');
//$xmlfile = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_sportsmanagement'.DS.'config.xml';  
//$jRegistry = new JRegistry;
//$jRegistry->loadString($params->toString('ini'), 'ini');
////$form =& JForm::getInstance('com_sportsmanagement', $xmlfile, array('control'=> 'params'), false, "/config");
//$form =& JForm::getInstance('com_sportsmanagement', $xmlfile,array('control'=> ''), false, "/config");
//$form->bind($jRegistry);
//$newparams = array();
//foreach($form->getFieldset($fieldset->name) as $field)
//        {
////         echo 'name -> '. $field->name.'<br>';
////         echo 'type -> '. $field->type.'<br>';
////         echo 'input -> '. $field->input.'<br>';
////         echo 'value -> '. $field->value.'<br>';
//        $newparams[$field->name] = $field->value;
//        
//        }

switch ($type)        
    {
    case "install":
//    self::setParams($newparams);
//    self::installComponentLanguages();
$image = '<img src="../media/com_sportsmanagement/jl_images/ext_mod.png">';
		echo JHtml::_('sliders.panel', $image.' Modules', 'panel-modules');
    self::installModules($parent);
    $image = '<img src="../media/com_sportsmanagement/jl_images/ext_plugin.png">';
		echo JHtml::_('sliders.panel', $image.' Plugins', 'panel-plugins');
    self::installPlugins($parent);
    $image = '<img src="../media/com_sportsmanagement/jl_images/ext_esp.png">';
		echo JHtml::_('sliders.panel', $image.' Create/Update Images Folders', 'panel-images');
    self::createImagesFolder();
//    self::migratePicturePath();
//    self::deleteInstallFolders();
//    self::sendInfoMail();
    break;
    case "update":
//    self::installComponentLanguages();
$image = '<img src="../media/com_sportsmanagement/jl_images/ext_mod.png">';
		echo JHtml::_('sliders.panel', $image.' Modules', 'panel-modules');
    self::installModules($parent);
    $image = '<img src="../media/com_sportsmanagement/jl_images/ext_plugin.png">';
		echo JHtml::_('sliders.panel', $image.' Plugins', 'panel-plugins');
    self::installPlugins($parent);
    $image = '<img src="../media/com_sportsmanagement/jl_images/ext_esp.png">';
		echo JHtml::_('sliders.panel', $image.' Create/Update Images Folders', 'panel-images');
    self::createImagesFolder();
//    self::migratePicturePath();
//      self::setParams($newparams);
//    self::deleteInstallFolders();
//    self::sendInfoMail();
    break;
    case "discover_install":
    break;
        
    }

echo JHtml::_('sliders.end');
echo self::getFxInitJSCode('steps');

}

	}
    
    
    /**
     * com_sportsmanagementInstallerScript::getFxInitJSCode()
     * 
     * @param mixed $group
     * @return
     */
    private function getFxInitJSCode ($group) 
    {
		$params = array();
		$params['allowAllClose'] = 'true';
		$display = (isset($params['startOffset']) && isset($params['startTransition']) && $params['startTransition'])
		? (int) $params['startOffset'] : null;
		$show = (isset($params['startOffset']) && !(isset($params['startTransition']) && $params['startTransition']))
		? (int) $params['startOffset'] : null;
		$options = '{';
		$opt['onActive'] = "function(toggler, i) {toggler.addClass('pane-toggler-down');" .
				"toggler.removeClass('pane-toggler');i.addClass('pane-down');i.removeClass('pane-hide');Cookie.write('jpanesliders_"
				. $group . "',$$('div#" . $group . ".pane-sliders > .panel > h3').indexOf(toggler));}";
		$opt['onBackground'] = "function(toggler, i) {toggler.addClass('pane-toggler');" .
				"toggler.removeClass('pane-toggler-down');i.addClass('pane-hide');i.removeClass('pane-down');if($$('div#"
				. $group . ".pane-sliders > .panel > h3').length==$$('div#" . $group
				. ".pane-sliders > .panel > h3.pane-toggler').length) Cookie.write('jpanesliders_" . $group . "',-1);}";
		$opt['duration'] = (isset($params['duration'])) ? (int) $params['duration'] : 300;
		$opt['display'] = (isset($params['useCookie']) && $params['useCookie']) ? JRequest::getInt('jpanesliders_' . $group, $display, 'cookie')
		: $display;
		$opt['show'] = (isset($params['useCookie']) && $params['useCookie']) ? JRequest::getInt('jpanesliders_' . $group, $show, 'cookie') : $show;
		$opt['opacity'] = (isset($params['opacityTransition']) && ($params['opacityTransition'])) ? 'true' : 'false';
		$opt['alwaysHide'] = (isset($params['allowAllClose']) && (!$params['allowAllClose'])) ? 'false' : 'true';
		foreach ($opt as $k => $v)
		{
			if ($v)
			{
				$options .= $k . ': ' . $v . ',';
			}
		}
		if (substr($options, -1) == ',')
		{
			$options = substr($options, 0, -1);
		}
		$options .= '}';
		
		$js = "window.addEvent('domready', function(){ new Fx.Accordion($$('div#" . $group
		. ".pane-sliders > .panel > h3.pane-toggler'), $$('div#" . $group . ".pane-sliders > .panel > div.pane-slider'), " . $options
		. "); });";
		
		return '<script>'.$js.'</script>';
	}
    
    /**
     * com_sportsmanagementInstallerScript::createImagesFolder()
     * 
     * @return void
     */
    public function createImagesFolder()
	{
		$mainframe = JFactory::getApplication();
  $db = JFactory::getDBO();
  
        //echo JText::_('Creating new Image Folder structure');
		$dest = JPATH_ROOT.'/images/com_sportsmanagement';
		$update = JFolder::exists($dest);
		$folders = array('agegroups',
		'clubs',
		'clubs/large',
		'clubs/medium',
		'clubs/small',
		'clubs/trikot_home',
		'clubs/trikot_away',
        'laender_karten',
		'events',
		'leagues',
		'divisions',
		'person_playground',
		'associations',
		'flags_associations',
		'persons',
		'placeholders',
		'predictionusers',
		'playgrounds',
		'projects',
		'projectreferees',
		'projectteams',
		'projectteams/trikot_home',
		'projectteams/trikot_away',
		'associations',
		'rosterground',
		'matchreport',
		'seasons',
		'sport_types',
		'rounds',
		'teams',
		'flags',
		'teamplayers',
		'teamstaffs',
		'venues',
        'jl_images',
		'statistics');
		JFolder::create(JPATH_ROOT.'/images/com_sportsmanagement');
		JFile::copy(JPATH_ROOT.'/images/index.html', JPATH_ROOT.'/images/com_sportsmanagement/index.html');
		JFolder::create(JPATH_ROOT.'/images/com_sportsmanagement/database');
		JFile::copy(JPATH_ROOT.'/images/index.html', JPATH_ROOT.'/images/com_sportsmanagement/database/index.html');
		
        foreach ($folders as $folder) 
        {
			JFolder::create(JPATH_ROOT.'/images/com_sportsmanagement/database/'.$folder);
			JFile::copy(JPATH_ROOT.'/images/index.html', JPATH_ROOT.'/images/com_sportsmanagement/database/'.$folder.'/index.html');
            
            echo '<p>' . JText::_('Imagefolder : ' ) . $folder . ' angelegt!</p>';
            
            //$mainframe->enqueueMessage(JText::sprintf('Verzeichnis [ %1$s ] angelegt!',$folder),'Notice');
            
		}
        
		foreach ($folders as $folder) {
			$from = JPath::clean(JPATH_ROOT.'/media/com_sportsmanagement/'.$folder);
			if(JFolder::exists($from)) {
				$to = JPath::clean($dest.'/database/'.$folder);
				if(!JFolder::exists($to)) {
					$ret = JFolder::move($from, $to);
				} else {
					$ret = JFolder::copy($from, $to, '', true);
					//$ret = JFolder::delete($from);
				}
			}
		}
		//echo ' - <span style="color:green">'.JText::_('Success').'</span><br />';
	}
    
    
    /*
    * sets parameter values in the component's row of the extension table
    */
    function setParams($param_array) 
    {
        
        $mainframe =& JFactory::getApplication();
        $db = JFactory::getDbo();
                                
//                if ( count($param_array) > 0 ) 
//                {
//                        // read the existing component value(s)
//                        $db = JFactory::getDbo();
//                        $db->setQuery('SELECT params FROM #__extensions WHERE name = "com_sportsmanagement"');
//                        $params = json_decode( $db->loadResult(), true );
//                        //$mainframe->enqueueMessage(JText::_('setParams params_array<br><pre>'.print_r($param_array,true).'</pre>'   ),'');
//                        //$mainframe->enqueueMessage(JText::_('setParams params aus db<br><pre>'.print_r($params,true).'</pre>'   ),'');
//                        // add the new variable(s) to the existing one(s)
//                        foreach ( $param_array as $name => $value ) {
//                                $params[ (string) $name ] = (string) $value;
//                        }
//                        //$mainframe->enqueueMessage(JText::_('setParams params neu<br><pre>'.print_r($params,true).'</pre>'   ),'');
//                        // store the combined new and existing values back as a JSON string
//                        $paramsString = json_encode( $params );
//                        $db->setQuery('UPDATE #__extensions SET params = ' .
//                                $db->quote( $paramsString ) .
//                                ' WHERE name = "com_sportsmanagement"' );
//                                $db->query();
//                }
                
        }
        
        
	/**
	 * method to install the plugins
	 *
	 * @return void
	 */
	public function installPlugins($parent)
	{
  $mainframe = JFactory::getApplication();
  $src = $parent->getParent()->getPath('source');
  $manifest = $parent->getParent()->manifest;
  $db = JFactory::getDBO();
  //$j = new JVersion();
//  $joomla_version = $j->RELEASE;
  
  //$mainframe->enqueueMessage(JText::_(get_class($this).' '.__FUNCTION__.'<br><pre>'.print_r($manifest,true).'</pre>'),'');
  //$mainframe->enqueueMessage(JText::_(get_class($this).' '.__FUNCTION__.'<br><pre>'.print_r($src,true).'</pre>'),'');
  
  $plugins = $manifest->xpath('plugins/plugin');
  $plugins3 = $manifest->xpath('plugins3/plugin');
  
  if(version_compare(JVERSION,'3.0.0','ge')) 
        {
  foreach ($plugins3 as $plugin)
        {
        $name = (string)$plugin->attributes()->plugin;
        $group = (string)$plugin->attributes()->group;
        
        echo '<p>' . JText::_('Plugin : ' ) . $name . ' installiert!</p>';
        
        //$mainframe->enqueueMessage(JText::_(get_class($this).' '.__FUNCTION__.'<br><pre>'.print_r($name,true).'</pre>'),'');
        //$mainframe->enqueueMessage(JText::_(get_class($this).' '.__FUNCTION__.'<br><pre>'.print_r($group,true).'</pre>'),'');
        
        // Select some fields
        $query = $db->getQuery(true);
        $query->clear();
		$query->select('extension_id');
        // From table
        $query->from('#__extensions');
        $query->where("type = 'plugin' ");
        $query->where("element = '".$name."' ");
        $query->where("folder = '".$group."' ");
        $db->setQuery($query);
        $plugin_id = $db->loadResult();

        switch ( $name )
        {
        case 'jqueryeasy';
        if ( $plugin_id )
        {
            // plugin ist vorhanden
            // wurde vielleicht schon aktualisiert
        }
        else
        {
            // plugin ist nicht vorhanden
            // also installieren
            $path = $src.DS.'plugins'.DS.$name.'_3';
            $installer = new JInstaller;
            $result = $installer->install($path);    
        }    
        break;
        default:    
        $path = $src.DS.'plugins'.DS.$name;
        $installer = new JInstaller;
        $result = $installer->install($path);
        break;
        }
        
        // auf alle faelle einschalten        
        // Create an object for the record we are going to update.
        $object = new stdClass();
        // Must be a valid primary key value.
        $object->extension_id = $plugin_id;
        $object->enabled = 1;
        // Update their details in the users table using id as the primary key.
        $result = JFactory::getDbo()->updateObject('#__extensions', $object, 'extension_id');  
        
        }
  }
  else
  {
  
  foreach ($plugins as $plugin)
        {
        $name = (string)$plugin->attributes()->plugin;
        $group = (string)$plugin->attributes()->group;
        
        echo '<p>' . JText::_('Plugin : ' ) . $name . ' installiert!</p>';
        
        //$mainframe->enqueueMessage(JText::_(get_class($this).' '.__FUNCTION__.'<br><pre>'.print_r($name,true).'</pre>'),'');
        //$mainframe->enqueueMessage(JText::_(get_class($this).' '.__FUNCTION__.'<br><pre>'.print_r($group,true).'</pre>'),'');
        
        // Select some fields
        $query = $db->getQuery(true);
        $query->clear();
		$query->select('extension_id');
        // From table
        $query->from('#__extensions');
        $query->where("type = 'plugin' ");
        $query->where("element = '".$name."' ");
        $query->where("folder = '".$group."' ");
        $db->setQuery($query);
        $plugin_id = $db->loadResult();

        switch ( $name )
        {
        case 'jqueryeasy';
        case 'jw_ts';
        case 'plugin_googlemap3';
        if ( $plugin_id )
        {
            // plugin ist vorhanden
            // wurde vielleicht schon aktualisiert
        }
        else
        {
            // plugin ist nicht vorhanden
            // also installieren
            $path = $src.DS.'plugins'.DS.$name;
            $installer = new JInstaller;
            $result = $installer->install($path);    
        }    
        break;
        default:    
        $path = $src.DS.'plugins'.DS.$name;
        $installer = new JInstaller;
        $result = $installer->install($path);
        break;
        }
        
        // auf alle faelle einschalten        
        // Create an object for the record we are going to update.
        $object = new stdClass();
        // Must be a valid primary key value.
        $object->extension_id = $plugin_id;
        $object->enabled = 1;
        // Update their details in the users table using id as the primary key.
        $result = JFactory::getDbo()->updateObject('#__extensions', $object, 'extension_id');  
        
        }
        
        }
        
        

    
    }
    
    
    /**
	 * method to install the modules
	 *
	 * @return void
	 */
	public function installModules($parent)
	{
  $mainframe = JFactory::getApplication();
  $src = $parent->getParent()->getPath('source');
  $manifest = $parent->getParent()->manifest;
  $db = JFactory::getDBO();
  
  //$mainframe->enqueueMessage(JText::_(get_class($this).' '.__FUNCTION__.'<br><pre>'.print_r($manifest,true).'</pre>'),'');
  //$mainframe->enqueueMessage(JText::_(get_class($this).' '.__FUNCTION__.'<br><pre>'.print_r($src,true).'</pre>'),'');
  
  
  $modules = $manifest->xpath('modules/module');
        foreach ($modules as $module)
        {
            $name = (string)$module->attributes()->module;
            $client = (string)$module->attributes()->client;
            
            $position = (string)$module->attributes()->position;
            $published = (string)$module->attributes()->published;
            
            echo '<p>' . JText::_('Modul : ' ) . $name . ' installiert!</p>';
            
            //$mainframe->enqueueMessage(JText::_(get_class($this).' '.__FUNCTION__.'<br><pre>'.print_r($name,true).'</pre>'),'');
            //$mainframe->enqueueMessage(JText::_(get_class($this).' '.__FUNCTION__.'<br><pre>'.print_r($client,true).'</pre>'),'');
            
            if (is_null($client))
            {
                $client = 'site';
            }
            $path = $client == 'administrator' ? $src.DS.'admin'.DS.'modules'.DS.$name : $src.DS.'modules'.DS.$name;
            $installer = new JInstaller;
            $result = $installer->install($path);
            
            if ( $position )
            {
                $query = "UPDATE #__modules SET position='".$position."', ordering=99, published=".$published." WHERE module='".$name."' ";
                $db->setQuery($query);
                $db->query();
                if ( $client == 'administrator' )
                {
                $query		 = $db->getQuery(true);
								$query->select('id')->from($db->qn('#__modules'))
									->where($db->qn('module') . ' = ' . $db->q($name));
								$db->setQuery($query);
								$moduleid	 = $db->loadResult();

								$query		 = $db->getQuery(true);
								$query->select('*')->from($db->qn('#__modules_menu'))
									->where($db->qn('moduleid') . ' = ' . $db->q($moduleid));
								$db->setQuery($query);
								$assignments = $db->loadObjectList();
								$isAssigned	 = !empty($assignments);

								if (!$isAssigned)
								{
									$o = (object) array(
											'moduleid'	 => $moduleid,
											'menuid'	 => 0
									);
									$db->insertObject('#__modules_menu', $o);
								}
                
                
                }   
                
            }
        }    
  
  
  

    }
    
    
                  
}
