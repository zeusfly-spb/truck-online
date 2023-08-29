<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\User;
use \Spatie\Permission\Models\Role;
use Auth;

class AssignRoleController extends Controller
{

    public function assign_role_executer(Request $request){

      $user = User::find($request->user_id);
      $user->assignRole('executer');
      $user->save();

      return response()->json(['message'=> 'success']);
    }
}
