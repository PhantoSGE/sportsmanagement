<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controlleradmin library
jimport('joomla.application.component.controlleradmin');
 
/**
 * SportsManagements Controller
 */
class sportsmanagementControllermatches extends JControllerAdmin
{
  
    
    function removeEvent()
    {
        // Check for request forgeries
		JSession::checkToken() or die('JINVALID_TOKEN');

		$event_id=JRequest::getInt('event_id');
		$model=$this->getModel();
		if (!$result=$model->deleteevent($event_id))
		{
			$result="0"."&".JText::_('COM_JOOMLEAGUE_ADMIN_MATCH_CTRL_ERROR_DELETE_EVENTS').': '.$model->getError();
		}
		else
		{
			$result="1"."&".JText::_('COM_JOOMLEAGUE_ADMIN_MATCH_CTRL_DELETE_EVENTS');
		}
		echo json_encode($result);
		//JFactory::getApplication()->close();
    }
    
    
    function removeCommentary()
    {
        // Check for request forgeries
		//JSession::checkToken() or die('JINVALID_TOKEN');

		$event_id = JRequest::getInt('event_id');
		$model = $this->getModel();
		if (!$result = $model->deletecommentary($event_id))
		{
			$result='0'.'&'.JText::_('COM_JOOMLEAGUE_ADMIN_MATCH_CTRL_ERROR_DELETE_COMMENTARY').': '.$model->getError();
		}
		else
		{
			$result='1'.'&'.JText::_('COM_JOOMLEAGUE_ADMIN_MATCH_CTRL_DELETE_COMMENTARY');
		}
		echo json_encode($result);
		//JFactory::getApplication()->close();
    }
    
    
    function removeSubst()
	{
		JSession::checkToken() or die('JINVALID_TOKEN');
		$substid = JRequest::getInt('substid',0);
		$model = $this->getModel();
		if (!$result = $model->removeSubstitution($substid))
		{
			$result="0"."&".JText::_('COM_SPORTSMANAGEMENT_ADMIN_MATCH_CTRL_ERROR_REMOVE_SUBST').': '.$model->getError();
		}
		else
		{
			$result="1"."&".JText::_('COM_SPORTSMANAGEMENT_ADMIN_MATCH_CTRL_REMOVE_SUBST');
		}
		echo json_encode($result);
		//JFactory::getApplication()->close();
	}
    
    function saveevent()
    {
        $option = JRequest::getCmd('option');

		// Check for request forgeries
		JSession::checkToken() or die('JINVALID_TOKEN');

		$mainframe = JFactory::getApplication();
		$data = array();
		$data['teamplayer_id']	= JRequest::getInt('teamplayer_id');
		$data['projectteam_id']	= JRequest::getInt('projectteam_id');
		$data['event_type_id']	= JRequest::getInt('event_type_id');
		$data['event_time']		= JRequest::getVar('event_time','');
		$data['match_id']		= JRequest::getInt('matchid');
		$data['event_sum']		= JRequest::getVar('event_sum', '');
		$data['notice']			= JRequest::getVar('notice', '');
		$data['notes']			= JRequest::getVar('notes', '');
        
        // diddipoeler
        $data['projecttime']			= JRequest::getVar('projecttime','');
        
        $model = $this->getModel();
		//$project_id = $mainframe->getUserState( "$option.pid", '0' );;
		if (!$result = $model->saveevent($data)) {
			$result = "0"."&".JText::_('COM_JOOMLEAGUE_ADMIN_MATCH_CTRL_ERROR_SAVED_EVENT').': '.$model->getError();
        } else {
			$result = $model->getDbo()->insertid()."&".JText::_('COM_JOOMLEAGUE_ADMIN_MATCH_CTRL_SAVED_EVENT');
		}    
 
		echo json_encode($result);
		//JFactory::getApplication()->close();
    }
    
    function savecomment()
    {
        $option = JRequest::getCmd('option');

		// Check for request forgeries
		JSession::checkToken() or die('JINVALID_TOKEN');

		$mainframe = JFactory::getApplication();
		$data = array();
		$data['event_time']		= JRequest::getVar('event_time','');
		$data['match_id']		= JRequest::getInt('matchid');
		$data['type']		= JRequest::getVar('type', '');
		$data['notes']			= JRequest::getVar('notes', '');
        
        // diddipoeler
        $data['projecttime']			= JRequest::getVar('projecttime','');
        
        $model = $this->getModel();
		//$project_id = $mainframe->getUserState( "$option.pid", '0' );;
		if (!$result = $model->savecomment($data)) {
            $result = '0&'.JText::_('COM_JOOMLEAGUE_ADMIN_MATCH_CTRL_ERROR_SAVED_COMMENT').': '.$model->getError();
        } else {
            //$result = $model->getDbo()->insertid()."&".JText::_('COM_JOOMLEAGUE_ADMIN_MATCH_CTRL_SAVED_COMMENT');
            $result = $result.'&'.JText::_('COM_JOOMLEAGUE_ADMIN_MATCH_CTRL_SAVED_COMMENT');
		}    
 
		echo json_encode($result);
		//JFactory::getApplication()->close();
    }
    
