<?php


namespace Enrise\Apigility\Workbench\Filter;


use Zend\InputFilter\InputFilter;

class ProxyInputFilter extends InputFilter
{
    public function __construct()
    {
        $this->add(
            array(
                'name'     => 'baseuri',
                'required' => true,
                'filters' => array(
                    array(
                        'name' => 'StringTrim'
                    )
                ),
                'validators' => array(
                    array(
                        'name' => 'Uri',
                        'allowRelative' => false
                    )
                )
            )
        );
        $this->add(
            array(
                'name'     => 'endpoint',
                'required' => true,
                'filters' => array(
                    array(
                        'name' => 'StringTrim'
                    )
                ),
                'validators' => array(
                    array(
                        'name' => 'Uri',
                        'allowAbsolute' => false,
                        'allowRelative' => true
                    )
                )
            )
        );
    }

} 
