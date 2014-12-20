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

use Zend\View\Helper\AbstractHelper;

/**
 * Bootstrap menu output
 *
 * Extends the normal navigation menu rendered html for Twitter Bootstrap menus
 *
 * @package    ZF2rapidLib
 */
class BootstrapMenu extends AbstractHelper
{
    /**
     * get rendered menu and adds drop down markup
     *
     * @param string $html rendered navigation
     * @param string $class css class to check for adding drop down
     *
     * @return string
     */
    public function __invoke($html, $class = 'toplevel')
    {
        $domDoc = new \DOMDocument('1.0', 'utf-8');
        $domDoc->loadXML('<?xml version="1.0" encoding="utf-8"?>' . $html);

        $xpath = new \DOMXPath($domDoc);

        foreach (
            $xpath->query('//a[starts-with(@class, "' . $class . '")]') as $item
        ) {
            $result = $xpath->query('../ul', $item);

            if ($result->length === 1) {
                $ul = $result->item(0);
                $ul->setAttribute('class', 'dropdown-menu');

                $li = $item->parentNode;
                $li->setAttribute('id', substr($item->getAttribute('href'), 1));

                if (($existingClass = $li->getAttribute('class')) !== '') {
                    $li->setAttribute('class', $existingClass . ' dropdown');
                } else {
                    $li->setAttribute('class', 'dropdown');
                }

                $item->setAttribute('data-toggle', 'dropdown');

                if (($existingClass = $item->getAttribute('class')) !== '') {
                    $item->setAttribute(
                        'class',
                        $item->getAttribute('class') . ' dropdown-toggle'
                    );
                } else {
                    $item->setAttribute('class', 'dropdown-toggle');
                }

                $space = $domDoc->createTextNode(' ');

                $item->appendChild($space);

                $caret = $domDoc->createElement('b', '');
                $caret->setAttribute('class', 'caret');

                $item->appendChild($caret);
            }
        }

        return $domDoc->saveXML(
            $xpath->query('/ul')->item(0), LIBXML_NOEMPTYTAG
        );
    }
}
