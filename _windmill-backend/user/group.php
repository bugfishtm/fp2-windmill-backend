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
		$table_general = _TABLE_USER_GROUP_;
		if(is_numeric(@$_GET["id"])) {
				
			////////////////////////////////////////////////////////////////
			// View Editing
			////////////////////////////////////////////////////////////////				
			
			// Edit Operation
			if(is_numeric(@$_POST["form_id_group"])) {
				if($object["csrf"]->check($_POST["form_csrf"])) {
					$bind[0]["value"] = @$_POST["form_group_name"];
					$bind[0]["type"] = "s";
					$object["mysql"]->query("UPDATE "._TABLE_USER_GROUP_." SET group_name = ? WHERE id = '".$_POST["form_id_group"]."'", $bind);
					$bind[0]["value"] = @$_POST["form_group_descr"];
					$bind[0]["type"] = "s";
					$object["mysql"]->query("UPDATE "._TABLE_USER_GROUP_." SET group_description = ? WHERE id = '".$_POST["form_id_group"]."'", $bind);
					
					// Add Rights
					$object["perm_group"]->clear_perms($_POST["form_id_group"]);
					if(is_array(@$_POST["multiselectsortable_value_right"])) {
						foreach($_POST["multiselectsortable_value_right"] AS $key => $value) {
							$isin = false;
							if(is_array($object["set"]["permission"])){
								foreach($object["set"]["permission"] AS $keyx => $valuex) {
									if($valuex[0] == $value) { $isin = true; }
								}
							}								
							if($isin) {
								$object["perm_group"]->add_perm($_POST["form_id_group"], $value);
							}
						}
					}					
					
					$object["log"]->info("[CHANGE] [TABLE] ".$table_general." [ID] ".$_POST["form_id_group"]." [UID] ".$object["user"]->user_id."", "user_groups");
					$object["eventbox"]->warning($object["lang"]->translate("be_list_exec_iedit"));
				} else { $object["eventbox"]->error($object["lang"]->translate("hive_login_msg_csrf")); }
			}
			
			// Delete Operation
			if(is_numeric(@$_POST["form_id_dgroup"]) AND is_numeric(@$_GET["id"])) {
				if($object["csrf"]->check($_POST["form_csrf"])) {			
				if(@$_GET["confirm"] != "confirmed") { 
				?>
				<script>
					Swal.fire({
					  title: "<?php echo $object["lang"]->translate("be_list_g_flush"); ?>",
					  html: "<?php echo $object["lang"]->translate("be_list_g_flush_rly"); ?><form method='post' action='<?php echo "./?"._HIVE_URL_GET_[0]."="._HIVE_URL_CUR_[0]."&"._HIVE_URL_GET_[1]."="._HIVE_URL_CUR_[1]."&id=".$_GET["id"]."&confirm=confirmed"; ?>'><input type='hidden' name='form_csrf' value='<?php echo $object["csrf"]->get(); ?>'><input type='hidden' name='form_id_dgroup' value='<?php echo @$_POST["form_id_dgroup"]; ?>'><input type='submit' class=\"flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-primary-bugfish border border-transparent xfpe_floatleft  xfpe_cursorpointer xfpe_marginbottom5px xfpe_marginright10px rounded-lg active:bg-primary-bugfish hover:bg-primary-bugfish focus:outline-none focus:shadow-primary-bugfish force-white-focus \" style=\"background: red;color: white;\" value='<?php echo htmlentities($object["lang"]->translate("be_yes") ?? ''); ?>'></form>",
					  showCancelButton: false,
					  showCloseButton: true,
					  showConfirmButton: false
					});
				</script>
				<?php 
			} else { 		
					$object["mysql"]->query("DELETE FROM "._TABLE_USER_GROUP_." WHERE id = '".@$_POST["form_id_dgroup"]."'");
					$object["mysql"]->query("DELETE FROM "._TABLE_USER_GROUP_LINK_." WHERE fk_group = '".@$_POST["form_id_dgroup"]."'");
					$object["mysql"]->query("DELETE FROM "._TABLE_USER_GROUP_PERM_." WHERE ref = '".@$_POST["form_id_dgroup"]."'");
					$object["log"]->info("[DELETION] [TABLE] ".$table_general." [ID] ".@$_GET["id"]." [UID] ".$object["user"]->user_id."", "user_groups");
					$object["eventbox"]->ok($object["lang"]->translate("be_list_exec_idel"));
			}
				} else { $object["eventbox"]->error($object["lang"]->translate("hive_login_msg_csrf")); }
			}

			
			$ar = $object["mysql"]->select("SELECT * FROM "._TABLE_USER_GROUP_." WHERE id = '".$_GET["id"]."'", false);
			if(is_array($ar)) { 
				// Div with Top Margin for Elements!
				echo "<div class='xfpe_margintop15px'></div>";
		


				// Display the Operations Bar!
				hive__windmill_box_start($object["lang"]->translate("be_group_egroup"), "min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800 dark:text-gray-200"); ?>
				<form method="post" action="<?php echo _HIVE_URL_REL_."/?"._HIVE_URL_GET_[0]."="._HIVE_URL_CUR_[0]."&"._HIVE_URL_GET_[1]."="._HIVE_URL_CUR_[1]."&id=".$_GET["id"].""; ?>">
					
					<label class="block text-sm">
						<span class="text-gray-700 dark:text-gray-400"><?php echo $object["lang"]->translate("be_se_gr_id2"); ?></span>
						<input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-primary-bugfish dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="<?php echo $object["lang"]->translate("be_se_gr_id2"); ?>" value="<?php echo htmlentities($ar["group_name"] ?? ''); ?>" name="form_group_name">
					</label>
				
					<label class="block mt-4 text-sm">
						<span class="text-gray-700 dark:text-gray-400"><?php echo $object["lang"]->translate("be_se_gr_id3"); ?></span>
						<textarea class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-primary-bugfish dark:focus:shadow-outline-gray" rows="3" placeholder="<?php echo $object["lang"]->translate("be_se_gr_id3"); ?>" name="form_group_descr"><?php echo htmlspecialchars($ar["group_description"] ?? ''); ?></textarea>
					</label>

					<label class="block mt-4 text-sm">
						<span class="text-gray-700 dark:text-gray-400"><?php echo $object["lang"]->translate("b_permission"); ?></span><br />
					<select class="multiselectsortable_value_right" id="multiselectsortable_value_right" name="multiselectsortable_value_right" multiple><?php
						if(is_array($ar)) {
							if(is_array($object["set"]["permission"])) {
								$curperms = $object["mysql"]->select("SELECT * FROM "._TABLE_USER_GROUP_PERM_." WHERE ref = ".$ar["id"]."", false);  
								if(is_array($curperms)) { $curperms = unserialize($curperms["content"]); }
								if(is_array($curperms)) {  
									foreach($curperms as $key => $value) {
										$descr = "";
										$isin = false;
										if(is_array($object["set"]["permission"])) {
											foreach($object["set"]["permission"] as $keyx => $valuex) {
												if($valuex[0] == $value) { $isin = true; $descr = $valuex[2]; $tt = $valuex[1]; }
											}		
										}												
										if($isin) { echo '<option value="'.htmlentities($value ?? '').'" selected><b>'.htmlspecialchars($tt ?? '').'</b> - '.htmlspecialchars($descr ?? '').'</option>'; }
									}	
									foreach($object["set"]["permission"] as $key => $value) {
										$used = false;
										if(is_array($curperms)) {
											foreach($curperms as $keyx => $valuex) {
												if($valuex == $value[0]) { $used = true; }
											}		
										}
										if(!$used) { echo '<option value="'.htmlentities($value[0] ?? '').'"><b>'.htmlspecialchars($value[1] ?? '').'</b> - '.htmlspecialchars($value[2] ?? '').'</option>'; }
									}									
								} else {
									if(is_array($object["set"]["permission"])) {
										foreach($object["set"]["permission"] as $key => $value) {
											echo '<option value="'.htmlentities($value[0] ?? '').'"><b>'.htmlspecialchars($value[1] ?? '').'</b> - '.htmlspecialchars($value[2] ?? '').'</option>';
										}
									}
								}								
							}	else { 
								if(is_array($object["set"]["permission"])) {
									foreach($object["set"]["permission"] as $key => $value) {
										echo '<option value="'.htmlentities($value[0] ?? '').'"><b>'.htmlspecialchars($value[1] ?? '').'</b> - '.htmlspecialchars($value[2] ?? '').'</option>';
									}
								}
							}								
						} else { 
							if(is_array($object["set"]["permission"])) {
								foreach($object["set"]["permission"] as $key => $value) {
									echo '<option value="'.htmlentities($value[0] ?? '').'"><b>'.htmlspecialchars($value[1] ?? '').'</b> - '.htmlspecialchars($value[2] ?? '').'</option>';
								}
							}
						}								
					?></select>	
					</label>
					<script>				  
						jQuery(function($){$('.multiselectsortable_value_right').bugfish_sortselect({rid:56,selectable:{
                title   :'<b><?php echo $object["lang"]->translate("b_inactive"); ?></b>' },
            selection :{
                title   :'<b><?php echo $object["lang"]->translate("b_active"); ?></b>'
            },});})							  
					</script>	
							
					<br />
					<?php 	echo hive__windmill_button_icright($object["lang"]->translate("be_group_egroup"), "bx bx-edit", "yellow", "black", "submit");
				echo "<input type='hidden' name='form_csrf' value='".$object["csrf"]->get()."'>";
				echo "<input type='hidden' name='form_id_group' value='".$_GET["id"]."'>";
				echo "</form>";
				hive__windmill_box_end();	
				
	
				// Display the Operations Bar!
				hive__windmill_box_start($object["lang"]->translate("b_g_delete"), "min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800 dark:text-gray-200 xfpe_margintop15px");	
				?> <form method="post" action="<?php echo _HIVE_URL_REL_."/?"._HIVE_URL_GET_[0]."="._HIVE_URL_CUR_[0]."&"._HIVE_URL_GET_[1]."="._HIVE_URL_CUR_[1]."&id=".$_GET["id"].""; ?>"><?php
				echo hive__windmill_button_icright($object["lang"]->translate("b_g_delete"), "bx bx-trash", "red", "white", "submit"); 
				echo "<input type='hidden' name='form_csrf' value='".$object["csrf"]->get()."'>";
				echo "<input type='hidden' name='form_id_dgroup' value='".$_GET["id"]."'>";
				echo "</form>";
				hive__windmill_box_end();	
				
				hive__windmill_box_start($object["lang"]->translate("b_g_memerlisth"), "min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800 dark:text-gray-200 xfpe_margintop15px");		
				$ar = $object["mysql"]->select("SELECT fk_user FROM "._TABLE_USER_GROUP_LINK_." WHERE fk_group = '".$_GET["id"]."'", true);
				if(is_array($ar)) {
					foreach($ar as $key => $value) {
						$x = @$object["user"]->get($ar[$key]["fk_user"]);
						if(!is_array($x)) { continue; }
						$ar[$key]["fk_user"] = "<a href='"."./?"._HIVE_URL_GET_[0]."=user&"._HIVE_URL_GET_[1]."=profile&id=".$x["id"].""."'>".$x["id"]."</a>";
						$ar[$key]["fk_user_mail"] = "<a href='"."./?"._HIVE_URL_GET_[0]."=user&"._HIVE_URL_GET_[1]."=profile&id=".$x["id"].""."'>".@htmlspecialchars(@$x["user_mail"])."</a>";
					}

					// Create Table Object
					$tbl = new x_class_table($object["mysql"], _TABLE_USER_GROUP_LINK_, "table");	
					$tbl->spawn_table(array(array("name" => $object["lang"]->translate("b_g_memerlisth1")),
									array("name" => $object["lang"]->translate("b_g_memerlisth2"))), $ar, false, false, false, false, "display");	
				} else { echo hive__windmill_alert_warning($object["lang"]->translate("b_g_nomember"));}
				hive__windmill_box_end();
			} else {
				// Div with Top Margin for Elements!
				echo "<div class='xfpe_margintop15px'></div>";
				// Display the Information Box!
				echo hive__windmill_alert_warning($object["lang"]->translate("b_g_noexist"));  
			}
		} else {
			////////////////////////////////////////////////////////////////
			// View the List
			////////////////////////////////////////////////////////////////
			
			////////////////////////////////////////////////////////////////
			// Variables
			////////////////////////////////////////////////////////////////
			$title_general 	= $object["lang"]->translate("be_se_gr_hti");
			$trts_general 	= "id as gid, group_name, group_description, id";
			$item_general 	= $object["lang"]->translate("be_se_gr_hti");
			$text_general 	= $object["lang"]->translate("be_exp_grp_l"); 
			$table_general 	= _TABLE_USER_GROUP_;
			$table_title   	= array(array("name" => $object["lang"]->translate("be_se_gr_id1")),
									array("name" => $object["lang"]->translate("be_se_gr_id2")),
									array("name" => $object["lang"]->translate("be_se_gr_id3")));
			
			// Create Table Object
			$tbl = new x_class_table($object["mysql"], $table_general, "table");
			
			// Table Edit Arrays and Create
			$tbl->config_rel_url("./?"._HIVE_URL_GET_[0]."="._HIVE_URL_CUR_[0]."&"._HIVE_URL_GET_[1]."="._HIVE_URL_CUR_[1]."");		
			$create_ar  = array();
			$create_ar[0]["field_name"] 	= "group_name";
			$create_ar[0]["field_ph"] 		= $object["lang"]->translate("be_se_gr_id2");
			$create_ar[0]["field_label"] 	= $object["lang"]->translate("be_se_gr_id2");
			$create_ar[0]["field_type"] 	= "string";
			$create_ar[0]["field_classes"] 	= "block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input";
			$create_ar[1]["field_name"] 	= "group_description";
			$create_ar[1]["field_ph"] 		= $object["lang"]->translate("be_se_gr_id3");
			$create_ar[1]["field_label"] 	= $object["lang"]->translate("be_se_gr_id3");
			$create_ar[1]["field_type"] 	= "text";
			$create_ar[1]["field_classes"] 	= "block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray";
			$tbl->config_array($create_ar, false);	
			
			// Delete Item Operations
			//$output1 =  $tbl->exec_delete();
			//if($output1 == "deleted") { $object["eventbox"]->warning("The item has been deleted!"); 
			//							$object["log"]->info("Item '".$item_general."' with ID: ".@$_POST["x_class_table_exec_deletetable"]." has been deleted by UID: ".$object["user"]->user_id."");}
			//if($output1 == "csrf") { $object["eventbox"]->error("Form expired! Please try again!");}

			// Delete Operations
			$output1 =  $tbl->exec_create();
			if($output1 == "created") { $object["eventbox"]->warning($object["lang"]->translate("be_str_item_created")); 
										$object["log"]->info("[CREATE] [TABLE] ".$table_general." [ID] ".@$object["mysql"]->insert_id()." [UID] ".$object["user"]->user_id."", "user_groups");}
			if($output1 == "csrf") { $object["eventbox"]->error($object["lang"]->translate("hive_login_msg_csrf"));}
		
			////////////////////////////////////////////////////////////////
			// Get Table Values
			////////////////////////////////////////////////////////////////
			$value_array = $object["mysql"]->select("SELECT ".$trts_general." FROM ".$table_general."", true);
			if(is_array($value_array)) {
				foreach($value_array as $key => $value) {
					$value_array[$key]["group_name"] = "<a href='"."./?"._HIVE_URL_GET_[0]."=user&"._HIVE_URL_GET_[1]."=group&id=".$value_array[$key]["gid"]."'>".@htmlspecialchars($value_array[$key]["group_name"])."</a>";
					$value_array[$key]["group_description"] = "<a href='./?"._HIVE_URL_GET_[0]."=user&"._HIVE_URL_GET_[1]."=group&id=".$value_array[$key]["gid"]."'>".@htmlspecialchars($value_array[$key]["group_description"])."</a>";
					$value_array[$key]["gid"] = "<a href='"."./?"._HIVE_URL_GET_[0]."=user&"._HIVE_URL_GET_[1]."=group&id=".$value_array[$key]["gid"].""."'>".@htmlspecialchars($value_array[$key]["gid"])."</a>";
				}
			}

			// Div with Top Margin for Elements!
			echo "<div class='xfpe_margintop15px'></div>";
			echo '<style>.x_class_table_label { color: grey;}</style>';
			// Display the Information Box!
			echo hive__windmill_alert_info($text_general); 

			hive__windmill_box_start($object["lang"]->translate("be_se_gr_add"), "min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800");
			$tbl->spawn_create($object["lang"]->translate("be_se_gr_add"), "flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-primary-bugfish border border-transparent rounded-lg 	active:bg-primary-bugfish hover:bg-primary-bugfish focus:outline-none focus:shadow-primary-bugfish force-white-focus");
			hive__windmill_box_end();
			
			// Display the Table!
			hive__windmill_box_start($title_general." ".$object["lang"]->translate("be_list_starthead"), "min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800 xfpe_margintop15px");
			$tbl->spawn_table($table_title, $value_array, false, false, false, "Action", "display");
			hive__windmill_box_end();
		}
	}