<?php
class Php_func
{
    public function __call($function_name, $args)
    {
        return call_user_func_array($function_name, $args);
    }
}
