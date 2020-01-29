<?php
namespace IMSGlobal\Caliper\entities\lis;

use IMSGlobal\Caliper;

class Role extends Caliper\util\BasicEnum implements Caliper\entities\w3c\Role {
    const
        __default = '',
        LEARNER = 'Learner',
        EXTERNAL_LEARNER = 'Learner#ExternalLearner',
        GUEST_LEARNER = 'Learner#GuestLearner',
        LEARNER_LEARNER = 'Learner#Learner',
        NONCREDIT_LEARNER = 'Learner#NonCreditLearner',

        INSTRUCTOR = 'Instructor',
        EXTERNAL_INSTRUCTOR = 'Instructor#ExternalInstructor',
        GRADER = 'Instructor#Grader',
        GUEST_INSTRUCTOR = 'Instructor#GuestInstructor',
        INSTRUCTOR_INSTRUCTOR = 'Instructor#Instructor',
        LECTURER = 'Instructor#Lecturer',
        PRIMARY_INSTRUCTOR = 'Instructor#PrimaryInstructor',
        SECONDARY_INSTRUCTOR = 'Instructor#SecondaryInstructor',
        TEACHING_ASSISTANT = 'Instructor#TeachingAssistant',
        TEACHING_ASSISTANT_GROUP = 'Instructor#TeachingAssistantGroup',
        TEACHING_ASSISTANT_OFFERING = 'Instructor#TeachingAssistantOffering',
        TEACHING_ASSISTANT_SECTION = 'Instructor#TeachingAssistantSection',
        TEACHING_ASSISTANT_TEMPLATE = 'Instructor#TeachingAssistantTemplate',

        ADMINISTRATOR = 'Administrator',
        ADMINISTRATOR_ADMINISTRATOR = 'Administrator#Administrator',
        ADMINISTRATOR_DEVELOPER = 'Administrator#Developer',
        ADMINISTRATOR_EXTERNAL_DEVELOPER = 'Administrator#ExternalSupport',
        ADMINISTRATOR_EXTERNAL_SUPPORT = 'Administrator#ExternalDeveloper',
        ADMINISTRATOR_EXTERNAL_SYSTEM_ADMINISTRATOR = 'Administrator#ExternalSystemAdministrator',
        ADMINISTRATOR_SUPPORT = 'Administrator#Support',
        ADMINISTRATOR_SYSTEM_ADMINISTRATOR = 'Administrator#SystemAdministrator',

        CONTENT_DEVELOPER = 'ContentDeveloper',
        CONTENT_DEVELOPER_CONTENT_DEVELOPER = 'ContentDeveloper#ContentDeveloper',
        CONTENT_DEVELOPER_CONTENT_EXPERT = 'ContentDeveloper#ContentExpert',
        CONTENT_DEVELOPER_EXTERNAL_CONTENT_EXPERT = 'ContentDeveloper#ExternalContentExpert',
        CONTENT_DEVELOPER_LIBRARIAN = 'ContentDeveloper#Librarian',

        MANAGER = 'Manager',
        MANAGER_AREA_MANAGER = 'Manager#AreaManager',
        MANAGER_COURSE_COORDINATOR = 'Manager#CourseCoordinator',
        MANAGER_OBSERVER = 'Manager#Observer',
        MANAGER_EXTERNAL_OBSERVER = 'Manager#ExternalObserver',

        MEMBER = 'Member',
        MEMBER_MEMBER = 'Member#Member',

        MENTOR = 'Mentor',
        MENTOR_ADVISOR = 'Mentor#Advisor',
        MENTOR_AUDITOR = 'Mentor#Auditor',
        MENTOR_EXTERNAL_ADVISOR = 'Mentor#ExternalAdvisor',
        MENTOR_EXTERNAL_AUDITOR = 'Mentor#ExternalAuditor',
        MENTOR_EXTERNAL_MENTOR = 'Mentor#ExternalMentor',
        MENTOR_EXTERNAL_REVIEWER = 'Mentor#ExternalReviewer',
        MENTOR_EXTERNAL_TUTOR = 'Mentor#ExternalTutor',
        MENTOR_EXTERNAL_LEARNING_FACILITATOR = 'Mentor#ExternalLearningFacilitator',
        MENTOR_LEARNING_FACILITATOR = 'Mentor#LearningFacilitator',
        MENTOR_MENTOR = 'Mentor#Mentor',
        MENTOR_REVIEWER = 'Mentor#Reviewer',
        MENTOR_TUTOR = 'Mentor#Tutor',

        OFFICER = 'Officer',
        OFFICER_CHAIR = 'Officer#Chair',
        OFFICER_SECRETARY = 'Officer#Secretary',
        OFFICER_TREASURER = 'Officer#Treasurer',
        OFFICER_VICE_CHAIR = 'Officer#Vice-Chair';
}
