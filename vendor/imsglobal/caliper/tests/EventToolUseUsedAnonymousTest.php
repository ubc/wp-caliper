<?php
require_once 'CaliperTestCase.php';

use IMSGlobal\Caliper\profiles\Profile;
use IMSGlobal\Caliper\actions\Action;
use IMSGlobal\Caliper\entities\agent\Organization;
use IMSGlobal\Caliper\entities\agent\Person;
use IMSGlobal\Caliper\entities\agent\SoftwareApplication;
use IMSGlobal\Caliper\entities\lis\CourseSection;
use IMSGlobal\Caliper\entities\lis\Membership;
use IMSGlobal\Caliper\entities\lis\Role;
use IMSGlobal\Caliper\entities\lis\Status;
use IMSGlobal\Caliper\entities\session\Session;
use IMSGlobal\Caliper\events\ToolUseEvent;


/**
 * @requires PHP 5.6.28
 */
class EventToolUseUsedAnonymousTest extends CaliperTestCase {
    function setUp() {
        parent::setUp();


        $this->setTestObject(
            (new ToolUseEvent('urn:uuid:7c0fc54b-cf2a-426f-9203-b2c97fb77bfd'))
                ->setActor(
                    Person::makeAnonymous()
                )
                ->setProfile(
                    new Profile(Profile::TOOL_USE))
                ->setAction(
                    new Action(Action::USED))
                ->setObject(
                    (new SoftwareApplication('https://example.edu'))
                )
                ->setEventTime(
                    new \DateTime('2018-11-15T10:15:00.000Z'))
                ->setEdApp(
                    (new SoftwareApplication('https://example.edu'))->makeReference())
                ->setGroup(
                    CourseSection::makeAnonymous()
                )
                ->setMembership(
                    Membership::makeAnonymous()
                        ->setMember(Person::makeAnonymous())
                        ->setOrganization(CourseSection::makeAnonymous())
                        ->setRoles(
                            [new Role(Role::LEARNER)])
                        ->setStatus(
                            new Status(Status::ACTIVE))
                )
        );
    }
}
