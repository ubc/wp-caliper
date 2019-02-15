<?php
require_once 'CaliperTestCase.php';

use IMSGlobal\Caliper\entities\agent\Person;
use IMSGlobal\Caliper\entities\session\LtiSession;
use IMSGlobal\Caliper\context;


/**
 * @requires PHP 5.6.28
 */
class EntityLtiSessionTest extends CaliperTestCase {
    function setUp() {
        parent::setUp();


        $this->setTestObject(
            (new LtiSession('https://example.edu/lti/sessions/b533eb02823f31024e6b7f53436c42fb99b31241'))
                ->setUser(
                    (new Person('https://example.edu/users/554433'))
                )
                ->setMessageParameters(
                    [
                        "iss" => "https://example.edu",
                        "sub" => "https://example.edu/users/554433",
                        "aud" => ["https://example.com/lti/tool"],
                        "exp" => 1510185728,
                        "iat" => 1510185228,
                        "azp" => "962fa4d8-bcbf-49a0-94b2-2de05ad274af",
                        "nonce" => "fc5fdc6d-5dd6-47f4-b2c9-5d1216e9b771",
                        "name" => "Ms Jane Marie Doe",
                        "given_name" => "Jane",
                        "family_name" => "Doe",
                        "middle_name" => "Marie",
                        "picture" => "https://example.edu/jane.jpg",
                        "email" => "jane@example.edu",
                        "locale" => "en-US",
                        "https://purl.imsglobal.org/spec/lti/claim/deployment_id" => "07940580-b309-415e-a37c-914d387c1150",
                        "https://purl.imsglobal.org/spec/lti/claim/message_type" => "LtiResourceLinkRequest",
                        "https://purl.imsglobal.org/spec/lti/claim/version" => "1.3.0",
                        "https://purl.imsglobal.org/spec/lti/claim/roles" => [
                            "http://purl.imsglobal.org/vocab/lis/v2/institution/person#Student",
                            "http://purl.imsglobal.org/vocab/lis/v2/membership#Learner",
                            "http://purl.imsglobal.org/vocab/lis/v2/membership#Mentor"
                        ],
                        "https://purl.imsglobal.org/spec/lti/claim/role_scope_mentor" => [
                            "http://purl.imsglobal.org/vocab/lis/v2/institution/person#Administrator"
                        ],
                        "https://purl.imsglobal.org/spec/lti/claim/context" => [
                            "id" => "https://example.edu/terms/201801/courses/7/sections/1",
                            "label" => "CPS 435-01",
                            "title" => "CPS 435 Learning Analytics, Section 01",
                            "type" => ["http://purl.imsglobal.org/vocab/lis/v2/course#CourseSection"]
                        ],
                        "https://purl.imsglobal.org/spec/lti/claim/resource_link" => [
                            "id" => "200d101f-2c14-434a-a0f3-57c2a42369fd",
                            "description" => "Assignment to introduce who you are",
                            "title" => "Introduction Assignment"
                        ],
                        "https://purl.imsglobal.org/spec/lti/claim/tool_platform" => [
                            "guid" => "https://example.edu",
                            "contact_email" => "support@example.edu",
                            "description" => "An Example Tool Platform",
                            "name" => "Example Tool Platform",
                            "url" => "https://example.edu",
                            "product_family_code" => "ExamplePlatformVendor-Product",
                            "version" => "1.0"
                        ],
                        "https://purl.imsglobal.org/spec/lti/claim/launch_presentation" => [
                            "document_target" => "iframe",
                            "height" => 320,
                            "width" => 240,
                            "return_url" => "https://example.edu/terms/201801/courses/7/sections/1/pages/1"
                        ],
                        "https://purl.imsglobal.org/spec/lti/claim/custom" => [
                            "xstart" => "2017-04-21T01:00:00Z",
                            "request_url" => "https://tool.com/link/123"
                        ],
                        "https://purl.imsglobal.org/spec/lti/claim/lis" => [
                            "person_sourcedid" => "example.edu:71ee7e42-f6d2-414a-80db-b69ac2defd4",
                            "course_offering_sourcedid" => "example.edu:SI182-F16",
                            "course_section_sourcedid" => "example.edu:SI182-001-F16"
                        ],
                        "http://www.ExamplePlatformVendor.com/session" => [
                            "id" => "89023sj890dju080"
                        ]
                    ]
                )
                ->setDateCreated(
                    new \DateTime('2018-11-15T10:15:00.000Z'))
                ->setStartedAtTime(
                    new \DateTime('2018-11-15T10:15:00.000Z'))
        );
    }
}
