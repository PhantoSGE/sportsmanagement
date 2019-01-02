<?php
/** SportsManagement ein Programm zur Verwaltung f�r Sportarten
 * @version   1.0.05
 * @file      positionlist.php
 * @author    diddipoeler, stony, svdoldie und donclumsy (diddipoeler@gmx.de)
 * @copyright Copyright: � 2013 Fussball in Europa http://fussballineuropa.de/ All rights reserved.
 * @license   This file is part of SportsManagement.
 * @package   sportsmanagement
 * @subpackage fields
 */

// Check to ensure this file is included in Joomla!
defined( '_JEXEC' ) or die( 'Restricted access' );
use Joomla\CMS\Factory;
use Joomla\CMS\Form\FormField;
use Joomla\CMS\Form\FormHelper;
use Joomla\CMS\Language\Text;
jimport('joomla.filesystem.folder');
FormHelper::loadFieldClass('list');

/**
 * FormFieldpositionlist
 * 
 * @package   
 * @author 
 * @copyright diddi
 * @version 2014
 * @access public
 */
class JFormFieldpositionlist extends \JFormFieldList
{
    
	/**
	 * field type
	 * @var string
	 */
	public $type = 'positionlist';

	/**
	 * Method to get the field options.
	 *
	 * @return  array  The field option objects.
	 *
	 * @since   11.1
	 */
	protected function getOptions()
	{
		// Reference global application object
        $this->jsmapp = Factory::getApplication();
        // JInput object
        $this->jsmjinput = $this->jsmapp->input;
        $this->jsmoption = $this->jsmjinput->getCmd('option');
        // Initialize variables.
		$options = array();
    $vartable = (string) $this->element['targettable'];
		$select_id = Factory::getApplication()->input->getVar('id');
    $db = Factory::getDbo();
			$query = $db->getQuery(true);
			
			$query->select('pos.id AS value, pos.name AS text');
			$query->from('#__sportsmanagement_position as pos');
			$query->join('INNER', '#__sportsmanagement_sports_type AS s ON s.id = pos.sports_type_id');
			$query->where('pos.published = 1');
			$query->order('pos.ordering,pos.name');
			$db->setQuery($query);
            		
        	try { 
			$options = $db->loadObjectList();
            }
catch (Exception $e) {
//    // catch any database errors.
//    $db->transactionRollback();
//    JErrorPage::render($e);

}
            
            foreach ( $options as $row )
            {
                $row->text = Text::_($row->text);
            }
    
		// Merge any additional options in the XML definition.
		$options = array_merge(parent::getOptions(), $options);
		return $options;
	}
}
