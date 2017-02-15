<?php
require('../includes/ImageResize.php');
/*  this file by aranje, any mistakes are his.
    this is a clone of what I think imgix does well, but done badly
 */

use \Eventviva\ImageResize;

if (isset($_GET['width'])) {
    if (is_numeric(trim($_GET['width']))) {
        $width = $_GET['width'];
    }
}

if (isset($_GET['height'])) {
    if (is_numeric(trim($_GET['height']))) {
        $height = $_GET['height'];
    }
}

if (isset($_GET['file'])) {
    $file = $_GET['file'];
    $root_path = "/home/tecmedia/public_html/feed/";
    $image_path = realpath($root_path . $file);
    if (realpath($image_path)) {
        //echo $image_path;
            if (strpos($image_path, $root_path) !== false) {
                header('cache-control:public; stale-if-error=315360000; stale-while-revalidate=315360000; immutable');
                header('cache-control:max-age=315360000');
                header('Expires: Thu, 31 Dec 2037 23:55:55 GMT');
                $image = new ImageResize($image_path);
                if (isset($height) && isset($width)) {
                    $image->resizeToBestFit($width, $height);
                } elseif (isset($width)) {
                    $image->resizeToWidth($width);
                } elseif (isset($height)) {
                    $image->resizeToHeight($height);
                }
                $image->output();
            } else {
                header('Location: https://placehold.it/300x250');
            }
    } else {
        header('Location: https://placehold.it/300x250');
    }
} else {
    header('Location: https://placehold.it/300x250');
}
