<?php
namespace App\Http\Controllers\Market\Admin\Config;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use DB;
use File;
use Storage;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Market\Services\ConfigService;


class TemplateController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct(
    ConfigService $configSvc
  )
  {
      // $this->middleware('auth');
    $this->configSvc = $configSvc;
  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */
  public function view()
  {
    
    // layout
    $layout_dir =  resource_path('views/market/templates/layouts');
    $layouts = array_map('basename',\File::directories($layout_dir));

    // main
    $main_dir =  resource_path('views/market/templates/main');
    $main = array_map('basename',\File::directories($main_dir));

    // shop
    $shop_dir =  resource_path('views/market/templates/shop');
    $shop = array_map('basename',\File::directories($shop_dir));

    // cart
    $cart_dir =  resource_path('views/market/templates/cart');
    $cart = array_map('basename',\File::directories($cart_dir));

    // order
    $order_dir =  resource_path('views/market/templates/order');
    $order = array_map('basename',\File::directories($order_dir));

    // userpage
    $userpage_dir =  resource_path('views/market/templates/userpage');
    $userpage = array_map('basename',\File::directories($userpage_dir));

    // auth
    $search_dir =  resource_path('views/market/templates/search');
    $search = array_map('basename',\File::directories($search_dir));

    // auth
    $auth_dir =  resource_path('views/market/templates/auth');
    $auth = array_map('basename',\File::directories($auth_dir));

    // components
    $component_dir =  resource_path('views/market/templates/components');
    $components = array_map('basename',\File::directories($component_dir));

    // mail
    $mail_dir =  resource_path('views/market/templates/mail');
    $mail = array_map('basename',\File::directories($mail_dir));

    // pages
    $pages_dir =  resource_path('views/market/templates/pages');
    $pages = array_map('basename',\File::directories($pages_dir));

    $template = $this->configSvc->get('template');


    return view('market.admin.config.template', [
      'template'=>$template,
      'layouts'=>$layouts,
      'main'=>$main,
      'shop'=>$shop,
      'cart'=>$cart,
      'order'=>$order,
      'userpage'=>$userpage,
      'search'=>$search,
      'auth'=>$auth,
      'components'=>$components,
      'mail'=>$mail,
      'pages'=>$pages,
    ]);
  }

  public function update(Request $request) {
    $template = $this->configSvc->get('template');

    $template['layout']['theme'] = $request->layout;
    $template['main']['theme'] = $request->main;
    $template['shop']['theme'] = $request->shop;
    $template['shop']['theme'] = $request->shop;
    $template['shop']['lists'] = $request->shop_lists;
    $template['cart']['theme'] = $request->cart;
    $template['order']['theme'] = $request->order;
    $template['userpage']['theme'] = $request->userpage;
    $template['search']['theme'] = $request->search;
    $template['search']['lists'] = $request->search_lists;
    $template['auth']['theme']  = $request->auth;
    $template['component']['theme']  = $request->component;
    $template['mail']['theme']  = $request->mail;
    $template['pages']['theme']  = $request->pages;

    $this->configSvc->set('template', $template );
    return response()->json(['error'=>false]);
  }

  public function updateCI(Request $request) {

    $file = $request->file('file');
    if($file) {
      // $filepath = storage_path('app/public/market');
      $filepath = 'public/market';
      // $filepath = public_path('storage/market');
      $fileName = $file->getClientOriginalName();
      // $ext = $file->getClientOriginalExtension();
      // $fileName = $name.'.'.$ext;
      // $path=\Storage::put($filepath, $file); // 

      $result = $file->storeAs($filepath, $fileName);
      $this->configSvc->set('template.ci', $fileName );
    }

    return redirect()->back();
  }

  public function updateFavicon(Request $request) {
    $file = $request->file('file');
    if($file) {
      // $filepath = storage_path('market');
      $filepath = 'public/market';
      $fileName = $file->getClientOriginalName();
      // $ext = $file->getClientOriginalExtension();
      // $fileName = $name.'.'.$ext;
      // $path=\Storage::put($filepath, $file); // 

      $result = $file->storeAs($filepath, $fileName);
      $this->configSvc->set('template.favicon', $fileName );
    }

    // return redirect()->back();
  }
}
