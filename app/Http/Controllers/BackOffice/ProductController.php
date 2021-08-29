<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Helpers\GlobalFunction as HelperFunction;
use App\Model\Product;

class ProductController extends Controller
{
  use HelperFunction;

  private $module_view = 'backoffice.modules.produk';
  private $status_message;
  private $status_alert;
  private $storage_disk = 'public';
  private $folder_disk  = 'produk';

  public function index( Request $request )
  {
    $keywords     = $request->keywords;
    $module_view  = $this->module_view . '.index';
    $getProduct   = Product::getAll( 'admin', $keywords );

    $data = [
      'title_page'  => 'Produk',
      'getProduct'  => $getProduct,
    ];

    return $this->responseView( $module_view, $data );
  }

  public function createOrEdit( Request $request, $id = null )
  {
    $getResult    = null;
    $url_action   = route('backoffice.product.store');
    $action_name  = 'store';
    $title_page   = 'Tambah Produk';

    if( ! empty( $id ) )
    {
      $getResult    = Product::findOrFail( $id );
      $action_name  = 'update';
      $url_action   = route('backoffice.product.update', ['id' => $id]);
      $title_page   = 'Edit Produk - ' . $getResult->product_name;
    }

    $module_view  = $this->module_view . '.create_edit';

    $data = [
      'title_page'  => $title_page,
      'action_name' => $action_name,
      'url_action'  => $url_action,
      'getResult'   => $getResult,
    ];

    return $this->responseView( $module_view, $data );
  }

  public function storeOrUpdate( Request $request, $id = null )
  {
    $id_produk    = $this->generateUuid();
    $kode_produk  = $request->kode_produk;
    $nama_produk  = $request->nama_produk;
    $harga_produk = $request->harga_produk;
    $foto_produk  = $request->hasFile('foto_produk') ? $request->file('foto_produk') : null;
    $publish      = $request->publish;
    $action_name  = $request->action_name;
    $filename     = $foto_produk ? $foto_produk->hashName() : null;
    $path_image   = $this->folder_disk . '/' . $filename;
    $old_filename = null;

    if( empty( $id ) )
    {
      $response = redirect()->route('backoffice.product.create_page')->withInput();
    }
    else
    {
      $response = redirect()->route('backoffice.product.edit_page', ['id' => $id])->withInput();
    }

    try
    {
      $check_product_code = Product::checkProductCode( $kode_produk, $id );

      if( $check_product_code === true )
      {
        $this->status_message = 'Kode produk ' . $kode_produk . ' sudah terdaftar.';
        $this->status_alert   = 'error';
      }
      else
      {
        if( ! empty( $id ) )
        {
          $model = Product::findOrFail( $id );
        }
        else
        {
          $model = new Product;
          $model->id = $id_produk;
        }

        if( $action_name == 'update' )
        {
          $old_filename = $model->product_image;
          $old_location = $this->folder_disk . '/' . $old_filename;
          $new_location = $this->folder_disk . '/' . $filename;
        }

        $model->product_code  = $kode_produk;
        $model->product_name  = $nama_produk;
        $model->price         = $harga_produk;
        $model->publish       = $publish;

        if( ! empty( $filename ) )
        {
          $model->product_image = $filename;
        }

        $model->save();

        if( ! empty( $filename ) )
        {
          if( $action_name == 'update' AND ! empty( $old_filename ) )
          {
            if( $this->checkFileExist( $this->storage_disk, $old_location ) )
            {
              $this->deleteFile( $this->storage_disk, $old_location );
            }
          }

          $this->uploadFromStorage(
            $this->storage_disk,
            $this->folder_disk,
            $foto_produk,
            $filename
          );
        }

        $this->status_message = 'Data berhasil disimpan';
        $this->status_alert   = 'success';

        $response     = redirect()->route('backoffice.product.index');
      }
    }
    catch (\Exception $e)
    {
      $this->status_message = $this->showError( $e->getLine(), $e->getMessage() );
      $this->status_alert   = 'error';
    }

    Session::flash( 'message', $this->status_message );
    Session::flash( 'alert', $this->status_alert );

    return $response;
  }

  public function destroy( Request $request, $id = null )
  {
    $id = $id === null ? $request->id : $id;

    try
    {
      $getResult  = Product::findOrFail( $id );
      $path_image = $this->folder_disk . '/' . $getResult->product_image;

      $this->foreignKeyEnable();

      if( ! empty( $getResult->product_image ) )
      {
        $this->deleteFile( $this->storage_disk, $path_image );
      }

      $getResult->delete();
      $this->foreignKeyDisable();

      $this->status_message = 'Data berhasil dihapus';
      $this->status_alert   = 'success';
    }
    catch (\Exception $e)
    {
      $this->status_message = $this->showError( $e->getLine(), $e->getMessage() );
      $this->status_alert   = 'error';
    }

    Session::flash( 'message', $this->status_message );
    Session::flash( 'alert', $this->status_alert );

    return redirect()->route('backoffice.product.index');
  }
}
