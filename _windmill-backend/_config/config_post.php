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
	*/ if(!is_array($object)) { @http_response_code(404); Header("Location: ../"); exit(); }
	
	///////////////////////////////////////////////////////////////////
	// Logging Submenue
	///////////////////////////////////////////////////////////////////
	$sub_logging = array();
	$sub_logging[0]["nav_title"] = $object["lang"]->translate("be_mysql"); 
	$sub_logging[1]["nav_title"] = $object["lang"]->translate("be_curl"); 
	$sub_logging[2]["nav_title"] = $object["lang"]->translate("be_visits"); 
	$sub_logging[3]["nav_title"] = $object["lang"]->translate("be_blacklist"); 
	$sub_logging[4]["nav_title"] = $object["lang"]->translate("be_referer"); 
	$sub_logging[5]["nav_title"] = $object["lang"]->translate("be_benchmark"); 
	$sub_logging[6]["nav_title"] = $object["lang"]->translate("be_javascript"); 
	$sub_logging[7]["nav_title"] = $object["lang"]->translate("be_mail"); 
	$sub_logging[8]["nav_title"] = $object["lang"]->translate("be_logging"); 
	$sub_logging[9]["nav_title"] = $object["lang"]->translate("be_cron"); 
	$sub_logging[0]["nav_sub"] = false;   
	$sub_logging[1]["nav_sub"] = false;	 
	$sub_logging[2]["nav_sub"] = false;	 
	$sub_logging[3]["nav_sub"] = false;	 
	$sub_logging[4]["nav_sub"] = false;	 
	$sub_logging[5]["nav_sub"] = false;	 
	$sub_logging[6]["nav_sub"] = false;	 
	$sub_logging[7]["nav_sub"] = false;	 
	$sub_logging[8]["nav_sub"] = false;	 
	$sub_logging[9]["nav_sub"] = false;	  
	$sub_logging[0]["nav_loc"] = hive_get_url_rel(array("logging", "mysql", false));
	$sub_logging[1]["nav_loc"] = hive_get_url_rel(array("logging", "curl", false));  
	$sub_logging[2]["nav_loc"] = hive_get_url_rel(array("logging", "visits", false));  
	$sub_logging[3]["nav_loc"] = hive_get_url_rel(array("logging", "blacklist", false));  
	$sub_logging[4]["nav_loc"] = hive_get_url_rel(array("logging", "referer", false));  
	$sub_logging[5]["nav_loc"] = hive_get_url_rel(array("logging", "benchmark", false));  
	$sub_logging[6]["nav_loc"] = hive_get_url_rel(array("logging", "js", false));  
	$sub_logging[7]["nav_loc"] = hive_get_url_rel(array("logging", "mail", false));  
	$sub_logging[8]["nav_loc"] = hive_get_url_rel(array("logging", "logging", false));  
	$sub_logging[9]["nav_loc"] = hive_get_url_rel(array("logging", "cron", false));  
	$sub_logging[0]["nav_img"] = ""; 
	$sub_logging[1]["nav_img"] = ""; 
	$sub_logging[2]["nav_img"] = ""; 
	$sub_logging[3]["nav_img"] = ""; 
	$sub_logging[4]["nav_img"] = ""; 
	$sub_logging[5]["nav_img"] = ""; 
	$sub_logging[6]["nav_img"] = ""; 
	$sub_logging[7]["nav_img"] = ""; 
	$sub_logging[8]["nav_img"] = ""; 
	$sub_logging[9]["nav_img"] = ""; 
	$sub_logging[0]["nav_act"] = "mysql";
	$sub_logging[1]["nav_act"] = "curl";
	$sub_logging[2]["nav_act"] = "visits";
	$sub_logging[3]["nav_act"] = "blacklist";
	$sub_logging[4]["nav_act"] = "referer";
	$sub_logging[5]["nav_act"] = "benchmark";
	$sub_logging[6]["nav_act"] = "js";
	$sub_logging[7]["nav_act"] = "mail";
	$sub_logging[8]["nav_act"] = "logging";
	$sub_logging[9]["nav_act"] = "cron";
		
	///////////////////////////////////////////////////////////////////
	// Backend Submenue
	///////////////////////////////////////////////////////////////////
	$sub_system = array();
	$sub_system[0]["nav_title"] = $object["lang"]->translate("be_constants"); 
	$sub_system[1]["nav_title"] = $object["lang"]->translate("be_templates"); 
	$sub_system[2]["nav_title"] = $object["lang"]->translate("be_api"); 
	$sub_system[3]["nav_title"] = $object["lang"]->translate("be_about"); 
	$sub_system[0]["nav_sub"] = false;   
	$sub_system[1]["nav_sub"] = false;	 
	$sub_system[2]["nav_sub"] = false;	 
	$sub_system[3]["nav_sub"] = false;	 
	$sub_system[0]["nav_loc"] = hive_get_url_rel(array("system", "constants", false));
	$sub_system[1]["nav_loc"] = hive_get_url_rel(array("system", "mailtemplates", false));  
	$sub_system[2]["nav_loc"] = hive_get_url_rel(array("system", "apitoken", false));  
	$sub_system[3]["nav_loc"] = hive_get_url_rel(array("system", "about", false));  
	$sub_system[0]["nav_img"] = ""; 
	$sub_system[1]["nav_img"] = ""; 
	$sub_system[2]["nav_img"] = ""; 
	$sub_system[3]["nav_img"] = ""; 
	$sub_system[0]["nav_act"] = "constants";
	$sub_system[1]["nav_act"] = "mailtemplates";
	$sub_system[2]["nav_act"] = "apitoken";
	$sub_system[3]["nav_act"] = "about";
	
	///////////////////////////////////////////////////////////////////
	// User Submenue
	///////////////////////////////////////////////////////////////////
	$sub_user = array();
	$sub_user[0]["nav_title"] = $object["lang"]->translate("be_list"); 
	$sub_user[1]["nav_title"] = $object["lang"]->translate("be_group"); 
	$sub_user[2]["nav_title"] = $object["lang"]->translate("be_session"); 
	$sub_user[0]["nav_sub"] = false;   
	$sub_user[1]["nav_sub"] = false;	 
	$sub_user[2]["nav_sub"] = false;	  
	$sub_user[0]["nav_loc"] = hive_get_url_rel(array("user", "user", false));
	$sub_user[1]["nav_loc"] = hive_get_url_rel(array("user", "group", false));  
	$sub_user[2]["nav_loc"] = hive_get_url_rel(array("user", "session", false));  
	$sub_user[0]["nav_img"] = ""; 
	$sub_user[1]["nav_img"] = ""; 
	$sub_user[2]["nav_img"] = ""; 
	$sub_user[0]["nav_act"] = "user";
	$sub_user[1]["nav_act"] = "group";
	$sub_user[2]["nav_act"] = "session";
	
	///////////////////////////////////////////////////////////////////
	// Navigation Main Menue Settings
	///////////////////////////////////////////////////////////////////
	$object["nav"] = array();
	$object["nav"][0]["nav_title"] = $object["lang"]->translate("be_start");
	$object["nav"][2]["nav_title"] = $object["lang"]->translate("be_user");
	$object["nav"][3]["nav_title"] = $object["lang"]->translate("be_logging");
	$object["nav"][4]["nav_title"] = $object["lang"]->translate("be_system");
	$object["nav"][0]["nav_img"] = "bx bxs-dashboard";
	$object["nav"][2]["nav_img"] = "bx bx-user";
	$object["nav"][3]["nav_img"] = "bx bx-notepad";
	$object["nav"][4]["nav_img"] = "bx bx-cog";
	$object["nav"][0]["nav_sub"] = false;
	$object["nav"][2]["nav_sub"] = $sub_user;
	$object["nav"][3]["nav_sub"] = $sub_logging; 
	$object["nav"][4]["nav_sub"] = $sub_system;	
	$object["nav"][0]["nav_act"] = "start";
	$object["nav"][2]["nav_act"] = "user";
	$object["nav"][3]["nav_act"] = "logging";
	$object["nav"][4]["nav_act"] = "system";	
	$object["nav"][0]["nav_loc"] = hive_get_url_rel(array("start", false, false, false, false));
	$object["nav"][2]["nav_loc"] = false;
	$object["nav"][3]["nav_loc"] = false;
	$object["nav"][4]["nav_loc"] = false;
	
	///////////////////////////////////////////////////////////////////
	// Navigation Profile Menue Settings
	///////////////////////////////////////////////////////////////////
	$pfm = array();
	$pfm[0]["nav_title"] = $object["lang"]->translate("be_profile");
	$pfm[1]["nav_title"] = $object["lang"]->translate("be_switch");  
	$pfm[2]["nav_title"] = $object["lang"]->translate("be_logout");  
	$pfm[0]["nav_loc"] 	= hive_get_url_rel(array("user", "profile", false, false, false));
	$pfm[1]["nav_loc"] 	= hive_get_url_rel(array("user", "switch", false, false, false));
	$pfm[2]["nav_loc"] 	= hive_get_url_rel(array("user", "logout", false, false, false));
	$pfm[0]["nav_img"] = "bx bx-user";  # Box Icon Image Class
	$pfm[1]["nav_img"] = "bx bxs-left-top-arrow-circle"; # Box Icon Image Class
	$pfm[2]["nav_img"] = "bx bx-door-open"; # Box Icon Image Class	
		
	///////////////////////////////////////////////////////////////////
	// Navigation Language Menue Settings
	///////////////////////////////////////////////////////////////////
	$lang_ar = array();
	$lang_ar[0]["current_ident"] = _HIVE_LANG_;
	$lang_ar[0]["current_img"] = _HIVE_URL_REL_."/_core/_vendor/country-flags-icons/png/"._HIVE_LANG_.".png";
	$lang_ar[0]["ident"] = "en";
	$lang_ar[0]["img"] = _HIVE_URL_REL_."/_core/_vendor/country-flags-icons/png/en.png";
	$lang_ar[0]["name"] = "English";
	$lang_ar[1]["ident"] = "de";
	$lang_ar[1]["img"] = _HIVE_URL_REL_."/_core/_vendor/country-flags-icons/png/de.png";
	$lang_ar[1]["name"] = "Deutsch";
	$lang_ar[2]["ident"] = "es";
	$lang_ar[2]["img"] = _HIVE_URL_REL_."/_core/_vendor/country-flags-icons/png/es.png";
	$lang_ar[2]["name"] = "Espanol";
	$lang_ar[3]["ident"] = "ja";
	$lang_ar[3]["img"] = _HIVE_URL_REL_."/_core/_vendor/country-flags-icons/png/ja.png";
	$lang_ar[3]["name"] = "日本語";
	
	///////////////////////////////////////////////////////////////////
	// Default Mail Templates
	///////////////////////////////////////////////////////////////////
	$object["mail_template"]->setup("_RECOVER_", "Recover your Account", "You have requested a password reset for your account. <br />Click here: <a href='_ACTION_URL_'>Set a new password</a><br /><br />If the redirecting is not working you can past the url into your browser:<br />_ACTION_URL_", "be_mail_exp_recover", false);	 
	$object["mail_template"]->setup("_ACTIVATE_", "Activate your Account",  "You need to active your account to be able to login. <br />Click here: <a href='_ACTION_URL_'>Activate my Account</a><br /><br />If the redirecting is not working you can past the url into your browser:<br />_ACTION_URL_", "be_mail_exp_acti", false);
	$object["mail_template"]->setup("_MAIL_CHANGE_", "Activate your new mail", "You have changed the e-mail in your account.<br />In order to confirm your new e-mail, click on the url below. <br />Click here: <a href='_ACTION_URL_'>Activate new Mail</a><br /><br />If the redirecting is not working you can past the url into your browser:<br />_ACTION_URL_",  "be_mail_exp_mchange", false);	
	
	
	#####################################################################################
	## Permission Settings
	#####################################################################################	
		# Here you can add permissions which can than be setup in the administrator panel!
		$object["set"]["permission"] = array(
				array("admin_user", $object["lang"]->translate("be_cperm_user"), $object["lang"]->translate("be_cperm_user_desc")),
				array("admin_logging", $object["lang"]->translate("be_cperm_logging"), $object["lang"]->translate("be_cperm_logging_desc")),
				array("admin_system", $object["lang"]->translate("be_cperm_system"), $object["lang"]->translate("be_cperm_system_desc")));	
	
	#####################################################################################
	## _core/_action User Script Activation
	#####################################################################################	
	$object["var"]->setup("_HIVE_USR_ACT_DISABLE_", "0", "be_var_refexcd_1");	 
	$object["var"]->setup("_HIVE_USR_ACT_REFER_", "0", "be_var_refexc_1");	 
	$object["var"]->setup("_HIVE_USR_REC_REFER_", "../../?fp2_l1=login_recover", "be_var_refexc_2");	 
	$object["var"]->setup("_HIVE_USR_REC_DISABLE_", "0", "be_var_refexcd_2");	 
	$object["var"]->setup("_HIVE_USR_MC_REFER_", "0", "be_var_refexc_3");	 
	$object["var"]->setup("_HIVE_USR_MC_DISABLE_", "0", "be_var_refexcd_3");	 