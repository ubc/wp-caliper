<?php
require_once 'CaliperTestCase.php';

use IMSGlobal\Caliper\entities\agent\Person;
use IMSGlobal\Caliper\entities\annotation\BookmarkAnnotation;
use IMSGlobal\Caliper\entities\Page;


/**
 * @requires PHP 5.6.28
 */
class EntityBookmarkAnnotationTest extends CaliperTestCase {
    function setUp() {
        parent::setUp();


        $this->setTestObject(
            (new BookmarkAnnotation('https://example.com/users/554433/texts/imscaliperimplguide/bookmarks/1'))
                ->setAnnotator(
                    (new Person('https://example.edu/users/554433'))
                )
                ->setAnnotated(
                    (new Page('https://example.com/#/texts/imscaliperimplguide/cfi/6/10!/4/2/2/2@0:0'))
                )
                ->setBookmarkNotes(
                    'Caliper profiles model discrete learning activities or supporting activities that facilitate learning.'
                )
                ->setDateCreated(
                    new \DateTime('2016-08-01T06:00:00.000Z'))
        );
    }
}
