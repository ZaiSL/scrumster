<?php
/**
 * Created by JetBrains PhpStorm.
 * User: boston
 * Date: 02.10.12
 * Time: 13:09
 * To change this template use File | Settings | File Templates.
 */
class ProfileWidget extends  WidgetBase{

	public static function render($di){
		
		$profiles = $di->profiler->getProfiles();

		foreach ($profiles as $profile) {
			echo "<ul>";
			echo "<li>SQL Statement: ", $profile->getSQLStatement(), "</li>\n";
			echo "<li>Start Time: ", $profile->getInitialTime(), "</li>\n";
			echo "<li>Final Time: ", $profile->getFinalTime(), "</li>\n";
			echo "<li>Total Elapsed Time: ", $profile->getTotalElapsedSeconds(), "</li>\n";
			echo "</ul>";
		}
	}
	
	
}
