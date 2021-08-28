<?php
// Ini untuk custom function

namespace App\Helpers;

use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

trait GlobalFunction
{
    public static function itWorks()
    {
        return 'it works!';
    }

    public static function getPath( $pathname = 'public' )
    {
        $path = null;

        if( $pathname == 'public' )
        {
            $path = app_path();
        }

        if( $pathname == 'base' )
        {
            $path = base_path();
        }

        if( $pathname == 'config' )
        {
            $path = config_path();
        }

        if( $pathname == 'database' )
        {
            $path = database_path();
        }

        if( $pathname == 'resource' )
        {
            $path = resource_path();
        }

        if( $pathname == 'storage' )
        {
            $path = storage_path();
        }

        return $path;
    }

    public static function truncated( $string = null, $append = '...', $len = 30 )
    {
        $string = trim( strip_tags( $string ) );
        return Str::limit( $string, $len, $append );
    }

    public static function pad( $string = null, $len = 0, $position = 'both', $append = '' )
    {
        $result = null;
        $pad    = Str::of( $string );

        if( $position == 'both' )
        {
            $result = $pad->padBoth( $string, (int) $len, $append );
        }

        if( $position == 'left' )
        {
            $result = $pad->padLeft( $string, (int) $len, $append );
        }

        if( $position == 'right' )
        {
            $result = $pad->padRight( $string, (int) $len, $append );
        }

        return $result;
    }

    public static function replaceString( $string, $keywords, $replace = null, $openTag = '', $closeTag = '' )
    {
        $replace = empty( $replace ) ? $keywords : $replace;

        if( is_array( $keywords ) )
        {
            $pattern = array_map(function( $item ) {
                return '/' . $item . '/i';
            }, $keywords);

            $replacement    = array_map(function( $item ) use ( $openTag, $closeTag ) {
                return $openTag . $item . $closeTag;
            }, $replace);
        }
        else
        {
            $pattern        = '/' . $keywords . '/i';
            $replacement    = $openTag . $replace . $closeTag;
        }

        return preg_replace( $pattern, $replacement, $string );
    }

    public static function strFindPos( $keyword )
    {

    }

    public static function boldString( $string, $keywords, $replace = null )
    {
        $replace = empty( $replace ) ? $keywords : $replace;

        if( is_array( $replace ) )
        {
            $replacement = array_map(function( $item ) use ( $replace ) {
                return '<strong></strong>';
            }, $replace);
        }
        else
        {
            $replacement = '<strong>' . $replace . '</strong>';
        }

        return self::replaceString( $string, $replace, $replacement );
    }

