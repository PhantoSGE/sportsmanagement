<?php
// no direct access
defined('_JEXEC') or die ;
use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Model\BaseDatabaseModel;

$classpath = JPATH_ADMINISTRATOR . DS . JSM_PATH . DS . 'helpers' . DS . 'sportsmanagement.php';
JLoader::register('sportsmanagementHelper', $classpath);
BaseDatabaseModel::getInstance("sportsmanagementHelper", "sportsmanagementModel");

jimport('joomla.form.formfield');

class JFormFieldserialnumber extends FormField {
		
	public $type = 'serialnumber';

	protected function getInput() {
	$app = Factory::getApplication();
	//$app->enqueueMessage(__METHOD__.' '.__LINE__.' element <pre>'.print_r($this->element, true).'</pre><br>','');
	//$app->enqueueMessage(__METHOD__.' '.__LINE__.' name<pre>'.print_r($this->name, true).'</pre><br>','');
	//$app->enqueueMessage(__METHOD__.' '.__LINE__.' id<pre>'.print_r($this->id, true).'</pre><br>','');
	//$app->enqueueMessage(__METHOD__.' '.__LINE__.' value<pre>'.print_r($this->value, true).'</pre><br>','');
	//$app->enqueueMessage(__METHOD__.' '.__LINE__.' value<pre>'.print_r($this->form, true).'</pre><br>','');
	if ( !$this->value )
	{
	$this->value = sportsmanagementHelper::jsmsernum();
	}
/*
	$html = '<div style="padding-top: 5px; overflow: inherit">';
		$html .= '<span class="label">'.$version.'</span>';
		$html .= '</div>';
*/
$html = '<input type="text" id="'.$this->id.'" name="'.$this->name.'" value="'.$this->value.'" />';		
		return $html;
	
	}

	

}
?>
