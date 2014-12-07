<?php
/**
 * ZF2rapid library
 *
 * @package    ZF2rapidLib
 * @link       https://github.com/ZFrapid/zf2rapid-library
 * @copyright  Copyright (c) 2014 Ralf Eggert
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 *
 * @todo       Move string concatenation to a widget view script
 */

/**
 * namespace definition and usage
 */
namespace ZF2rapidLib\View\Helper;

use Zend\Mvc\Controller\Plugin\FlashMessenger as ZendFlashMessenger;
use Zend\View\Helper\AbstractHelper;

/**
 * FlashMessenger view helper
 *
 * Outputs all messages from FlashMessenger in Bootstrap style
 *
 * @package    ZF2rapidLib
 */
class FlashMessenger extends AbstractHelper
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
        $allMessages = array(
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
        );

        // clear messages
        $this->flashMessenger->clearMessagesFromContainer();
        $this->flashMessenger->clearCurrentMessagesFromContainer();

        // initialize output
        $output = '';

        // loop through messages
        foreach ($allMessages as $groupKey => $groupMessages) {
            foreach ($groupMessages as $message) {
                $addClass = $groupKey == 'default' ? '' : 'alert-' . $groupKey;

                // create output
                $output .= '<div class="alert ' . $addClass . '">';
                $output .= '<button class="close" data-dismiss="alert" type="button">×</button>';
                $output .= '<h2>' . $message . '</h2>';
                $output .= '</div>';
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
