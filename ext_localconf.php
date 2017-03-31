<?php
if (!defined ('TYPO3_MODE')) die ('Access denied.');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('<INCLUDE_TYPOSCRIPT: source="FILE:EXT:uw_two_clicks/Configuration/TSconfig/Page/ContentElementWizard.txt">');

if (!is_array($TYPO3_CONF_VARS['SYS']['caching']['cacheConfigurations']['uw_two_clicks_cache'])) {
    $TYPO3_CONF_VARS['SYS']['caching']['cacheConfigurations']['uw_two_clicks_cache'] = array();
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'De\Uniwue\RZ\Typo3\Ext\.'.$_EXTKEY,
    'App',
    array(
        'Start' => 'index,show',
    ),
    array(
        'Start' => 'index,show',
    )
); 