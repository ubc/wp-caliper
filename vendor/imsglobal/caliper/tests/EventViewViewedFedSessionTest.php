<?php
require_once 'CaliperTestCase.php';

use IMSGlobal\Caliper\actions\Action;
use IMSGlobal\Caliper\entities\agent\Organization;
use IMSGlobal\Caliper\entities\agent\Person;
use IMSGlobal\Caliper\entities\agent\SoftwareApplication;
use IMSGlobal\Caliper\entities\lis\CourseSection;
use IMSGlobal\Caliper\entities\lis\Membership;
use IMSGlobal\Caliper\entities\lis\Role;
use IMSGlobal\Caliper\entities\lis\Status;
use IMSGlobal\Caliper\entities\reading\Document;
use IMSGlobal\Caliper\entities\session\LtiSession;
use IMSGlobal\Caliper\entities\session\Session;
use IMSGlobal\Caliper\events\ViewEvent;


/**
 * @requires PHP 5.6.28
 */
class EventViewViewedFedSessionTest extends CaliperTestCase {
    function setUp() {
        parent::setUp();


        $this->setTestObject(
            (new ViewEvent('urn:uuid:4be6d29d-5728-44cd-8a8f-3d3f07e46b61'))
                ->setActor(
                    (new Person('https://example.edu/users/554433'))
                )
                ->setAction(
                    new Action(Action::VIEWED))
                ->setObject(
                    (new Document('https://example.com/lti/reader/202.epub'))
                        ->setName(
                            'Caliper Case Studies'
                        )
                        ->setMediaType(
                            'application/epub+zip'
                        )
                        ->setDateCreated(
                            new \DateTime('2016-08-01T09:00:00.000Z'))
                )
                ->setEventTime(
                    new \DateTime('2016-11-15T10:20:00.000Z'))
                ->setEdApp(
                    (new SoftwareApplication('https://example.com'))->makeReference())
                ->setGroup(
                    (new CourseSection('https://example.edu/terms/201601/courses/7/sections/1'))
                        ->setExtensions([
                            'edu_example_course_section_instructor' => 'https://example.edu/faculty/1234',
                        ])
                )
                ->setMembership(
                    (new Membership('https://example.edu/terms/201601/courses/7/sections/1/rosters/1'))
                        ->setMember(
                            (new Person('https://example.edu/users/554433'))->makeReference())
                        ->setOrganization(
                            (new Organization('https://example.edu/terms/201601/courses/7/sections/1'))->makeReference())
                        ->setRoles(
                            [new Role(Role::LEARNER)])
                        ->setStatus(
                            new Status(Status::ACTIVE))
                        ->setDateCreated(
                            new \DateTime('2016-08-01T06:00:00.000Z'))
                )
                ->setSession(
                    (new Session('https://example.com/sessions/c25fd3da-87fa-45f5-8875-b682113fa5ee'))
                        ->setDateCreated(
                            new \DateTime('2016-11-15T10:20:00.000Z'))
                        ->setStartedAtTime(
                            new \DateTime('2016-11-15T10:20:00.000Z'))
                )
                ->setFederatedSession(
                    (new LtiSession('urn:uuid:1c519ff7-3dfa-4764-be48-d2fb35a2925a'))
                        ->setUser(
                            (new Person('https://example.edu/users/554433'))->makeReference())
                        ->setMessageParameters(
                            [
                                'context_id' => '4f1a161f-59c3-43e5-be37-445ad09e3f76',
                                'context_type' => 'CourseSection',
                                'custom' => [
                                    'caliper_profile_url' => 'https://example.edu/lti/tc/cps',
                                    'caliper_session_id' => '1c519ff7-3dfa-4764-be48-d2fb35a2925a',
                                    'tool_consumer_instance_url' => 'https://example.edu',
                                ],
                                'ext' => [
                                    'edu_example_course_section' => 'https://example.edu/terms/201601/courses/7/sections/1',
                                    'edu_example_course_section_instructor' => 'https://example.edu/faculty/1234',
                                    'edu_example_course_section_learner' => 'https://example.edu/users/554433',
                                    'edu_example_course_section_roster' => 'https://example.edu/terms/201601/courses/7/sections/1/rosters/1',
                                ],
                                'lti_message_type' => 'basic-lti-launch-request',
                                'lti_version' => 'LTI-2p0',
                                'resource_link_id' => '6b37a950-42c9-4117-8f4f-03e6e5c88d24',
                                'roles' => [
                                    'Learner',
                                ],
                                'user_id' => '0ae836b9-7fc9-4060-006f-27b2066ac545',
                            ]
                        )
                        ->setDateCreated(
                            new \DateTime('2016-11-15T10:15:00.000Z'))
                        ->setStartedAtTime(
                            new \DateTime('2016-11-15T10:15:00.000Z'))
                )
        );
    }
}
