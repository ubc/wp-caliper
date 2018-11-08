<?php
require_once 'CaliperTestCase.php';

use IMSGlobal\Caliper\entities\agent\Person;
use IMSGlobal\Caliper\entities\annotation\TagAnnotation;
use IMSGlobal\Caliper\entities\Page;


/**
 * @requires PHP 5.6.28
 */
class EntityTagAnnotationTest extends CaliperTestCase {
    function setUp() {
        parent::setUp();


        $this->setTestObject(
            (new TagAnnotation('https://example.com/users/554433/texts/imscaliperimplguide/tags/3'))
                ->setAnnotator(
                    (new Person('https://example.edu/users/554433'))
                )
                ->setAnnotated(
                    (new Page('https://example.com/#/texts/imscaliperimplguide/cfi/6/10!/4/2/2/2@0:0'))
                )
                ->setTags(
                    [
                        'profile'
                        ,
                        'event'
                        ,
                        'entity'
                        ,
                    ]
                )
                ->setDateCreated(
                    new \DateTime('2016-08-01T09:00:00.000Z'))
        );
    }
}
