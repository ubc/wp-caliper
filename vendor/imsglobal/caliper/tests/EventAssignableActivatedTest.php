<?php
require_once 'CaliperTestCase.php';

use IMSGlobal\Caliper\actions\Action;
use IMSGlobal\Caliper\entities\agent\Organization;
use IMSGlobal\Caliper\entities\agent\Person;
use IMSGlobal\Caliper\entities\agent\SoftwareApplication;
use IMSGlobal\Caliper\entities\assessment\Assessment;
use IMSGlobal\Caliper\entities\lis\CourseSection;
use IMSGlobal\Caliper\entities\lis\Membership;
use IMSGlobal\Caliper\entities\lis\Role;
use IMSGlobal\Caliper\entities\lis\Status;
use IMSGlobal\Caliper\entities\session\Session;
use IMSGlobal\Caliper\events\AssignableEvent;


/**
 * @requires PHP 5.6.28
 */
class EventAssignableActivatedTest extends CaliperTestCase {
    function setUp() {
        parent::setUp();


        $this->setTestObject(
            (new AssignableEvent('urn:uuid:2635b9dd-0061-4059-ac61-2718ab366f75'))
                ->setActor(
                    (new Person('https://example.edu/users/112233'))
                )
                ->setAction(
                    new Action(Action::ACTIVATED))
                ->setObject(
                    (new Assessment('https://example.edu/terms/201601/courses/7/sections/1/assess/1'))
                        ->setName(
                            'Quiz One'
                        )
                        ->setDateCreated(
                            new \DateTime('2016-08-01T06:00:00.000Z'))
                        ->setDateModified(
                            new \DateTime('2016-09-02T11:30:00.000Z'))
                        ->setDatePublished(
                            new \DateTime('2016-11-12T10:10:00.000Z'))
                        ->setDateToActivate(
                            new \DateTime('2016-11-12T10:15:00.000Z'))
                        ->setDateToStartOn(
                            new \DateTime('2016-11-14T05:00:00.000Z'))
                        ->setDateToSubmit(
                            new \DateTime('2016-11-18T11:59:59.000Z'))
                        ->setMaxAttempts(
                            2
                        )
                        ->setMaxSubmits(
                            2
                        )
                        ->setMaxScore(
                            25.0
                        )
                        ->setVersion(
                            '1.0'
                        )
                )
                ->setEventTime(
                    new \DateTime('2016-11-12T10:15:00.000Z'))
                ->setEdApp(
                    (new SoftwareApplication('https://example.edu'))
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
                            (new Person('https://example.edu/users/112233'))->makeReference())
                        ->setOrganization(
                            (new Organization('https://example.edu/terms/201601/courses/7/sections/1'))->makeReference())
                        ->setRoles(
                            [new Role(Role::INSTRUCTOR)])
                        ->setStatus(
                            new Status(Status::ACTIVE))
                        ->setDateCreated(
                            new \DateTime('2016-08-01T06:00:00.000Z'))
                )
                ->setSession(
                    (new Session('https://example.edu/sessions/f095bbd391ea4a5dd639724a40b606e98a631823'))
                        ->setStartedAtTime(
                            new \DateTime('2016-11-12T10:00:00.000Z'))
                )
        );
    }
}
