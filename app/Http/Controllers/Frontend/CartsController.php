<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Helpers\GlobalFunction as HelperFunction;
use App\Model\Users;
use App\Model\Product;
use App\Model\Carts;
use App\Model\AT_Carts;
use App\Model\Transactions;
use App\Model\AT_Transactions;

class CartsController extends Controller
{
  use HelperFunction;

  private $status_alert   = '';
  private $status_code    = 200;
  private $status_message = 'OK';
  private $module_view    = 'frontend.modules';

  public function index()
  {
    $module_view    = $this->module_view . '.cart';
    $getUserDetail  = Users::getDetail();
    $getCarts       = Carts::getCart( $getUserDetail->id );
    $getCartsItem   = $getCarts ? AT_Carts::getAll( $getCarts->cart_id ) : [];

    $data = [
      'title_page'    => 'Carts',
      'getUserDetail' => $getUserDetail,
      'getCarts'      => $getCarts,
      'getCartsItem'  => $getCartsItem,
    ];

    return $this->responseView( $module_view, $data );
  }

  public function storeOrUpdate( Request $request )
  {
    $result     = null;
    $product_id = $request->product_id;
    $price      = $request->price ? $request->price : 0;
    $qty        = $request->qty ? $request->qty : 1;
    $type       = $request->type;

    try {
      $get_user_detail  = Session::get('user_detail');
      $user_id          = $get_user_detail['id'];
      $get_user_carts   = Carts::where( 'ref_user_id', $user_id )->first();

      $current_price  = $get_user_carts ? $get_user_carts->total_price : 0;
      $current_qty    = $get_user_carts ? $get_user_carts->total_qty : 0;

      if( $type == 'add' )
      {
        $sum_total_price  = $current_price + $price;
        $sum_total_qty    = $current_qty + $qty;
      }
      else
      {
        $sum_total_price  = $current_price - $price;
        $sum_total_qty    = $current_qty - $qty;
      }

      if( ! $get_user_carts )
      {
        $updateCarts = new Carts;
        $updateCarts->id          = $this->generateUuid();
        $updateCarts->ref_user_id = $user_id;
      }
      else
      {
        $updateCarts = $get_user_carts;
      }

      $updateCarts->total_price = $sum_total_price;
      $updateCarts->total_qty   = $sum_total_qty;
      $updateCarts->save();

      $get_cart_product       = AT_Carts::getDetailItem( $updateCarts->id, $product_id );
      $current_price_product  = $get_cart_product ? $get_cart_product->price : 0;
      $current_qty_product    = $get_cart_product ? $get_cart_product->qty : 0;

      if( $type == 'add' )
      {
        $sum_total_price_product  = $current_price_product + $price;
        $sum_total_qty_product    = $current_qty_product + $qty;
      }
      else
      {
        $sum_total_price_product  = $current_price_product - $price;
        $sum_total_qty_product    = $current_qty_product - $qty;
      }

      if( ! $get_cart_product )
      {
        $updateCartItem = new AT_Carts;
        $updateCartItem->id             = $this->generateUuid();
        $updateCartItem->ref_cart_id    = $updateCarts->id;
        $updateCartItem->ref_product_id = $product_id;
      }
      else
      {
        $updateCartItem = $get_cart_product;
      }

      $updateCartItem->price          = $price;
      $updateCartItem->subtotal_price = $sum_total_price_product;
      $updateCartItem->qty            = $sum_total_qty_product;
      $updateCartItem->save();

      $result = [
        'carts'       => [
          'total_cart'      => AT_Carts::getAll( $user_id )->count(),
          'total_all_price' => $sum_total_price,
          'total_all_qty'   => $sum_total_qty,
        ],
        'carts_item'  => $updateCartItem,
      ];

      $this->status_code    = 201;
      $this->status_message = 'Cart updated';
    } catch (\Exception $e) {
      $this->status_code    = 500;
      $this->status_message = $this->showError( $e->getLine(), $e->getMessage() );
    }

    $response = [
      'status_code'     => $this->status_code,
      'status_message'  => $this->status_message,
      'result'          => $result,
    ];

    return $this->responseJson( $response, $this->status_code );
  }

