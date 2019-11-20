<?php
require_once 'CaliperTestCase.php';

use IMSGlobal\Caliper\entities\agent\Person;
use IMSGlobal\Caliper\entities\annotation\Annotation;
use IMSGlobal\Caliper\entities\Page;

/**
 * @requires PHP 5.6.28
 */
class EntityAnnotationTest extends CaliperTestCase {
    function setUp() {
        parent::setUp();


        $this->setTestObject(
            (new Annotation('https://example.com/users/554433/texts/imscaliperimplguide/annotations/1'))
                ->setAnnotator((new Person('https://example.edu/users/554433')))
                ->setAnnotated((new Page('https://example.com/#/texts/imscaliperimplguide/cfi/6/10!/4/2/2/2@0:0')))
                ->setDateCreated(new \DateTime('2016-08-01T06:00:00.000Z'))
        );
    }
}



