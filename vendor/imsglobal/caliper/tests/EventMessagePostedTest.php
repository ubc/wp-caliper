<?php
require_once 'CaliperTestCase.php';

use IMSGlobal\Caliper\actions\Action;
use IMSGlobal\Caliper\entities\agent\Organization;
use IMSGlobal\Caliper\entities\agent\Person;
use IMSGlobal\Caliper\entities\agent\SoftwareApplication;
use IMSGlobal\Caliper\entities\Forum;
use IMSGlobal\Caliper\entities\lis\CourseSection;
use IMSGlobal\Caliper\entities\lis\Membership;
use IMSGlobal\Caliper\entities\lis\Role;
use IMSGlobal\Caliper\entities\lis\Status;
use IMSGlobal\Caliper\entities\Message;
use IMSGlobal\Caliper\entities\session\Session;
use IMSGlobal\Caliper\entities\Thread;
use IMSGlobal\Caliper\events\MessageEvent;


/**
 * @requires PHP 5.6.28
 */
class EventMessagePostedTest extends CaliperTestCase {
    function setUp() {
        parent::setUp();


        $this->setTestObject(
            (new MessageEvent('urn:uuid:0d015a85-abf5-49ee-abb1-46dbd57fe64e'))
                ->setActor(
                    (new Person('https://example.edu/users/554433'))
                )
                ->setAction(
                    new Action(Action::POSTED))
                ->setObject(
                    (new Message('https://example.edu/terms/201601/courses/7/sections/1/forums/2/topics/1/messages/2'))
                        ->setCreators(
                            [
                                (new Person('https://example.edu/users/554433'))
                                ,
                            ]
                        )
                        ->setBody(
                            'Are the Caliper Sensor reference implementations production-ready?'
                        )
                        ->setIsPartOf(
                            (new Thread('https://example.edu/terms/201601/courses/7/sections/1/forums/2/topics/1'))
                                ->setName(
                                    'Caliper Adoption'
                                )
                                ->setIsPartOf(
                                    (new Forum('https://example.edu/terms/201601/courses/7/sections/1/forums/2'))
                                        ->setName(
                                            'Caliper Forum'
                                        )
                                )
                        )
                        ->setDateCreated(
                            new \DateTime('2016-11-15T10:15:00.000Z'))
                )
                ->setEventTime(
                    new \DateTime('2016-11-15T10:15:00.000Z'))
                ->setEdApp(
                    (new SoftwareApplication('https://example.edu/forums'))
                        ->setVersion(
                            'v2'
                        )
                )
                ->setGroup(
                    (new CourseSection('https://example.edu/terms/201601/courses/7/sections/1'))
                        ->setCourseNumber(
                            'CPS 435-01'
                        )
                        ->setAcademicSession(
                            'Fall 2016'
                        )
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
                    (new Session('https://example.edu/sessions/1f6442a482de72ea6ad134943812bff564a76259'))
                        ->setStartedAtTime(
                            new \DateTime('2016-11-15T10:00:00.000Z'))
                )
        );
    }
}
