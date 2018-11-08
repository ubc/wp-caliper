<?php
require_once 'CaliperTestCase.php';

use IMSGlobal\Caliper\entities\agent\Person;
use IMSGlobal\Caliper\entities\lis\CourseOffering;
use IMSGlobal\Caliper\entities\lis\CourseSection;
use IMSGlobal\Caliper\entities\lis\Membership;
use IMSGlobal\Caliper\entities\lis\Role;
use IMSGlobal\Caliper\entities\lis\Status;


/**
 * @requires PHP 5.6.28
 */
class EntityMembershipTest extends CaliperTestCase {
    function setUp() {
        parent::setUp();


        $this->setTestObject(
            (new Membership('https://example.edu/terms/201601/courses/7/sections/1/rosters/1/members/554433'))
                ->setMember(
                    (new Person('https://example.edu/users/554433'))
                )
                ->setOrganization(
                    (new CourseSection('https://example.edu/terms/201601/courses/7/sections/1'))
                        ->setSubOrganizationOf(
                            (new CourseOffering('https://example.edu/terms/201601/courses/7'))
                        )
                )
                ->setRoles(
                    [new Role(Role::LEARNER)])
                ->setStatus(
                    new Status(Status::ACTIVE))
                ->setDateCreated(
                    new \DateTime('2016-11-01T06:00:00.000Z'))
        );
    }
}
