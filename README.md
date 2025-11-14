# My2FA

My2FA is a comprehensive, modern two-factor authentication (2FA) plugin for MyBB forums, designed to provide robust account security for both users and administrators. Built with a focus on security, extensibility, and user experience, My2FA integrates seamlessly into your forum and supports a wide range of authentication and management features.

## Features

- **Multiple 2FA Methods**: Supports TOTP (authenticator apps), email-based codes, and is architected for easy addition of new authentication methods.
- **Device Trusting**: Users can trust devices for a configurable period, reducing login friction while maintaining strong security.
- **Admin Control Panel Protection**: Enforces 2FA for admin logins, securing sensitive administrative actions.
- **User Self-Service**: Users can enable, manage, and deactivate 2FA from their User Control Panel, with clear setup and recovery flows.
- **Security Notifications**: Users receive notifications for critical security events, such as method deactivation or backup code usage.
- **Database Agnostic**: Full support for both MySQL and PostgreSQL, with automatic detection and optimized queries.
- **Extensible Architecture**: Modular codebase and plugin hooks make it easy to add new 2FA methods or customize behavior.
- **Automated Testing**: Comprehensive PHPUnit test suite for security, validation, and utility functions.

## Philosophy

My2FA is developed with a security-minded and user-centric philosophy. Every feature is designed to:

- Maximize account protection without sacrificing usability
- Be extensible and maintainable for future needs
- Integrate cleanly with MyBB's core and theming system
- Provide clear, actionable feedback to users and administrators
- Avoid legacy or duplicate artifacts during upgrades and maintenance

## Outstanding Features (Planned)

- **Backup Codes**: Secure, one-time-use backup codes for account recovery
- **Administrator Reset**: Admins can reset a user's MFA to email-based authentication in case of TOTP seed loss
- **Additional 2FA Methods**: Support for more authentication options as needed

## Getting Started

1. Upload the plugin files to your MyBB installation.
2. Install and activate My2FA from the Admin Control Panel.
3. Configure settings and templates as desired.
4. Users can enable and manage 2FA from their User Control Panel.

## Security

My2FA is built to meet modern security standards, including:

- Security-minded input handling and validation throughout
- SQL injection, XSS, CSRF, and timing attack prevention
- Open redirect and host header validation
- Idempotent template and database changes to ensure safe upgrades

## Testing

A full PHPUnit test suite is included. Run `composer install` and `composer test` to verify plugin integrity and security.

---

For documentation, support, and contribution guidelines, see the project repository.


