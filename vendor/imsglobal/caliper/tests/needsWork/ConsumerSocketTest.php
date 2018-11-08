<?php
use IMSGlobal\Caliper\entities\lis\CourseSection;

/**
 * These tests may require an eventstore endpoint
 *
 * @requires extension fix_these_tests
 * @requires PHP 5.6.28
 *
 * PHPUnit grouping
 * @group needsWork
 */
class ConsumerSocketTest extends PHPUnit_Framework_TestCase {

    private $client;

    private $caliperEntity;

    function setUp() {
        $this->client = new IMSGlobal\Caliper\Client('testApiKey', [
            'consumer' => 'socket',
        ]);

        // $this->caliperEntity = new IMSGlobal\Caliper\entities\Entity();
        $this->caliperEntity = (new CourseSection('_:course-1234'))
            ->setDateCreated(new \DateTime())
            ->setCategory('Engineering');
    }

    function testTimeout() {
        $client = new IMSGlobal\Caliper\Client('testApiKey', [
            'timeout' => 0.01,
            'consumer' => 'socket',
        ]);


        $described = $client->describe($this->caliperEntity);
        echo '**********************************';
        echo $described;
        echo '**********************************';
        $this->assertTrue($described);

        $client->__destruct();
    }

    function testProd() {
        $client = new IMSGlobal\Caliper\Client('x', [
            'consumer' => 'socket',
            'error_handler' => function () {
                throw new Exception('Was called');
            }]);

        # Shouldn't error out without debug on.
        $client->describe($this->caliperEntity);
        $client->__destruct();
    }

    function testDebug() {

        $options = [
            'debug' => true,
            'consumer' => 'socket',
            'error_handler' => function ($errno, $errmsg) {
                if ($errno != 400)
                    throw new Exception('Response is not 400');
            },
        ];

        $client = new IMSGlobal\Caliper\Client('x', $options);

        # Should error out with debug on.
        ## TODO - renable after fixing socket issues
        // $clients->describe('Course', 'course-1234', [
        //                 'program'    => 'Engineering',
        //                 'start-date' => time(),
        //                 ));
        $client->__destruct();
    }


    function testLargeMessage() {
        $options = [
            'debug' => true,
            'consumer' => 'socket',
        ];

        $client = new IMSGlobal\Caliper\Client('testApiKey', $options);

        $large_message_body = str_repeat('a', 10000);

        // $ce = new IMSGlobal\Caliper\entities\Entity();
        // $ce->setId('course-1234');
        // $ce->setType('course');
        // $ce->setProperties([
        //     'program' => 'Engineering',
        //     'start-date' => time(),
        //     'big_property' => $large_message_body
        // ]);
        $ce = (new CourseSection('_:course-1234'))
            ->setDateCreated(new \DateTime())
            ->setCategory('Engineering')
            ->setDescription($large_message_body);


        $client->describe($ce);

        $client->__destruct();
    }
}

?>