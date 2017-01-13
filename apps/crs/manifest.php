<?php defined('WITYCMS_VERSION') or die('Access denied'); ?>
<?xml version="1.0" encoding="utf-8" ?>
<app>
	<!-- Application name -->
	<name>Chasse Ragequit et Safari</name>

	<version>1.0.0-03-09-2016</version>

	<!-- Last update date -->
	<date>03-09-2016</date>

	<action default="default">overlay</action>
	<action>pick</action>

	<!-- Admin actions -->
	<admin>
		<action default="default" description="Games list">games</action>
        <action menu="false">game</action>
        <action description="Add a game" menu="false">game_add</action>
		<action menu="false">increment_timer</action>
        <action menu="false">kill_count</action>
	</admin>
</app>
