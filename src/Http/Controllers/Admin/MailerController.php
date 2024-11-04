<?php
namespace Pondol\Market\Http\Controllers\Admin;

use Illuminate\Http\Request;

use Pondol\Auth\Models\Role\Role;

use Pondol\Mailer\Models\NotificationMessage;

use Pondol\Mailer\Traits\Mailer;
use App\Http\Controllers\Controller;
class MailerController extends Controller
{

  use Mailer;
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
  }


  public function index(Request $request) {
    $items = $this->_index($request);
    $items = $items->orderBy('id', 'desc')
      ->paginate(20)->appends(request()->query());
      
    return view('market::admin.mailer.index', ['items'=>$items]);
  }

  public function show(NotificationMessage $message, Request $request) {
    $items = $this->_receptionist($message->id);
    $items = $items->orderBy('id', 'desc')
      ->paginate(20)->appends(request()->query());
      
    return view('market::admin.mailer.show', [
      'message'=>$message,
      'items'=>$items
    ]);
  }


  public function create() {
    return view('market::admin.mailer.create', ['roles' => Role::get()]);
  }

  public function store(Request $request) {
    $result = $this->_store($request);
    if($result->error == 'validator') {
      return redirect()->back()->withInput()->withErrors($result->validator->errors());
    }

    return redirect()->route('market.admin.mailer');
  }


}