<?php
require_once 'CaliperTestCase.php';

use IMSGlobal\Caliper\entities\agent\Person;
use IMSGlobal\Caliper\entities\lis\CourseOffering;
use IMSGlobal\Caliper\entities\lis\CourseSection;
use IMSGlobal\Caliper\entities\lis\Group;


/**
 * @requires PHP 5.6.28
 */
class EntityGroupTest extends CaliperTestCase {
    function setUp() {
        parent::setUp();


        $this->setTestObject(
            (new Group('https://example.edu/terms/201601/courses/7/sections/1/groups/2'))
                ->setName(
                    'Discussion Group 2'
                )
                ->setSubOrganizationOf(
                    (new CourseSection('https://example.edu/terms/201601/courses/7/sections/1'))
                        ->setSubOrganizationOf(
                            (new CourseOffering('https://example.edu/terms/201601/courses/7'))
                        )
                )
                ->setMembers(
                    [
                        (new Person('https://example.edu/users/554433'))
                        ,
                        (new Person('https://example.edu/users/778899'))
                        ,
                        (new Person('https://example.edu/users/445566'))
                        ,
                        (new Person('https://example.edu/users/667788'))
                        ,
                        (new Person('https://example.edu/users/889900'))
                        ,
                    ]
                )
                ->setDateCreated(
                    new \DateTime('2016-11-01T06:00:00.000Z'))
        );
    }
}
