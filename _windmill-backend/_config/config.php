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
	// Required PHP Modules
	///////////////////////////////////////////////////////////////////
	$object["var"]->setup("_HIVE_PHP_MODS_",  @serialize(@array("curl", "zip", "gd")), "be_var_phpmod");
	
	///////////////////////////////////////////////////////////////////
	// Site SEO URLs?
	///////////////////////////////////////////////////////////////////
	$object["var"]->setup("_HIVE_URL_SEO_", "0", "be_var_url_seo");
	
	///////////////////////////////////////////////////////////////////
	// Site Get Location Names
	///////////////////////////////////////////////////////////////////
	$object["var"]->setup("_HIVE_URL_GET_",  @serialize(@array("fpa_l1", "fpa_l2", "fpa_l3", "fpa_l4", "fpa_l5")), "be_var_url");
	
	///////////////////////////////////////////////////////////////////
	// Theme Settings
	///////////////////////////////////////////////////////////////////
	$object["var"]->setup("_HIVE_THEME_DEFAULT_", "dynamic", "be_var_theme1");
	$object["var"]->setup("_HIVE_THEME_ARRAY_",  @serialize(@array("dynamic")), "be_var_theme2");
	$object["var"]->setup("_HIVE_THEME_COLOR_DEFAULT_", "#ff5707", "be_var_theme3");
	
	///////////////////////////////////////////////////////////////////
	// Site Title
	///////////////////////////////////////////////////////////////////
	$object["var"]->setup("_HIVE_TITLE_", "Windmill Backend", "be_var_site_1");
	$object["var"]->setup("_HIVE_TITLE_SPACER_", " - ", "be_var_site_2");
	
	///////////////////////////////////////////////////////////////////
	// Mail Configuration
	///////////////////////////////////////////////////////////////////
	$object["var"]->setup("_SMTP_SENDER_MAIL_", "example@example", "be_var_smtp_1");	 
	$object["var"]->setup("_SMTP_SENDER_NAME_", "Max Mustermann", "be_var_smtp_2");		
	$object["var"]->setup("_SMTP_MAILS_IN_HTML_", "1", "be_var_smtp_3");		
	$object["var"]->setup("_SMTP_DEBUG_", "0", "be_var_smtp_4");
	$object["var"]->setup("_SMTP_MAILS_HEADER_", '<!doctype html><html><head><meta name="viewport" content="width=device-width, initial-scale=1.0"/><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /><style>body { background-color: #121212; font-family: sans-serif; -webkit-font-smoothing: antialiased; font-size: 14px; line-height: 1.4; margin: 0; padding: 0; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; } .content { background: #FFFFFF; box-sizing: border-box; display: block; margin: 0 auto; max-width: 580px; padding: 10px; border-radius: 5px; margin-top: 15px;  }  .footer { clear: both; margin-top: 10px; text-align: center; width: 100%; color: #000000; font-size: 12px; text-align: center;  }  h1, h2, h3, h4 { color: #000000; font-family: sans-serif; font-weight: 400; line-height: 1.4; margin: 0; margin-bottom: 30px; }  h1 { font-size: 35px; font-weight: 300; text-align: center; text-transform: capitalize; }  a { color: blue; text-decoration: none; } hr { border: 0; border-bottom: 1px solid #242424; margin: 20px 0; }  @media only screen and (max-width: 620px) { div.content { margin-top: 2vw !important; margin-left: 2vw !important; margin-right: 2vw !important;}}</style></head><body><div class="content">', "be_var_smtp_5");
	$object["var"]->setup("_SMTP_MAILS_FOOTER_", '</div></body></html>', "be_var_smtp_6");
	$object["var"]->setup("_SMTP_INSECURE_", "1", "be_var_smtp_7");	
	$object["var"]->setup("_SMTP_HOST_", "localhost", "be_var_smtp_8");		
	$object["var"]->setup("_SMTP_PORT_", "587", "be_var_smtp_9");
	$object["var"]->setup("_SMTP_AUTH_", "ssl", "be_var_smtp_10");
	$object["var"]->setup("_SMTP_USER_", "example@example", "be_var_smtp_11");	
	$object["var"]->setup("_SMTP_PASS_", "***********", "be_var_smtp_12");		

	///////////////////////////////////////////////////////////////////
	// Lang Settings
	///////////////////////////////////////////////////////////////////
	$object["var"]->setup("_HIVE_LANG_DEFAULT_", "en", "be_var_lang1");
	$object["var"]->setup("_HIVE_LANG_ARRAY_",  @serialize(@array("en", "de", "ja", "es")), "be_var_lang2");
	$object["var"]->setup("_HIVE_LANG_DB_", "0", "be_var_lang3");			
		
	///////////////////////////////////////////////////////////////////
	// Site Configuration
	/////////////////////////////////////////////////////////////////// 
	$object["var"]->setup("_HIVE_URL_", $object["url"], "b_var_sitecn1");		
	$object["var"]->setup("_HIVE_PHP_DEBUG_", "1", "b_var_sitecn2");		
	$object["var"]->setup("_HIVE_JS_ACTION_ACTIVE_", "1", "b_var_sitecn3");		
	$object["var"]->setup("_HIVE_MYSQL_DEBUG_", "0", "b_var_sitecn4");		
		
	///////////////////////////////////////////////////////////////////
	// More Configuration
	///////////////////////////////////////////////////////////////////
	$object["var"]->setup("_HIVE_CURL_LOGGING_", "1", "b_var_vmsic1");
	$object["var"]->setup("_HIVE_IP_LIMIT_", "100000", "b_var_vmsic2");
	$object["var"]->setup("_HIVE_REFERER_", "0", "b_var_vmsic3");
	$object["var"]->setup("_HIVE_CSRF_TIME_", "2000", "b_var_vmsic4");
	$object["var"]->setup("_CRON_ONLY_CLI_", "1", "b_var_vmsic5");
		
	///////////////////////////////////////////////////////////////////
	// Redis Configuration
	///////////////////////////////////////////////////////////////////
	$object["var"]->setup("_REDIS_", "0", "b_var_redis1");
	$object["var"]->setup("_REDIS_HOST_", "localhost", "b_var_redis2");
	$object["var"]->setup("_REDIS_PORT_", "6379", "b_var_redis3");
	define("_REDIS_PREFIX_", $object["prefix"]); 
	
	///////////////////////////////////////////////////////////////
	// Tinymce Configuration
	///////////////////////////////////////////////////////////////////
	$object["var"]->setup("_TINYMCE_PLUGINS_", "preview importcss searchreplace autolink directionality visualblocks visualchars fullscreen image link media codesample table charmap pagebreak nonbreaking anchor advlist lists wordcount help charmap quickbars emoticons code", "b_var_tmce1");
	$object["var"]->setup("_TINYMCE_MENU_BAR_", "file edit view insert format table help", "b_var_tmce2");
	$object["var"]->setup("_TINYMCE_TOOL_BAR_", "undo redo | bold italic underline strikethrough | blocks fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent | numlist bullist | image media link", "b_var_tmce3");		
		
	///////////////////////////////////////////////////////////////////
	// User Settings
	///////////////////////////////////////////////////////////////////
	$object["var"]->setup("_USER_MAX_SESSION_", "7", "b_var_user1");	
	$object["var"]->setup("_USER_TOKEN_TIME_", "300", "b_var_user2");	
	$object["var"]->setup("_USER_AUTOBLOCK_", "0", "b_var_user3");	
	$object["var"]->setup("_USER_WAIT_COUNTER_", "10", "b_var_user4");	
	$object["var"]->setup("_USER_LOG_SESSIONS_", "1", "b_var_user5");	
	$object["var"]->setup("_USER_LOG_IP_", "0", "b_var_user6");	
	$object["var"]->setup("_USER_REC_DROP_", "1", "b_var_user7");	
	$object["var"]->setup("_USER_MULTI_LOGIN_", "0", "b_var_user8");	
	$object["var"]->setup("_USER_PF_SIGNS_", "7", "b_var_user9");	
	$object["var"]->setup("_USER_PF_CAPSIGNS_", "1", "b_var_user10");	
	$object["var"]->setup("_USER_PF_SMSIGNS_", "1", "b_var_user11");	
	$object["var"]->setup("_USER_PF_SPSIGNS_", "0", "b_var_user12");	
	$object["var"]->setup("_USER_PF_NUMSIGNS_", "1", "b_var_user13");			
		
	///////////////////////////////////////////////////////////////////
	// Updater Configuration
	///////////////////////////////////////////////////////////////////
	$object["var"]->setup("_UPDATER_TITLE_", "Administrator", "b_var_up1");
	$object["var"]->setup("_UPDATER_CODE_", "0", "b_var_up2");		
		
	///////////////////////////////////////////////////////////////////
	// Captcha Configuration
	///////////////////////////////////////////////////////////////////
	define("_CAPTCHA_CODE_", 		mt_rand(1000, 9999)); 
	define("_CAPTCHA_COLORS_", 		false); 
	$object["var"]->setup("_CAPTCHA_LINES_", "7", "b_var_captcha1");
	$object["var"]->setup("_CAPTCHA_SQUARES_", "7", "b_var_captcha2");
	$object["var"]->setup("_CAPTCHA_HEIGHT_", "70", "b_var_captcha3");
	$object["var"]->setup("_CAPTCHA_WIDTH_", "200", "b_var_captcha4");
	$object["var"]->setup("_CAPTCHA_FONT_PATH_", "0", "b_var_captcha5");		
		
	///////////////////////////////////////////////////////////////////
	// HTAccess [OUTDATED, CHANGE YOUR HTACCESS FILE DIRECTLY IS RECOMMENDED!]
	// BUT THIS FUNCTIONALITY IS STILL OPERATIVE AND WORKING IF YOU NEED IT. 
	// JUST BE SURE THE RIGHT .HTACCESS GETS CREATED, MAYBE THE CORE MODULE 
	// WILL CREATE .HTACCESS BEFORE SITE MODULE IS ABLE TO DO SO.
	// HTACCESS WILL NEVER BE OVERWRITTEN BY CORE.
	///////////////////////////////////////////////////////////////////
	//$object["var"]->setup("_HIVE_HTACCESS_WRITE_", "0", "1 - Create HTAccess | 0 - Do Not Create HTAccess");
	//$object["var"]->setup("_HIVE_HTACCESS_HTTPS_FORWARD_", "0", "1 - Forward to HTTPS | 0 - Not Forward");
	//$object["var"]->setup("_HIVE_HTACCESS_WWW_FORWARD_", "0", "1 - Forward to HTTPS | 0 - Not Forward");
	//$object["var"]->setup("_HIVE_HTACCESS_REFRESH_", "0", "1 - REFRESH MODULE | 0 - Not Refresh Module");
	//$object["var"]->setup("_HIVE_SITEMAP_URL_", "0", "URL of the Sitemap for Current Site to include in Robots");
	$object["var"]->setup("_HIVE_ROBOT_SPAWN_", "0", "be_var_robot");
	

	
	

				
				
				