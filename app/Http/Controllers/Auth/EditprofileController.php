<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Auth;
class EditprofileController extends Controller
{
	
	public function __construct()
    {
       $this->middleware('auth');
    }

    public function editprofile()
    {
    	$user = User::find(Auth::user()->id);    
        return view('auth/editprofile',["user" => $user]);
    }

    public function saveprofile(Request $input){

        $this->validate($input, [
        'name' => 'required|max:255',
        'password' => 'min:6|confirmed'        
            ]);

    	$user = User::find(Auth::user()->id);
    	$user->name = $input["name"];
        if ($input->has('password')) 
        $user->password = bcrypt($input['password']);
    	$user->save();    	  	

    	return redirect('edit-profile');

    }

}