    function savesubst()
	{
		// Check for request forgeries
		JSession::checkToken() or die('JINVALID_TOKEN');
		$data = array();
		$data['in'] 					= JRequest::getInt('in');
		$data['out'] 					= JRequest::getInt('out');
		$data['matchid'] 				= JRequest::getInt('matchid');
		$data['in_out_time'] 			= JRequest::getVar('in_out_time','');
		$data['project_position_id'] 	= JRequest::getInt('project_position_id');
        
        // diddipoeler
        $data['projecttime']			= JRequest::getVar('projecttime','');
		
        $model = $this->getModel();
		if (!$result = $model->savesubstitution($data)){
			$result = "0"."&".JText::_('COM_SPORTSMANAGEMENT_ADMIN_MATCH_CTRL_ERROR_SAVED_SUBST').': '.$model->getError();
		} else {
            $result = $model->getDbo()->insertid()."&".JText::_('COM_SPORTSMANAGEMENT_ADMIN_MATCH_CTRL_SAVED_SUBST');
		}
        
		echo json_encode($result);
		//JFactory::getApplication()->close();
	}
    
    
    
    function saveroster()
    {
        $option = JRequest::getCmd('option');
        $post = JRequest::get('post');
        $model = $this->getModel();
        
        $positions = $model->getProjectPositionsOptions(0, 1,$post['project_id']);
        $staffpositions = $model->getProjectPositionsOptions(0, 2,$post['project_id']);
        $post['positions'] = $positions;
        $post['staffpositions'] = $staffpositions;
        
        if ($model->updateRoster($post))
		{
			$msg = JText::_('COM_SPORTSMANAGEMENT_ADMIN_MATCH_CTRL_SAVED_MR');
		}
		else
		{
			$msg = JText::_('COM_SPORTSMANAGEMENT_ADMIN_MATCH_CTRL_ERROR_SAVE_MR').'<br />';
		}
        
        if ($model->updateStaff($post))
		{
			$msg .= ' - '.JText::_('COM_SPORTSMANAGEMENT_ADMIN_MATCH_CTRL_SAVED_MR');
		}
		else
		{
			$msg .= ' - '.JText::_('COM_SPORTSMANAGEMENT_ADMIN_MATCH_CTRL_ERROR_SAVE_MR').'<br />';
		}
        
        if ( JRequest::getString('close', 0) == 1 )
        {
            $link = 'index.php?option='.$option.'&view=close&tmpl=component';
        }
        else
        {
            $link = 'index.php?option='.$option.'&close='.JRequest::getString('close', 0).'&tmpl=component&view=match&layout=editlineup&id='.$post['id'].'&team='.$post['team'];
        }
        
		//echo $link.'<br />';
		$this->setRedirect($link,$msg);
    }    
    
    
    function saveReferees()
    {
        $option = JRequest::getCmd('option');
        $post = JRequest::get('post');
        $model = $this->getModel();
        $positions = $model->getProjectPositionsOptions(0, 3,$post['project_id']);
        $post['positions'] = $positions;
        
        if ($model->updateReferees($post))
		{
			$msg = JText::_('COM_SPORTSMANAGEMENT_ADMIN_MATCH_CTRL_SAVED_MR');
		}
		else
		{
			$msg = JText::_('COM_SPORTSMANAGEMENT_ADMIN_MATCH_CTRL_ERROR_SAVE_MR').'<br />';
		}
        
        if ( JRequest::getString('close', 0) == 1 )
        {
            $link = 'index.php?option='.$option.'&view=close&tmpl=component';
        }
        else
        {
            $link = 'index.php?option='.$option.'&close='.JRequest::getString('close', 0).'&tmpl=component&view=match&layout=editreferees&id='.$post['id'];
        }
        
		//echo $link.'<br />';
		$this->setRedirect($link,$msg);
    }
    
    
    /**
	 * Method to update checked matches
	 *
	 * @access	public
	 * @return	boolean	True on success
	 *
	 */
    function saveshort()
	{
	   $model = $this->getModel();
       $model->saveshort();
       $this->setRedirect(JRoute::_('index.php?option='.$this->option.'&view='.$this->view_list, false));
    } 
    
    
	/**
	 * Proxy for getModel.
	 * @since	1.6
	 */
	public function getModel($name = 'match', $prefix = 'sportsmanagementModel') 
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		return $model;
	}
}