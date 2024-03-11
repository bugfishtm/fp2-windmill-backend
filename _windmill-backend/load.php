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
	*/	 if(!is_array($object)) { @http_response_code(404); Header("Location ../"); exit(); }
	//////////////////////////////////////////////////////////////////////////////
	// Show Login if not Logged In
	//////////////////////////////////////////////////////////////////////////////
	x_cookieBanner_Pre(_HIVE_SITE_COOKIE_);
	if((!$object["user"]->user_loggedIn OR @trim(_HIVE_URL_CUR_[0]) == "") AND (@trim(_HIVE_URL_CUR_[0]) != "login_recover" AND @trim(_HIVE_URL_CUR_[0]) != "login_mail_change")) { $csrf_key = "login_auth"; $object["add_nav_title"] = ""; $object["add_top_title"] = ""; $object["add_head_title"] = $object["lang"]->translate("be_login");
	if(!defined("_INT_SHOW_LOGIN_")) { define("_INT_SHOW_LOGIN_", 1); }}
	
	//////////////////////////////////////////////////////////////////////////////
	// Start Page if no Page Selected
	//////////////////////////////////////////////////////////////////////////////
	if($object["user"]->user_loggedIn AND @trim(_HIVE_URL_CUR_[0]) == "") { Header("Location: ".hive_get_url_rel(array("start", false, false, false, false))); exit();}
	
	//////////////////////////////////////////////////////////////////////////////
	// Login Areas - Titles
	//////////////////////////////////////////////////////////////////////////////
	$csrf_key = "";
	$object["add_nav_title"] = _HIVE_TITLE_;
	$object["add_top_title"] = 404;
	if(!$object["user"]->loggedIn) {
		if(!defined("_INT_SHOW_ACCESS_")) {
			switch(_HIVE_URL_CUR_[0]) {
				case "login_recover": $csrf_key = "login_recover"; $object["add_nav_title"] = ""; $object["add_top_title"] = ""; $object["add_head_title"] = $object["lang"]->translate("be_recover"); $object["csrf"] = new x_class_csrf(_HIVE_SITE_COOKIE_.$csrf_key); hive__template_recover_exec($object, "_core/_action/user_recover.php?", "rec_token", "rec_user", "_RECOVER_", true, _HIVE_URL_REL_);  break;
				case "login_auth": 			$csrf_key = "login_auth"; $object["add_nav_title"] = ""; $object["add_top_title"] = ""; $object["add_head_title"] = $object["lang"]->translate("be_login"); break;
			};	
		}
	}
	
	//////////////////////////////////////////////////////////////////////////////
	// Secure Areas - Titles
	//////////////////////////////////////////////////////////////////////////////
	if($object["user"]->user_loggedIn AND !defined("_INT_SHOW_FOUND_") AND !defined("_INT_SHOW_LOGIN_") AND !defined("_INT_SHOW_ACCESS_")) {	
		switch(_HIVE_URL_CUR_[0]) {
			//////////////////////////////////////////////////////////////////////////////
			//////////////////////////////////////////////////////////////////////////////
			// Start Related Titles and Operations	
			//////////////////////////////////////////////////////////////////////////////
			case false: case "": case "login_auth": case NULL: Header("Location: ".hive_get_url_rel(array("start", false, false, false, false))); break;
			case "start": $csrf_key = "start"; $object["add_nav_title"] = _HIVE_TITLE_; $object["add_top_title"] = $object["lang"]->translate("be_start"); $object["add_head_title"] = $object["add_top_title"]; break;
			// Logging Related Titles	
			case "logging":
				switch(_HIVE_URL_CUR_[1]) {
					case "mysql": $csrf_key = "logging_mysql"; $object["add_nav_title"] = _HIVE_TITLE_; $object["add_top_title"] = $object["lang"]->translate("be_mysql"); $object["add_head_title"] = $object["add_top_title"]; break;
					case "curl": $csrf_key = "logging_curl"; $object["add_nav_title"] = _HIVE_TITLE_; $object["add_top_title"] = $object["lang"]->translate("be_curl"); $object["add_head_title"] = $object["add_top_title"]; break;
					case "visits": $csrf_key = "logging_visits"; $object["add_nav_title"] = _HIVE_TITLE_; $object["add_top_title"] = $object["lang"]->translate("be_visits"); $object["add_head_title"] = $object["add_top_title"]; break;
					case "blacklist": $csrf_key = "logging_blacklist"; $object["add_nav_title"] = _HIVE_TITLE_; $object["add_top_title"] = $object["lang"]->translate("be_blacklist"); $object["add_head_title"] = $object["add_top_title"]; break;
					case "referer": $csrf_key = "logging_referer"; $object["add_nav_title"] = _HIVE_TITLE_; $object["add_top_title"] = $object["lang"]->translate("be_referer"); $object["add_head_title"] = $object["add_top_title"]; break;
					case "benchmark": $csrf_key = "logging_benchmark"; $object["add_nav_title"] = _HIVE_TITLE_; $object["add_top_title"] = $object["lang"]->translate("be_benchmark"); $object["add_head_title"] = $object["add_top_title"]; break;
					case "js": $csrf_key = "logging_js"; $object["add_nav_title"] = _HIVE_TITLE_; $object["add_top_title"] = $object["lang"]->translate("be_javascript"); $object["add_head_title"] = $object["add_top_title"]; break;
					case "mail": $csrf_key = "logging_mail"; $object["add_nav_title"] = _HIVE_TITLE_; $object["add_top_title"] = $object["lang"]->translate("be_mail"); $object["add_head_title"] = $object["add_top_title"]; break;
					case "logging": $csrf_key = "logging_logging"; $object["add_nav_title"] = _HIVE_TITLE_; $object["add_top_title"] = $object["lang"]->translate("be_logging"); $object["add_head_title"] = $object["add_top_title"]; break;
					case "cron": $csrf_key = "logging_cron"; $object["add_nav_title"] = _HIVE_TITLE_; $object["add_top_title"] = $object["lang"]->translate("be_cron"); $object["add_head_title"] = $object["add_top_title"]; break;
				};		
				break;		
			// User Related Titles		
			case "user":	
				switch(_HIVE_URL_CUR_[1]) {
					case "profile": $csrf_key = "user_profile"; $object["add_nav_title"] = _HIVE_TITLE_; $object["add_top_title"] = $object["lang"]->translate("be_profile"); $object["add_head_title"] = $object["add_top_title"]; break;
					case "logout": $object["user"]->logout(); $object["eventbox"]->ok($object["lang"]->translate("be_logged_out")); @Header("Location: ".hive_get_url_rel(array("start", false, false, false, false))); exit(); break;
					case "user": $csrf_key = "user_user"; $object["add_nav_title"] = _HIVE_TITLE_; $object["add_top_title"] = $object["lang"]->translate("be_list"); $object["add_head_title"] = $object["add_top_title"]; break;
					case "switch": $csrf_key = "user_switch";  @Header("Location: "._HIVE_URL_REL_."/_core/_action/admin_switch.php"); exit(); break;
					case "group": $csrf_key = "user_group"; $object["add_nav_title"] = _HIVE_TITLE_; $object["add_top_title"] = $object["lang"]->translate("be_group"); $object["add_head_title"] = $object["add_top_title"]; break;
					case "session": $csrf_key = "user_session"; $object["add_nav_title"] = _HIVE_TITLE_; $object["add_top_title"] = $object["lang"]->translate("be_session"); $object["add_head_title"] = $object["add_top_title"]; break;
				};	
				break;		
			// System Related Titles	
			case "system":	
				switch(_HIVE_URL_CUR_[1]) {
					case "constants": $csrf_key = "system_constant"; $object["add_nav_title"] = _HIVE_TITLE_; $object["add_top_title"] = $object["lang"]->translate("be_constants"); $object["add_head_title"] = $object["add_top_title"]; break;
					case "mailtemplates": $csrf_key = "system_mailtemplates"; $object["add_nav_title"] = _HIVE_TITLE_; $object["add_top_title"] = $object["lang"]->translate("be_templates"); $object["add_head_title"] = $object["add_top_title"]; break;
					case "apitoken": $csrf_key = "system_apitoken"; $object["add_nav_title"] = _HIVE_TITLE_; $object["add_top_title"] = $object["lang"]->translate("be_api"); $object["add_head_title"] = $object["add_top_title"]; break;
					case "about": $csrf_key = "system_about"; $object["add_nav_title"] = _HIVE_TITLE_; $object["add_top_title"] = $object["lang"]->translate("be_about"); $object["add_head_title"] = $object["add_top_title"]; break;
				};	
				break;	  
		}; 	
	}		
	
	//////////////////////////////////////////////////////////////////////////////
	// Default CSRF Key
	//////////////////////////////////////////////////////////////////////////////
	if(!@$object["csrf"]) { $object["csrf"] = new x_class_csrf(_HIVE_SITE_COOKIE_.$csrf_key);	}
	
	//////////////////////////////////////////////////////////////////////////////
	// Start Variables
	//////////////////////////////////////////////////////////////////////////////
	$object["add_head_theme"] 			= "dark"; # Dark/ Light
	$object["add_nav_button_title"] 	= false;
	$object["add_nav_button_url"] 		= false;
	$object["add_topbar_search"] 		= false;
	$object["add_head_ext"] 			= '<link rel="icon" type="image/x-icon" href="'._HIVE_URL_REL_.'/_core/_image/favicon.ico">';
	$object["add_topbar_theme"] 		= true;
	$object["add_topbar_image"] 		= _HIVE_URL_REL_."/_core/_image/user_image.png";
	
	//////////////////////////////////////////////////////////////////////////////
	// Start Elements
	//////////////////////////////////////////////////////////////////////////////
	if(!@$object["add_head_title"]) { $object["add_head_title"] = $object["lang"]->translate("be_operr");}
	hive__windmill_header($object, $object["add_head_title"], @$object["add_head_ext"], @$object["add_head_theme"]);
	if($object["user"]->user_loggedIn) { hive__windmill_nav($object, $object["add_nav_title"], $object["add_nav_button_url"]); }
	hive__windmill_start($object);
	if($object["user"]->user_loggedIn) { hive__windmill_topbar($object, $pfm, $object["add_topbar_theme"], $object["add_topbar_search"], $object["add_top_title"], $object["add_topbar_image"], $lang_ar); }
	hive__windmill_content_start($object);	
	
	//////////////////////////////////////////////////////////////////////////////
	// Login Areas Selection - Require
	//////////////////////////////////////////////////////////////////////////////
	if(!defined("_INT_SHOW_ACCESS_")) { 
		if(!$object["user"]->loggedIn) {
			switch(_HIVE_URL_CUR_[0]) {
				case "login_recover":  hive__windmill_recover($object, hive_get_url_rel(array("login_auth", false, false)), hive_get_url_rel(array("login_recover", false, false)), "rec_token", "rec_user", _HIVE_URL_REL_."/_core/_image/bugfish-framework-logo.jpg", _HIVE_URL_REL_."/_core/_image/bugfish-framework-logo.jpg", "_RECOVER_"); if(!defined("_INT_SHOW_FOUND_")) { define("_INT_SHOW_FOUND_", 1); } break;
				case "login_auth": if(!defined("_INT_SHOW_LOGIN_")) { define("_INT_SHOW_LOGIN_", 1); } break;
			};	
		}
	}	
	
	//////////////////////////////////////////////////////////////////////////////
	// Secured User Areas - Require
	//////////////////////////////////////////////////////////////////////////////
	if($object["user"]->user_loggedIn AND !defined("_INT_SHOW_FOUND_") AND !defined("_INT_SHOW_LOGIN_") AND !defined("_INT_SHOW_ACCESS_")) {
		switch(_HIVE_URL_CUR_[0]) {
			//case false: case "":  break;
			case "start": require_once(_HIVE_SITE_PATH_."/start.php"); if(!defined("_INT_SHOW_FOUND_")) { define("_INT_SHOW_FOUND_", 1); } break;	
			// Logging Related Pages
			case "logging":
				switch(_HIVE_URL_CUR_[1]) {
					case "mysql": require_once(_HIVE_SITE_PATH_."/logging/mysql.php"); if(!defined("_INT_SHOW_FOUND_")) { define("_INT_SHOW_FOUND_", 1); } break;
					case "curl": require_once(_HIVE_SITE_PATH_."/logging/curl.php"); if(!defined("_INT_SHOW_FOUND_")) { define("_INT_SHOW_FOUND_", 1); } break;
					case "visits": require_once(_HIVE_SITE_PATH_."/logging/visits.php"); if(!defined("_INT_SHOW_FOUND_")) { define("_INT_SHOW_FOUND_", 1); } break;
					case "blacklist": require_once(_HIVE_SITE_PATH_."/logging/blacklist.php"); if(!defined("_INT_SHOW_FOUND_")) { define("_INT_SHOW_FOUND_", 1); } break;
					case "referer": require_once(_HIVE_SITE_PATH_."/logging/referer.php"); if(!defined("_INT_SHOW_FOUND_")) { define("_INT_SHOW_FOUND_", 1); } break;
					case "benchmark": require_once(_HIVE_SITE_PATH_."/logging/benchmark.php"); if(!defined("_INT_SHOW_FOUND_")) { define("_INT_SHOW_FOUND_", 1); } break;
					case "js": require_once(_HIVE_SITE_PATH_."/logging/js.php"); if(!defined("_INT_SHOW_FOUND_")) { define("_INT_SHOW_FOUND_", 1); } break;
					case "mail": require_once(_HIVE_SITE_PATH_."/logging/mail.php"); if(!defined("_INT_SHOW_FOUND_")) { define("_INT_SHOW_FOUND_", 1); } break;
					case "logging": require_once(_HIVE_SITE_PATH_."/logging/logging.php"); if(!defined("_INT_SHOW_FOUND_")) { define("_INT_SHOW_FOUND_", 1); } break;
					case "cron": require_once(_HIVE_SITE_PATH_."/logging/cron.php"); if(!defined("_INT_SHOW_FOUND_")) { define("_INT_SHOW_FOUND_", 1); } break;
				}; break;	
			// User Related Pages
			case "user":	
				switch(_HIVE_URL_CUR_[1]) {
					case "profile": require_once(_HIVE_SITE_PATH_."/user/profile.php"); if(!defined("_INT_SHOW_FOUND_")) { define("_INT_SHOW_FOUND_", 1); } break;
					case "logout": require_once(_HIVE_SITE_PATH_."/user/logout.php"); if(!defined("_INT_SHOW_FOUND_")) { define("_INT_SHOW_FOUND_", 1); } break;
					case "user": require_once(_HIVE_SITE_PATH_."/user/user.php"); if(!defined("_INT_SHOW_FOUND_")) { define("_INT_SHOW_FOUND_", 1); } break;
					case "group": require_once(_HIVE_SITE_PATH_."/user/group.php"); if(!defined("_INT_SHOW_FOUND_")) { define("_INT_SHOW_FOUND_", 1); } break;
					case "session": require_once(_HIVE_SITE_PATH_."/user/session.php"); if(!defined("_INT_SHOW_FOUND_")) { define("_INT_SHOW_FOUND_", 1); } break;
				}; break;	
			// System Related Pages
			case "system":	
				switch(_HIVE_URL_CUR_[1]) {
					case "constants": require_once(_HIVE_SITE_PATH_."/system/constants.php"); if(!defined("_INT_SHOW_FOUND_")) { define("_INT_SHOW_FOUND_", 1); } break;
					case "mailtemplates": require_once(_HIVE_SITE_PATH_."/system/mailtemplates.php"); if(!defined("_INT_SHOW_FOUND_")) { define("_INT_SHOW_FOUND_", 1); } break;
					case "apitoken": require_once(_HIVE_SITE_PATH_."/system/apitoken.php"); if(!defined("_INT_SHOW_FOUND_")) { define("_INT_SHOW_FOUND_", 1); } break;
					case "about": require_once(_HIVE_SITE_PATH_."/system/about.php"); if(!defined("_INT_SHOW_FOUND_")) { define("_INT_SHOW_FOUND_", 1); } break;
				}; break;	
		};		
	}
	
	//////////////////////////////////////////////////////////////////////////////
	// Special Areas
	//////////////////////////////////////////////////////////////////////////////
		if(defined("_INT_SHOW_LOGIN_") AND !defined("_INT_SHOW_FOUND_") AND !$object["user"]->user_loggedin) {
			// Executions by Template FP2
			 hive__template_login_exec($object, true); 
			// Display Login Page if Required
			hive__windmill_login($object, true, hive_get_url_rel(array("login_recover", false, false)), _HIVE_URL_REL_."/_core/_image/bugfish-framework-logo.jpg", _HIVE_URL_REL_."/_core/_image/bugfish-framework-logo.jpg", $object["lang"]->translate("be_login_switch"));
		} elseif(!defined("_INT_SHOW_FOUND_")) {
			// Display No Found Page if Required
			hive__windmill_404($object, $object["lang"]->translate("be_404_1"), $object["lang"]->translate("be_404_2"));
		} elseif(defined("_INT_SHOW_ACCESS_")) {
			// Display No Access Page if Required
			hive__windmill_401($object, $object["lang"]->translate("be_401_1"), $object["lang"]->translate("be_401_2"));
		}
	
	//////////////////////////////////////////////////////////////////////////////
	// Finalize
	//////////////////////////////////////////////////////////////////////////////
		// End Dashboard Content
		hive__windmill_content_end($object);
		
		// End Dashboard Main
		hive__windmill_end($object);
		
		// Show EventBox Classes Objects if required
		$object["eventbox"]->show($object["lang"]->translate("be_close"));
		
		// Show Cookiebanner if required
		x_cookieBanner(_HIVE_SITE_COOKIE_, false, $object["lang"]->translate("be_cbanner_1"), "", false, $object["lang"]->translate("be_cbanner_2"));
		
		// Display Footer and End Website
		hive__windmill_footer($object, _HIVE_CREATOR_);