<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Profile;

use App\Profilehistory;
use Carbon\Carbon;


class ProfileController extends Controller
{
    public function add()
    {
        return view('admin.profile.create');
        
    }
    public function create(Request $request)
    {
        $this->validate($request, Profile::$rules);
        
        $profile = new Profile;
        $form = $request->all();
        
        unset($form['_token']);
        
        $profile->fill($form);
        $profile->save();
        
        return redirect('admin/profile/create');
    }
     public function edit(Request $request)
  {
      //  Modelからデータを取得する
      $profile = Profile::find($request->id);
      if (empty($profile)) {
        abort(404);    
      }
      return view('admin.profile.edit', ['profile_form' => $profile]);
  }
    public function update(Request $request) 
     {
          $this->validate($request, Profile::$rules);
      //  Modelからデータを取得する
      $profile = Profile::find($request->id);
      // 送信されてきたフォームデータを格納する
      $profile_form = $request->all();
      unset($profile_form['_token']);

      // 該当するデータを上書きして保存する
      $profile->fill($profile_form)->save();

      
      $history = new Profilehistory;
      $history->profile_id = $profile->id;
      $history->edited_at = Carbon::now();
      $history->save();
      return redirect('admin/profile/');
     }
}