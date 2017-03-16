<?php
if (!defined('TYPO3_MODE')) {
        die ('Access denied.');
}

// Declare static TS file
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    $_EXTKEY,
    'Configuration/TypoScript/',
    'Examples TypoScript'
);

// Add the plugin to the list of elements.
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPlugin(
    [
        'LLL:EXT:'.$_EXTKEY.'/Resources/Private/Language/locallang_db.xlf:tt_content.list_type_uw_two_clicks',
        'uwtwoclicks_app',
    ],
    'list_type',
    'uwtwoclicks'
);

// Register the plugin
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'uw_two_clicks',
    'App',
    'LLL:EXT:uw_two_clicks/Resources/Private/Language/locallang_db.xlf:tt_content.list_type_uw_two_clicks'
);

// Disable layout for the plugin
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['uwtwoclicks_app'] = 'layout,select_key,pages,recursive';
// Activate FlexForm the plugin
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['uwtwoclicks_app'] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    'uwtwoclicks_app', 'FILE:EXT:uw_two_clicks/Configuration/FlexForms/Records.xml'
);