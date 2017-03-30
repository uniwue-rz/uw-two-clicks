<?php
defined('TYPO3_MODE') or die();

// Add the post process data map hook
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass']["uw_two_clicks"] = 'De\\Uniwue\\RZ\\Typo3\\Ext\\UwTwoClicks\\Hooks\\ProcessDataMap';
$GLOBALS ['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processCmdmapClass']['uw_two_clicks'] = 'De\\Uniwue\\RZ\\Typo3\\Ext\\UwTwoClicks\\Hooks\\ProcessDataMap';
// Allow create this record
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages ( 'tx_uw_two_clicks_records' );
// Adds the TYPO Script Settings:
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Setup');

if (TYPO3_MODE === 'BE') {
}