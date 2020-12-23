<?php
//----------------------------
//developer   : Sh.Jafarkhani
//date        : 2020-11
//----------------------------

use App\Controllers\PlayerController;

$app->group('/api/', function () {
	
	$this->get('AddScore', 'App\Controllers\PlayerController:AddScore');
	$this->get('GetScores', 'App\Controllers\PlayerController:GetScores');
	

});
