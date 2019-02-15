<?php
require_once 'CaliperTestCase.php';

use IMSGlobal\Caliper\entities\search\SearchResponse;
use IMSGlobal\Caliper\entities\search\Query;
use IMSGlobal\Caliper\entities\agent\Person;
use IMSGlobal\Caliper\entities\agent\SoftwareApplication;
use IMSGlobal\Caliper\entities\reading\Document;
use IMSGlobal\Caliper\entities\media\VideoObject;


/**
 * @requires PHP 5.6.28
 */
class EntitySearchResponseTest extends CaliperTestCase {
    function setUp() {
        parent::setUp();

        $this->setTestObject(
            (new SearchResponse('https://example.edu/users/554433/response?query=IMS%20AND%20%28Caliper%20OR%20Analytics%29'))
                ->setSearchProvider(
                    (new SoftwareApplication('https://example.edu'))
                )
                ->setSearchTarget(
                    (new SoftwareApplication('https://example.edu/catalog'))
                )
                ->setQuery(
                    (new Query('https://example.edu/users/554433/search?query=IMS%20AND%20%28Caliper%20OR%20Analytics%29'))
                        ->setCreator(
                            (new Person('https://example.edu/users/554433'))
                        )
                        ->setSearchTarget(
                            ((new SoftwareApplication('https://example.edu/catalog'))->makeReference())
                        )
                        ->setSearchTerms("IMS AND (Caliper OR Analytics)")
                        ->setDateCreated(
                            new \DateTime('2018-11-15T10:05:00.000Z'))
                )
                ->setSearchResultsItemCount(3)
                ->setSearchResults([
                    (new Document("https://example.edu/catalog/record/01234?query=IMS%20AND%20%28Caliper%20OR%20Analytics%29"))
                        ->setMediaType("application/pdf"),
                    (new VideoObject("https://example.edu/catalog/record/09876?query=IMS%20AND%20%28Caliper%20OR%20Analytics%29"))
                        ->setMediaType("video/ogg"),
                    (new Document("https://example.edu/catalog/record/05432?query=IMS%20AND%20%28Caliper%20OR%20Analytics%29"))
                        ->setMediaType("application/epub+zip")
                ])
                ->setDateCreated(
                    new \DateTime('2018-11-15T10:05:00.000Z'))
        );
    }
}
