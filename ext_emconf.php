
<?php
$EM_CONF['uw_two_clicks'] = array(
    'title' => 'Two Clicks',
    'description' => 'Allow two click solution for embedded items on the website. Give more privacy to users.',
    'category' => 'plugin',
    'author' => 'Pouyan Azari',
    'author_company' => 'University of Wuerzburg',
    'author_email' => 'pouyan.azari@uni-wuerzburg.de',
    'dependencies' => 'extbase,fluid',
    'state' => 'alpha',
    'clearCacheOnLoad' => '1',
    'version' => '0.0.3',
    'constraints' => array(
        'depends' => array(
            'typo3' => '7.6.0-7.6.99',
            'extbase' => '1.0.0-0.0.0',
            'fluid' => '1.0.0-0.0.0',
        )
    )
);
