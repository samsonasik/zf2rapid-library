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
namespace ZF2rapidLib\View;

use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\ViewModel;
use Zend\View\Resolver\AggregateResolver;

/**
 * Layout listener
 *
 * Adds layout segments to standard layout
 *
 * @package    ZF2rapidLib
 */
class LayoutListener extends AbstractListenerAggregate
{
    /**
     * @var array
     */
    protected $layoutSegments = [];

    /**
     * @param array $layoutSegments
     */
    function __construct(array $layoutSegments = [])
    {
        $this->layoutSegments = $layoutSegments;
    }

    /**
     * Attach to an event manager
     *
     * @param  EventManagerInterface $events
     */
    public function attach(EventManagerInterface $events)
    {
        $this->listeners[] = $events->attach(
            MvcEvent::EVENT_RENDER,
            [$this, 'renderLayoutSegments'],
            -100
        );
    }

    /**
     * Listen to the "render" event and render additional layout segments
     *
     * @param  MvcEvent $e
     *
     * @return null
     */
    public function renderLayoutSegments(MvcEvent $e)
    {
        /* @var $viewModel ViewModel */
        $viewModel = $e->getViewModel();

        // skip if current ViewModel is of expected type
        if ('Zend\View\Model\ViewModel' != get_class($viewModel)) {
            return;
        }

        /** @var AggregateResolver $resolver */
        $resolver = $e->getApplication()->getServiceManager()->get(
            'ViewResolver'
        );

        // loop through layout segments
        foreach ($this->layoutSegments as $segment) {

            // skip if layout segment does not exist
            if (!$resolver->resolve('layout/' . $segment)) {
                continue;
            }

            // add an additional header segment to layout
            $header = new ViewModel();
            $header->setTemplate('layout/' . $segment);
            $viewModel->addChild($header, $segment);
        }
    }
}
