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
	if(!hive__access($object, "admin_system", false) AND $object["user"]->user["user_initial"] != 1) {
		define("_INT_SHOW_ACCESS_", "true");
	} else {		
		////////////////////////////////////////////////////////////////
		// Variables
		////////////////////////////////////////////////////////////////
		$title_general 	= $object["lang"]->translate("be_mail_template_raw");
		$trts_general 	= "name, description, section, id";
		$item_general 	= $object["lang"]->translate("be_mail_template_raw");
		$text_general 	= $object["lang"]->translate("be_exp_mailtempl");
		$table_general 	= _TABLE_MAIL_TPL_;
		$table_title   	= array(array("name" => $object["lang"]->translate("be_mail_template_name")), 
							    array("name" => $object["lang"]->translate("b_description")),
							    array("name" => $object["lang"]->translate("be_list_h_mode"))); 
		
		// Create Table Object
		$tbl = new x_class_table($object["mysql"], $table_general, "table");
		if(!isset($_SESSION[_HIVE_SITE_COOKIE_."section_admin_change"])) { $_SESSION[_HIVE_SITE_COOKIE_."section_admin_change"] = "*"; }
		if(@$_POST["hive_submit_chmcxg"]) { 
			if($object["csrf"]->check(@$_POST["hive_submit_flush_table_token"])) { 
				if(in_array(@$_POST["hive_submit_chmcxg"], _HIVE_MODE_ARRAY_)) { $_SESSION[_HIVE_SITE_COOKIE_."section_admin_change"] = $_POST["hive_submit_chmcxg"]; } 
				else { $_SESSION[_HIVE_SITE_COOKIE_."section_admin_change"] = "*"; }
				$object["eventbox"]->warning($object["lang"]->translate("be_list_h_exec_chmg"));
			} else { $object["eventbox"]->error($object["lang"]->translate("hive_login_msg_csrf")); }		 
		}			
		// Table Edit Arrays and Create
		$tbl->config_rel_url("./?"._HIVE_URL_GET_[0]."="._HIVE_URL_CUR_[0]."&"._HIVE_URL_GET_[1]."="._HIVE_URL_CUR_[1]."");
		$create_ar  = array();
		$create_ar[0]["field_name"] 	= "name";
		$create_ar[0]["field_ph"] 		= $object["lang"]->translate("be_mail_template_name");
		$create_ar[0]["field_label"] 	= $object["lang"]->translate("be_mail_template_name");
		$create_ar[0]["field_type"] 	= "string";
		$create_ar[0]["field_classes"] 	= "block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input";
		$create_ar[1]["field_name"] 	= "subject";
		$create_ar[1]["field_ph"] 		= $object["lang"]->translate("be_mail_template_subject");
		$create_ar[1]["field_label"] 	= $object["lang"]->translate("be_mail_template_subject");
		$create_ar[1]["field_type"] 	= "string";
		$create_ar[1]["field_classes"] 	= "block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input";
		$create_ar[2]["field_name"] 	= "content";
		$create_ar[2]["field_ph"] 		= $object["lang"]->translate("be_mail_template_content");
		$create_ar[2]["field_label"] 	= $object["lang"]->translate("be_mail_template_content");
		$create_ar[2]["field_type"] 	= "text";
		$create_ar[2]["field_classes"] 	= "block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray";
		$create_ar[3]["field_name"] 	= "description";
		$create_ar[3]["field_ph"] 		= $object["lang"]->translate("be_mail_template_description");
		$create_ar[3]["field_label"] 	= $object["lang"]->translate("be_mail_template_description");
		$create_ar[3]["field_type"] 	= "text";
		$create_ar[3]["field_classes"] 	= "block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray";
		$create_ar[4]["field_name"] 	= "section";
		$create_ar[4]["field_ph"] 		= $object["lang"]->translate("be_list_h_mode");
		$create_ar[4]["field_label"] 	= $object["lang"]->translate("be_list_h_mode");
		$create_ar[4]["field_type"] 	= "select";
		$create_ar[4]["field_pre"] 		= $_SESSION[_HIVE_SITE_COOKIE_."section_admin_change"];
		$create_ar[4]["select_array"] 	= _HIVE_MODE_ARRAY_;
		$create_ar[4]["field_classes"] 	= "block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input";
		
		
		$edit_ar    = array();
		$edit_ar[0]["field_name"] 		= "subject";
		$edit_ar[0]["field_ph"] 		= $object["lang"]->translate("be_mail_template_subject");
		$edit_ar[0]["field_label"] 		= $object["lang"]->translate("be_mail_template_subject");
		$edit_ar[0]["field_type"] 		= "string";
		$edit_ar[0]["field_classes"] 	= "block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input";
		$edit_ar[1]["field_name"] 		= "content";
		$edit_ar[1]["field_ph"] 		= $object["lang"]->translate("be_mail_template_content");
		$edit_ar[1]["field_label"] 		= $object["lang"]->translate("be_mail_template_content");
		$edit_ar[1]["field_type"] 		= "text";
		$edit_ar[1]["field_classes"] 	= "block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray";
		$edit_ar[2]["field_name"] 		= "description";
		$edit_ar[2]["field_ph"] 		= $object["lang"]->translate("be_mail_template_description");
		$edit_ar[2]["field_label"] 		= $object["lang"]->translate("be_mail_template_description");
		$edit_ar[2]["field_type"] 		= "text";
		$edit_ar[2]["field_classes"] 	= "block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray";
		
		
		$tbl->config_array($create_ar, $edit_ar);			
		
		// Delete Item Operations
		$output1 =  $tbl->exec_delete();
		if($output1 == "deleted") { $object["eventbox"]->warning($object["lang"]->translate("be_list_exec_idel")); 
									$object["log"]->info("[DELETION] [TABLE] ".$table_general." [ID] ".@$_POST["x_class_table_exec_deletetable"]." [UID] ".$object["user"]->user_id."", "system_mailtemplates");}
		if($output1 == "csrf") { $object["eventbox"]->error($object["lang"]->translate("hive_login_msg_csrf"));}

		// Delete Operations
		$output1 =  $tbl->exec_create();
		if($output1 == "created") { 
						if(@$object["mysql"]->insert_id() > 0) {
							$object["log"]->info("[CREATE] [TABLE] ".$table_general." [ID] ".@$object["mysql"]->insert_id()." [UID] ".$object["user"]->user_id."", "system_mailtemplates");
							$object["eventbox"]->warning($object["lang"]->translate("be_str_item_created"));
						} else { $object["eventbox"]->error($object["lang"]->translate("be_mailt_err")); } 
									}
		if($output1 == "csrf") { $object["eventbox"]->error($object["lang"]->translate("hive_login_msg_csrf"));}
		
		// Delete Operations
		$output1 =  $tbl->exec_edit();
		if($output1 == "edited") { $object["eventbox"]->warning($object["lang"]->translate("be_mailt_edit")); 
			$object["log"]->info("[CHANGE] [TABLE] ".$table_general." [ID] ".@$_POST["x_class_table_exec_edittable"]." [UID] ".$object["user"]->user_id."", "system_mailtemplates");}
		if($output1 == "csrf") { $object["eventbox"]->error($object["lang"]->translate("hive_login_msg_csrf"));}

	
		////////////////////////////////////////////////////////////////
		// Get Table Values
		////////////////////////////////////////////////////////////////
		$tmpx = $_SESSION[_HIVE_SITE_COOKIE_."section_admin_change"];
		$value_array = $object["mysql"]->select("SELECT ".$trts_general." FROM ".$table_general."", true);
		if(is_array($value_array)) {
			foreach($value_array as $key => $value) {
				if($tmpx == $value["section"]) {
				} elseif($tmpx == "*") { }
				else  { unset($value_array[$key]); continue; }
				$value_array[$key]["name"] = @htmlspecialchars($value_array[$key]["name"]);
				$value_array[$key]["description"] = @htmlspecialchars($object["lang"]->translate($value_array[$key]["description"]));
				$value_array[$key]["section"] = @htmlspecialchars($value_array[$key]["section"]);
			}
		}

		// Div with Top Margin for Elements!
		echo "<div class='xfpe_margintop15px'></div>";
		
		// Display the Information Box!
		echo hive__windmill_alert_info($text_general);
		// Display the Operations Bar!
		hive__windmill_box_start(false, "min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800 dark:text-gray-200");
			if(in_array(@$_SESSION[_HIVE_SITE_COOKIE_."section_admin_change"], _HIVE_MODE_ARRAY_)) { } 
			else { $_SESSION[_HIVE_SITE_COOKIE_."section_admin_change"] = "*"; }
			echo "<form method='post' action='./?"._HIVE_URL_GET_[0]."="._HIVE_URL_CUR_[0]."&"._HIVE_URL_GET_[1]."="._HIVE_URL_CUR_[1]."'>";
				echo "<input type='hidden' name='hive_submit_chmc' value='1'>";
				echo "<input type='hidden' name='hive_submit_flush_table_token' value='".$object["csrf"]->get()."'>";
				echo '<select name="hive_submit_chmcxg" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-primary-bugfish dark:focus:shadow-outline-gray xfpe_floatleft xfpe_marginbottom5px xfpe_marginright10px">';
					echo '<option value="*">*</option>';
					foreach(_HIVE_MODE_ARRAY_ as $key => $value) {
						if($_SESSION[_HIVE_SITE_COOKIE_."section_admin_change"] == $value) { $cmtp = "selected"; } else { $cmtp = ""; }
						echo '<option value="'.htmlentities($value ?? '').'" '.$cmtp.'>'.htmlspecialchars($value ?? '').'</option>';
					}
				echo '</select>';
					echo '<button onclick="" name="hive_submit_chmc" type="submit" class="flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-primary-bugfish border border-transparent xfpe_floatleft xfpe_marginbottom5px xfpe_marginright10px rounded-lg active:bg-primary-bugfish hover:bg-primary-bugfish focus:outline-none focus:shadow-primary-bugfish force-white-focus " style="background: blue;color: white;"><span>'.$object["lang"]->translate("be_list_h_btn_chm").'</span><i class="bx bx bx-trash xfpe_marginleft10px"></i></button>';
					echo '<button onclick="window.location.href = \''.hive_get_url_rel(array("system", "mailtemplates", false)).'&op=create\';" type="button" class="flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-primary-bugfish border border-transparent xfpe_floatleft xfpe_marginbottom5px xfpe_marginright10px rounded-lg active:bg-primary-bugfish hover:bg-primary-bugfish focus:outline-none focus:shadow-primary-bugfish force-white-focus " style="background: lime;color: black;"><span>'.$object["lang"]->translate("be_mail_template_add").'</span><i class="bx bx bx-plus xfpe_marginleft10px"></i></button>';
			echo "</form>";
		hive__windmill_box_end();		
		if(@$_GET["op"] == "create") {
			hive__windmill_box_start($object["lang"]->translate("be_mail_template_add"), "min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800 xfpe_margintop15px");
			$tbl->spawn_create($object["lang"]->translate("be_mail_template_add"), "flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-primary-bugfish border border-transparent rounded-lg 	active:bg-primary-bugfish hover:bg-primary-bugfish focus:outline-none focus:shadow-primary-bugfish force-white-focus");
			echo "<a href='".hive_get_url_rel(array("system", "mailtemplates", false))."'>".$object["lang"]->translate("be_edit_abort")."</a>"; 
			hive__windmill_box_end();
		} elseif(@$_POST["x_class_table_exec_edittable"] ) {
			hive__windmill_box_start($object["lang"]->translate("be_mail_template_edit"), "min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800 xfpe_margintop15px");
			$x = $object["mysql"]->select("SELECT * FROM ".$table_general." WHERE id = '".$_POST["x_class_table_exec_edittable"]."'");
			if($x) { 
				echo "<div class='min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800 dark:text-gray-200'>";
					echo "<b>".$object["lang"]->translate("be_mailt_name")."</b>: ".htmlspecialchars($x["name"] ?? '')."<br />";
					echo "<b>".$object["lang"]->translate("be_list_h_mode")."</b>: ".htmlspecialchars($x["section"] ?? '')."<br />";
				echo "</div>";
			}
			$tbl->spawn_edit($object["lang"]->translate("be_mail_template_edit"), "flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-primary-bugfish border border-transparent rounded-lg active:bg-primary-bugfish hover:bg-primary-bugfish focus:outline-none focus:shadow-primary-bugfish force-white-focus");
			echo "<a href='".hive_get_url_rel(array("system", "mailtemplates", false))."'>".$object["lang"]->translate("be_edit_abort")."</a>"; 
			hive__windmill_box_end();
		}
		
		// Display the Table!
		hive__windmill_box_start($title_general." ".$object["lang"]->translate("be_list_starthead"). " [".$object["lang"]->translate("be_list_h_module")." ".$_SESSION[_HIVE_SITE_COOKIE_."section_admin_change"]."]", "min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800 xfpe_margintop15px");
		$tbl->spawn_table($table_title, $value_array, $object["lang"]->translate("b_edit"), $object["lang"]->translate("b_delete"), false, $object["lang"]->translate("b_action"), "display");
		hive__windmill_box_end();
	} 