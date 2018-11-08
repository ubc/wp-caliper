<?php

use IMSGlobal\Caliper\actions\Action;
use IMSGlobal\Caliper\entities\agent\Organization;
use IMSGlobal\Caliper\entities\agent\Person;
use IMSGlobal\Caliper\entities\agent\SoftwareApplication;
use IMSGlobal\Caliper\entities\assessment\Assessment;
use IMSGlobal\Caliper\entities\assignable\Attempt;
use IMSGlobal\Caliper\entities\DigitalResource;
use IMSGlobal\Caliper\entities\lis\CourseSection;
use IMSGlobal\Caliper\entities\lis\Membership;
use IMSGlobal\Caliper\entities\lis\Role;
use IMSGlobal\Caliper\entities\lis\Status;
use IMSGlobal\Caliper\entities\session\Session;
use IMSGlobal\Caliper\events\AssessmentEvent;
use IMSGlobal\Caliper\Sensor;

require_once 'CaliperTestCase.php';

/**
 * @requires PHP 5.6.28
 */
class EnvelopeEventSingleTest extends CaliperTestCase {
    function setUp() {
        parent::setUp();

        $this->setTestObject((new \IMSGlobal\Caliper\request\Envelope())
            ->setSensorId(new Sensor('https://example.edu/sensors/1'))
            ->setSendTime(new \DateTime('2016-11-15T11:05:01.000Z'))
            ->setData([
                (new AssessmentEvent())
                    ->setActor((new Person('https://example.edu/users/554433'))
                    )
                    ->setAction(new Action(Action::STARTED))
                    ->setEdApp((new SoftwareApplication('https://example.edu'))
                        ->setVersion('v2')
                    )
                    ->setEventTime(new \DateTime('2016-11-15T10:15:00.000Z'))
                    ->setGenerated((new Attempt('https://example.edu/terms/201601/courses/7/sections/1/assess/1/users/554433/attempts/1'))
                        ->setAssignable((new DigitalResource('https://example.edu/terms/201601/courses/7/sections/1/assess/1'))->makeReference())
                        ->setAssignee(((new Person('https://example.edu/users/554433'))->makeReference())
                        )
                        ->setCount(1)
                        ->setDateCreated(new \DateTime('2016-11-15T10:15:00.000Z'))
                        ->setStartedAtTime(new \DateTime('2016-11-15T10:15:00.000Z'))
                    )
                    ->setGroup((new CourseSection('https://example.edu/terms/201601/courses/7/sections/1'))
                        ->setAcademicSession('Fall 2016')
                        ->setCourseNumber('CPS 435-01')
                    )
                    ->setMembership((new Membership('https://example.edu/terms/201601/courses/7/sections/1/rosters/1'))
                        ->setDateCreated(new \DateTime('2016-08-01T06:00:00.000Z'))
                        ->setMember(((new Person('https://example.edu/users/554433'))->makeReference())
                        )
                        ->setOrganization((new Organization('https://example.edu/terms/201601/courses/7/sections/1'))->makeReference())
                        ->setRoles(new Role(Role::LEARNER))
                        ->setStatus(new Status(Status::ACTIVE))
                    )
                    ->setObject((new Assessment('https://example.edu/terms/201601/courses/7/sections/1/assess/1'))
                        ->setDateToStartOn(new \DateTime('2016-11-14T05:00:00.000Z'))
                        ->setDateToSubmit(new \DateTime('2016-11-18T11:59:59.000Z'))
                        ->setMaxAttempts(2)
                        ->setMaxScore(25)
                        ->setMaxSubmits(2)
                        ->setName('Quiz One')
                        ->setVersion('1.0')
                    )
                    ->setSession((new Session('https://example.edu/sessions/1f6442a482de72ea6ad134943812bff564a76259'))
                        ->setStartedAtTime(new \DateTime('2016-11-15T10:00:00.000Z'))
                    )
                    ->setId('urn:uuid:c51570e4-f8ed-4c18-bb3a-dfe51b2cc594'),
            ])
        );
    }
}
