# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [2.0.0] - 2026-02-13

### 🚀 Added
- Modern PHP 8.0+ syntax with named arguments
- `arrCleanerAdvanced()` function for custom callback filtering
- Automatic cleanup of empty nested arrays after filtering
- Strict type comparisons for improved safety
- Comprehensive documentation with examples
- Composer support for package distribution
- Badges for PHP version, license, and version

### ⚡ Changed
- **BREAKING**: Removed callback parameter from main `arrCleaner()` function
- **BREAKING**: Renamed `$typeFilter` parameter to `$filterByKeys` for clarity
- **BREAKING**: Minimum PHP version is now 8.0
- Simplified API - no external callback required for basic usage
- Improved code readability and maintainability
- Updated return type hints to use modern PHP syntax

### 🗑️ Removed
- `arrCleanerCallback()` function (no longer needed for basic usage)
- Support for PHP 7.x (use v1.x for legacy projects)

### 📚 Documentation
- Complete README rewrite with modern examples
- Added migration guide from v1.x to v2.0
- Added comparison with native PHP functions
- Added advanced usage examples
- Added roadmap and contributing guidelines

### 🔧 Technical
- Added `composer.json` for Composer/Packagist distribution
- Added this CHANGELOG
- Prepared structure for future PHPUnit tests

---

## [1.0.0] - Legacy

### Initial Release
- Basic `arrCleaner()` function with callback support
- Recursive filtering of nested arrays
- Filter by keys or values
- `arrCleanerCallback()` helper function
- PHP 7.0+ compatible

---

## Migration Guide: v1.x → v2.0

### Before (v1.x)
```php
$result = arrCleaner($array, $filter, true, 'arrCleanerCallback');
```

### After (v2.0)
```php
// Simple syntax
$result = arrCleaner($array, $filter, filterByKeys: true);

// Or without named arguments
$result = arrCleaner($array, $filter, true);
```

### For Advanced Filtering
If you had custom callbacks in v1.x:

```php
// v1.x
function myCallback($filter, $typeFilter, $value, $key) {
    // custom logic
}
$result = arrCleaner($array, $filter, false, 'myCallback');
```

Use `arrCleanerAdvanced()` in v2.0:

```php
// v2.0
$result = arrCleanerAdvanced($array, function($value, $key) {
    // custom logic - return true to remove
    return /* your condition */;
});
```