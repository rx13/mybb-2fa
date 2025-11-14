# My2FA

A MyBB two-factor authentication plugin for added account security.

## Security Status

This plugin has undergone a security review addressing:
- Input validation and sanitization
- SQL injection prevention
- XSS vulnerability fixes
- CSRF protection
- Timing attack prevention
- Open redirect protection

## Database Support

This plugin supports both MySQL and PostgreSQL databases. The plugin automatically detects your database type and uses the appropriate syntax during installation.

## Alpha Release

Not suggested for production use. In the meantime feedback and suggestions are welcome.

## Outstanding Features

Prioritized by value and ease of implementation:

```
1. backup codes (High Priority)
   - High value: essential fallback authentication method
   - Moderate complexity: cryptographic code generation, secure storage, one-time use validation
   
2. security mail notifications on disable of a method + use of a backup code (Lower Priority)
   - Moderate value: enhances security awareness
   - Low complexity: email notifications on specific events
```

