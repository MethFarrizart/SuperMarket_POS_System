<?php
require get_language_file();
function get_language_file()
{
    $_SESSION['lang'] = $_SESSION['lang'] ?? 'kh';
    $_SESSION['lang'] = $_GET['lang'] ?? $_SESSION['lang'];

    return "../../Translate/" . $_SESSION['lang'] . ".php";
}


function __($str)
{
    global $lang;
    if (!empty($lang[$str])) {
        return $lang[$str] . '<style> *{font-family: "Khmer OS Siemreap"; font-weight: bold;} </style>';
    }
    return $str;
}