    public static function foreignKeyEnable()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
    }

    public static function foreignKeyDisable()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    public static function showError( $line, $message )
    {
      return 'Error line code (' . $line . '): ' . $message;
    }

    public static function responseView( $view, $data = [] )
    {
        return response()->view( $view, $data )
        ->header('X-Content-Type-Options', 'nosniff')
        ->header('X-XSS-Protection', '1; mode=block')
        ->header('Cache-control', 'no-cache, max-age=0, no-store, must-revalidate')
        ->header('X-Frame-Options', 'SAMEORIGIN')
        ->header('Strict-Transport-Security', 'max-age=31536000; includeSubDomains')
        ->header('Referrer-Policy', 'no-referrer');
    }

    public static function responseJson( $response = [], $status_code = 200, $cors = 'no' )
    {
        $response = response()->json( $response, $status_code )
        ->header('X-Content-Type-Options', 'nosniff')
        ->header('X-XSS-Protection', '1; mode=block')
        ->header('Cache-control', 'no-cache, max-age=0, no-store, must-revalidate')
        ->header('X-Frame-Options', 'SAMEORIGIN')
        ->header('Strict-Transport-Security', 'max-age=31536000; includeSubDomains')
        ->header('Referrer-Policy', 'no-referrer');

        if( $cors == 'yes' )
        {
            $response = $response->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
            ->header('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Authorization');
        }

        return $response;
    }

    public static function storageDisk( $disk )
    {
        return Storage::disk( $disk );
    }

    public static function downloadFile( $disk, $location, $name = null, $headers = [] )
    {
        return self::storageDisk( $disk )->download( $location, $name, $headers );
    }

    public static function storageGetUrl( $disk, $location )
    {
        $url = null;

        if( self::checkFileExist( $disk, $location ) === true )
        {
            $url = self::storageDisk( $disk )->url( $location );
        }

        return $url;
    }

    public static function uploadFromStorage( $disk, $location, $request, $filename )
    {
        return self::storageDisk( $disk )->putFileAs( $location, $request, $filename );
    }

    public static function checkFileExist( $disk, $location )
    {
        return self::storageDisk( $disk )->exists( $location ) ? true : false;
    }

    public static function deleteFile( $disk, $location )
    {
        if( self::checkFileExist( $disk, $location ) === true )
            return self::storageDisk($disk)->delete( $location );

        return false;
    }

    public static function storageGetFile( $disk, $location, $filename )
    {
        $files = $location . '/' . $filename;

        if( self::checkFileExist( $disk, $files ) )
        {
            return self::storageDisk( $disk )->get( $files );
        }

        return false;
    }

    public static function generateUuid()
    {
        return Str::uuid()->toString();
    }

    public static function rand( $length = 32 )
    {
        if( ! is_numeric( $length ) ) $length = 32;
        return Str::random($length);
    }

    public static function makeHash( $string )
    {
        return Hash::make( $string );
    }

    public static function checkHash( $plain, $hash )
    {
        return Hash::check( $plain, $hash );
    }

    public static function encode64( $string )
    {
        return base64_encode( $string );
    }

    public static function decode64( $string )
    {
        return base64_decode( $string );
    }

    public static function kebab( $string )
    {
        return Str::kebab( $string );
    }

    public static function slug( $string, $divider = '-' )
    {
        return Str::slug( $string, $divider );
    }

    public static function isEmpty( $data = [] )
    {
        $data = is_array( $data ) ? $data : func_get_args();

        $filter = array_filter( $data, function( $item ) {
            return empty( $item );
        });

        return count( $filter ) > 0
        ? true
        : false;
    }

    public static function isArrayExist( $data = [], $key = null )
    {
        if( ! is_array( $data ) ) return false;
        return Arr::exists( $data, $key );
    }

    public static function labelStatus( $status )
    {
        return $status == 'Y' ? 'Publish' : 'Unpublish';
    }

    public static function labelStatusCustomer( $status = 'new' )
    {
        $label = 'New Registered';

        if( $status == 'new' )
        {
            $label = 'New Registered';
        }
        else if( $status == 'pending' )
        {
            $label = 'Pending Approval';
        }
        else if( $status == 'verified' )
        {
            $label = 'Verified';
        }
        else
        {
            $label = 'Rejected';
        }

        return $label;
    }

    public static function labelStatusClassCustomer( $status = 'new' )
    {
        $label = 'badge-primary';

        if( $status == 'new' )
        {
            $label = 'badge-primary';
        }
        else if( $status == 'pending' )
        {
            $label = 'badge-warning';
        }
        else if( $status == 'verified' )
        {
            $label = 'badge-success';
        }
        else
        {
            $label = 'badge-danger';
        }

        return $label;
    }

    public static function getRouteName()
    {
        return Route::currentRouteName();
    }

    public static function getFileJson( $disk, $location = 'json', $filename = null )
    {
        $get_file = self::storageGetFile( $disk, $location, $filename );
        return $get_file === false
        ? []
        : ( empty( $get_file ) ? [] : json_decode( $get_file, true ) );
    }

    public static function updateFileJson( $disk, $data = [], $location = 'json', $filename )
    {
        return self::storageDisk( $disk )->put(
            $location . '/' . $filename,
            json_encode( $data )
        );
    }

    public static function validateGrecaptcha( $request_data )
    {
        $url_api    = 'https://www.google.com/recaptcha/api/siteverify';
        $response   = Http::asForm()->post( $url_api, $request_data );
        $response   = $response->successful() ? $response->body() : null;

        if( $response )
        {
            $result = json_decode( $response, true );
            return $result['success'];
        }
        else
        {
            return null;
        }
    }
}
