# Security System Test Documentation

This document provides comprehensive testing documentation for the Laravel Security Incident Alert System.

## Test Structure

### Unit Tests

#### DetectBruteForceTest (`tests/Unit/Middleware/DetectBruteForceTest.php`)
Tests the rate limiting middleware functionality:
- ✅ Normal traffic passes through
- ✅ Rate limit blocking works correctly
- ✅ Duplicate notifications are prevented
- ✅ Notification failures are logged
- ✅ Incident data structure is correct
- ✅ Rate limiting parameters are accurate

#### FailedLoginListenerTest (`tests/Unit/Listeners/FailedLoginListenerTest.php`)
Tests the failed login event listener:
- ✅ Failed login attempts are tracked
- ✅ Events without email are handled
- ✅ IP-based brute force detection
- ✅ Email-based brute force detection
- ✅ Duplicate notification prevention
- ✅ Simultaneous IP and email thresholds
- ✅ Notification failure handling
- ✅ Correct decay times (15 minutes)
- ✅ Complete incident data structure

#### SecurityIncidentTest (`tests/Unit/Notifications/SecurityIncidentTest.php`)
Tests the multi-channel notification system:
- ✅ Channel selection based on configuration
- ✅ Telegram message formatting for all incident types
- ✅ Slack message formatting with proper colors
- ✅ Email message formatting with all fields
- ✅ Optional field handling
- ✅ Subject lines for different incident types
- ✅ Array representation
- ✅ Queue configuration
- ✅ Long text truncation

### Feature Tests

#### TestIncidentTest (`tests/Feature/Commands/TestIncidentTest.php`)
Tests the artisan testing command:
- ✅ All incident types can be tested
- ✅ Default type handling
- ✅ Invalid type rejection
- ✅ Success message display
- ✅ Channel-specific output
- ✅ Notification failure handling
- ✅ Test data structure accuracy
- ✅ Consistent test data across calls

#### SecurityIntegrationTest (`tests/Feature/Security/SecurityIntegrationTest.php`)
Tests complete security flow integration:
- ✅ Complete brute force attack scenarios
- ✅ Multi-IP email-based attacks
- ✅ Rate limiting notification prevention
- ✅ Request blocking after rate limits
- ✅ Concurrent attack handling
- ✅ System recovery after decay
- ✅ Edge cases (empty email, null user agent, long URLs)
- ✅ IPv6 address support
- ✅ High volume legitimate traffic
- ✅ Notification failure resilience

#### SecurityPerformanceTest (`tests/Feature/Security/SecurityPerformanceTest.php`)
Tests system performance under load:
- ✅ Middleware efficiency (1000 requests < 5 seconds)
- ✅ Event listener burst handling (500 events < 3 seconds)
- ✅ Rate limiter memory usage (< 10MB for 2000 keys)
- ✅ Cache operation efficiency (1000 ops < 2 seconds)
- ✅ Notification queue handling (100 notifications < 5 seconds)
- ✅ Concurrent attack type handling
- ✅ Large incident data processing
- ✅ Accuracy under stress
- ✅ Cleanup operation efficiency

## Running Tests

### Run All Security Tests
```bash
php artisan test --filter Security
```

### Run Specific Test Categories

**Unit Tests Only:**
```bash
php artisan test tests/Unit/Middleware/DetectBruteForceTest.php
php artisan test tests/Unit/Listeners/FailedLoginListenerTest.php
php artisan test tests/Unit/Notifications/SecurityIncidentTest.php
```

**Feature Tests Only:**
```bash
php artisan test tests/Feature/Commands/TestIncidentTest.php
php artisan test tests/Feature/Security/SecurityIntegrationTest.php
php artisan test tests/Feature/Security/SecurityPerformanceTest.php
```

**Complete Test Suite:**
```bash
php artisan test tests/Feature/Security/SecurityTestSuite.php
```

### Performance Benchmarks

