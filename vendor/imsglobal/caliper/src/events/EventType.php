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
        RESOURCE_MANAGEMENT = 'ResourceManagementEvent',
        SEARCH = 'SearchEvent',
        SESSION = 'SessionEvent',
        THREAD = 'ThreadEvent',
        TOOL_LAUNCH = 'ToolLaunchEvent',
        TOOL_USE = 'ToolUseEvent',
        VIEW = 'ViewEvent';
}

