<?php
/** SportsManagement ein Programm zur Verwaltung für Sportarten
 * @version   1.0.05
 * @file      jsmgcalendar.php
 * @author    diddipoeler, stony, svdoldie und donclumsy (diddipoeler@gmx.de)
 * @copyright Copyright: © 2013 Fussball in Europa http://fussballineuropa.de/ All rights reserved.
 * @license   This file is part of SportsManagement.
 * @package   sportsmanagement
 * @subpackage models
 */

defined('_JEXEC') or die();
use Joomla\CMS\Language\Text;
use Joomla\CMS\Factory;
use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Filesystem\File;
use Joomla\CMS\Filesystem\Folder;
use Joomla\CMS\Table\Table;
use Joomla\CMS\MVC\Model\AdminModel;

JLoader::import('joomla.application.component.modeladmin');

JLoader::import('components.com_sportsmanagement.libraries.GCalendar.GCalendarZendHelper', JPATH_ADMINISTRATOR);
JLoader::import('joomla.utilities.simplecrypt');

/**
 * sportsmanagementModeljsmGCalendar
 * 
 * @package 
 * @author diddi
 * @copyright 2014
 * @version $Id$
 * @access public
 */
class sportsmanagementModeljsmGCalendar extends AdminModel
{
	/**
	 * sportsmanagementModeljsmGCalendar::allowEdit()
	 * 
	 * @param mixed $data
	 * @param string $key
	 * @return
	 */
	protected function allowEdit($data = array(), $key = 'id')
	{
		// Check specific edit permission then general edit permission.
		return Factory::getUser()->authorise('core.edit', 'com_sportsmanagement.calendar.'.((int) isset($data[$key]) ? $data[$key] : 0)) or parent::allowEdit($data, $key);
	}

	/**
	 * sportsmanagementModeljsmGCalendar::getTable()
	 * 
	 * @param string $type
	 * @param string $prefix
	 * @param mixed $config
	 * @return
	 */
	public function getTable($type = 'jsmGCalendar', $prefix = 'sportsmanagementTable', $config = array())
	{
	$config['dbo'] = sportsmanagementHelper::getDBConnection(); 
		return Table::getInstance($type, $prefix, $config);
	}

	/**
	 * sportsmanagementModeljsmGCalendar::getForm()
	 * 
	 * @param mixed $data
	 * @param bool $loadData
	 * @return
	 */
	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm('com_sportsmanagement.jsmGCalendar', 'jsmGCalendar', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form))
		{
			return false;
		}
		return $form;
	}

	/**
	 * sportsmanagementModeljsmGCalendar::loadFormData()
	 * 
	 * @return
	 */
	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$data = Factory::getApplication()->getUserState('com_sportsmanagement.edit.jsmGCalendar.data', array());
		if (empty($data))
		{
			$data = $this->getItem();
		}
		return $data;
	}
    
    
    /**
	 * Method to save the form data.
	 *
	 * @param	array	The form data.
	 * @return	boolean	True on success.
	 * @since	1.6
     * 
     * http://framework.zend.com/manual/1.12/en/zend.http.response.html
     * 
	 */
	public function save($data)
	{
	   $app = Factory::getApplication();
       $config = Factory::getConfig();
       $option = Factory::getApplication()->input->getCmd('option');
       $post = Factory::getApplication()->input->post->getArray(array());
       // Get a db connection.
        $db = Factory::getDbo();
        
       //$app->enqueueMessage(Text::_(__METHOD__.' '.__LINE__.' data<br><pre>'.print_r($data,true).'</pre>'),'Notice');
       //$app->enqueueMessage(Text::_(__METHOD__.' '.__LINE__.' post<br><pre>'.print_r($post,true).'</pre>'),'Notice');
       //$app->enqueueMessage(Text::_(__METHOD__.' '.__LINE__.' config<br><pre>'.print_r($config,true).'</pre>'),'Notice');
       
       $timezone = ComponentHelper::getParams(Factory::getApplication()->input->getCmd('option'))->get('timezone','');
       
       if ( empty($data['id']) )
       {
        // xml file erstellen
        $file = JPATH_SITE.DS.'tmp'.DS.'createcal.xml'; 
$output  = "<entry xmlns='http://www.w3.org/2005/Atom'". "\n";
$output .= "xmlns:gd='http://schemas.google.com/g/2005'". "\n";
$output .= "xmlns:gCal='http://schemas.google.com/gCal/2005'>". "\n";
$output .= "<title type='text'>[TITLE]</title>". "\n";
$output .= "<summary type='text'>[SUMMARY]</summary>". "\n";
$output .= "<gCal:timezone value='".$config->getValue('config.offset')."'></gCal:timezone>". "\n";
$output .= "<gCal:hidden value='false'></gCal:hidden>". "\n";
$output .= "<gCal:color value='#".$data['color']."'></gCal:color>". "\n";
$output .= "<gd:where rel='' label='' valueString='Oakland'></gd:where>". "\n";
$output .= "</entry>". "\n";
        // mal als test
        $xmlfile = $xmlfile.$output;
        File::write($file, $xmlfile);

        $username = ComponentHelper::getParams(Factory::getApplication()->input->getCmd('option'))->get('google_mail_account','');
        $password = ComponentHelper::getParams(Factory::getApplication()->input->getCmd('option'))->get('google_mail_password','');
                
         $service = Zend_Gdata_Calendar::AUTH_SERVICE_NAME;
    $client = Zend_Gdata_ClientLogin::getHttpClient($username, $password,$service);
    $gdataCal = new Zend_Gdata_Calendar($client);
    $title = $data['name'];
    $summary = $data['name'];
    $uri = 'http://www.google.com/calendar/feeds/default/owncalendars/full';
    $xml = file_get_contents($file);
    $xml = str_replace('[TITLE]', $title, $xml);
    $xml = str_replace('[SUMMARY]', $summary, $xml);
    $response = $gdataCal->post($xml, $uri);
    
    $app->enqueueMessage(Text::_(__METHOD__.' '.__LINE__.' response<br><pre>'.print_r($response,true).'</pre>'),'Notice');
    $app->enqueueMessage(Text::_(__METHOD__.' '.__LINE__.' getMessage<br><pre>'.print_r($response->getMessage(),true).'</pre>'),'Notice');
    $app->enqueueMessage(Text::_(__METHOD__.' '.__LINE__.' getHeader<br><pre>'.print_r($response->getHeader('Content-location'),true).'</pre>'),'Notice');
    
    // die erstellte kalender id übergeben
    $data['calendar_id'] = substr($response->getHeader('Content-location'), strrpos($response->getHeader('Content-location'), '/')+1);
    
        }
        
        
        
       // Proceed with the save
		return parent::save($data);   
    }    
}
