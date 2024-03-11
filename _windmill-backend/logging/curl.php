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
	if(!hive__access($object, "admin_logging", false) AND $object["user"]->user["user_initial"] != 1) {
		define("_INT_SHOW_ACCESS_", "true");
	} else {		
		////////////////////////////////////////////////////////////////
		// Variables
		////////////////////////////////////////////////////////////////
		$title_general 	= $object["lang"]->translate("be_curl");
		$trts_general 	= "creation, url, request, section, id";
		$item_general 	= $object["lang"]->translate("be_curl")." ".$object["lang"]->translate("be_list_starthead");
		$text_general 	= $object["lang"]->translate("be_exp_curl");
		$table_general 	= _TABLE_LOG_CURL_;
		$table_title   	= array(array("name" => $object["lang"]->translate("be_list_h_date")), 
							    array("name" => $object["lang"]->translate("be_list_h_url")),
							    array("name" => $object["lang"]->translate("be_list_h_req")),
							    array("name" => $object["lang"]->translate("be_list_h_mode")));
		
		// Create Table Object
		$tbl = new x_class_table($object["mysql"], $table_general, "table");
		if(!isset($_SESSION[_HIVE_SITE_COOKIE_."section_admin_change"])) { $_SESSION[_HIVE_SITE_COOKIE_."section_admin_change"] = "*"; }
		
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
					$object["log"]->info("[FLUSH] [TABLE] ".$table_general." [UID] ".$object["user"]->user_id."", "logging_curl");
				} else { $object["eventbox"]->error($object["lang"]->translate("hive_login_msg_csrf")); }		 
			}
		}		
		
		if(!isset($_SESSION[_HIVE_SITE_COOKIE_."section_admin_change"])) { $_SESSION[_HIVE_SITE_COOKIE_."section_admin_change"] = "*"; }
		if(@$_POST["hive_submit_chmcxg"]) { 
			if($object["csrf"]->check(@$_POST["hive_submit_flush_table_token"])) { 
				if(in_array(@$_POST["hive_submit_chmcxg"], _HIVE_MODE_ARRAY_)) { $_SESSION[_HIVE_SITE_COOKIE_."section_admin_change"] = $_POST["hive_submit_chmcxg"]; } 
				else { $_SESSION[_HIVE_SITE_COOKIE_."section_admin_change"] = "*"; }
				$object["eventbox"]->warning($object["lang"]->translate("be_list_h_exec_chmg"));
			} else { $object["eventbox"]->error($object["lang"]->translate("hive_login_msg_csrf")); }		 
		}	
		
		// Delete Item Operations
		$output1 =  $tbl->exec_delete();
		if($output1 == "deleted") {  $object["eventbox"]->warning($object["lang"]->translate("be_list_exec_idel"));  
									$object["log"]->info("[DELETION] [TABLE] ".$table_general." [ID] ".@$_POST["x_class_table_exec_deletetable"]." [UID] ".$object["user"]->user_id."", "logging_curl");}
		if($output1 == "csrf") { $object["eventbox"]->error($object["lang"]->translate("hive_login_msg_csrf"));}

		////////////////////////////////////////////////////////////////
		// Get Table Values
		////////////////////////////////////////////////////////////////
		if(@$_GET["op"] == "more") { $limit = ""; $limit_desc = " [".$object["lang"]->translate("be_limit_before"). " *]"; } else { $limit = 1500; $limit_desc = " [".$object["lang"]->translate("be_limit_before")." ".$limit."]"; }
		if(is_numeric($limit)) { $limitx = "LIMIT ".$limit; } else { $limitx = ""; }
		if($_SESSION[_HIVE_SITE_COOKIE_."section_admin_change"] == '*') { 
			$value_array = $object["mysql"]->select("SELECT ".$trts_general." FROM ".$table_general." ORDER BY id DESC ".$limitx."", true);
		} else {
			$b[0]["value"] = $_SESSION[_HIVE_SITE_COOKIE_."section_admin_change"];
			$value_array = $object["mysql"]->select("SELECT ".$trts_general." FROM ".$table_general." WHERE section = ? ORDER BY id DESC ".$limitx."", true, $b); 
        }
		$tmpx = $_SESSION[_HIVE_SITE_COOKIE_."section_admin_change"];
		if(is_array($value_array)) {
			foreach($value_array as $key => $value) {
				if($tmpx == $value["section"]) {
				} elseif($tmpx == "*") { }
				else  { unset($value_array[$key]); continue; }
				$value_array[$key]["creation"] = @htmlspecialchars($value_array[$key]["creation"] ?? '');
				$value_array[$key]["url"] = @htmlspecialchars($value_array[$key]["url"] ?? '');
				$value_array[$key]["request"] = @htmlspecialchars($value_array[$key]["request"] ?? '');
				$value_array[$key]["section"] = @htmlspecialchars($value_array[$key]["section"] ?? '');
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
				echo '<button onclick="" name="hive_submit_flush_table" type="submit" class="flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-primary-bugfish border border-transparent xfpe_floatleft xfpe_marginbottom5px xfpe_marginright10px rounded-lg active:bg-primary-bugfish hover:bg-primary-bugfish focus:outline-none focus:shadow-primary-bugfish force-white-focus " style="background: red;color: white;"><span>'.$object["lang"]->translate("be_list_h_btn_flush").'</span><i class="bx bx bx-trash xfpe_marginleft10px"></i></button>';
				echo "<input type='hidden' name='hive_submit_flush_table_token' value='".$object["csrf"]->get()."'>";
				echo "<input type='hidden' name='hive_submit_flush_table' value='1'>";
			echo "</form>";
			echo "<form method='post' action='./?"._HIVE_URL_GET_[0]."="._HIVE_URL_CUR_[0]."&"._HIVE_URL_GET_[1]."="._HIVE_URL_CUR_[1]."'>";
				echo "<input type='hidden' name='hive_submit_chmc' value='1'>";
				if(@$_GET["op"] == "more") { 
					echo '<button onclick="window.location.href = \''._HIVE_URL_REL_.'/?'._HIVE_URL_GET_[0].'='._HIVE_URL_CUR_[0].'&'._HIVE_URL_GET_[1].'='._HIVE_URL_CUR_[1].'&op=less\';" type="button" class="flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-primary-bugfish border border-transparent xfpe_floatleft xfpe_marginbottom5px xfpe_marginright10px rounded-lg active:bg-primary-bugfish hover:bg-primary-bugfish focus:outline-none focus:shadow-primary-bugfish force-white-focus " style="background: blue;color: white;"><span>'.$object["lang"]->translate("be_list_h_btn_less").'</span><i class="bx bx bx-list-ul xfpe_marginleft10px"></i></button>';
				} else {
					echo '<button onclick="window.location.href = \''._HIVE_URL_REL_.'/?'._HIVE_URL_GET_[0].'='._HIVE_URL_CUR_[0].'&'._HIVE_URL_GET_[1].'='._HIVE_URL_CUR_[1].'&op=more\';" type="button" class="flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-primary-bugfish border border-transparent xfpe_floatleft xfpe_marginbottom5px xfpe_marginright10px rounded-lg active:bg-primary-bugfish hover:bg-primary-bugfish focus:outline-none focus:shadow-primary-bugfish force-white-focus " style="background: blue;color: white;"><span>'.$object["lang"]->translate("be_list_h_btn_more").'</span><i class="bx bx bx-list-ul xfpe_marginleft10px"></i></button>';
				}
				echo "<input type='hidden' name='hive_submit_flush_table_token' value='".$object["csrf"]->get()."'>";
				echo '<select name="hive_submit_chmcxg" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-primary-bugfish dark:focus:shadow-outline-gray xfpe_floatleft xfpe_marginbottom5px xfpe_marginright10px">';
					echo '<option value="*">*</option>';
					foreach(_HIVE_MODE_ARRAY_ as $key => $value) {
						if($_SESSION[_HIVE_SITE_COOKIE_."section_admin_change"] == $value) { $cmtp = "selected"; } else { $cmtp = ""; }
						echo '<option value="'.htmlentities($value ?? '').'" '.$cmtp.'>'.htmlspecialchars($value ?? '').'</option>';
					}
				echo '</select>';
					echo '<button onclick="" name="hive_submit_chmc" type="submit" class="flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-primary-bugfish border border-transparent xfpe_floatleft xfpe_marginbottom5px xfpe_marginright10px rounded-lg active:bg-primary-bugfish hover:bg-primary-bugfish focus:outline-none focus:shadow-primary-bugfish force-white-focus " style="background: blue;color: white;"><span>'.$object["lang"]->translate("be_list_h_btn_chm").'</span><i class="bx bx bx-trash xfpe_marginleft10px"></i></button>';
			echo "</form>";
		hive__windmill_box_end();
		
		// Display the Table!
		hive__windmill_box_start($item_general. " [".$object["lang"]->translate("be_list_h_module")." ".$_SESSION[_HIVE_SITE_COOKIE_."section_admin_change"]."]".$limit_desc, "min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800 xfpe_margintop15px");
		$tbl->spawn_table($table_title, $value_array, false, $object["lang"]->translate("be_list_h_delete"), false, $object["lang"]->translate("be_list_h_delete"), "display");
		hive__windmill_box_end();
	}