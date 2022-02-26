<?php 

	function lang($phrase)
	{
		static $lang = array(
			'MESSAGE' => "Welcome In Arabic", 
			"ADMIN"	  => "Administrator"
		);

		return $lang[$phrase];
		
	}

?>