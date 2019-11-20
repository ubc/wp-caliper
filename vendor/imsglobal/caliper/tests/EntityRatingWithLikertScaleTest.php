<?php
require_once 'CaliperTestCase.php';

use IMSGlobal\Caliper\entities\feedback\Rating;
use IMSGlobal\Caliper\entities\question\RatingScaleQuestion;
use IMSGlobal\Caliper\entities\scale\LikertScale;
use IMSGlobal\Caliper\entities\feedback\Comment;
use IMSGlobal\Caliper\entities\agent\Person;
use IMSGlobal\Caliper\entities\DigitalResource;
use IMSGlobal\Caliper\entities\DigitalResourceCollection;
use IMSGlobal\Caliper\entities\lis\CourseSection;


/**
 * @requires PHP 5.6.28
 */
class EntityRatingWithLikertScaleTest extends CaliperTestCase {
    function setUp() {
        parent::setUp();

        $this->setTestObject(
            (new Rating('https://example.edu/users/554433/rating/1'))
                ->setRater(
                    (new Person('https://example.edu/users/554433'))
                )
                ->setRated(
                    (new DigitalResource('https://example.edu/terms/201801/courses/7/sections/1/resources/1/syllabus.pdf'))
                        ->setName('Course Syllabus')
                        ->setMediaType('application/pdf')
                        ->setIsPartOf((new DigitalResourceCollection('https://example.edu/terms/201801/courses/7/sections/1/resources/1'))
                            ->setName('Course Assets')
                            ->setIsPartOf(new CourseSection('https://example.edu/terms/201801/courses/7/sections/1'))
                        )
                        ->setDateCreated(new \DateTime('2018-08-02T11:32:00.000Z'))
                )
                ->setQuestion(
                    (new RatingScaleQuestion('https://example.edu/question/2'))
                        ->setQuestionPosed('Do you agree with the opinion presented?')
                        ->setScale(
                            (new LikertScale('https://example.edu/scale/2'))
                                ->setScalePoints(4)
                                ->setItemLabels(['Strongly Disagree', 'Disagree', 'Agree', 'Strongly Agree'])
                                ->setItemValues(['-2', '-1', '1', '2'])
                        )
                )
                ->setSelections(['1'])
                ->setRatingComment(
                    (new Comment('https://example.edu/terms/201801/courses/7/sections/1/assess/1/items/6/users/665544/responses/1/comment/1'))
                        ->setCommenter(
                            (new Person('https://example.edu/users/554433'))
                        )
                        ->setCommentedOn(
                            (new DigitalResource('https://example.edu/terms/201801/courses/7/sections/1/resources/1/syllabus.pdf'))
                                ->setName('Course Syllabus')
                                ->setMediaType('application/pdf')
                                ->setIsPartOf((new DigitalResourceCollection('https://example.edu/terms/201801/courses/7/sections/1/resources/1'))
                                    ->setName('Course Assets')
                                    ->setIsPartOf(new CourseSection('https://example.edu/terms/201801/courses/7/sections/1'))
                                )
                                ->setDateCreated(new \DateTime('2018-08-02T11:32:00.000Z'))
                        )
                        ->setValue('I like what you did here but you need to improve on...')
                        ->setDateCreated(new \DateTime('2018-08-01T06:00:00.000Z'))
                )
                ->setDateCreated(new \DateTime('2018-08-01T06:00:00.000Z'))
        );
    }
}
