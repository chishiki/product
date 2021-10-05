<?php

    foreach (glob($_SERVER['DOCUMENT_ROOT'] . '/satellites/product/php/model/*.php') AS $models) { require($models); }
    foreach (glob($_SERVER['DOCUMENT_ROOT'] . '/satellites/product/php/view/*.php') AS $views) { require($views); }
    foreach (glob($_SERVER['DOCUMENT_ROOT'] . '/satellites/product/php/controller/*.php') AS $controllers) { require($controllers); }

?>