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
        FEEDBACK = 'FeedbackEvent',
        FORUM = 'ForumEvent',
        MEDIA = 'MediaEvent',
        MESSAGE = 'MessageEvent',
        NAVIGATION = 'NavigationEvent',
        GRADE = 'GradeEvent',
        QUESTIONNAIRE = 'QuestionnaireEvent',
        QUESTIONNAIRE_ITEM = 'QuestionnaireItemEvent',
        RESOURCE_MANAGEMENT = 'ResourceManagementEvent',
        SEARCH = 'SearchEvent',
        SESSION = 'SessionEvent',
        SURVEY = 'SurveyEvent',
        SURVEY_INVITATION = 'SurveyInvitationEvent',
        THREAD = 'ThreadEvent',
        TOOL_LAUNCH = 'ToolLaunchEvent',
        TOOL_USE = 'ToolUseEvent',
        VIEW = 'ViewEvent';
}

