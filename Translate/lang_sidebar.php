<?php

function func($strs)
{
    global $lang;
    if (!empty($lang[$strs])) {
        return $lang[$strs];
    }
    return $strs;
}
