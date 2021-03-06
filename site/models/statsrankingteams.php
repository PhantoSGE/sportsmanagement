<?php
/** SportsManagement ein Programm zur Verwaltung für alle Sportarten
 * @version   1.0.05
 * @file      statsranking.php
 * @author    diddipoeler, stony, svdoldie und donclumsy (diddipoeler@gmx.de)
 * @copyright Copyright: © 2013 Fussball in Europa http://fussballineuropa.de/ All rights reserved.
 * @license   This file is part of SportsManagement.
 * @package   sportsmanagement
 * @subpackage statsranking
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
use Joomla\CMS\MVC\Model\BaseDatabaseModel;

class sportsmanagementModelStatsRankingTeams extends BaseDatabaseModel
{

  /**
	 * players total
	 *
	 * @var integer
	 */
	var $_total = null;

	/**
	 * Pagination object
	 *
	 * @var object
	 */
	var $_pagination = null;
	
	var $order = null;
	static $divisionid = 0;
	static $teamid = 0;
    
    static $cfg_which_database = 0;
	static $projectid = 0;
    
	
	function __construct( )
	{
        // Reference global application object
        $app = Factory::getApplication();
        // JInput object
        $jinput = $app->input;
		parent::__construct( );


		self::$projectid	= $jinput->getInt( 'p', 0 );
		self::$divisionid	= $jinput->getInt( 'division', 0 );
		self::$teamid		= $jinput->getInt( 'tid', 0 );
		self::setStatid($jinput->getVar( 'sid', 0 ));
		$config = sportsmanagementModelProject::getTemplateConfig($this->getName());
		// TODO: the default value for limit should be updated when we know if there is more than 1 statistics type to be shown
		if ( $this->stat_id != 0 )
		{
			$this->limit = $jinput->getInt( 'limit', $config["max_stats"] );
		}
		else
		{
			$this->limit = $jinput->getInt( 'limit', $config["count_stats"] );
		}
		$this->limitstart = $jinput->getInt( 'limitstart', 0 );
		$this->setOrder($jinput->getVar('order'));
        
        self::$cfg_which_database = $jinput->getInt( 'cfg_which_database', 0 );
        sportsmanagementModelProject::$projectid = self::$projectid;
        
	}
	
	

	

	/**
	 * set order (asc or desc)
	 * @param string $order
	 * @return string order
	 */
	function setOrder($order)
	{
		if (strcasecmp($order, 'asc') === 0 || strcasecmp($order, 'desc') === 0) {
			$this->order = strtolower($order);
		}
		return $this->order;
	}

	
	function getLimit( )
	{
		return $this->limit;
	}

	
	function getLimitStart( )
	{
		return $this->limitstart;
	}

	
	function setStatid($statid)
	{
		// Allow for multiple statistics IDs, arranged in a single parameters (sid) as string
		// with "|" as separator
		$sidarr = explode("|", $statid);
		$this->stat_id = array();
		foreach ($sidarr as $sid)
		{
			$this->stat_id[] = (int)$sid;	// The cast gets rid of the slug
		}
		// In case 0 was (part of) the sid string, make sure all stat types are loaded)
		if (in_array(0, $this->stat_id))
		{
			$this->stat_id = 0;
		}
	}

	
	
	function getProjectUniqueStats()
	{
		$pos_stats = sportsmanagementModelProject::getProjectStats($this->stat_id,0,self::$cfg_which_database);
		
		$allstats = array();
		foreach ($pos_stats as $pos => $stats) 
		{
			foreach ($stats as $stat) {
				$allstats[$stat->id] = $stat;
			} 
		}
		return $allstats;
	}
	
	
	function getPlayersStats($order=null)
	{
		$stats = self::getProjectUniqueStats();
		$order = ($order ? $order : $this->order);
		$results = array();
		$results2 = array();
		foreach ($stats as $stat) 
		{
			$results[$stat->id] = $stat->getPlayersRanking(self::$projectid, self::$divisionid, self::$teamid, self::getLimit(), self::getLimitStart(), $order);
			$results2[$stat->id] = $stat->getTeamsRanking(self::$projectid, self::getLimit(), self::getLimitStart(), $order);
		}
		return $results;
	}

	function getTeamsStats($order=null)
	{
		$stats = self::getProjectUniqueStats();
		$order = ($order ? $order : $this->order);
		$results = array();
		$results2 = array();
		foreach ($stats as $stat) 
		{
			$results[$stat->id] = $stat->getPlayersRanking(self::$projectid, self::$divisionid, self::$teamid, self::getLimit(), self::getLimitStart(), $order);
			$results2[$stat->id] = $stat->getTeamsRanking(self::$projectid, self::getLimit(), self::getLimitStart(), $order);
		}
		return $results2;
	}

	function getTeamsTotal($teamsstats = array() )
	{
	$teamstotal = array();	
	foreach((array) $teamsstats as $rows => $value )
	{
	foreach ( $value AS $row )
	{
	$teamstotal[$row->team_id][team_id] = $row->team_id;
	$teamstotal[$row->team_id][total] += $row->total;	
	$teamstotal[$row->team_id][$rows] = $row->total;
	}
	
	}
	// Hole eine Liste von Spalten
foreach ($teamstotal as $key => $row) {
    $total[$key]    = $row['total'];
}
	array_multisort($total, SORT_DESC, $teamstotal);	
	return $teamstotal;	
	}
}
?>
