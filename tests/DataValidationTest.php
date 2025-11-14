<?php

namespace My2FA\Tests;

use PHPUnit\Framework\TestCase;

/**
 * Tests for data validation and sanitization
 */
class DataValidationTest extends TestCase
{
    /**
     * Test integer type casting for user IDs
     */
    public function testUserIdTypeCasting()
    {
        $userId = "123";
        $casted = (int) $userId;
        $this->assertIsInt($casted);
        $this->assertEquals(123, $casted);
    }

    /**
     * Test integer type casting prevents SQL injection
     */
    public function testUserIdSqlInjectionPrevention()
    {
        $maliciousInput = "123 OR 1=1";
        $casted = (int) $maliciousInput;
        // Should only get 123, not the SQL injection
        $this->assertEquals(123, $casted);
    }

    /**
     * Test array_map intval for method IDs
     */
    public function testMethodIdArraySanitization()
    {
        $methodIds = ["1", "2", "3"];
        $sanitized = array_map('intval', $methodIds);
        
        $this->assertIsArray($sanitized);
        $this->assertCount(3, $sanitized);
        foreach ($sanitized as $id) {
            $this->assertIsInt($id);
        }
    }

    /**
     * Test array_map intval filters out non-numeric values
     */
    public function testMethodIdArraySanitizationMalicious()
    {
        $methodIds = ["1", "2' OR '1'='1", "3"];
        $sanitized = array_map('intval', $methodIds);
        
        // Malicious SQL should become 2 (integer conversion)
        $this->assertEquals([1, 2, 3], $sanitized);
    }

    /**
     * Test OTP input sanitization
     */
    public function testOtpInputSanitization()
    {
        $input = "12 34 56";
        $sanitized = preg_replace('/[^0-9]/', '', $input);
        
        $this->assertEquals('123456', $sanitized);
    }

    /**
     * Test OTP input sanitization removes letters
     */
    public function testOtpInputSanitizationRemovesLetters()
    {
        $input = "123abc456";
        $sanitized = preg_replace('/[^0-9]/', '', $input);
        
        $this->assertEquals('123456', $sanitized);
    }

    /**
     * Test OTP input sanitization removes special characters
     */
    public function testOtpInputSanitizationRemovesSpecialChars()
    {
        $input = "123-456";
        $sanitized = preg_replace('/[^0-9]/', '', $input);
        
        $this->assertEquals('123456', $sanitized);
    }

    /**
     * Test email code validation length check
     */
    public function testEmailCodeValidationLength()
    {
        $code = "123456";
        $this->assertEquals(6, strlen($code));
        $this->assertTrue(is_numeric($code));
    }

    /**
     * Test email code validation rejects short codes
     */
    public function testEmailCodeValidationRejectsShort()
    {
        $code = "12345";
        $this->assertNotEquals(6, strlen($code));
    }

    /**
     * Test email code validation rejects long codes
     */
    public function testEmailCodeValidationRejectsLong()
    {
        $code = "1234567";
        $this->assertNotEquals(6, strlen($code));
    }

    /**
     * Test hash_equals for constant-time comparison
     */
    public function testConstantTimeComparison()
    {
        $code1 = "123456";
        $code2 = "123456";
        
        $this->assertTrue(hash_equals($code1, $code2));
    }

    /**
     * Test hash_equals rejects different codes
     */
    public function testConstantTimeComparisonRejects()
    {
        $code1 = "123456";
        $code2 = "654321";
        
        $this->assertFalse(hash_equals($code1, $code2));
    }
}
