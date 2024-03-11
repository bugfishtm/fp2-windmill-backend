<?php
	/* 	__________ ____ ___  ___________________.___  _________ ___ ___  
		\______   \    |   \/  _____/\_   _____/|   |/   _____//   |   \ 
		 |    |  _/    |   /   \  ___ |    __)  |   |\_____  \/    ~    \
		 |    |   \    |  /\    \_\  \|     \   |   |/        \    Y    /
		 |______  /______/  \______  /\___  /   |___/_______  /\___|_  / 
				\/                 \/     \/                \/       \/  	
							www.bugfish.eu
							
	    Bugfish Fast PHP Page Framework
		Copyright (C) 2024 Jan Maurice Dahlmanns [Bugfish]

		This program is free software: you can redistribute it and/or modify
		it under the terms of the GNU General Public License as published by
		the Free Software Foundation, either version 3 of the License, or
		(at your option) any later version.

		This program is distributed in the hope that it will be useful,
		but WITHOUT ANY WARRANTY; without even the implied warranty of
		MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
		GNU General Public License for more details.

		You should have received a copy of the GNU General Public License
		along with this program.  If not, see <https://www.gnu.org/licenses/>.
	*/
	if(!is_array($object)) { @http_response_code(404); Header("Location: ../"); exit(); }

	// Div with Top Margin for Elements!
	echo "<div class='xfpe_margintop15px'></div>";
	
	// Display the Information Box!
	echo hive__windmill_alert_info($object["lang"]->translate("be_exp_start"));
	
	
	// Information Text
	hive__windmill_box_start($object["lang"]->translate("be_start_dash_heading"), "min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800 dark:text-gray-200 ");
	echo $object["lang"]->translate("be_start_main_text");
	hive__windmill_box_end();
	
	// Powerd By Bugfish Framework
	hive__windmill_box_start($object["lang"]->translate("be_start_bframe"), "min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800 dark:text-gray-200 xfpe_margintop15px");
	?> 
		<img src="<?php echo _HIVE_URL_REL_; ?>/_core/_image/bugfish-framework-banner.jpg">
	<?php
	hive__windmill_box_end();
	
	// Support Us Banner
	hive__windmill_box_start($object["lang"]->translate("be_start_fp2frame"), "min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800 dark:text-gray-200 xfpe_margintop15px");
	?> 
		<img src="<?php echo _HIVE_URL_REL_; ?>/_core/_image/bugfish-fp2-banner.jpg">
	<?php
	hive__windmill_box_end();