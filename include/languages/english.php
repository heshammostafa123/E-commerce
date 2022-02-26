<?php 

	function lang($phrase)
	{
		static $lang = array(
			'MESSAGE' => "Welcome", 
			"ADMIN"	  => "Administrator"
		);

		return $lang[$phrase];
		
	}

?>