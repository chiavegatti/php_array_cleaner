<?php

/**
 * PHP Array Cleaner - Usage Examples
 * 
 * Run this file to see practical examples of how to use arrCleaner()
 * 
 * @author chiavegatti
 * @version 2.0.0
 */

require_once 'arr_cleaner.php';

echo "========================================\n";
echo "PHP Array Cleaner - Examples\n";
echo "========================================\n\n";

// Example 1: Filter by values (default)
echo "Example 1: Filter by values\n";
echo "----------------------------\n";
$data = [
    'name' => 'John',
    'status' => 'inactive',
    'age' => 30,
    'role' => 'inactive'
];

echo "Original: ";
print_r($data);

$result = arrCleaner($data, ['inactive']);
echo "After removing 'inactive': ";
print_r($result);
echo "\n";

// Example 2: Filter by keys
echo "Example 2: Filter by keys\n";
echo "----------------------------\n";
$data = [
    'name' => 'John',
    'password' => '12345',
    'email' => 'john@example.com',
    'secret_key' => 'xyz'
];

echo "Original: ";
print_r($data);

$result = arrCleaner($data, ['password', 'secret_key'], filterByKeys: true);
echo "After removing sensitive keys: ";
print_r($result);
echo "\n";

// Example 3: Nested arrays (recursive)
echo "Example 3: Nested arrays (recursive)\n";
echo "----------------------------\n";
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

echo "Original: ";
print_r($data);

$result = arrCleaner($data, ['password'], filterByKeys: true);
echo "After removing all 'password' keys recursively: ";
print_r($result);
echo "\n";

// Example 4: Multiple values
echo "Example 4: Remove multiple values\n";
echo "----------------------------\n";
$data = [
    'items' => [
        'apple' => 'available',
        'banana' => 'out_of_stock',
        'orange' => 'available',
        'grape' => 'discontinued',
        'mango' => 'out_of_stock'
    ]
];

echo "Original: ";
print_r($data);

$result = arrCleaner($data, ['out_of_stock', 'discontinued']);
echo "After removing unavailable items: ";
print_r($result);
echo "\n";

// Example 5: Advanced - Custom callback
echo "Example 5: Advanced with custom callback\n";
echo "----------------------------\n";
$data = [
    'name' => 'John',
    '_internal' => 'secret',
    'age' => null,
    'email' => 'john@example.com',
    '_debug' => true,
    'phone' => '123-456'
];

echo "Original: ";
print_r($data);

$result = arrCleanerAdvanced($data, function($value, $key) {
    return str_starts_with($key, '_') || $value === null;
});
echo "After removing keys starting with '_' and null values: ";
print_r($result);
echo "\n";

// Example 6: Advanced - Remove empty strings
echo "Example 6: Remove empty strings and zeros\n";
echo "----------------------------\n";
$data = [
    'name' => 'John',
    'middle_name' => '',
    'age' => 30,
    'score' => 0,
    'email' => 'john@example.com',
    'notes' => ''
];

echo "Original: ";
print_r($data);

$result = arrCleanerAdvanced($data, fn($v, $k) => $v === '' || $v === 0);
echo "After removing empty strings and zeros: ";
print_r($result);
echo "\n";

// Example 7: Complex nested structure
echo "Example 7: Complex nested structure\n";
echo "----------------------------\n";
$data = [
    'users' => [
        [
            'id' => 1,
            'name' => 'John',
            'status' => 'active',
            'metadata' => [
                'created' => '2024-01-01',
                'status' => 'active'
            ]
        ],
        [
            'id' => 2,
            'name' => 'Jane',
            'status' => 'inactive',
            'metadata' => [
                'created' => '2024-01-02',
                'status' => 'inactive'
            ]
        ]
    ]
];

echo "Original: ";
print_r($data);

$result = arrCleaner($data, ['inactive']);
echo "After removing 'inactive' status: ";
print_r($result);
echo "\n";

// Example 8: Performance test
echo "Example 8: Performance test\n";
echo "----------------------------\n";
$largeArray = [];
for ($i = 0; $i < 1000; $i++) {
    $largeArray["key_$i"] = ($i % 3 === 0) ? 'remove_me' : "value_$i";
}

echo "Testing with 1000 elements...\n";
$start = microtime(true);
$result = arrCleaner($largeArray, ['remove_me']);
$end = microtime(true);

echo "Original count: " . count($largeArray) . "\n";
echo "Result count: " . count($result) . "\n";
echo "Execution time: " . number_format(($end - $start) * 1000, 4) . " ms\n";

echo "\n========================================\n";
echo "All examples completed!\n";
echo "========================================\n";