<?php
require_once 'CaliperTestCase.php';

use IMSGlobal\Caliper\entities\Page;
use IMSGlobal\Caliper\entities\reading\Chapter;
use IMSGlobal\Caliper\entities\reading\Document;


/**
 * @requires PHP 5.6.28
 */
class EntityPageTest extends CaliperTestCase {
    function setUp() {
        parent::setUp();


        $this->setTestObject(
            (new Page('https://example.com/#/texts/imscaliperimplguide/cfi/6/10!/4/2/2/2@0:0'))
                ->setName(
                    'Page 5'
                )
                ->setIsPartOf(
                    (new Chapter('https://example.com/#/texts/imscaliperimplguide/cfi/6/10'))
                        ->setName(
                            'Chapter 1'
                        )
                        ->setIsPartOf(
                            (new Document('https://example.com/#/texts/imscaliperimplguide'))
                                ->setName(
                                    'IMS Caliper Implementation Guide'
                                )
                                ->setDateCreated(
                                    new \DateTime('2016-10-01T06:00:00.000Z'))
                                ->setVersion(
                                    '1.1'
                                )
                        )
                )
        );
    }
}
