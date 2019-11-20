<?php
namespace IMSGlobal\Caliper\entities\response;

use IMSGlobal\Caliper;

class ResponseType extends Caliper\util\BasicEnum implements Caliper\entities\Type {
    const
        DATE_TIME = 'DateTimeResponse',
        FILLINBLANK = 'FillinBlankResponse',
        MULTIPLECHOICE = 'MultipleChoiceResponse',
        MULTIPLERESPONSE = 'MultipleResponseResponse',
        MULTISELECT = 'MultiselectResponse',
        OPEN_ENDED = 'OpenEndedResponse',
        RATING_SCALE = 'RatingScaleResponse',
        SELECTTEXT = 'SelectTextResponse',
        TRUEFALSE = 'TrueFalseResponse';
}