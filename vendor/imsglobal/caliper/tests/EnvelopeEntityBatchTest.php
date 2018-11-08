<?php
use IMSGlobal\Caliper\entities\agent\Person;
use IMSGlobal\Caliper\entities\DigitalResourceCollection;
use IMSGlobal\Caliper\entities\lis\CourseOffering;
use IMSGlobal\Caliper\entities\lis\CourseSection;
use IMSGlobal\Caliper\entities\media\VideoObject;
use IMSGlobal\Caliper\entities\reading\Document;

require_once 'CaliperTestCase.php';


/**
 * @requires PHP 5.6.28
 */
class EnvelopeEntityBatchTest extends CaliperTestCase {
    function setUp() {
        parent::setUp();

        $this->setTestObject((new \IMSGlobal\Caliper\request\Envelope())
            ->setSensorId(new \IMSGlobal\Caliper\Sensor('https://example.edu/sensors/1'))
            ->setSendTime(new \DateTime('2016-11-15T11:05:01.000Z'))
            ->setData([
                (new Person('https://example.edu/users/554433'))
                    ->setDateCreated(new \DateTime('2016-08-01T06:00:00.000Z'))
                    ->setDateModified(new \DateTime('2016-09-02T11:30:00.000Z')),
                (new Document('https://example.edu/etexts/201.epub'))
                    ->setName('IMS Caliper Implementation Guide')
                    ->setCreators([
                        (new Person('https://example.edu/people/12345')),
                        (new Person('https://example.com/staff/56789')),
                    ])
                    ->setDateCreated(new \DateTime('2016-10-01T06:00:00.000Z'))
                    ->setVersion('1.1'),
                (new DigitalResourceCollection('https://example.edu/terms/201601/courses/7/sections/1/resources/2'))
                    ->setName('Video Collection')
                    ->setItems([
                        (new VideoObject('https://example.edu/videos/1225'))
                            ->setMediaType('video/ogg')
                            ->setName('Introduction to IMS Caliper')
                            ->setDateCreated(new \DateTime('2016-08-01T06:00:00.000Z'))
                            ->setDuration('PT1H12M27S')
                            ->setVersion('1.1'),
                        (new VideoObject('https://example.edu/videos/5629'))
                            ->setMediaType('video/ogg')
                            ->setName('IMS Caliper Activity Profiles')
                            ->setDateCreated(new \DateTime('2016-08-01T06:00:00.000Z'))
                            ->setDuration('PT55M13S')
                            ->setVersion('1.1.1'),
                    ])
                    ->setIsPartOf((new CourseSection('https://example.edu/terms/201601/courses/7/sections/1'))
                        ->setSubOrganizationOf(new CourseOffering('https://example.edu/terms/201601/courses/7'))
                    )
                    ->setDateCreated(new \DateTime('2016-08-01T06:00:00.000Z'))
                    ->setDateModified(new \DateTime('2016-09-02T11:30:00.000Z')),
            ])
        );
    }
}
