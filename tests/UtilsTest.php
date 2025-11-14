<?php

namespace My2FA\Tests;

use PHPUnit\Framework\TestCase;

/**
 * Tests for utility functions in utils.php
 * These tests focus on standalone functions that don't require MyBB globals
 */
class UtilsTest extends TestCase
{
    /**
     * Test getMultiOptionscode function
     */
    public function testGetMultiOptionscode()
    {
        require_once __DIR__ . '/../inc/plugins/my2fa/utils.php';
        
        $result = \My2FA\getMultiOptionscode('radio', [
            'option1' => 'Option 1',
            'option2' => 'Option 2'
        ]);
        
        $this->assertStringContainsString('radio', $result);
        $this->assertStringContainsString('option1=Option 1', $result);
        $this->assertStringContainsString('option2=Option 2', $result);
    }

    /**
     * Test getMultiOptionscode with empty options
     */
    public function testGetMultiOptionscodeEmpty()
    {
        require_once __DIR__ . '/../inc/plugins/my2fa/utils.php';
        
        $result = \My2FA\getMultiOptionscode('checkbox', []);
        
        $this->assertEquals('checkbox', $result);
    }

    /**
     * Test getMultiOptionscode with special characters
     */
    public function testGetMultiOptionscodeSpecialChars()
    {
        require_once __DIR__ . '/../inc/plugins/my2fa/utils.php';
        
        $result = \My2FA\getMultiOptionscode('select', [
            'key_with_underscore' => 'Value with spaces',
            'another-key' => 'Value=with=equals'
        ]);
        
        $this->assertStringContainsString('key_with_underscore=Value with spaces', $result);
        $this->assertStringContainsString('another-key=Value=with=equals', $result);
    }
}
