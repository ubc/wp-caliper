<?php
require_once 'CaliperTestCase.php';

use IMSGlobal\Caliper\entities\reading\Document;
use IMSGlobal\Caliper\entities\reading\Frame;


/**
 * @requires PHP 5.6.28
 */
class EntityFrameTest extends CaliperTestCase {
    function setUp() {
        parent::setUp();


        $this->setTestObject(
            (new Frame('https://example.edu/etexts/201?index=2502'))
                ->setDateCreated(
                    new \DateTime('2016-08-01T06:00:00.000Z'))
                ->setIndex(
                    2502
                )
                ->setIsPartOf(
                    (new Document('https://example.edu/etexts/201'))
                        ->setName(
                            'IMS Caliper Implementation Guide'
                        )
                        ->setVersion(
                            '1.1'
                        )
                )
        );
    }
}
