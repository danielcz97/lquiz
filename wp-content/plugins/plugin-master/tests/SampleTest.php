<?php
/**
 * Class SampleTest
 *
 * @package Test2
 */

/**
 * Sample test case.
 */
class SampleTest {

	/**
	 * A single example test.
     * @test
	 */
	public function test_sample() {
		// Replace this with some actual testing code.
		$this->assertTrue( true );
	}

    function test_sample_string() {

        $string = 'Unit tests are sweet';

        $this->assertEquals( 'Unit tests are sweet', $string );
}
}