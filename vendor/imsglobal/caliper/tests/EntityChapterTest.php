<?php
require_once 'CaliperTestCase.php';

use IMSGlobal\Caliper\entities\reading\Chapter;
use IMSGlobal\Caliper\entities\reading\Document;


/**
 * @requires PHP 5.6.28
 */
class EntityChapterTest extends CaliperTestCase {
    function setUp() {
        parent::setUp();


        $this->setTestObject(
            (new Chapter('https://example.com/#/texts/imscaliperimplguide/cfi/6/10'))
                ->setName(
                    'The Caliper Information Model'
                )
                ->setIsPartOf(
                    (new Document('https://example.com/#/texts/imscaliperimplguide'))
                        ->setDateCreated(
                            new \DateTime('2016-10-01T06:00:00.000Z'))
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
