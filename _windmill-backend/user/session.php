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
	if(!hive__access($object, "admin_user", false) AND $object["user"]->user["user_initial"] != 1) {
		define("_INT_SHOW_ACCESS_", "true");
	} else {		
		////////////////////////////////////////////////////////////////
		// Variables
		////////////////////////////////////////////////////////////////
		$title_general 	= $object["lang"]->translate("be_sessions"); 
		$trts_general 	= "creation, fk_user, key_type, is_active, id";
		$item_general 	= $object["lang"]->translate("be_sessions");
		$text_general 	= $object["lang"]->translate("be_exp_usr_se"); 
		$table_general 	= _TABLE_USER_SESSION_;
		$table_title   	= array(array("name" => $object["lang"]->translate("be_se_key_h1")),
							    array("name" => $object["lang"]->translate("be_se_key_h2")),
							    array("name" => $object["lang"]->translate("be_se_key_h3")),
							    array("name" => $object["lang"]->translate("be_se_key_h4")));
		
		// Create Table Object
		$tbl = new x_class_table($object["mysql"], $table_general, "table");
		
		// Table Flush Operation
		if(@$_POST["hive_submit_flush_table"] OR @$_GET["op"] == "flush") {
			if(@$_GET["confirm"] != "confirmed") { 
				?>
				<script>
					Swal.fire({
					  title: "<?php echo $object["lang"]->translate("be_list_h_btn_flush"); ?>",
					  html: "<?php echo $object["lang"]->translate("be_list_h_btn_flush_rly"); ?><form method='post' action='<?php echo "./?"._HIVE_URL_GET_[0]."="._HIVE_URL_CUR_[0]."&"._HIVE_URL_GET_[1]."="._HIVE_URL_CUR_[1]."&confirm=confirmed"; ?>'><input type='hidden' name='hive_submit_flush_table_token' value='<?php echo $object["csrf"]->get(); ?>'><input type='hidden' name='hive_submit_flush_table' value='1'><input type='submit' class=\"flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-primary-bugfish border border-transparent xfpe_floatleft  xfpe_cursorpointer xfpe_marginbottom5px xfpe_marginright10px rounded-lg active:bg-primary-bugfish hover:bg-primary-bugfish focus:outline-none focus:shadow-primary-bugfish force-white-focus \" style=\"background: red;color: white;\" value='<?php echo htmlentities($object["lang"]->translate("be_yes") ?? ''); ?>'></form>",
					  showCancelButton: false,
					  showCloseButton: true,
					  showConfirmButton: false
					});
				</script>
				<?php 
			} else { 
				if($object["csrf"]->check(@$_POST["hive_submit_flush_table_token"])) { 
					$object["mysql"]->query("DELETE FROM ".$table_general."");
					$object["mysql"]->query("ALTER TABLE ".$table_general." AUTO_INCREMENT = 1");
					$object["eventbox"]->warning($object["lang"]->translate("be_list_h_exec_flush"));
					$object["log"]->info("[FLUSH] [TABLE] ".$table_general." [UID] ".$object["user"]->user_id."", "user_session");
				} else { $object["eventbox"]->error($object["lang"]->translate("hive_login_msg_csrf")); }		 
			}
		}	
		
		// Delete Item Operations
		$output1 =  $tbl->exec_delete();
		if($output1 == "deleted") { $object["eventbox"]->warning($object["lang"]->translate("be_list_exec_idel")); 
									$object["log"]->info("[DELETION] [TABLE] ".$table_general." [ID] ".@$_POST["x_class_table_exec_deletetable"]." [UID] ".$object["user"]->user_id."", "user_session");}
		if($output1 == "csrf") { $object["eventbox"]->error($object["lang"]->translate("hive_login_msg_csrf"));}

		////////////////////////////////////////////////////////////////
		// Get Table Values
		////////////////////////////////////////////////////////////////
		$value_array = $object["mysql"]->select("SELECT ".$trts_general." FROM ".$table_general."", true);
		if(is_array($value_array)) {
			foreach($value_array as $key => $value) {
				$value_array[$key]["creation"] = @htmlspecialchars($value_array[$key]["creation"]);
				$value_array[$key]["fk_user"] = @htmlspecialchars($value_array[$key]["fk_user"]);
				$value_array[$key]["key_type"] = @htmlspecialchars($value_array[$key]["key_type"]);
				$value_array[$key]["is_active"] = @htmlspecialchars($value_array[$key]["is_active"]);
				if($value_array[$key]["key_type"] == 1) { $value_array[$key]["key_type"] = $object["lang"]->translate("be_se_key_act"); }
				if($value_array[$key]["key_type"] == 2) { $value_array[$key]["key_type"] = $object["lang"]->translate("be_se_key_ses"); }
				if($value_array[$key]["key_type"] == 3) { $value_array[$key]["key_type"] = $object["lang"]->translate("be_se_key_rec"); }
				if($value_array[$key]["key_type"] == 4) { $value_array[$key]["key_type"] = $object["lang"]->translate("be_se_key_mch"); }
			}
		}

		// Div with Top Margin for Elements!
		echo "<div class='xfpe_margintop15px'></div>";
		
		// Display the Information Box!
		echo  hive__windmill_alert_info($text_general);
		
		// Display the Operations Bar!
		hive__windmill_box_start(false, "min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800 dark:text-gray-200");
			echo "<form method='post' action='./?"._HIVE_URL_GET_[0]."="._HIVE_URL_CUR_[0]."&"._HIVE_URL_GET_[1]."="._HIVE_URL_CUR_[1]."'>";
				echo hive__windmill_button_icright($object["lang"]->translate("be_list_h_btn_flush"), "bx bxs-trash", "red", "white", "submit", "", "hive_submit_flush_table");
				echo "<input type='hidden' name='hive_submit_flush_table_token' value='".$object["csrf"]->get()."'>";
				echo "<input type='hidden' name='hive_submit_flush_table' value='1'>";
			echo "</form>";
		hive__windmill_box_end();
		
		// Display the Table!
		hive__windmill_box_start($title_general." ".$object["lang"]->translate("be_list_starthead"), "min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800 xfpe_margintop15px");
		$tbl->spawn_table($table_title, $value_array, false, $object["lang"]->translate("b_delete"), false, $object["lang"]->translate("b_delete"), "display");
		hive__windmill_box_end();
	}