<?php
namespace IMSGlobal\Caliper\events;

class EventType extends \IMSGlobal\Caliper\util\BasicEnum {
    const
        __default = '',
        ANNOTATION = 'AnnotationEvent',
        ASSESSMENT = 'AssessmentEvent',
        ASSESSMENT_ITEM = 'AssessmentItemEvent',
        ASSIGNABLE = 'AssignableEvent',
        EVENT = 'Event',
        FORUM = 'ForumEvent',
        MEDIA = 'MediaEvent',
        MESSAGE = 'MessageEvent',
        NAVIGATION = 'NavigationEvent',
        GRADE = 'GradeEvent',
        SESSION = 'SessionEvent',
        THREAD = 'ThreadEvent',
        TOOL_USE = 'ToolUseEvent',
        VIEW = 'ViewEvent';
}

