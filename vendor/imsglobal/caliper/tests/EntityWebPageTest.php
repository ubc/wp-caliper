<?php
require_once 'CaliperTestCase.php';

use IMSGlobal\Caliper\entities\lis\CourseSection;
use IMSGlobal\Caliper\entities\reading\WebPage;


/**
 * @requires PHP 5.6.28
 */
class EntityWebPageTest extends CaliperTestCase {
    function setUp() {
        parent::setUp();


        $this->setTestObject(
            (new WebPage('https://example.edu/terms/201601/courses/7/sections/1/pages/index.html'))
                ->setName(
                    'CPS 435-01 Landing Page'
                )
                ->setMediaType(
                    'text/html'
                )
                ->setIsPartOf(
                    (new CourseSection('https://example.edu/terms/201601/courses/7/sections/1'))
                        ->setCourseNumber(
                            'CPS 435-01'
                        )
                        ->setAcademicSession(
                            'Fall 2016'
                        )
                )
        );
    }
}
