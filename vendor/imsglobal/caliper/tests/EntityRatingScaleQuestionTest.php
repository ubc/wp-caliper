<?php
require_once 'CaliperTestCase.php';

use IMSGlobal\Caliper\entities\question\RatingScaleQuestion;
use IMSGlobal\Caliper\entities\scale\LikertScale;


/**
 * @requires PHP 5.6.28
 */
class EntityRatingScaleQuestionTest extends CaliperTestCase {
    function setUp() {
        parent::setUp();

        $this->setTestObject(
            (new RatingScaleQuestion('https://example.edu/question/2'))
                ->setQuestionPosed('Do you agree with the opinion presented?')
                ->setScale(
                    (new LikertScale('https://example.edu/scale/2'))
                        ->setScalePoints(4)
                        ->setItemLabels(['Strongly Disagree', 'Disagree', 'Agree', 'Strongly Agree'])
                        ->setItemValues(['-2', '-1', '1', '2'])
                        ->setDateCreated(new \DateTime('2018-08-01T06:00:00.000Z'))
                )
        );
    }
}

