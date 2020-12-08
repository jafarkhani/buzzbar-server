<?php
//----------------------------
//developer   : Sh.Jafarkhani
//date        : 2020-11
//----------------------------


$app->group('/api/v1', function () {
	
	$this->get('/domain/selectDeputies', 'ProfPortfolio\Controllers\DomainController:selectDeputies');
	$this->get('/domain/selectDeputies/{id}', 'ProfPortfolio\Controllers\DomainController:selectDeputies');
	
	$this->get('/IndicatorGroups/select/{id}', 'ProfPortfolio\Controllers\IndicatorGroupController:find');
	$this->get('/IndicatorGroups/selectAll', 'ProfPortfolio\Controllers\IndicatorGroupController:selectAll');
	$this->post('/IndicatorGroups/save', 'ProfPortfolio\Controllers\IndicatorGroupController:save');
	$this->get('/IndicatorGroups/delete/{id}', 'ProfPortfolio\Controllers\IndicatorGroupController:delete');
	
	$this->get('/FormHeader/selectAll', function (){return "----"});
	$this->post('/FormHeader/save', 'ProfPortfolio\Controllers\FormHeaderController:save');
	$this->get('/FormHeader/compute/{id}', 'ProfPortfolio\Controllers\FormHeaderController:compute');

});
