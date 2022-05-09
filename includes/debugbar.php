<?php

use DebugBar\StandardDebugBar;

$debugbar = new StandardDebugBar();

$debugbarRenderer =$debugbar->getJavascriptRenderer()->setBaseUrl(BASE_PATH.'includes/vendor/maximebf/debugbar/src/DebugBar/Resources/')->setBasePath(__DIR__.'/debugbar');



 //

$debugbarRenderer = & $debugbarRenderer;
$debugbars = & $debugbar;


function test($error)
{
	Global $debugbars;
	$debugbars['messages']->addMessage($error);
}