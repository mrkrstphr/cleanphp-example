<?php

namespace Application\View\Helper;

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
     * @return bool|array
     */
    protected function getErrors($element)
    {
        if (!isset($this->getView()->errors)) {
            return false;
        }

        $errors = $this->getView()->errors;

        if (isset($errors[$element])) {
            return $errors[$element];
        }

        return false;
    }
}
