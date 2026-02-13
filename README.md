# PHP Array Cleaner

![PHP Version](https://img.shields.io/badge/PHP-8.0%2B-777BB4?logo=php&logoColor=white)
![License](https://img.shields.io/badge/license-GPL--3.0-blue)
![Version](https://img.shields.io/badge/version-2.0.0-green)

A modern PHP utility for recursively cleaning associative arrays by filtering keys or values. Works seamlessly with nested/multidimensional arrays.

---

## 🎯 What's New in v2.0

- ✅ **PHP 8.0+ syntax** with modern type hints
- ✅ **Simplified API** - no callback required for basic usage
- ✅ **Named arguments** support
- ✅ **Strict comparisons** by default
- ✅ **Auto-cleanup** of empty nested arrays
- ✅ **Advanced mode** with custom callbacks
- ✅ **Composer ready** for easy installation

---

## 📋 Description

`php_array_cleaner` provides a simple and efficient way to remove specific elements from nested arrays based on their keys or values. The function works recursively, ensuring that all levels of a multidimensional array are properly filtered.

**Why use this?** PHP's native `array_filter()`, `array_diff()`, and `array_diff_key()` don't work recursively on nested arrays. This library solves that problem.

---

## 🚀 Features

- ✅ Recursive filtering of deeply nested arrays
- ✅ Filter by keys OR values
- ✅ Preserves array structure and keys
- ✅ Type-safe with PHP 8+ type declarations
- ✅ Zero dependencies
- ✅ Simple API with optional advanced mode
- ✅ PSR-12 compliant code

---

## 📦 Installation

### Via Composer (recommended)

```bash
composer require chiavegatti/php_array_cleaner
```

### Manual Installation

Download and include the file:

```php
require_once 'arr_cleaner.php';
```

---

## 💡 Usage

### Basic Syntax

```php
arrCleaner(array $array, array $filter, bool $filterByKeys = false): array
```

### Parameters

| Parameter | Type | Required | Default | Description |
|-----------|------|----------|---------|-------------|
| `$array` | array | Yes | - | The array to be filtered |
| `$filter` | array | Yes | - | List of keys or values to remove |
| `$filterByKeys` | bool | No | `false` | `true` = filter by keys, `false` = filter by values |

### Return Value

Returns the filtered array with matching elements removed.

---

## 📖 Examples

### Example 1: Filter by Values (default)

Remove all occurrences of specific values:

```php
$data = [
    'name' => 'John',
    'status' => 'inactive',
    'age' => 30,
    'role' => 'inactive'
];

$result = arrCleaner($data, filter: ['inactive']);

// Result: ['name' => 'John', 'age' => 30]
```

### Example 2: Filter by Keys

Remove specific keys from the array:

```php
$data = [
    'name' => 'John',
    'password' => '12345',
    'email' => 'john@example.com',
    'secret_key' => 'xyz'
];

$result = arrCleaner(
    array: $data,
    filter: ['password', 'secret_key'],
    filterByKeys: true
);

// Result: ['name' => 'John', 'email' => 'john@example.com']
```

### Example 3: Nested Arrays (Recursive)

Works recursively with multidimensional arrays:

```php
$data = [
    'user' => [
        'name' => 'John',
        'password' => '123',
        'address' => [
            'city' => 'New York',
            'password' => 'secret',
            'zip' => '10001'
        ]
    ],
    'password' => 'root'
];

$result = arrCleaner($data, ['password'], filterByKeys: true);

// Result: 
// [
//     'user' => [
//         'name' => 'John',
//         'address' => [
//             'city' => 'New York',
//             'zip' => '10001'
//         ]
//     ]
// ]
```

### Example 4: Remove Multiple Values

```php
$data = [
    'items' => [
        'apple' => 'available',
        'banana' => 'out_of_stock',
        'orange' => 'available',
        'grape' => 'discontinued',
        'mango' => 'out_of_stock'
    ]
];

$result = arrCleaner($data, ['out_of_stock', 'discontinued']);

// Result: 
// [
//     'items' => [
//         'apple' => 'available',
//         'orange' => 'available'
//     ]
// ]
```

---

## 🔧 Advanced Usage

For complex filtering logic, use `arrCleanerAdvanced()` with a custom callback:

```php
// Remove all null values and keys starting with underscore
$data = [
    'name' => 'John',
    '_internal' => 'secret',
    'age' => null,
    'email' => 'john@example.com',
    '_debug' => true
];

$result = arrCleanerAdvanced($data, function($value, $key) {
    return str_starts_with($key, '_') || $value === null;
});

// Result: ['name' => 'John', 'email' => 'john@example.com']
```

### More Advanced Examples

```php
// Remove empty strings and zero values
$result = arrCleanerAdvanced($data, fn($v, $k) => $v === '' || $v === 0);

// Remove keys matching a pattern
$result = arrCleanerAdvanced($data, fn($v, $k) => preg_match('/^temp_/', $k));

// Remove values outside a range
$result = arrCleanerAdvanced($data, fn($v, $k) => is_numeric($v) && ($v < 0 || $v > 100));
```

---

## 🆚 Comparison with Native PHP Functions

| Feature | `arrCleaner()` | `array_filter()` | `array_diff()` | `array_diff_key()` |
|---------|----------------|------------------|----------------|-------------------|
| Filter by values | ✅ | ✅ | ✅ | ❌ |
| Filter by keys | ✅ | ⚠️ (with flag) | ❌ | ✅ |
| Recursive (nested arrays) | ✅ | ❌ | ❌ | ❌ |
| Custom callback | ✅ | ✅ | ❌ | ❌ |
| Named arguments | ✅ | ✅ | ✅ | ✅ |
| PHP 8+ syntax | ✅ | ✅ | ✅ | ✅ |

**Key Advantage:** `arrCleaner()` is the **only solution** that handles nested arrays recursively without manual loops.

---

## ⚙️ Requirements

- PHP 8.0 or higher
- No external dependencies

---

## 📦 Composer Configuration

```json
{
    "require": {
        "chiavegatti/php_array_cleaner": "^2.0"
    }
}
```

---

## 🧪 Testing

```bash
# Run the examples
php examples.php

# Install PHPUnit (for future unit tests)
composer require --dev phpunit/phpunit
```

---

## 🔄 Migration from v1.x

### Old Syntax (v1.x)
```php
arrCleaner($array, $filter, true, 'arrCleanerCallback');
```

### New Syntax (v2.0)
```php
arrCleaner($array, $filter, filterByKeys: true);
```

**Breaking Changes:**
- ❌ Removed required `$callback` parameter
- ✅ Simplified to 3 parameters (was 4)
- ✅ Added `arrCleanerAdvanced()` for custom callbacks
- ✅ Now uses strict comparisons by default

---

## 📄 License

[GNU General Public License v3.0](LICENSE)

This means you can freely use, modify, and distribute this code, but any modifications must also be open-sourced under GPL-3.0.

---

## 🤝 Contributing

Contributions, issues, and feature requests are welcome!

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

---

## 👤 Author

**chiavegatti**
- GitHub: [@chiavegatti](https://github.com/chiavegatti)
- Repository: [php_array_cleaner](https://github.com/chiavegatti/php_array_cleaner)

---

## 📌 Roadmap

- [ ] Add comprehensive PHPUnit tests
- [ ] Publish to Packagist
- [ ] Add CI/CD with GitHub Actions
- [ ] Performance benchmarks
- [ ] Support for object filtering
- [ ] Laravel/Symfony integrations

---

## ⭐ Show Your Support

If this project helped you, please give it a ⭐️!

---

**Made with ❤️ by [chiavegatti](https://github.com/chiavegatti) | Modern PHP for 2026+