<?php
namespace IMSGlobal\Caliper\entities\response;

use IMSGlobal\Caliper;

class ResponseType extends Caliper\util\BasicEnum implements Caliper\entities\Type {
    const
        FILLINBLANK = 'FillinBlankResponse',
        MULTIPLECHOICE = 'MultipleChoiceResponse',
        MULTIPLERESPONSE = 'MultipleResponseResponse',
        SELECTTEXT = 'SelectTextResponse',
        TRUEFALSE = 'TrueFalseResponse';
}