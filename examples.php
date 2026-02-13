<?php
/**
 * PHP Array Cleaner - Examples
 * 
 * Run this file to see all examples in action:
 * php examples.php
 */

require_once 'arr_cleaner.php';

echo "PHP Array Cleaner - Examples\n";
echo str_repeat("=", 50) . "\n\n";

// Example 1: Filter by Values
echo "Example 1: Filter by Values\n";
echo str_repeat("-", 50) . "\n";
$data1 = [
    'name' => 'John',
    'status' => 'inactive',
    'age' => 30,
    'role' => 'inactive'
];
echo "Before: " . json_encode($data1) . "\n";
$result1 = arrCleaner($data1, ['inactive']);
echo "After:  " . json_encode($result1) . "\n\n";

// Example 2: Filter by Keys
echo "Example 2: Filter by Keys\n";
echo str_repeat("-", 50) . "\n";
$data2 = [
    'name' => 'John',
    'password' => '12345',
    'email' => 'john@example.com',
    'secret_key' => 'xyz'
];
echo "Before: " . json_encode($data2) . "\n";
$result2 = arrCleaner($data2, ['password', 'secret_key'], filterByKeys: true);
echo "After:  " . json_encode($result2) . "\n\n";

// Example 3: Nested Arrays (Recursive)
echo "Example 3: Nested Arrays (Recursive)\n";
echo str_repeat("-", 50) . "\n";
$data3 = [
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
echo "Before: " . json_encode($data3) . "\n";
$result3 = arrCleaner($data3, ['password'], filterByKeys: true);
echo "After:  " . json_encode($result3) . "\n\n";

// Example 4: Remove Multiple Values
echo "Example 4: Remove Multiple Values\n";
echo str_repeat("-", 50) . "\n";
$data4 = [
    'items' => [
        'apple' => 'available',
        'banana' => 'out_of_stock',
        'orange' => 'available',
        'grape' => 'discontinued',
        'mango' => 'out_of_stock'
    ]
];
echo "Before: " . json_encode($data4) . "\n";
$result4 = arrCleaner($data4, ['out_of_stock', 'discontinued']);
echo "After:  " . json_encode($result4) . "\n\n";

// Example 5: Advanced - Remove null and underscore keys
echo "Example 5: Advanced - Remove null and underscore keys\n";
echo str_repeat("-", 50) . "\n";
$data5 = [
    'name' => 'John',
    '_internal' => 'secret',
    'age' => null,
    'email' => 'john@example.com',
    '_debug' => true
];
echo "Before: " . json_encode($data5) . "\n";
$result5 = arrCleanerAdvanced($data5, function($value, $key) {
    return str_starts_with($key, '_') || $value === null;
});
echo "After:  " . json_encode($result5) . "\n\n";

// Example 6: Advanced - Remove empty strings
echo "Example 6: Advanced - Remove empty strings and zeros\n";
echo str_repeat("-", 50) . "\n";
$data6 = [
    'name' => 'John',
    'description' => '',
    'count' => 0,
    'age' => 30,
    'bio' => ''
];
echo "Before: " . json_encode($data6) . "\n";
$result6 = arrCleanerAdvanced($data6, fn($v, $k) => $v === '' || $v === 0);
echo "After:  " . json_encode($result6) . "\n\n";

// Example 7: Complex nested structure
echo "Example 7: Complex Nested Structure\n";
echo str_repeat("-", 50) . "\n";
$data7 = [
    'users' => [
        [
            'id' => 1,
            'name' => 'John',
            'status' => 'inactive',
            'meta' => [
                'status' => 'inactive',
                'verified' => true
            ]
        ],
        [
            'id' => 2,
            'name' => 'Jane',
            'status' => 'active',
            'meta' => [
                'status' => 'active',
                'verified' => true
            ]
        ]
    ]
];
echo "Before: " . json_encode($data7) . "\n";
$result7 = arrCleaner($data7, ['inactive']);
echo "After:  " . json_encode($result7) . "\n\n";

// Example 8: Performance test
echo "Example 8: Performance Test\n";
echo str_repeat("-", 50) . "\n";
$largeArray = [];
for ($i = 0; $i < 1000; $i++) {
    $largeArray["key_" . $i] = [
        'id' => $i,
        'status' => $i % 2 === 0 ? 'active' : 'inactive',
        'data' => [
            'nested' => $i,
            'status' => 'inactive'
        ]
    ];
}
$start = microtime(true);
$resultLarge = arrCleaner($largeArray, ['inactive']);
$end = microtime(true);
$time = round(($end - $start) * 1000, 2);
echo "Filtered 1000 nested items in {$time}ms\n";
echo "Items before: " . count($largeArray) . "\n";
echo "Items after: " . count($resultLarge) . "\n\n";

echo str_repeat("=", 50) . "\n";
echo "All examples completed successfully!\n";