<?php

namespace App\Http\Middleware;

use Intervention\Image\Image;
use Intervention\Image\Filters\FilterInterface;

class ImageFilter implements FilterInterface {

    public function applyFilter(Image $img)
    {
        $max_w = config('const.image.max_width');
        $max_h = config('const.image.max_height');
        $w = $img->width();
        $h = $img->height();

        if ($max_w != $w || $max_h != $h) {
            $w_ratio = $max_w / $w;
            $h_ratio = $max_h / $h;

            if ($w_ratio > $h_ratio) {
                $img->resize($max_w, null, function($constraint) {
                    $constraint->aspectRatio();
                });
            } else {
                $img->resize(null, $max_h, function($constraint) {
                    $constraint->aspectRatio();
                });
            }

            $img->resizeCanvas($max_w, $max_h, 'center');
        }

        return $img->encode('jpg', 100);
    }
}