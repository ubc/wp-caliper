<?php
require_once 'CaliperTestCase.php';

use IMSGlobal\Caliper\profiles\Profile;
use IMSGlobal\Caliper\actions\Action;
use IMSGlobal\Caliper\entities\agent\Organization;
use IMSGlobal\Caliper\entities\agent\Person;
use IMSGlobal\Caliper\entities\agent\SoftwareApplication;
use IMSGlobal\Caliper\entities\measure\AggregateMeasureCollection;
use IMSGlobal\Caliper\entities\measure\AggregateMeasure;
use IMSGlobal\Caliper\entities\measure\Metric;
use IMSGlobal\Caliper\entities\lis\CourseOffering;
use IMSGlobal\Caliper\entities\lis\CourseSection;
use IMSGlobal\Caliper\entities\lis\Membership;
use IMSGlobal\Caliper\entities\lis\Role;
use IMSGlobal\Caliper\entities\lis\Status;
use IMSGlobal\Caliper\entities\session\Session;
use IMSGlobal\Caliper\events\ToolUseEvent;


/**
 * @requires PHP 5.6.28
 */
class EventToolUseUsedWithProgressTest extends CaliperTestCase {
    function setUp() {
        parent::setUp();


        $this->setTestObject(
            (new ToolUseEvent('urn:uuid:7e10e4f3-a0d8-4430-95bd-783ffae4d916'))
                ->setActor(
                    (new Person('https://example.edu/users/554433'))
                )
                ->setProfile(
                    new Profile(Profile::TOOL_USE))
                ->setAction(
                    new Action(Action::USED))
                ->setObject(
                    (new SoftwareApplication('https://example.edu'))
                )
                ->setEventTime(
                    new \DateTime('2019-11-15T10:15:00.000Z'))
                ->setEdApp(
                    (new SoftwareApplication('https://example.edu'))->makeReference())
                ->setGenerated(
                    (new AggregateMeasureCollection('urn:uuid:7e10e4f3-a0d8-4430-95bd-783ffae4d912'))
                        ->setItems(
                            [
                                (new AggregateMeasure('urn:uuid:21c3f9f2-a9ef-4f65-bf9a-0699ed85e2c7'))
                                    ->setMetric(new Metric(Metric::MINUTES_ON_TASK))
                                    ->setName('Minutes On Task')
                                    ->setMetricValue(873.0)
                                    ->setStartedAtTime(new \DateTime('2019-08-15T10:15:00.000Z'))
                                    ->setEndedAtTime(new \DateTime('2019-11-15T10:15:00.000Z'))
                                ,
                                (new AggregateMeasure('urn:uuid:c3ba4c01-1f17-46e0-85dd-1e366e6ebb81'))
                                    ->setMetric(new Metric(Metric::UNITS_COMPLETED))
                                    ->setName('Units Completed')
                                    ->setMetricValue(12.0)
                                    ->setMaxMetricValue(25.0)
                                    ->setStartedAtTime(new \DateTime('2019-08-15T10:15:00.000Z'))
                                    ->setEndedAtTime(new \DateTime('2019-11-15T10:15:00.000Z'))
                            ]
                        )
                )
                ->setGroup(
                    (new CourseSection('https://example.edu/terms/201601/courses/7/sections/1'))
                        ->setAcademicSession(
                            'Fall 2016'
                        )
                        ->setCourseNumber(
                            'CPS 435-01'
                        )
                        ->setName(
                            'CPS 435 Learning Analytics, Section 01'
                        )
                        ->setCategory(
                            'seminar'
                        )
                        ->setSubOrganizationOf(
                            (new CourseOffering('https://example.edu/terms/201601/courses/7'))
                                ->setCourseNumber(
                                    'CPS 435'
                                )
                        )
                        ->setDateCreated(
                            new \DateTime('2016-08-01T06:00:00.000Z'))
                )
                ->setMembership(
                    (new Membership('https://example.edu/terms/201601/courses/7/sections/1/rosters/1/members/554433'))
                        ->setMember(
                            (new Person('https://example.edu/users/554433'))
                        )
                        ->setOrganization(
                            (new CourseSection('https://example.edu/terms/201601/courses/7/sections/1'))
                                ->setSubOrganizationOf(
                                    (new CourseOffering('https://example.edu/terms/201601/courses/7'))
                                )
                        )
                        ->setRoles(
                            [new Role(Role::LEARNER)])
                        ->setStatus(
                            new Status(Status::ACTIVE))
                        ->setDateCreated(
                            new \DateTime('2016-11-01T06:00:00.000Z'))
                )
                ->setSession(
                    (new Session('https://example.edu/sessions/1f6442a482de72ea6ad134943812bff564a76259'))
                        ->setUser(
                            (new Person('https://example.edu/users/554433'))
                        )
                        ->setStartedAtTime(
                            new \DateTime('2016-09-15T10:00:00.000Z'))
                )
        );
    }
}
