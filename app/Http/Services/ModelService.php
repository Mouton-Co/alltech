<?php

namespace App\Http\Services;

class ModelService
{
    /**
     * Get the value of a nested property
     *
     * @param  mixed  $resource
     * @param  string|null  $value
     */
    public static function nestedValue($resource, $value): ?string
    {
        $nesters = explode('->', $value);
        $nester = $nesters[0];
        $field = $resource->$nester;

        for ($i = 1; $i < count($nesters); $i++) {
            $nester = $nesters[$i];
            if (empty($field->$nester)) {
                return null;
            }
            $field = $field->$nester;
        }

        return $field;
    }
}
