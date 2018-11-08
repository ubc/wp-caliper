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
use IMSGlobal\Caliper\entities\media\MediaLocation;
use IMSGlobal\Caliper\entities\media\VideoObject;
use IMSGlobal\Caliper\entities\session\Session;
use IMSGlobal\Caliper\events\MediaEvent;


/**
 * @requires PHP 5.6.28
 */
class EventMediaPausedVideoTest extends CaliperTestCase {
    function setUp() {
        parent::setUp();


        $this->setTestObject(
            (new MediaEvent('urn:uuid:956b4a02-8de0-4991-b8c5-b6eebb6b4cab'))
                ->setActor(
                    (new Person('https://example.edu/users/554433'))
                )
                ->setAction(
                    new Action(Action::PAUSED))
                ->setObject(
                    (new VideoObject('https://example.edu/UQVK-dsU7-Y'))
                        ->setName(
                            'Information and Welcome'
                        )
                        ->setMediaType(
                            'video/ogg'
                        )
                        ->setDuration(
                            'PT20M20S'
                        )
                )
                ->setTarget(
                    (new MediaLocation('https://example.edu/UQVK-dsU7-Y?t=321'))
                        ->setCurrentTime(
                            'PT05M21S'
                        )
                )
                ->setEventTime(
                    new \DateTime('2016-11-15T10:15:00.000Z'))
                ->setEdApp(
                    (new SoftwareApplication('https://example.edu/player'))->makeReference())
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
