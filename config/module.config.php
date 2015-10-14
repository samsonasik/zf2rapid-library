<?php
/**
 * ZF2rapid library
 *
 * @package    ZF2rapidLib
 * @link       https://github.com/ZFrapid/zf2rapid-library
 * @copyright  Copyright (c) 2014 Ralf Eggert
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 */

/**
 * ZF2rapidLib module configuration
 *
 * @package    ZF2rapidLib
 */
return [
    'view_helpers' => [
        'invokables' => [
            'zf2rapidLibH1'            => 'ZF2rapidLib\View\Helper\H1',
            'zf2rapidLibDate'          => 'ZF2rapidLib\View\Helper\Date',
            'zf2rapidLibBootstrapForm' => 'ZF2rapidLib\View\Helper\BootstrapForm',
            'zf2rapidLibBootstrapMenu' => 'ZF2rapidLib\View\Helper\BootstrapMenu',
        ],
        'factories'  => [
            'zf2rapidLibBootstrapFlashMessenger' => 'ZF2rapidLib\View\Helper\BootstrapFlashMessengerFactory',
        ],
    ],

    'view_manager' => [
        'template_map'        => include __DIR__ . '/../template_map.php',
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
