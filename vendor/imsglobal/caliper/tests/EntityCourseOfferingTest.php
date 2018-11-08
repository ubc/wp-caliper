<?php
require_once 'CaliperTestCase.php';

use IMSGlobal\Caliper\entities\lis\CourseOffering;


/**
 * @requires PHP 5.6.28
 */
class EntityCourseOfferingTest extends CaliperTestCase {
    function setUp() {
        parent::setUp();


        $this->setTestObject(
            (new CourseOffering('https://example.edu/terms/201601/courses/7'))
                ->setCourseNumber(
                    'CPS 435'
                )
                ->setAcademicSession(
                    'Fall 2016'
                )
                ->setName(
                    'CPS 435 Learning Analytics'
                )
                ->setDateCreated(
                    new \DateTime('2016-08-01T06:00:00.000Z'))
                ->setDateModified(
                    new \DateTime('2016-09-02T11:30:00.000Z'))
        );
    }
}
