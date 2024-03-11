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
		$table_general = _TABLE_USER_;
		if(@$_GET["add"] == "true") { 
			////////////////////////////////////////////////////////////////
			// View Creating
			////////////////////////////////////////////////////////////////		
			if(@$_POST["form_add_user"] == "add") {
				if($object["csrf"]->check($_POST["form_csrf"])) {
					if(@trim(@$_POST["form_user_mail"] ?? '') != "") {
						// Only Activation with Pre-Set Password by Administrator
						if(@$_POST["form_user_act"] == "act") { 
							if($object["user"]->passfilter_check(@$_POST["form_user_pass"])) { 
								$result = $object["user"]->addUser(@trim(@$_POST["form_user_mail"]), @trim(@$_POST["form_user_mail"]), @$_POST["form_user_pass"], 1, 0);		
								if($result) {
									$object["log"]->info("[CREATE] [TABLE] ".$table_general." [ID] ".@$object["mysql"]->insert_id()." [UID] ".$object["user"]->user_id."", "user_user");
									$addid = $object["mysql"]->insert_id();
									$result = $object["user"]->activation_request_id($addid);		
									if($result == 1) { 
										$object["mail_template"]->set_template("_ACTIVATE_");	
										$object["mail_template"]->add_substitution("_ACTION_URL_",  _HIVE_SITE_URL_ . "/_core/_action/user_activate.php?act_token=" . $object["user"]->mail_ref_token . "&act_user=" . $object["user"]->mail_ref_user . ""); 
										$title = $object["mail_template"]->get_subject(true);
										$content = $object["mail_template"]->get_content(true);					
										if($object["mail"]->send($object["user"]->mail_ref_receiver, $object["user"]->mail_ref_receiver, $title, $content)) {
											$object["eventbox"]->ok($object["lang"]->translate("be_usr_ad_hmaok"));
											$object["eventbox"]->skip();
											echo "<script>window.location.href=window.location.href+\"&add=done\";</script>";
										} else {
											$object["eventbox"]->error($object["lang"]->translate("be_usr_ad_errgm"));
										} 
									} else { 
										$object["eventbox"]->error($object["lang"]->translate("be_usr_ad_errg"));
									}
								} else { $object["eventbox"]->error($object["lang"]->translate("be_usr_ad_hmailex")); }
							} else {
								$object["eventbox"]->error($object["lang"]->translate("be_usr_ad_hpasserem"));
							}						
						}

						// Activation with User to set his own password at Activation
						if(@$_POST["form_user_act"] == "rec") { 
							$result = $object["user"]->addUser(@trim(@$_POST["form_user_mail"]), @trim(@$_POST["form_user_mail"]), mt_rand(100000, 9999999), 1, 0);		
							if($result) {
								$addid = $object["mysql"]->insert_id();
								$result = $object["user"]->recover_request_id($addid);			
								$object["log"]->info("[CREATE] [TABLE] ".$table_general." [ID] ".@$object["mysql"]->insert_id()." [UID] ".$object["user"]->user_id."", "user_user");
								if ($result == 1) {
									$object["mail_template"]->set_template("_RECOVER_");	
									$object["mail_template"]->add_substitution("_ACTION_URL_", _HIVE_SITE_URL_ . "/_core/_action/user_recover.php?rec_token=" . $object["user"]->mail_ref_token . "&rec_user=" . $object["user"]->mail_ref_user . ""); 
									$title = $object["mail_template"]->get_subject(true);
									$content = $object["mail_template"]->get_content(true);	
									if($object["mail"]->send($object["user"]->mail_ref_receiver, $object["user"]->mail_ref_receiver, $title, $content)) {
										$object["eventbox"]->ok($object["lang"]->translate("be_usr_ad_hmaok"));
										$object["eventbox"]->skip();
										echo "<script>window.location.href=window.location.href+\"&add=done\";</script>";
									} else {
										$object["eventbox"]->error($object["lang"]->translate("be_usr_ad_errgm"));
									} 
								} else { $object["eventbox"]->error($object["lang"]->translate("be_usr_ad_errg")); }
							} else { $object["eventbox"]->error($object["lang"]->translate("be_usr_ad_hmailex")); }
						}						 
						
						// No Activation Procedure - Directly Activated
						if(@$_POST["form_user_act"] == "ok") { 
							if($object["user"]->passfilter_check(@$_POST["form_user_pass"])) { 
								$result = $object["user"]->addUser(@trim(@$_POST["form_user_mail"]), @trim(@$_POST["form_user_mail"]), @$_POST["form_user_pass"], 1, 1);	
								$object["log"]->info("[CREATE] [TABLE] ".$table_general." [ID] ".@$object["mysql"]->insert_id()." [UID] ".$object["user"]->user_id."", "user_user");
								if($result == 1) {
									$object["eventbox"]->ok($object["lang"]->translate("be_usr_ad_hmaok"));
									$object["eventbox"]->skip();
									echo "<script>window.location.href=window.location.href+\"&add=done\";</script>";
								} else { $object["eventbox"]->error($object["lang"]->translate("be_usr_ad_hmailex")); }
							} else {
								$object["eventbox"]->error($object["lang"]->translate("be_usr_ad_hpasserem"));
							}
						}						
					} else { $object["eventbox"]->error($object["lang"]->translate("be_usr_ad_herem")); }
				} else { $object["eventbox"]->error($object["lang"]->translate("hive_login_msg_csrf")); }
			}

			// Div with Top Margin for Elements!
			echo "<div class='xfpe_margintop15px'></div>";
		
			// Display the Operations Bar!
			hive__windmill_box_start($object["lang"]->translate("be_user_area_create"), "min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800 dark:text-gray-200"); ?>
			<form method="post" action="<?php echo _HIVE_URL_REL_."/?"._HIVE_URL_GET_[0]."="._HIVE_URL_CUR_[0]."&"._HIVE_URL_GET_[1]."="._HIVE_URL_CUR_[1]."&add=true"; ?>">
				<label class="block text-sm">
					<span class="text-gray-700 dark:text-gray-400"><?php echo $object["lang"]->translate("be_usr_ad_hmail"); ?></span>
					<input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-primary-bugfish dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="<?php echo $object["lang"]->translate("be_usr_ad_hmail"); ?>" name="form_user_mail">
				</label><br />
				<label class="block text-sm">
					<span class="text-gray-700 dark:text-gray-400"><?php echo $object["lang"]->translate("be_usr_ad_hpass"); ?></span>
					<input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-primary-bugfish dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="<?php echo $object["lang"]->translate("be_usr_ad_hpass"); ?>" type="password" name="form_user_pass">
				</label>
				 <br />
				<?php echo hive__windmill_alert_info($object["lang"]->translate("be_noti_user_crea")); ?>

				<div class="mt-4 text-sm">
					<span class="text-gray-700 dark:text-gray-400">
					  <b><?php echo $object["lang"]->translate("be_usr_ad_h"); ?></b> 
					</span>
					<div class="mt-2">
					  <label class="inline-flex items-center text-gray-600 dark:text-gray-400">
						<input type="radio" class="text-bugfish-primary-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-primary-bugfish dark:focus:shadow-outline-gray" name="form_user_act" value="rec" checked>
						<span class="ml-2"><?php echo $object["lang"]->translate("be_usr_ad_rec"); ?></span>
					  </label>
					</div>
					<div class="mt-2">
					  <label class="inline-flex items-center text-gray-600 dark:text-gray-400">
						<input type="radio" class="text-bugfish-primary-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-primary-bugfish dark:focus:shadow-outline-gray" name="form_user_act" value="act">
						<span class="ml-2"><?php echo $object["lang"]->translate("be_usr_ad_act"); ?></span>
					  </label>
					</div>
					<div class="mt-2">
					  <label class="inline-flex items-center text-gray-600 dark:text-gray-400">
						<input type="radio" class="text-bugfish-primary-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-primary-bugfish dark:focus:shadow-outline-gray" name="form_user_act" value="ok">
						<span class="ml-2"><?php echo $object["lang"]->translate("be_usr_ad_ok"); ?></span>
					  </label>
					</div>
			  </div>		
			<br />				
			
			<?php echo hive__windmill_button_icright($object["lang"]->translate("be_user_area_create"), "bx bx-plus", "lime", "black", "submit");
			echo "<input type='hidden' name='form_csrf' value='".$object["csrf"]->get()."'>";
			echo "<input type='hidden' name='form_add_user' value='add'>";
			echo "</form>";
			hive__windmill_box_end();	
		} else {
			////////////////////////////////////////////////////////////////
			// View the List
			////////////////////////////////////////////////////////////////
			
			////////////////////////////////////////////////////////////////
			// Variables
			////////////////////////////////////////////////////////////////
			$title_general 	= $object["lang"]->translate("be_user_area_name"); 
			$trts_general 	= "id as gid, user_mail, user_confirmed, user_disabled, user_blocked, id";
			$item_general 	= $object["lang"]->translate("be_user_area_name");
			$text_general 	= $object["lang"]->translate("be_exp_usrlst");
			$table_general 	= _TABLE_USER_;
			$table_title   	= array(array("name" => $object["lang"]->translate("be_se_key_h2")), 
									array("name" => $object["lang"]->translate("be_user_area_mail")));
			
			// Create Table Object
			$tbl = new x_class_table($object["mysql"], $table_general, "table");
			
			// Table Edit Arrays and Create
			$tbl->config_rel_url("./?"._HIVE_URL_GET_[0]."="._HIVE_URL_CUR_[0]."&"._HIVE_URL_GET_[1]."="._HIVE_URL_CUR_[1]."");		
			
		
			////////////////////////////////////////////////////////////////
			// Get Table Values
			////////////////////////////////////////////////////////////////
			$value_array = $object["mysql"]->select("SELECT ".$trts_general." FROM ".$table_general."", true);
			if(is_array($value_array)) {
				foreach($value_array as $key => $value) {
					$value_array[$key]["user_mail"] = "<a href='"."./?"._HIVE_URL_GET_[0]."=user&"._HIVE_URL_GET_[1]."=profile&id=".$value_array[$key]["id"].""."'>".@htmlspecialchars($value_array[$key]["user_mail"])."</a>";
					$value_array[$key]["gid"] = "<a href='"."./?"._HIVE_URL_GET_[0]."=user&"._HIVE_URL_GET_[1]."=profile&id=".$value_array[$key]["id"].""."'>".@htmlspecialchars($value_array[$key]["id"])."</a>";
					if($value_array[$key]["user_confirmed"] == 1) { $tmp = "<small><font color='green'>".$object["lang"]->translate("be_yes")."</font></small>"; } else { $tmp = "<small><font color='red'>".$object["lang"]->translate("be_no")."</font></small>"; }
					$value_array[$key]["user_mail"] .= "<br /><small>".$object["lang"]->translate("be_usrl_confirmed").":</small> ".$tmp;
					if($value_array[$key]["user_blocked"] == 0) { $tmp = "<small><font color='green'>".$object["lang"]->translate("be_no")."</font></small>"; } else { $tmp = "<small><font color='red'>".$object["lang"]->translate("be_yes")."</font></small>"; }
					$value_array[$key]["user_mail"] .= "<br /><small>".$object["lang"]->translate("be_usrl_blocked").":</small> ".$tmp;
					
					
					if($value_array[$key]["user_disabled"] == 1) { $tmp = "<small><font color='red'>".$object["lang"]->translate("be_yes")."</font></small>"; } else { $tmp = "<small><font color='green'>".$object["lang"]->translate("be_no")."</font></small>"; }
					$value_array[$key]["user_mail"] .= "<br /><small>".$object["lang"]->translate("be_usrl_active").":</small> ".$tmp;
					unset($value_array[$key]["user_confirmed"]);
					unset($value_array[$key]["user_blocked"]);
					unset($value_array[$key]["user_disabled"]);
				}
			}

			// Div with Top Margin for Elements!
			echo "<div class='xfpe_margintop15px'></div>"; 
			
			// Display the Information Box!
			echo hive__windmill_alert_info($text_general);
			
			// Display the Operations Bar!
			hive__windmill_box_start($object["lang"]->translate("be_user_area_create"), "min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800 dark:text-gray-200");
					echo hive__windmill_button_icright($object["lang"]->translate("be_user_area_create"), "bx bx-plus", "lime", "black", "button", "", "", "window.location.href=window.location.href+'&add=true';");
			hive__windmill_box_end();
			
			// Display the Table!
			hive__windmill_box_start($title_general." ".$object["lang"]->translate("be_list_starthead"), "min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800 xfpe_margintop15px");
			$tbl->spawn_table($table_title, $value_array, false, false, false, "Action", "display");
			hive__windmill_box_end();
		}
	}