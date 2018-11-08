<?php
namespace IMSGlobal\Caliper\entities\assignable;

use IMSGlobal\Caliper;

class AssignableDigitalResourceType extends Caliper\util\BasicEnum implements Caliper\entities\Type {
    const
        __default = '',
        ASSESSMENT = 'Assessment',
        ASSESSMENT_ITEM = 'AssessmentItem';
}