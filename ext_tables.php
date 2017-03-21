<?php
defined('TYPO3_MODE') or die();

// Add the post process data map hook
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass']["uw_two_clicks"] = 'De\\Uniwue\\RZ\\Typo3\\Ext\\UwTwoClicks\\Hooks\\ProcessDataMap';

if (TYPO3_MODE === 'BE') {
}