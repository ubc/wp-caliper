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
class EventMessageRepliedTest extends CaliperTestCase {
    function setUp() {
        parent::setUp();


        $this->setTestObject(
            (new MessageEvent('urn:uuid:aed54386-a3fb-45ff-90f9-a35d3daaf031'))
                ->setActor(
                    (new Person('https://example.edu/users/778899'))
                )
                ->setAction(
                    new Action(Action::POSTED))
                ->setObject(
                    (new Message('https://example.edu/terms/201601/courses/7/sections/1/forums/2/topics/1/messages/3'))
                        ->setCreators(
                            [
                                (new Person('https://example.edu/users/778899'))
                                ,
                            ]
                        )
                        ->setReplyTo(
                            (new Message('https://example.edu/terms/201601/courses/7/sections/1/forums/2/topics/1/messages/2'))
                        )
                        ->setIsPartOf(
                            (new Thread('https://example.edu/terms/201601/courses/7/sections/1/forums/2/topics/1'))
                                ->setIsPartOf(
                                    (new Forum('https://example.edu/terms/201601/courses/7/sections/1/forums/2'))
                                )
                        )
                        ->setDateCreated(
                            new \DateTime('2016-11-15T10:15:30.000Z'))
                )
                ->setEventTime(
                    new \DateTime('2016-11-15T10:15:30.000Z'))
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
                            (new Person('https://example.edu/users/778899'))->makeReference())
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
                    (new Session('https://example.edu/sessions/1d6fa9adf16f4892650e4305f6cf16610905cd50'))
                        ->setStartedAtTime(
                            new \DateTime('2016-11-15T10:12:00.000Z'))
                )
        );
    }
}
