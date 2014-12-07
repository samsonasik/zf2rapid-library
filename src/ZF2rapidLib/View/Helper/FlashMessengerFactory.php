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
 * namespace definition and usage
 */
namespace ZF2rapidLib\View\Helper;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * FlashMessenger view helper factory
 *
 * Generates the FlashMessenger view helper object
 *
 * @package    ZF2rapidLib
 */
class FlashMessengerFactory implements FactoryInterface
{
    /**
     * Create Service Factory
     *
     * @param ServiceLocatorInterface $viewHelperManager
     *
     * @return mixed|\ZF2rapidLib\View\Helper\FlashMessenger
     */
    public function createService(ServiceLocatorInterface $viewHelperManager)
    {
        $serviceManager          = $viewHelperManager->getServiceLocator();
        $controllerPluginManager = $serviceManager->get(
            'ControllerPluginManager'
        );

        $plugin = $controllerPluginManager->get('flashMessenger');

        $helper = new FlashMessenger($plugin);

        return $helper;
    }
}
