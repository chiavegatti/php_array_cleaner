<?php

/**
 * PHP Array Cleaner
 * 
 * Recursively removes items from an array based on keys or values.
 * Works with nested/multidimensional arrays.
 * 
 * @author chiavegatti
 * @license GPL-3.0
 * @version 2.0.0
 */

/**
 * Recursively removes items from an array based on keys or values
 * 
 * @param array $array Array to filter
 * @param array $filter Elements to remove (keys or values depending on $filterByKeys)
 * @param bool $filterByKeys true = filter by keys, false = filter by values (default: false)
 * @return array Filtered array
 * 
 * @example
 * // Remove by values
 * $data = ['name' => 'John', 'status' => 'inactive', 'age' => 30];
 * $result = arrCleaner($data, ['inactive'], false);
 * // Result: ['name' => 'John', 'age' => 30]
 * 
 * @example
 * // Remove by keys
 * $data = ['name' => 'John', 'password' => '123', 'email' => 'john@example.com'];
 * $result = arrCleaner($data, ['password'], true);
 * // Result: ['name' => 'John', 'email' => 'john@example.com']
 * 
 * @example
 * // Nested arrays
 * $data = [
 *     'user' => [
 *         'name' => 'John',
 *         'password' => '123',
 *         'address' => ['city' => 'NY', 'password' => 'secret']
 *     ]
 * ];
 * $result = arrCleaner($data, ['password'], true);
 * // Result: ['user' => ['name' => 'John', 'address' => ['city' => 'NY'] }]
 */
function arrCleaner(array $array, array $filter, bool $filterByKeys = false): array 
{
    if (empty($array)) {
        return $array;
    }

    foreach ($array as $key => $value) {
        if (is_array($value)) {
            // Recursive call for nested arrays
            $array[$key] = arrCleaner($value, $filter, $filterByKeys);
            
            // Remove empty arrays after filtering (optional - keeps structure clean)
            if (empty($array[$key])) {
                unset($array[$key]);
            }
        } else {
            // Check if should be removed
            if ($filterByKeys) {
                if (in_array($key, $filter, strict: true)) {
                    unset($array[$key]);
                }
            } else {
                if (in_array($value, $filter, strict: true)) {
                    unset($array[$key]);
                }
            }
        }
    }
    
    return $array;
}

/**
 * Alternative: Filter with custom callback for advanced use cases
 * 
 * @param array $array Array to filter
 * @param callable $callback Function that returns true to remove element
 * @return array Filtered array
 * 
 * @example
 * $result = arrCleanerAdvanced($data, function($value, $key) {
 *     return str_starts_with($key, '_') || $value === null;
 * });
 */
function arrCleanerAdvanced(array $array, callable $callback): array 
{
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            $array[$key] = arrCleanerAdvanced($value, $callback);
            
            if (empty($array[$key])) {
                unset($array[$key]);
            }
        } else {
            if ($callback($value, $key)) {
                unset($array[$key]);
            }
        }
    }
    
    return $array;
}