# My2FA

A MyBB two-factor authentication plugin for added account security.

## Security Status

This plugin has undergone a comprehensive security review addressing:
- Input validation and sanitization
- SQL injection prevention
- XSS vulnerability fixes
- CSRF protection
- Timing attack prevention
- Open redirect protection

## Database Support

This plugin supports both MySQL and PostgreSQL databases. The plugin automatically detects your database type and uses the appropriate syntax during installation.

## Alpha Release

Not suggested for production use. In the meantime feedback and suggestions are welcome. Lazy to-do list:

```
- backup codes
- email method (send otp via email)

- security mail notifications on disable of a method + use of a backup code
- templates caching
- hooks
```

