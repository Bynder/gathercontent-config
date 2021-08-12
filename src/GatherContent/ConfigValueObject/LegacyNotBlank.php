<?php

namespace GatherContent\ConfigValueObject;

trait LegacyNotBlank
{
    /**
     * Assert that value is not blank
     *
     * @param mixed $value
     * @param string|null $message
     * @param string|null $propertyPath
     * @return void
     * @throws \Assert\AssertionFailedException
     */
    public static function notBlank($value, $message = null, $propertyPath = null)
    {
        if (false === $value || (empty($value) && '0' != $value)) {
            $message = sprintf(
                $message ?: 'Value "%s" is blank, but was expected to contain a value.',
                self::stringify($value)
            );

            throw static::createException($value, $message, Assertion::INVALID_NOT_BLANK, $propertyPath);
        }
    }

    /**
     * Helper method that handles building the assertion failure exceptions.
     * They are returned from this method so that the stack trace still shows
     * the assertions method.
     */
    protected static function createException($value, $message, $code, $propertyPath, array $constraints = array())
    {
        return new ConfigValueException($message, $code, $propertyPath, $value, $constraints);
    }

    /**
     * Make a string version of a value.
     *
     * @param mixed $value
     * @return string
     */
    private static function stringify($value)
    {
        if (is_bool($value)) {
            return $value ? '<TRUE>' : '<FALSE>';
        }

        if (is_scalar($value)) {
            $val = (string)$value;

            if (strlen($val) > 100) {
                $val = substr($val, 0, 97) . '...';
            }

            return $val;
        }

        if (is_array($value)) {
            return '<ARRAY>';
        }

        if (is_object($value)) {
            return get_class($value);
        }

        if (is_resource($value)) {
            return '<RESOURCE>';
        }

        if ($value === NULL) {
            return '<NULL>';
        }

        return 'unknown';
    }

}