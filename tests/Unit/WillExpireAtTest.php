<?php

namespace Tests\Unit;

use Carbon\Carbon;
use Tests\TestCase;
use DTApi\Helpers\TeHelper;

class WillExpireAtTest extends TestCase
{
    protected $helper;

    protected function setUp(): void
    {
        parent::setUp();
        $this->helper = new TeHelper();
      
        
    }

    /**
     * Test for willExpireAt method when the time difference is <= 90 minutes.
     *
     * @return void
     */
    public function testWillExpireAtWhenDifferenceIsLessThanOrEqualTo90Minutes()
    {
        // Setup mock dates
        $due_time = Carbon::now()->addMinutes(60); // 60 minutes from now
        $created_at = Carbon::now()->subMinutes(30); // 30 minutes ago

        // Call the static method
        $result = $this->helper->willExpireAt($due_time, $created_at);

        // The result should be the due_time itself because the difference is <= 90 minutes
        $this->assertEquals($due_time->format('Y-m-d H:i:s'), $result);
    }

    /**
     * Test for willExpireAt method when the time difference is between 90 minutes and 24 hours.
     *
     * @return void
     */
    public function testWillExpireAtWhenDifferenceIsBetween90MinutesAnd24Hours()
    {
        // Setup mock dates
        $due_time = Carbon::now()->addHours(1); // 1 hour from now
        $created_at = Carbon::now()->subHours(10); // 10 hours ago

        // Call the static method
        $result = $this->helper->willExpireAt($due_time, $created_at);

        // The result should be created_at + 90 minutes
        $expectedTime = $created_at->addMinutes(90)->format('Y-m-d H:i:s');
        $this->assertEquals($expectedTime, $result);
    }

    /**
     * Test for willExpireAt method when the time difference is between 24 and 72 hours.
     *
     * @return void
     */
    public function testWillExpireAtWhenDifferenceIsBetween24And72Hours()
    {
        // Setup mock dates
        $due_time = Carbon::now()->addHours(3); // 3 hours from now
        $created_at = Carbon::now()->subHours(30); // 30 hours ago

        // Call the static method
        $result = $this->helper->willExpireAt($due_time, $created_at);

        // The result should be created_at + 16 hours
        $expectedTime = $created_at->addHours(16)->format('Y-m-d H:i:s');
        $this->assertEquals($expectedTime, $result);
    }

    /**
     * Test for willExpireAt method when the time difference is greater than 72 hours.
     *
     * @return void
     */
    public function testWillExpireAtWhenDifferenceIsGreaterThan72Hours()
    {
        // Setup mock dates
        $due_time = Carbon::now()->addHours(10); // 10 hours from now
        $created_at = Carbon::now()->subDays(4); // 4 days ago (more than 72 hours)

        // Call the static method
        $result = $this->helper->willExpireAt($due_time, $created_at);

        // The result should be due_time - 48 hours
        $expectedTime = $due_time->subHours(48)->format('Y-m-d H:i:s');
        $this->assertEquals($expectedTime, $result);
    }
}
