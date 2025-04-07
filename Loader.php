<?php
function autoload($className)
{
    require $className . '.php';
}
spl_autoload_register('autoload');
