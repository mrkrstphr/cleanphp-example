<?php

namespace Application\View\Helper;

use Vnn\Keyper\Keyper;
use Zend\View\Helper\AbstractHelper;

/**
 * Class ValidationErrors
 * @package Application\View\Helper
 */
class ValidationErrors extends AbstractHelper
{
    /**
     * @param string $element
     * @return string
     */
    public function __invoke($element) {
        if ($errors = $this->getErrors($element)) {
            return '<div class="alert alert-danger">' .
            implode('. ', $errors) .
            '</div>';
        }

        return '';
    }

    /**
     * @param string $element
     * @return null|array
     */
    protected function getErrors($element)
    {
        if (!isset($this->getView()->errors)) {
            return false;
        }

        $errors = Keyper::create($this->getView()->errors);

        return $errors->get($element) ?: false;
    }
}
