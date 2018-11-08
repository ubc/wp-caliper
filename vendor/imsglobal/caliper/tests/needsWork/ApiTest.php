<?php
use IMSGlobal\Caliper\entities\lis\CourseSection;

/**
 * @requires PHP 5.6.28
 *
 * PHPUnit grouping
 * @group needsWork
 */
class ApiTest extends PHPUnit_Framework_TestCase {

    function setUp() {
        date_default_timezone_set('UTC');
        $this->markTestSkipped('TODO: Update these tests to use a testing server or mock their own.');
        IMSGlobal\Caliper\Sensor::init('testapiKey');
    }

    function testDescribe() {
        $this->markTestSkipped('Fix this test to not instantiate abstract class Entity()');
        // $caliperEntity = new IMSGlobal\Caliper\entities\Entity();
        $caliperEntity = (new CourseSection('_:course-1234'))
            ->setDateCreated(new \DateTime())
            ->setCategory('Engineering');

        $described = IMSGlobal\Caliper\Sensor::describe($caliperEntity);
        $this->assertTrue($described);
    }

    function testSend() {
        $caliperEvent = new IMSGlobal\Caliper\events\Event();
        $caliperEvent->setAction("HILIGHT");
        $caliperEvent->setLearningContext([
            "courseId" => "course-1234",
            "userId" => "user-1234",
        ]);

        $sent = IMSGlobal\Caliper\Sensor::send($caliperEvent);
        $this->assertTrue($sent);
    }
}
