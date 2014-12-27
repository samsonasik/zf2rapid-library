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

use Zend\Form\Element\Button;
use Zend\Form\Element\Checkbox;
use Zend\Form\Element\Csrf;
use Zend\Form\Element\Hidden;
use Zend\Form\Element\Submit;
use Zend\Form\FormInterface;
use Zend\View\Helper\AbstractHelper;
use Zend\View\Model\ViewModel;

/**
 * Bootstrap form output
 *
 * Render a form in Twitter Bootstrap style
 *
 * @package    ZF2rapidLib
 */
class BootstrapForm extends AbstractHelper
{
    /**
     * Outputs message depending on flag
     *
     * @return string
     */
    public function __invoke(
        FormInterface $form, $class = 'form-horizontal'
    ) {
        $submitElements = array();

        $form->setAttribute('class', $class . ' well');
        $form->setAttribute('role', 'form');
        $form->prepare();

        $output = $this->getView()->form()->openTag($form);

        foreach ($form as $element) {
            if ($element instanceof Submit || $element instanceof Button) {
                $submitElements[] = $element;
            } elseif ($element instanceof Csrf || $element instanceof Hidden) {
                $output .= $this->getView()->formElement($element);
            } elseif ($element instanceof Checkbox) {
                // setup view model
                $viewModel = new ViewModel();
                $viewModel->setVariable('element', $element);
                $viewModel->setTemplate(
                    'zf2rapid-library/widget/bootstrap-form-checkbox'
                );

                // render form element
                $output .= $this->getView()->render($viewModel);
            } else {
                $element->setAttributes(array('class' => 'form-control'));
                $element->setLabelAttributes(
                    array('class' => 'col-sm-2 control-label')
                );

                // setup view model
                $viewModel = new ViewModel();
                $viewModel->setVariable('element', $element);
                $viewModel->setTemplate(
                    'zf2rapid-library/widget/bootstrap-form-group'
                );

                // render form element
                $output .= $this->getView()->render($viewModel);
            }
        }


        // setup view model
        $viewModel = new ViewModel();
        $viewModel->setVariable('submitElements', $submitElements);
        $viewModel->setTemplate(
            'zf2rapid-library/widget/bootstrap-form-submit'
        );

        // render submit elements
        $output .= $this->getView()->render($viewModel);

        $output .= $this->getView()->form()->closeTag();

        return $output;
    }
}
