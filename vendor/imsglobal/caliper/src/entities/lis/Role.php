<?php
namespace IMSGlobal\Caliper\entities\lis;

use IMSGlobal\Caliper;

class Role extends Caliper\util\BasicEnum implements Caliper\entities\w3c\Role {
    const
        __default = '',
        LEARNER = 'Learner',
        EXTERNAL_LEARNER = 'Learner#ExternalLearner',
        GUEST_LEARNER = 'Learner#GuestLearner',
        LEARNER_INSTRUCTOR = 'Learner#Instructor',
        LEARNER_LEARNER = 'Learner#Learner',
        NONCREDIT_LEARNER = 'Learner#NonCreditLearner',

        INSTRUCTOR = 'Instructor',
        EXTERNAL_INSTRUCTOR = 'Instructor#ExternalInstructor',
        GUEST_INSTRUCTOR = 'Instructor#GuestInstructor',
        LECTURER = 'Instructor#Lecturer',
        PRIMARY_INSTRUCTOR = 'Instructor#PrimaryInstructor',

        ADMINISTRATOR = 'Administrator',
        ADMINISTRATOR_ADMINISTRATOR = 'Administrator#Administrator',
        ADMINISTRATOR_DEVELOPER = 'Administrator#Developer',
        ADMINISTRATOR_SUPPORT = 'Administrator#Support',
        ADMINISTRATOR_SYSTEM_ADMINISTRATOR = 'Administrator#SystemAdministrator',

        ADMINISTRATOR_EXTERNAL_DEVELOPER = 'Administrator#ExternalSupport',
        ADMINISTRATOR_EXTERNAL_SUPPORT = 'Administrator#ExternalDeveloper',
        ADMINISTRATOR_EXTERNAL_SYSTEM_ADMINISTRATOR = 'Administrator#ExternalSystemAdministrator',

        CONTENT_DEVELOPER = 'ContentDeveloper',
        CONTENT_DEVELOPER_CONTENT_DEVELOPER = 'ContentDeveloper#ContentDeveloper',
        CONTENT_DEVELOPER_LIBRARIAN = 'ContentDeveloper#Librarian',
        CONTENT_DEVELOPER_CONTENT_EXPERT = 'ContentDeveloper#ContentExpert',
        CONTENT_DEVELOPER_EXTERNAL_CONTENT_EXPERT = 'ContentDeveloper#ExternalContentExpert',

        MANAGER = 'Manager',
        MANAGER_AREA_MANAGER = 'Manager#AreaManager',
        MANAGER_COURSE_COORDINATOR = 'Manager#CourseCoordinator',
        MANAGER_OBSERVER = 'Manager#Observer',
        MANAGER_EXTERNAL_OBSERVER = 'Manager#ExternalObserver',

        MEMBER = 'Member',
        MEMBER_MEMBER = 'Member#Member',

        MENTOR = 'Mentor',
        MENTOR_MENTOR = 'Mentor#Mentor',
        MENTOR_ADVISOR = 'Mentor#Advisor',
        MENTOR_AUDITOR = 'Mentor#Auditor',
        MENTOR_REVIEWER = 'Mentor#Reviewer',
        MENTOR_TUTOR = 'Mentor#Tutor',
        MENTOR_LEARNING_FACILITATOR = 'Mentor#LearningFacilitator',

        MENTOR_EXTERNAL_MENTOR = 'Mentor#ExternalMentor',
        MENTOR_EXTERNAL_ADVISOR = 'Mentor#ExternalAdvisor',
        MENTOR_EXTERNAL_AUDITOR = 'Mentor#ExternalAuditor',
        MENTOR_EXTERNAL_REVIEWER = 'Mentor#ExternalReviewer',
        MENTOR_EXTERNAL_TUTOR = 'Mentor#ExternalTutor',
        MENTOR_EXTERNAL_LEARNING_FACILITATOR = 'Mentor/ExternalLearningFacilitator',

        TEACHING_ASSISTANT = 'TeachingAssistant',
        TEACHING_ASSISTANT_TEACHING_ASSISTANT = 'TeachingAssistant#TeachingAssistant',
        TEACHING_ASSISTANT_GRADER = 'TeachingAssistant#Grader',
        TEACHING_ASSISTANT_TEACHING_ASSISTANT_SECTION = 'TeachingAssistant#TeachingAssistantSection',
        TEACHING_ASSISTANT_TEACHING_ASSISTANT_SECTION_ASSOCIATION = 'TeachingAssistant#TeachingAssistantSectionAssociation',
        TEACHING_ASSISTANT_TEACHING_ASSISTANT_OFFERING = 'TeachingAssistant#TeachingAssistantOffering',
        TEACHING_ASSISTANT_TEACHING_ASSISTANT_TEMPLATE = 'TeachingAssistant#TeachingAssistantTemplate',
        TEACHING_ASSISTANT_TEACHING_ASSISTANT_GROUP = 'TeachingAssistant#TeachingAssistantGroup';
}