  public function updateQty( Request $request )
  {
    $result       = null;
    $item_cart_id = $request->item_cart_id;
    $qty          = $request->qty;
    $price        = $request->price;

    try
    {
      $get_item = AT_Carts::where('id', $item_cart_id)->first();
      $get_cart = Carts::where('id', $get_item->ref_cart_id)->first();

      $subtotal_price = $qty * $price;

      $get_item->qty            = $qty;
      $get_item->price          = $price;
      $get_item->subtotal_price = $subtotal_price;
      $get_item->save();

      $get_item_all         = AT_Carts::getAll( $get_cart->ref_user_id );
      $get_total_price_item = $get_item_all->map(function( $item ) {
        return $item->subtotal_price;
      })
      ->toArray();

      $get_total_qty_item   = $get_item_all->map(function( $item ) {
        return $item->qty;
      })
      ->toArray();

      $total_price_item = array_sum( $get_total_price_item );
      $total_qty_item   = array_sum( $get_total_qty_item );

      $get_cart->total_price  = $total_price_item;
      $get_cart->total_qty    = $total_qty_item;
      $get_cart->save();

      $result = [
        'carts'       => [
          'total_cart'      => $get_item_all->count(),
          'total_all_price' => $total_price_item,
          'total_all_qty'   => $total_qty_item,
        ],
        'carts_item'  => $get_item,
      ];

      $this->status_code    = 201;
      $this->status_message = 'Cart item updated';
    }
    catch (\Exception $e)
    {
      $this->status_code    = 500;
      $this->status_message = $this->showError( $e->getLine(), $e->getMessage() );
    }

    $response = [
      'status_code'     => $this->status_code,
      'status_message'  => $this->status_message,
      'result'          => $result,
    ];

    return $this->responseJson( $response, $this->status_code );
  }

  public function deleteItem( Request $request, $item_id = null )
  {
    $result   = null;
    $item_id  = $item_id ? $item_id : $request->item_id;

    try
    {
      $get_cart_product = AT_Carts::find( $item_id );

      if( $get_cart_product )
      {
        $get_cart     = Carts::where('id', $get_cart_product->ref_cart_id)->first();
        $get_cart_product->delete();

        $get_item_all = AT_Carts::getAll( $get_cart_product->ref_cart_id );

        $get_total_price_item = $get_item_all->map(function( $item ) {
          return $item->subtotal_price;
        })
        ->toArray();

        $get_total_qty_item   = $get_item_all->map(function( $item ) {
          return $item->qty;
        })
        ->toArray();

        $total_price_item = array_sum( $get_total_price_item );
        $total_qty_item   = array_sum( $get_total_qty_item );

        $get_cart->total_price  = $total_price_item;
        $get_cart->total_qty    = $total_qty_item;
        $get_cart->save();

        $this->status_code    = 200;
        $this->status_message = 'Deleted';
      }
      else
      {
        $this->status_code    = 404;
        $this->status_message = 'Data not found';
      }
    }
    catch (\Exception $e)
    {
      $this->status_code    = 500;
      $this->status_message = $this->showError( $e->getLine(), $e->getMessage() );
    }

    $response = [
      'status_code'     => $this->status_code,
      'status_message'  => $this->status_message,
      'result'          => $result,
    ];

    return $this->responseJson( $response, $this->status_code );
  }

  public function checkout( $cart_id )
  {
    try
    {
      $get_carts  = Carts::getCart( $cart_id );
      $get_carts_item = AT_Carts::getAll( $cart_id );

      if( ! $get_carts ) abort(404);

      $transactions_id      = $this->generateUuid();
      $transactions_number  = 'TR-' . date('Ymd') . '-' . strtoupper( $this->rand(5) );
      $user_id              = $get_carts->user_id;

      $transactions = new Transactions;
      $transactions->id             = $transactions_id;
      $transactions->transaction_id = $transactions_number;
      $transactions->ref_user_id    = $user_id;
      $transactions->total_price    = $get_carts->total_price;
      $transactions->total_qty      = $get_carts->total_qty;
      $transactions->save();

      $transaction_item = $get_carts_item->map(function( $item, $index ) use ( $transactions_id ) {
        return [
          'ref_transaction_id'  => $transactions_id,
          'ref_product_id'      => $item->product_id,
          'qty'                 => $item->qty,
          'price'               => $item->price,
          'subtotal_price'      => $item->subtotal_price,
          'sort'                => ++$index,
        ];
      })
      ->toArray();

      AT_Transactions::insert( $transaction_item );

      Carts::where('id', $cart_id)->delete();

      $this->status_alert   = 'success';
      $this->status_message = 'Berhasil melakukan transaksi. Nomor Transaksi: ' . $transactions_number;

      $response = redirect()->route('frontend.user.transaction.index');
    }
    catch (\Exception $e)
    {
      $this->status_alert   = 'error';
      $this->status_message = $this->showError( $e->getLine(), $e->getMessage() );

      $response = redirect()->route('frontend.user.carts.index');
    }

    Session::flash( 'message', $this->status_message );
    Session::flash( 'alert', $this->status_alert );

    return $response;
  }
}
