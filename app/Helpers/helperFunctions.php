<?php


use NumberFormatter as NumberFormatter;
use Illuminate\Support\Optional;
use Illuminate\Support\Str;

// Steps To Make Helper File
//     * create app/helpers.php
//     * add this
//     "files": [
//         "app/helpers.php"
//     ]
//     inside the "autoload": {}  in composer.json
//     * run > composer dump-autoload
//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////
function transformDate($value, $format = 'Y-m-d')
{
    try {
        return \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value));
    } catch (\ErrorException $e) {
        return \Carbon\Carbon::createFromFormat($format, $value);
    }
}
//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////
function format_money_custom($amount, $currency = null)
{
    $formatter = new NumberFormatter(config('app.locale'), NumberFormatter::CURRENCY);
    if ($currency === null) {
        $currency = config('app.currency', 'ils');
    }
    return $formatter->formatCurrency($amount, $currency);
}
//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////
function quickRandomString($length = 4)
{
    $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
}
//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////
// function productImagePath($image_name)
// {
//     return public_path('images/products/' . $image_name);
// }
//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////
// function model_path($model){
//     return "App\\Models\\$model";
// }
// function request_path($request){
//     return "App\\Http\\Requests\\$request";
// }
// function resource_path($resource){
//     return "App\\Http\\Resources\\$resource";
// }
//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////
function get_class_name($classPath)
{
    $classPath = get_class($classPath);
    $pathPartials = explode('\\', $classPath);
    return end($pathPartials);
}
//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////
if (!function_exists('optional')) {
    function optional($value = null, callable $callback = null)
    {
        if (is_null($callback)) {
            return new Optional($value);
        } elseif (!is_null($callback)) {
            return $callback($value);
        }
    }
}
//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////
if (!function_exists('image_url')) {
    function image_url($img, $custom_path = null)
    {
        if ($img)
            return (!empty($custom_path)) ? asset($custom_path . '/' . $img) : asset('storage/' . $img);

        return asset('cms/assets/media/custom/default_no-image-available-1.png');
    }
}
//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////
function slug($attr)
{
    return quickRandomString() . '-' . Str::slug($attr);
}
//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////
if (!function_exists('format_resource')) {
    function format_resource($text)
    {
        // Replace underscores with spaces
        $text = str_replace('_', ' ', $text);

        // Add space before capital letters
        $text = preg_replace('/(?<=\w)(?=[A-Z])/', ' ', $text);

        // Capitalize the first letter of each word
        $text = ucwords($text);

        return $text;
    }
}
//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////



// trait uploadFile {
//     protected function uploadImage(
//         Request $request,
//         $old_image = null,
//         $filename = 'image',
//         $disk = 'public',
//         $path = '/'
//     ) {
//         if ($request->hasFile($filename)) {
//             if ($old_image) {
//                 Storage::disk($disk)->delete($old_image);
//             }
//             $file = $request->file($filename);

//             // $file->getClientOriginalName();
//             // $file->getSize();
//             // $file->getClientOriginalExtension();
//             // $file->getMimeType();

//             $path = $file->store($path, $disk);
//         } else {
//             $path = $old_image;
//         }
//         return $path;
//     }
// }
