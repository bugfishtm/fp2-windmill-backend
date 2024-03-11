
<?php if(@$_SESSION[_HIVE_SITE_COOKIE_."hive_dashboard_subtheme"] == "dark") { ?>
	/******************************************************* dark Table Style for Datatables  *********/
	.x_class_table_listing {
		color: #CCCCCC ;
		max-width: 100%;
	}

	.dataTables_length, .dataTables_filter, .dataTables_info, .dataTables_paginate  {
		color: #CCCCCC !important;
	}

	.dataTables_paginate  .current {
		color: #CCCCCC !important;
	}
<?php } ?>

	/******************************************************* Light Table Style for Datatables  *********/
	.x_class_table_box_table {
		max-width: 100%;
		overflow-x: scroll;
	}
	
	.x_class_table_listing {
		max-width: 100%;
		word-break: break-all;
	}
	.x_class_table_listing td {
		min-width: 100px;
	}