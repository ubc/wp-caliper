<?php
require_once 'CaliperTestCase.php';

use IMSGlobal\Caliper\profiles\Profile;
use IMSGlobal\Caliper\actions\Action;
use IMSGlobal\Caliper\entities\agent\Organization;
use IMSGlobal\Caliper\entities\agent\Person;
use IMSGlobal\Caliper\entities\agent\SoftwareApplication;
use IMSGlobal\Caliper\entities\lis\CourseSection;
use IMSGlobal\Caliper\entities\lis\Membership;
use IMSGlobal\Caliper\entities\lis\Role;
use IMSGlobal\Caliper\entities\lis\Status;
use IMSGlobal\Caliper\entities\survey\QuestionnaireItem;
use IMSGlobal\Caliper\entities\question\RatingScaleQuestion;
use IMSGlobal\Caliper\entities\scale\LikertScale;
use IMSGlobal\Caliper\entities\session\Session;
use IMSGlobal\Caliper\events\QuestionnaireItemEvent;


/**
 * @requires PHP 5.6.28
 */
class EventQuestionnaireItemStartedTest extends CaliperTestCase {
    function setUp() {
        parent::setUp();


        $this->setTestObject(
            (new QuestionnaireItemEvent('urn:uuid:23995ed4-3c6b-11e9-b210-d663bd873d93'))
                ->setActor(
                    (new Person('https://example.edu/users/554433'))
                )
                ->setProfile(
                    new Profile(Profile::SURVEY))
                ->setAction(
                    new Action(Action::STARTED))
                ->setObject(
                    (new QuestionnaireItem('https://example.edu/surveys/100/questionnaires/30/items/1'))
                        ->setQuestion(
                            (new RatingScaleQuestion('https://example.edu/surveys/100/questionnaires/30/items/1/question'))
                                ->setQuestionPosed('How satisfied are you with our services?')
                                ->setScale(
                                    (new LikertScale('https://example.edu/scale/2'))
                                        ->setScalePoints(4)
                                        ->setItemLabels(['Strongly Disagree', 'Disagree', 'Agree', 'Strongly Agree'])
                                        ->setItemValues(['-2', '-1', '1', '2'])
                                )
                        )
                        ->setCategories(['teaching effectiveness', 'Course structure'])
                        ->setWeight(1.0)
                )
                ->setEventTime(
                    new \DateTime('2018-11-12T10:15:00.000Z'))
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
                    (new Session('https://example.edu/sessions/f095bbd391ea4a5dd639724a40b606e98a631823'))
                        ->setStartedAtTime(
                            new \DateTime('2018-11-12T10:00:00.000Z'))
                )
        );
    }
}
