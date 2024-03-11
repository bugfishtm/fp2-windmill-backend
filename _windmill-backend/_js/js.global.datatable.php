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
	*/if(!is_array($object)) { @http_response_code(404); Header("Location: ../"); exit(); } ?>
	/* Datables Initialization */ 
	$( document ).ready(function() {
		new DataTable("#x_class_table_id_tbl_table", {
			order: [[0, 'desc']],   
			autoWidth: false,
			buttons: [
				'copy', 'csv', 'excel', 'print', 'pdf'
			],
			<?php if(file_exists(_HIVE_PATH_."/_core/_vendor/datatables/lang/"._HIVE_LANG_.".json")) { ?>
			language: {
				 url: '<?php echo _HIVE_URL_REL_."/_core/_vendor/datatables/lang/"._HIVE_LANG_.".json"; ?>', 
			},
			<?php } ?>
		});
	});