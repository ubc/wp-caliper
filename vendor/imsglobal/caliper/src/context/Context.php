<?php
namespace IMSGlobal\Caliper\context;

class Context extends \IMSGlobal\Caliper\util\BasicEnum {
    const
        __default = '',
        CONTEXT = 'http://purl.imsglobal.org/ctx/caliper/v1p1';

    private $propertyName = '@context';

    public function getPropertyName() {
        return $this->propertyName;
    }
}

