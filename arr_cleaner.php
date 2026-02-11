<?php
/**
 * Recursively removes array items based on specified filter criteria
 * 
 * This function traverses multi-dimensional arrays and removes elements that match
 * the filter criteria. Can filter by keys or values, with optional custom callback.
 * 
 * @param array         $array       The array to be filtered (will be traversed recursively)
 * @param array         $filter      List of values/keys to remove from the array
 * @param bool          $filterKeys  If true, filters by keys; if false, filters by values (default: false)
 * @param callable|null $callback    Optional custom filter function with signature: fn($filterList, $filterKeys, $value, $key): bool
 *                                   Should return true to remove the item, false to keep it
 * 
 * @return array|false Returns the filtered array, or false if input is invalid
 * 
 * @example
 * // Remove specific values
 * $data = ['a' => 1, 'b' => 2, 'c' => 3];
 * $result = arrCleaner($data, [2, 3]); // Returns: ['a' => 1]
 * 
 * @example
 * // Remove specific keys
 * $data = ['name' => 'John', 'age' => 30, 'email' => 'test@example.com'];
 * $result = arrCleaner($data, ['age', 'email'], true); // Returns: ['name' => 'John']
 * 
 * @example
 * // Nested arrays with value filtering
 * $data = [
 *     'users' => ['admin', 'guest', 'user'],
 *     'roles' => ['admin', 'moderator']
 * ];
 * $result = arrCleaner($data, ['admin']); 
 * // Returns: ['users' => ['guest', 'user'], 'roles' => ['moderator']]
 */
function arrCleaner(array $array, array $filter, bool $filterKeys = false, ?callable $callback = null): array|false
{
    // Input validation
    if (empty($array)) {
        return $array;
    }

    if (empty($filter)) {
        return $array;
    }

    // Use custom callback or default filtering logic
    $filterFunction = $callback ?? function($filter, $filterKeys, $value, $key): bool {
        return in_array($filterKeys ? $key : $value, $filter, true);
    };

    // Process array recursively
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            // Recursively clean nested arrays
            $array[$key] = arrCleaner($value, $filter, $filterKeys, $callback);
        } else {
            // Apply filter function
            if ($filterFunction($filter, $filterKeys, $value, $key)) {
                unset($array[$key]);
            }
        }
    }

    return $array;
}

/**
 * Default callback implementation for arrCleaner
 * 
 * This function provides the standard filtering logic when no custom callback is provided.
 * It checks if the current value/key matches any item in the filter list.
 * 
 * @param array $filter      List of values/keys to filter
 * @param bool  $filterKeys  If true, compares keys; if false, compares values
 * @param mixed $value       Current value being evaluated
 * @param mixed $key         Current key being evaluated
 * 
 * @return bool Returns true if item should be removed, false otherwise
 * 
 * @deprecated This function is now integrated into arrCleaner as a closure
 */
function arrCleanerCallback(array $filter, bool $filterKeys, mixed $value, mixed $key): bool
{
    return in_array($filterKeys ? $key : $value, $filter, true);
}