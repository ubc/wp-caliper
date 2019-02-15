<?php
require_once 'CaliperTestCase.php';

use IMSGlobal\Caliper\actions\Action;
use IMSGlobal\Caliper\entities\agent\Organization;
use IMSGlobal\Caliper\entities\agent\Person;
use IMSGlobal\Caliper\entities\agent\SoftwareApplication;
use IMSGlobal\Caliper\entities\lis\CourseSection;
use IMSGlobal\Caliper\entities\lis\Membership;
use IMSGlobal\Caliper\entities\lis\Role;
use IMSGlobal\Caliper\entities\lis\Status;
use IMSGlobal\Caliper\entities\session\Session;
use IMSGlobal\Caliper\events\SearchEvent;
use IMSGlobal\Caliper\entities\search\SearchResponse;
use IMSGlobal\Caliper\entities\search\Query;


/**
 * @requires PHP 5.6.28
 */
class EventSearchSearchedTest extends CaliperTestCase {
    function setUp() {
        parent::setUp();

        $this->setTestObject(
            (new SearchEvent('urn:uuid:cb3878ed-8240-4c6d-9fee-77221810f5e4'))
                ->setActor(
                    (new Person('https://example.edu/users/554433'))
                )
                ->setAction(
                    new Action(Action::SEARCHED))
                ->setObject(
                    (new SoftwareApplication('https://example.edu/catalog'))
                )
                ->setGenerated(
                    (new SearchResponse('https://example.edu/users/554433/response?query=IMS%20AND%20%28Caliper%20OR%20Analytics%29'))
                        ->setSearchProvider(
                            ((new SoftwareApplication('https://example.edu'))->makeReference())
                        )
                        ->setSearchTarget(
                            ((new SoftwareApplication('https://example.edu/catalog'))->makeReference())
                        )
                        ->setQuery(
                            (new Query('https://example.edu/users/554433/search?query=IMS%20AND%20%28Caliper%20OR%20Analytics%29'))
                                ->setCreator(
                                    ((new Person('https://example.edu/users/554433'))->makeReference())
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
                            "https://example.edu/catalog/record/01234?query=IMS%20AND%20%28Caliper%20OR%20Analytics%29",
                            "https://example.edu/catalog/record/09876?query=IMS%20AND%20%28Caliper%20OR%20Analytics%29",
                            "https://example.edu/catalog/record/05432?query=IMS%20AND%20%28Caliper%20OR%20Analytics%29"
                        ])
                )
                ->setEventTime(
                    new \DateTime('2018-11-15T10:05:00.000Z'))
                ->setEdApp(
                    (new SoftwareApplication('https://example.edu'))->makeReference())
                ->setGroup(
                    (new CourseSection('https://example.edu/terms/201801/courses/7/sections/1'))
                        ->setCourseNumber(
                            'CPS 435-01'
                        )
                        ->setAcademicSession(
                            'Fall 2018'
                        )
                )
                ->setMembership(
                    (new Membership('https://example.edu/terms/201801/courses/7/sections/1/rosters/1'))
                        ->setMember(
                            (new Person('https://example.edu/users/554433'))->makeReference())
                        ->setOrganization(
                            (new Organization('https://example.edu/terms/201801/courses/7/sections/1'))->makeReference())
                        ->setRoles(
                            [new Role(Role::LEARNER)])
                        ->setStatus(
                            new Status(Status::ACTIVE))
                        ->setDateCreated(
                            new \DateTime('2018-08-01T06:00:00.000Z'))
                )
                ->setSession(
                    (new Session('https://example.edu/sessions/1f6442a482de72ea6ad134943812bff564a76259'))
                        ->setStartedAtTime(
                            new \DateTime('2018-11-15T10:00:00.000Z'))
                )
        );
    }
}
