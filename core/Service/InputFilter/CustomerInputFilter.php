<?php

namespace CleanPhp\Invoicer\Service\InputFilter;

use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;
use Zend\Validator\EmailAddress;

/**
 * Class CustomerInputFilter
 * @package CleanPhp\Invoicer\Service\InputFilter
 */
class CustomerInputFilter extends InputFilter
{
    /**
     * Set us up the class!
     */
    public function __construct() {
        $name = (new Input('name'))
            ->setRequired(true);

        $email = (new Input('email'))
            ->setRequired(true);
        $email->getValidatorChain()->attach(
            new EmailAddress()
        );

        $this->add($name);
        $this->add($email);
    }
}
