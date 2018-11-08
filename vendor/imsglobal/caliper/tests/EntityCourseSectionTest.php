<?php
require_once 'CaliperTestCase.php';

use IMSGlobal\Caliper\entities\lis\CourseOffering;
use IMSGlobal\Caliper\entities\lis\CourseSection;


/**
 * @requires PHP 5.6.28
 */
class EntityCourseSectionTest extends CaliperTestCase {
    function setUp() {
        parent::setUp();


        $this->setTestObject(
            (new CourseSection('https://example.edu/terms/201601/courses/7/sections/1'))
                ->setAcademicSession(
                    'Fall 2016'
                )
                ->setCourseNumber(
                    'CPS 435-01'
                )
                ->setName(
                    'CPS 435 Learning Analytics, Section 01'
                )
                ->setCategory(
                    'seminar'
                )
                ->setSubOrganizationOf(
                    (new CourseOffering('https://example.edu/terms/201601/courses/7'))
                        ->setCourseNumber(
                            'CPS 435'
                        )
                )
                ->setDateCreated(
                    new \DateTime('2016-08-01T06:00:00.000Z'))
        );
    }
}
