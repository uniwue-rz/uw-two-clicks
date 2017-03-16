<?php
if (!defined ('TYPO3_MODE')) die ('Access denied.');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('<INCLUDE_TYPOSCRIPT: source="FILE:EXT:uw_two_clicks/Configuration/TSconfig/Page/ContentElementWizard.txt">');

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'De\Uniwue\RZ.'.$_EXTKEY,
    'App',
    array(
        'Start' => 'index,show',
    ),
    array(
        'Start' => 'index,show',
    )
); 