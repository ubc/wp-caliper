#JSON Output Files for Debugging

The tests can make files of formatted and sorted JSON from the fixture
files and the serialized Caliper objects.  Enable this feature by setting
the environment variable `PHPUNIT_OUTPUT_DIR` to the name of a writable
directory.  The JSON files will be saved with the names 
`NameOfTest_fixture.json` and `NameOfTest_output.json`.

##Examples

When using a BASH shell on UNIX/Linux, to set the variable for only the
current run of PHPUnit:

    $ PHPUNIT_OUTPUT_DIR=/tmp phpunit test #run all tests
    $ PHPUNIT_OUTPUT_DIR=/tmp phpunit test/caliper/event/EventNavigationNavigatedToTest.php #run specific test
    $ ls /tmp/EventNavigationNavigatedToTest*.json
    /tmp/EventNavigationNavigatedToTest_fixture.json
    /tmp/EventNavigationNavigatedToTest_output.json

To set the variable once for many runs of PHPUnit:

    $ PHPUNIT_OUTPUT_DIR=/tmp; export PHPUNIT_OUTPUT_DIR
    $ phpunit test #run all tests
    $ phpunit test/caliper/event/EventNavigationNavigatedToTest.php #run specific test
    $ ls /tmp/EventNavigationNavigatedToTest*.json
    /tmp/EventNavigationNavigatedToTest_fixture.json
    /tmp/EventNavigationNavigatedToTest_output.json

Both JSON files from each test are formatted and sorted in the same way so
they are easy to compare and find differences.
