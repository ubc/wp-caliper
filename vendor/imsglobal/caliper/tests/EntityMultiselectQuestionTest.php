<?php
require_once 'CaliperTestCase.php';

use IMSGlobal\Caliper\entities\question\MultiselectQuestion;


/**
 * @requires PHP 5.6.28
 */
class EntityMultiselectQuestionTest extends CaliperTestCase {
    function setUp() {
        parent::setUp();

        $this->setTestObject(
            (new MultiselectQuestion('https://example.edu/surveys/100/questionnaires/30/items/4/question'))
                ->setQuestionPosed('What do you want to study today?')
                ->setPoints(4)
                ->setItemLabels(['Calculus', 'Number theory', 'Combinatorics', 'Algebra'])
                ->setItemValues([
                    'https://example.edu/terms/201801/courses/7/sections/1/objectives/1',
                    'https://example.edu/terms/201801/courses/7/sections/1/objectives/2',
                    'https://example.edu/terms/201801/courses/7/sections/1/objectives/3',
                    'https://example.edu/terms/201801/courses/7/sections/1/objectives/4'
                ])
        );
    }
}