**Expected Performance Metrics:**
- Middleware: < 5ms per request (normal load)
- Event Listener: < 6ms per failed login event
- Notification Creation: < 100ms per incident
- Rate Limiter Memory: < 5KB per unique IP/email
- Cache Operations: < 2ms per operation

### Test Coverage

**What's Tested:**
- ✅ Rate limiting accuracy and thresholds
- ✅ Incident detection logic for all types
- ✅ Multi-channel notification delivery
- ✅ Caching and duplicate prevention
- ✅ Error handling and graceful degradation
- ✅ Performance under load
- ✅ Edge cases and unusual inputs
- ✅ Security boundary conditions
- ✅ Data integrity and structure
- ✅ Configuration-based behavior

**What's NOT Tested (Requires Manual Testing):**
- Actual Telegram bot API calls
- Real SMTP email delivery
- Slack webhook delivery
- Network failure scenarios
- Database connection failures
- Redis connection failures

## Manual Testing Checklist

### 1. End-to-End Notification Testing
```bash
# Test each incident type
php artisan incident:test brute_force
php artisan incident:test failed_login
php artisan incident:test suspicious_activity

# Verify notifications arrive in:
# - Email inbox
# - Telegram chat
# - Slack channel (if configured)
```

### 2. Real Attack Simulation
```bash
# Use curl or a script to simulate:
# 1. Multiple failed login attempts (6+ from same IP)
# 2. Rate limiting (50+ requests per minute)
# 3. Email-based attacks (3+ failures for same email)

# Example failed login simulation:
for i in {1..6}; do
  curl -X POST https://andrej.nankov.mk/login \
    -d "email=test@example.com&password=wrong" \
    -H "X-Forwarded-For: 192.168.1.100"
done
```

### 3. Configuration Testing
Test with different configurations:
- Telegram only
- Email only
- All channels enabled
- No channels configured (should not crash)

### 4. Queue Worker Testing
```bash
# Start queue worker
php artisan queue:work --queue=notifications

# Generate incidents and verify they're processed
# Monitor: storage/logs/laravel.log
# Monitor: php artisan queue:monitor
```

## Troubleshooting Tests

### Common Test Failures

**Rate Limiter Tests Failing:**
```bash
# Clear rate limiters between tests
php artisan cache:clear
```

**Notification Tests Failing:**
```bash
# Ensure notification fake is properly set up
# Check config values in test environment
```

**Performance Tests Failing:**
```bash
# Run on dedicated test environment
# Ensure no other processes are consuming resources
# Use array cache driver for consistent results
```

### Debug Commands

**View Test Output with Details:**
```bash
php artisan test --filter SecurityTest --verbose
```

**Run Single Test Method:**
```bash
php artisan test --filter "it_detects_ip_based_brute_force_attack"
```

**Test with Coverage:**
```bash
php artisan test --coverage --filter Security
```

## Test Data

**Sample IPs Used in Tests:**
- `192.168.1.1` - Primary test IP
- `192.168.1.100` - Command test IP
- `10.0.0.1-10.0.0.4` - Multiple IP tests
- `2001:0db8:85a3:...` - IPv6 test

**Sample Emails:**
- `test@example.com` - General testing
- `admin@andrej.nankov.mk` - Admin attack simulation
- `victim@example.com` - Victim testing

**Test Thresholds:**
- IP-based: 5 failed attempts
- Email-based: 3 failed attempts
- Rate limiting: 50 requests per minute
- Cache duration: 1 hour for notification prevention

## Continuous Integration

**Recommended CI Pipeline:**
```yaml
name: Security Tests
on: [push, pull_request]
jobs:
  security-tests:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v2
      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: 8.2
      - name: Install Dependencies
        run: composer install
      - name: Run Security Tests
        run: php artisan test --filter Security --parallel
```

This comprehensive test suite ensures the security system is robust, performant, and reliable under various conditions and attack scenarios.