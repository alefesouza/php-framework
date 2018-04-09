<?php

namespace Framework\Models;

use JsonSerializable;

abstract class JsonCommon implements JsonSerializable
{
    public function jsonSerialize()
    {
        $vars = get_object_vars($this);

        foreach ($vars as $key => $value) {
            if (!isset($vars[$key]) || $vars[$key] === 0) {
                unset($vars[$key]);
            }
        }

        return $vars;
    }
}
