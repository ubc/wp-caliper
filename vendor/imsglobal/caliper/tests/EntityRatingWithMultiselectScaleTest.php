<?php
require_once 'CaliperTestCase.php';

use IMSGlobal\Caliper\entities\feedback\Rating;
use IMSGlobal\Caliper\entities\question\RatingScaleQuestion;
use IMSGlobal\Caliper\entities\scale\MultiselectScale;
use IMSGlobal\Caliper\entities\feedback\Comment;
use IMSGlobal\Caliper\entities\agent\Person;
use IMSGlobal\Caliper\entities\DigitalResource;
use IMSGlobal\Caliper\entities\DigitalResourceCollection;
use IMSGlobal\Caliper\entities\lis\CourseSection;


/**
 * @requires PHP 5.6.28
 */
class EntityRatingWithMultiselectScaleTest extends CaliperTestCase {
    function setUp() {
        parent::setUp();

        $this->setTestObject(
            (new Rating('https://example.edu/users/554433/rating/2'))
                ->setRater(
                    (new Person('https://example.edu/users/554433'))
                )
                ->setRated(
                    (new DigitalResourceCollection('https://example.edu/terms/201801/courses/7/sections/1/resources/1'))
                        ->setName('Course Assets')
                        ->setIsPartOf(new CourseSection('https://example.edu/terms/201801/courses/7/sections/1'))
                )
                ->setQuestion(
                    (new RatingScaleQuestion('https://example.edu/question/3'))
                        ->setQuestionPosed('How do you feel about this content? (select one or more)')
                        ->setScale(
                            (new MultiselectScale('https://example.edu/scale/3'))
                                ->setScalePoints(5)
                                ->setItemLabels(['😁', '😀', '😐', '😕', '😞'])
                                ->setItemValues(['superhappy', 'happy', 'indifferent', 'unhappy', 'disappointed'])
                                ->setIsOrderedSelection(false)
                                ->setMinSelections(1)
                                ->setMaxSelections(5)
                        )
                )
                ->setSelections(['superhappy', 'disappointed'])
                ->setDateCreated(new \DateTime('2018-08-01T06:00:00.000Z'))
        );
    }
}
