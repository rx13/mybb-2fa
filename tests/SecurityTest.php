<?php

namespace My2FA\Tests;

use PHPUnit\Framework\TestCase;

/**
 * Tests for security-critical validation functions
 */
class SecurityTest extends TestCase
{
    protected function setUp(): void
    {
        // Mock MyBB settings
        global $mybb;
        if (!isset($mybb)) {
            $mybb = new \stdClass();
        }
        $mybb->settings = [
            'bburl' => 'https://example.com/forum'
        ];
    }

    /**
     * Test redirect URL validation - valid same-host URL
     */
    public function testIsRedirectUrlValidSameHost()
    {
        require_once __DIR__ . '/../inc/plugins/my2fa/core.php';
        
        $result = \My2FA\isRedirectUrlValid('https://example.com/forum/usercp.php');
        $this->assertTrue($result);
    }

    /**
     * Test redirect URL validation - blocks different host
     */
    public function testIsRedirectUrlValidDifferentHost()
    {
        require_once __DIR__ . '/../inc/plugins/my2fa/core.php';
        
        $result = \My2FA\isRedirectUrlValid('https://evil.com/phishing');
        $this->assertFalse($result);
    }

    /**
     * Test redirect URL validation - blocks protocol-relative URLs
     */
    public function testIsRedirectUrlValidProtocolRelative()
    {
        require_once __DIR__ . '/../inc/plugins/my2fa/core.php';
        
        $result = \My2FA\isRedirectUrlValid('//evil.com/phishing');
        $this->assertFalse($result);
    }

    /**
     * Test redirect URL validation - empty URL
     */
    public function testIsRedirectUrlValidEmpty()
    {
        require_once __DIR__ . '/../inc/plugins/my2fa/core.php';
        
        $result = \My2FA\isRedirectUrlValid('');
        $this->assertFalse($result);
    }

    /**
     * Test redirect URL validation - relative URL (valid)
     */
    public function testIsRedirectUrlValidRelative()
    {
        require_once __DIR__ . '/../inc/plugins/my2fa/core.php';
        
        $result = \My2FA\isRedirectUrlValid('usercp.php?action=my2fa');
        $this->assertTrue($result);
    }

    /**
     * Test redirect URL validation - blocks ajax parameter
     */
    public function testIsRedirectUrlValidBlocksAjax()
    {
        require_once __DIR__ . '/../inc/plugins/my2fa/core.php';
        
        $result = \My2FA\isRedirectUrlValid('https://example.com/forum/index.php?ajax=1');
        $this->assertFalse($result);
    }

    /**
     * Test HTTP_HOST sanitization
     */
    public function testHttpHostSanitization()
    {
        $_SERVER['HTTP_HOST'] = 'example.com';
        $_SERVER['REQUEST_URI'] = '/forum/index.php';
        
        require_once __DIR__ . '/../inc/plugins/my2fa/utils.php';
        
        global $mybb;
        $mybb->settings['bburl'] = 'https://example.com/forum';
        
        $url = \My2FA\getCurrentUrl();
        $this->assertNotNull($url);
        $this->assertStringContainsString('example.com', $url);
    }

    /**
     * Test HTTP_HOST with malicious characters
     */
    public function testHttpHostSanitizationMalicious()
    {
        $_SERVER['HTTP_HOST'] = 'example.com<script>alert(1)</script>';
        $_SERVER['REQUEST_URI'] = '/forum/index.php';
        
        require_once __DIR__ . '/../inc/plugins/my2fa/utils.php';
        
        global $mybb;
        $mybb->settings['bburl'] = 'https://example.com/forum';
        
        $url = \My2FA\getCurrentUrl();
        $this->assertNotNull($url);
        // Script tags should be removed by sanitization
        $this->assertStringNotContainsString('<script>', $url);
        $this->assertStringNotContainsString('alert', $url);
    }
}
