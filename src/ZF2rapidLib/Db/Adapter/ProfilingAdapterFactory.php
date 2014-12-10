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
namespace ZF2rapidLib\Db\Adapter;

use BjyProfiler\Db\Adapter\ProfilingAdapter;
use BjyProfiler\Db\Profiler\Profiler;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Profiling adapter controller factory
 *
 * Factory to create the Profiling adapter
 *
 * @package    ZF2rapidLib
 */
class ProfilingAdapterFactory implements FactoryInterface
{
    /**
     * Create Service Factory
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return ProfilingAdapter
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');

        $adapter = new ProfilingAdapter($config['db']);
        $adapter->setProfiler(new Profiler());
        $adapter->injectProfilingStatementPrototype(
            array('buffer_results' => true)
        );

        return $adapter;
    }
}
