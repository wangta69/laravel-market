<?php
namespace Pondol\Market\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use DB;

use Pondol\Market\Models\MarketBanner;

use App\Http\Controllers\Controller;
class BannerController extends Controller
{

 
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    
  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    return view('market::admin.banner.index');
  }

  public function view(Request $request, string $type)
  {
    $items = MarketBanner::where('position', $type)->orderBy('id', 'desc')->paginate(20)->appends(request()->query());

    return view('market::admin.banner.view', compact('items', 'type'));
  }

  /**
   * Banner 등록 폼
   */
  public function create(string $type)
  {
    $item = new MarketBanner;
    return view('market::admin.banner.create', compact('type', 'item'));
  }

  public function edit(string $type, MarketBanner $item)
  {
    return view('market::admin.banner.create', compact('type', 'item'));
  }

    /**
   * Banner 생성
   */
  public function store(Request $request, string $type){
    $item = new MarketBanner;
    $item->position = $type;
    // $item->image = $request->file('file')->getClientOriginalName();
    $item->title = $request->title;
    $item->description = $request->description;
    $item->url = $request->url;
    $item->save();
    
    if ($request->file('file')) {
      $path = $request->file('file')->store('public/banner/'.$type.'/'.$item->id);
      $item->image = $path;
      $item->save();
    }

    return redirect()->route('market.admin.banner', [$type]);
  }

  public function update(Request $request, string $type, MarketBanner $item){
    
    $item->position = $type;
    
    $item->title = $request->title;
    $item->description = $request->description;
    $item->url = $request->url;
    if ($request->file('file')) {
      \Storage::deleteDirectory('public/banner/'.$type.'/'.$item->id);
      $path = $request->file('file')->store('public/banner/'.$type.'/'.$item->id);

      $item->image = $path;
      $item->save();
    }

    return redirect()->route('market.admin.banner', [$type]);
  }


}
