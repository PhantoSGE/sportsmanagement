<?php 
/** SportsManagement ein Programm zur Verwaltung für alle Sportarten
 * @version   1.0.05
 * @file      default_projectheading.php
 * @author    diddipoeler, stony, svdoldie und donclumsy (diddipoeler@gmx.de)
 * @copyright Copyright: © 2013 Fussball in Europa http://fussballineuropa.de/ All rights reserved.
 * @license   This file is part of SportsManagement.
 * @package   sportsmanagement
 * @subpackage globalviews
 */

defined( '_JEXEC' ) or die( 'Restricted access' );
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Factory;

$document = Factory::getDocument();

?>
<script>
console.log("jquery version : "+jQuery().jquery);
console.log("bootstrap version : "+jQuery.fn.tooltip.Constructor.VERSION);
	
if( typeof jQuery.fn.tooltip.Constructor.VERSION === 'undefined' || jQuery.fn.tooltip.Constructor.VERSION === null ){
console.log("bootstrap version ist nicht vorhanden");   
<?php	
$stylelink = '<link rel="stylesheet" href="' . Uri::root() . 'components/com_sportsmanagement/assets/css/jsmbootstrap.css' . '" type="text/css" />' . "\n";
$document->addCustomTag($stylelink);
?>	
}	
	
</script>
<?php

$nbcols = 2;
if ( $this->overallconfig['show_project_sporttype_picture'] ) { $nbcols++; }
if ( $this->overallconfig['show_project_kunena_link'] ) { $nbcols++; }
if ( $this->overallconfig['show_project_picture'] ) { $nbcols++; }
if ( $this->overallconfig['show_project_staffel_id'] ) { $nbcols++; }
if ( $this->overallconfig['show_project_heading'] == 1 && $this->project)
{
	?>
<div class="<?php echo $this->divclassrow;?>" id="projectheading">
		<table class="table">

				<?php
				if ( $this->overallconfig['show_project_country'] )
				{
					?>
				<tr class="contentheading">
					<td colspan="<?php echo $nbcols; ?>">
					<?php
					$country = $this->project->country;
				echo JSMCountries::getCountryFlag($country) . ' ' . JSMCountries::getCountryName($country);    
				
					?>
					</td>
				</tr>
				<?php
				}
				?>
				<tr class="contentheading">
					<?php
		if ( $this->overallconfig['show_project_sporttype_picture'] )
					{
						?>
						<td>

<?PHP
if ( !sportsmanagementHelper::existPicture( $this->project->sport_type_picture ) )
{
$this->project->sport_type_picture = sportsmanagementHelper::getDefaultPlaceholder("clublogobig");
}

echo sportsmanagementHelperHtml::getBootstrapModalImage('sporttype_picture',
$this->project->sport_type_picture,
Text::_($this->project->sport_type_name),
$this->overallconfig['picture_width'],
'',
$this->modalwidth,
$this->modalheight,
$this->overallconfig['use_jquery_modal']							
);
?>
          

						</td>
					<?php
			    	}
			    if ( $this->overallconfig['show_project_picture'] )
				{
				$picture = $this->project->picture;
				$copyright = $this->project->cr_picture;
                if ( $picture == 'images/com_sportsmanagement/database/placeholders/placeholder_150.png' || empty($picture) )
				{
				$picture = $this->project->leaguepicture;
				$copyright = $this->project->cr_leaguepicture;
				}

					?>
						<td>


<?php
if ( !sportsmanagementHelper::existPicture( $picture ) )
{
$picture = sportsmanagementHelper::getDefaultPlaceholder("clublogobig"); 
}
echo sportsmanagementHelperHtml::getBootstrapModalImage('project_picture',
$picture,
$this->project->name,
$this->overallconfig['picture_width'],
'',
$this->modalwidth,
$this->modalheight,
$this->overallconfig['use_jquery_modal']
);

if ( $copyright )
{
echo Text::sprintf('COM_SPORTSMANAGEMENT_COPYRIGHT_INFO','<i>'.$copyright.'</i>');
}
?>

						</td>
					<?php	
			    	}
			    	?>
					<?php
			    	if ( $this->overallconfig['show_project_text'] )
					{
						?>
				    	<td>
						<?php
						echo $this->project->name;
						if (isset( $this->division))
						{
							echo ' - ' . $this->division->name;
						}
						?>
						</td>
					<?php	
			    	}
			    	
			    	if ( $this->overallconfig['show_project_staffel_id'] )
					{
						?>
				    	<td>
						<?php
						//echo $this->project->staffel_id;
						echo Text::sprintf('COM_SPORTSMANAGEMENT_PROJECT_INFO_STAFFEL_ID','<i>'.$this->project->staffel_id.'</i>');
						?>
						</td>
					<?php	
			    	}

			    	?>
					<td class="buttonheading" align="right">
					<?php
						if(Factory::getApplication()->input->getVar('print') != 1) {
							$overallconfig = $this->overallconfig;
							echo sportsmanagementHelper::printbutton(null, $overallconfig);
						}
					?>
					&nbsp;
					</td>
                    
                    <td class="buttonheading" align="right">
					<?php
					if ( $this->overallconfig['show_project_kunena_link'] == 1 && $this->project->sb_catid )
                    {
						$link = sportsmanagementHelperRoute::getKunenaRoute( $this->project->sb_catid );
						$imgTitle = Text::_($this->project->name.' Forum');
						$desc = HTMLHelper::image('media/com_sportsmanagement/jl_images/kunena.logo.png', $imgTitle, array('title' => $imgTitle,'width' => '100' ));
						echo '&nbsp;';
						echo HTMLHelper::link($link, $desc);    
                    }
					?>
					&nbsp;
					</td>
                    
				</tr>
<!--				</tbody> -->
		</table>
</div>
<?php 
}
else
	{
	if ( $this->overallconfig['show_print_button'] )
	{
?>
		<div class="<?php echo $this->divclassrow;?>">
			<table class="table">
	<!--				<tbody> -->
					<tr class="contentheading">
						<td class="buttonheading" align="right">
						<?php 
							if(Factory::getApplication()->input->getVar('print') != 1)
							{
								echo sportsmanagementHelper::printbutton(null, $this->overallconfig);
							}
						?>
						&nbsp;
						</td>
					</tr>
		<!--			</tbody> -->
			</table>
		</div>
<?php
	}
}
?>
