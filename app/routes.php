<?php
//----------------------------
//developer   : Sh.Jafarkhani
//date        : 2020-11
//----------------------------


$app->group('/api/', function () {
	
	
	$this->get('AddScore', 'App\Controllers\PlayerController:AddScore');
	

});
