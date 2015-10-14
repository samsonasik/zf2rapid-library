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

use Zend\Mvc\Controller\Plugin\FlashMessenger as ZendFlashMessenger;
use Zend\View\Helper\AbstractHelper;
use Zend\View\Model\ViewModel;

/**
 * BootstrapFlashMessenger view helper
 *
 * Outputs all messages from FlashMessenger in Bootstrap style
 *
 * @package    ZF2rapidLib
 */
class BootstrapFlashMessenger extends AbstractHelper
{
    /**
     * FlashMessenger plugin
     *
     * @var ZendFlashMessenger
     */
    protected $flashMessenger;

    /**
     * Constructor
     *
     * @param  ZendFlashMessenger $flashMessenger
     */
    public function __construct(ZendFlashMessenger $flashMessenger)
    {
        $this->setFlashMessenger($flashMessenger);
    }

    /**
     * Outputs message depending on flag
     *
     * @return string
     */
    public function __invoke()
    {
        return $this;
    }

    /**
     * Outputs message depending on flag
     *
     * @return string
     */
    public function render()
    {
        // get messages
        $allMessages = [
            'danger'  => array_unique(
                array_merge(
                    $this->flashMessenger->getErrorMessages(),
                    $this->flashMessenger->getCurrentErrorMessages()
                )
            ),
            'success' => array_unique(
                array_merge(
                    $this->flashMessenger->getSuccessMessages(),
                    $this->flashMessenger->getCurrentSuccessMessages()
                )
            ),
            'warning' => array_unique(
                array_merge(
                    $this->flashMessenger->getWarningMessages(),
                    $this->flashMessenger->getCurrentWarningMessages()
                )
            ),
            'info'    => array_unique(
                array_merge(
                    $this->flashMessenger->getInfoMessages(),
                    $this->flashMessenger->getCurrentInfoMessages()
                )
            ),
            'default' => array_unique(
                array_merge(
                    $this->flashMessenger->getMessages(),
                    $this->flashMessenger->getCurrentMessages()
                )
            ),
        ];

        // clear messages
        $this->flashMessenger->clearMessagesFromContainer();
        $this->flashMessenger->clearCurrentMessagesFromContainer();

        // initialize output
        $output = '';

        // loop through messages
        foreach ($allMessages as $groupKey => $groupMessages) {
            foreach ($groupMessages as $message) {
                $addClass = $groupKey == 'default' ? '' : 'alert-' . $groupKey;

                // setup view model
                $viewModel = new ViewModel();
                $viewModel->setVariable('alertClass', $addClass);
                $viewModel->setVariable('alertMessage', $message);
                $viewModel->setTemplate('zf2rapid-library/widget/bootstrap-alert');

                // add rendered output
                $output .= $this->getView()->render($viewModel);
            }
        }

        // return output
        return $output . "\n";
    }

    /**
     * Sets FlashMessenger plugin
     *
     * @param  ZendFlashMessenger $flashMessenger
     *
     * @return AbstractHelper
     */
    public function setFlashMessenger(ZendFlashMessenger $flashMessenger = null)
    {
        $this->flashMessenger = $flashMessenger;

        return $this;
    }
}
