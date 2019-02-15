<?php
require_once realpath(dirname(__FILE__) . '/../vendor/autoload.php');

define('CALIPER_LIB_PATH', realpath(dirname(__FILE__) . '/..'));

require_once 'CaliperTestUtilities.php';

class CaliperTestCase extends PHPUnit_Framework_TestCase {
    const
        DEFAULT_TIMEZONE = 'UTC',
        FIXTURE_DIRECTORY_PATH = '/../caliper-common-fixtures/src/',
        FIXTURE_FILE_EXTENSION = '.json';

    /** @var string */
    protected $fixtureDirectoryPath = false;
    /** @var string */
    protected $fixtureFilePath = false;
    /** @var object */
    private $testObject = null;
    /** @var string */
    private $calledClass = false;
    /** @var string Path to output directory, from PHPUNIT_OUTPUT_DIR environment variable */
    private $outputDirectoryPath = false;
    /** @var bool Only failures save files to output directory, from PHPUNIT_OUTPUT_ONLY_FAILURES
     * environment variable */
    private $outputOnlyFailures = true;

    function setUp() {
        parent::setUp();
        date_default_timezone_set(self::DEFAULT_TIMEZONE);

        $this->setCalledClass(get_called_class());
        $this->setFixtureDirectoryPath(self::FIXTURE_DIRECTORY_PATH);
        $this->setFixtureFilePath($this->makeFixturePathFromClassName($this->getCalledClass()));

        $outputDirectoryPath = getenv('PHPUNIT_OUTPUT_DIR');
        if ($outputDirectoryPath !== false) {
            $normalizedOutputDirectoryPath = realpath($outputDirectoryPath);
            self::assertNotFalse($normalizedOutputDirectoryPath,
                "Unable to normalize PHPUNIT_OUTPUT_DIR value, '${outputDirectoryPath}'");
            $this->outputDirectoryPath = $normalizedOutputDirectoryPath;

            $this->outputOnlyFailures = (strtolower(getenv('PHPUNIT_OUTPUT_ONLY_FAILURES')) !== 'true');
        }
    }

    /**
     * Return the absolute path to the fixture file by combining CALIPER_LIB_PATH,
     * the fixture directory previously set with setFixtureDirectoryPath(), the name of
     * the test class, and the fixture filename extension.  It's intended to make the path
     * reference the appropriate caliper-common-fixtures files which are installed in the
     * same directory as caliper-php.
     *
     * @param string $testClass Name of the test class
     * @param string $extension <i>(Optional)</i> Extension of the fixture file, ".json" by default
     * @return string
     */
    public function makeFixturePathFromClassName($testClass,
                                                 $extension = self::FIXTURE_FILE_EXTENSION) {
        $testName = str_replace('Test', null, $testClass);
        $testFilePath = CALIPER_LIB_PATH . DIRECTORY_SEPARATOR .
            $this->getFixtureDirectoryPath() . DIRECTORY_SEPARATOR . 'caliper' . $testName .
            $extension;
        $normalizedTestFilePath = realpath($testFilePath);
        self::assertNotFalse($normalizedTestFilePath,
            "Unable to normalize '${testFilePath}'");

        return $normalizedTestFilePath;
    }

    /** @return string */
    public function getFixtureDirectoryPath() {
        self::assertNotFalse($this->fixtureDirectoryPath, 'fixtureDirectoryPath has not been set');
        return $this->fixtureDirectoryPath;
    }

    /**
     * @param string $fixtureDirectoryPath
     * @return $this
     */
    public function setFixtureDirectoryPath($fixtureDirectoryPath) {
        $this->fixtureDirectoryPath = strval($fixtureDirectoryPath);
        return $this;
    }

    /** @return string */
    public function getCalledClass() {
        self::assertNotFalse($this->calledClass, 'calledClass has not been set');
        return $this->calledClass;
    }

    /**
     * @param string $calledClass
     * @return $this
     */
    public function setCalledClass($calledClass) {
        $this->calledClass = strval($calledClass);
        return $this;
    }

    function testObjectSerializesToJson() {
        $testOptions = new IMSGlobal\Caliper\Options();
        $testRequestor = new IMSGlobal\Caliper\request\HttpRequestor($testOptions);
        $testJson = $testRequestor->serializeData($this->getTestObject());

        $fixtureFilePath = $this->getFixtureFilePath();
        try {
            $fixtureJson = file_get_contents($fixtureFilePath);
        } catch (Exception $ex) {
            throw new PHPUnit_Runner_Exception("Error getting contents of '$fixtureFilePath'");
        }

        $exception = false;
        try {
            self::assertJsonStringEqualsJsonString(
                $fixtureJson, $testJson, 'Failed: ' . $this->getCalledClass());
        } catch (Exception $exception) {
            throw $exception;
        } finally {
            $outputDirectoryPath = $this->getOutputDirectoryPath();
            if (($outputDirectoryPath !== false) && ($exception || $this->isOutputOnlyFailures())) {
                CaliperTestUtilities::saveFormattedFixtureAndTestJson(
                    $fixtureJson, $testJson, $this->getCalledClass(), $outputDirectoryPath);
            }
        }
    }

    /** @return object */
    public function getTestObject() {
        self::assertNotNull($this->testObject, 'testObject has not been set');
        return $this->testObject;
    }

    /**
     * @param object $testObject
     * @return $this
     */
    public function setTestObject($testObject) {
        $this->testObject = $testObject;
        return $this;
    }

    /** @return string */
    public function getFixtureFilePath() {
        self::assertNotFalse($this->fixtureFilePath, 'fixtureFilePath has not been set');
        return $this->fixtureFilePath;
    }

    /**
     * @param string $fixtureFilePath
     * @return $this
     */
    public function setFixtureFilePath($fixtureFilePath) {
        $this->fixtureFilePath = strval($fixtureFilePath);
        return $this;
    }

    /** @return bool|string */
    public function getOutputDirectoryPath() {
        return $this->outputDirectoryPath;
    }

    /** @return boolean */
    public function isOutputOnlyFailures() {
        return $this->outputOnlyFailures;
    }
}
