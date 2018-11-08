<?php
require_once 'CaliperTestCase.php';

use IMSGlobal\Caliper\entities\agent\Person;
use IMSGlobal\Caliper\entities\session\LtiSession;


/**
 * @requires PHP 5.6.28
 */
class EntityLtiSessionTest extends CaliperTestCase {
    function setUp() {
        parent::setUp();


        $this->setTestObject(
            (new LtiSession('https://example.com/sessions/b533eb02823f31024e6b7f53436c42fb99b31241'))
                ->setUser(
                    (new Person('https://example.edu/users/554433'))
                )
                ->setMessageParameters(
                    [
                        'context_id' => '4f1a161f-59c3-43e5-be37-445ad09e3f76',
                        'context_type' => 'CourseSection',
                        'custom' => [
                            'caliper_profile_url' => 'https://example.edu/lti/tc/cps',
                            'caliper_session_id' => '1c519ff7-3dfa-4764-be48-d2fb35a2925a',
                            'tool_consumer_instance_url' => 'https://example.edu',
                        ],
                        'ext' => [
                            'edu_example_course_section' => 'https://example.edu/terms/201601/courses/7/sections/1',
                            'edu_example_course_section_instructor' => 'https://example.edu/faculty/1234',
                            'edu_example_course_section_learner' => 'https://example.edu/users/554433',
                            'edu_example_course_section_roster' => 'https://example.edu/terms/201601/courses/7/sections/1/rosters/1',
                        ],
                        'lti_message_type' => 'basic-lti-launch-request',
                        'lti_version' => 'LTI-2p0',
                        'resource_link_id' => '6b37a950-42c9-4117-8f4f-03e6e5c88d24',
                        'roles' => [
                            'Learner',
                        ],
                        'user_id' => '0ae836b9-7fc9-4060-006f-27b2066ac545',
                    ]
                )
                ->setDateCreated(
                    new \DateTime('2016-11-15T10:15:00.000Z'))
                ->setStartedAtTime(
                    new \DateTime('2016-11-15T10:15:00.000Z'))
        );
    }
}
