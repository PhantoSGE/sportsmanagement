<?php
/** SportsManagement ein Programm zur Verwaltung für alle Sportarten
 * @version   1.0.05
 * @file      default.php
 * @author    diddipoeler, stony, svdoldie und donclumsy (diddipoeler@gmx.de)
 * @copyright Copyright: © 2013 Fussball in Europa http://fussballineuropa.de/ All rights reserved.
 * @license   This file is part of SportsManagement.
 * @package   sportsmanagement
 * @subpackage nextmatch
 */

defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Language\Text;

// Make sure that in case extensions are written for mentioned (common) views,
// that they are loaded i.s.o. of the template of this view
$templatesToLoad = array('globalviews');
sportsmanagementHelper::addTemplatePaths($templatesToLoad, $this);
?>

<div class="<?php echo $this->divclasscontainer;?>" id="nextmatch">
<?php
echo $this->loadTemplate('projectheading');

if ($this->match)
{
if ( $this->config['show_sectionheader'] ) {
echo $this->loadTemplate('sectionheader');
}

if ( $this->config['show_nextmatch'] ) {
echo $this->loadTemplate('nextmatch');
}

$this->output = array();
if ( $this->config['show_details'] ) {
$this->output['COM_SPORTSMANAGEMENT_NEXTMATCH_DETAILS'] = 'details';
}

if ( $this->config['show_preview'] ) {
$this->output['COM_SPORTSMANAGEMENT_NEXTMATCH_PREVIEW'] = 'preview';
}

if ( $this->config['show_stats'] ) {
$this->output['COM_SPORTSMANAGEMENT_NEXTMATCH_H2H'] = 'stats';
}

if ( $this->config['show_history'] ) {
$this->output['COM_SPORTSMANAGEMENT_NEXTMATCH_HISTORY'] = 'history';
}

if ( $this->config['show_previousx'] ) {
$this->output['COM_SPORTSMANAGEMENT_NEXTMATCH_PREVIOUS'] = 'previousx';
}

if ( $this->config['show_commentary'] && $this->matchcommentary ) {
$this->output['COM_SPORTSMANAGEMENT_MATCHREPORT_MATCH_COMMENTARY'] = 'commentary';
}

echo $this->loadTemplate($this->config['show_nextmatch_tabs']);
echo $this->loadTemplate('jsminfo');
?>
</div>
<div>
<?PHP
}
else {
echo "<p>" . Text::_('COM_SPORTSMANAGEMENT_NEXTMATCH_NO_MORE_MATCHES') . "</p>";
}
?>
</div>
