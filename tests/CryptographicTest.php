<?php

namespace My2FA\Tests;

use PHPUnit\Framework\TestCase;

/**
 * Tests for cryptographic security functions
 */
class CryptographicTest extends TestCase
{
    /**
     * Test random_int generates numbers in range
     */
    public function testRandomIntRange()
    {
        $code = random_int(100000, 999999);
        
        $this->assertIsInt($code);
        $this->assertGreaterThanOrEqual(100000, $code);
        $this->assertLessThanOrEqual(999999, $code);
    }

    /**
     * Test random_int generates 6-digit codes
     */
    public function testRandomIntSixDigits()
    {
        $code = random_int(100000, 999999);
        $codeString = (string) $code;
        
        $this->assertEquals(6, strlen($codeString));
    }

    /**
     * Test random_int generates different codes
     */
    public function testRandomIntUniqueness()
    {
        $codes = [];
        for ($i = 0; $i < 10; $i++) {
            $codes[] = random_int(100000, 999999);
        }
        
        // At least some should be different (extremely unlikely to get duplicates)
        $unique = array_unique($codes);
        $this->assertGreaterThan(1, count($unique));
    }

    /**
     * Test password_hash and password_verify (for future backup code hashing)
     */
    public function testPasswordHashingForBackupCodes()
    {
        $code = "ABCD-EFGH-1234";
        $hash = password_hash($code, PASSWORD_DEFAULT);
        
        $this->assertNotEquals($code, $hash);
        $this->assertTrue(password_verify($code, $hash));
        $this->assertFalse(password_verify("wrong-code", $hash));
    }

    /**
     * Test base64 encoding for secure token generation
     */
    public function testBase64EncodingForTokens()
    {
        $randomBytes = random_bytes(24);
        $token = base64_encode($randomBytes);
        
        $this->assertIsString($token);
        $this->assertEquals(32, strlen($token)); // 24 bytes = 32 base64 chars
        
        // Verify it can be decoded
        $decoded = base64_decode($token, true);
        $this->assertEquals($randomBytes, $decoded);
    }

    /**
     * Test constant-time string comparison (timing attack prevention)
     */
    public function testTimingSafeComparison()
    {
        $secret = "super-secret-key-12345";
        $input1 = "super-secret-key-12345";
        $input2 = "wrong-secret-key-12345";
        
        // These should use hash_equals for timing safety
        $this->assertTrue(hash_equals($secret, $input1));
        $this->assertFalse(hash_equals($secret, $input2));
    }
}
