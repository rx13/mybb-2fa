# My2FA Tests

This directory contains PHPUnit tests for the MyBB 2FA plugin.

## Test Coverage

The test suite covers:

### Security Tests (`SecurityTest.php`)
- Redirect URL validation (preventing open redirects)
- Protocol-relative URL blocking
- HTTP_HOST sanitization
- Ajax parameter blocking
- XSS prevention

### Data Validation Tests (`DataValidationTest.php`)
- User ID type casting and SQL injection prevention
- Method ID array sanitization
- OTP input sanitization
- Email code validation
- Constant-time comparison (timing attack prevention)

### Cryptographic Tests (`CryptographicTest.php`)
- Random number generation for codes
- Password hashing for backup codes
- Token generation
- Timing-safe string comparison

### Utility Tests (`UtilsTest.php`)
- Multi-option code generation
- Input handling with special characters

## Running Tests

### Prerequisites

```bash
composer install
```

### Run all tests

```bash
composer test
```

### Run tests with coverage

```bash
composer test-coverage
```

Coverage report will be generated in the `coverage/` directory.

### Run specific test file

```bash
vendor/bin/phpunit tests/SecurityTest.php
```

## CI/CD

Tests run automatically on pull requests to `main` via GitHub Actions (`.github/workflows/tests.yml`).

The workflow includes:
- **Multiple PHP versions**: 7.4, 8.0, 8.1, 8.2
- **Security checks**: Scans for hardcoded credentials, SQL injection patterns
- **Code quality**: Syntax validation, file structure verification

## Test Philosophy

These tests focus on:
1. **Security-critical functions** - validating inputs, preventing injections
2. **Pure functions** - testing logic without MyBB dependencies
3. **Core functionality** - ensuring critical security features work correctly

Tests intentionally avoid:
- MyBB database operations (mocked)
- External email sending (mocked)
- Template rendering (mocked)
- Session management (mocked)

This allows tests to run independently without a full MyBB installation.
