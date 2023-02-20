<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
   /**
    * It gets all the users from the database and returns them to the view.
    *
    * @return All the users in the database.
    */
    public function AllUser()
    {
        $all = DB::table('users')->get();



        return view('backend.user.all-user', compact('all'));
    }
    public function InfoUser()
    {
        $all = DB::table('users')->get();



        return view('backend.user.info-user', compact('all'));
    }
    // AddUser,InsertUser
    public function AddUserIndex()
    {
        return view('backend.user.add-user');
    }
    /**
     * It inserts a new user into the database.
     *
     * @param Request request The request object.
     */
    public function InsertUser(Request $request)
    {
        $data = array();
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['role'] = $request->role;
        $data['password'] = Hash::make($request->password);
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');



        $insert = DB::table('users')->insert($data);
        if ($insert) {
            $notification = array(
                'message' => 'successfully added user',
                'alert-type' => 'success',
            );
            return redirect()->route('alluser')->with($notification);
        } else {

            $notification = array(
                'message' => 'Something went wrong, try again',
                'alert-type' => 'error',
            );
            return redirect()->route('alluser')->with($notification);
        }
    }
    /**
     * A function that is used to edit the user.
     *
     * @param id The id of the user you want to edit.
     *
     * @return The edit variable is being returned.
     */
    public function EditUser($id)
    {
        $edit = DB::table('users')->where('id', $id)->first();
        return view('backend.user.edit-user', compact('edit'));
    }
    public function EditByUser($id)
    {
        $edit = DB::table('users')->where('id', $id)->first();
        return view('backend.user.edit-byuser', compact('edit'));
    }
    /**
     * It updates the user information.
     *
     * @param Request request The request object.
     * @param id The id of the user to be updated.
     */
    public function UpdatetUser(Request $request, $id)
    {
        $data = array();
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['role'] = $request->role;
        $data['password'] = Hash::make($request->password);
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');

        $update = DB::table('users')->where('id', $id)->update($data);
        if ($update) {
            $notification = array(
                'message' => 'successfully updated user',
                'alert-type' => 'success',
            );
            return redirect()->route('alluser')->with($notification);
        } else {

            $notification = array(
                'message' => 'Something went wrong,try again',
                'alert-type' => 'error',
            );
            return redirect()->route('alluser')->with($notification);
        }
    }
    /**
     * It deletes a user from the database.
     *
     * @param id The id of the user to delete.
     */
    public function DeleteUser($id)
    {
        $delete = DB::table('users')->where('id', $id)->delete();
        if ($delete) {
            $notification = array(
                'message' => 'successfully deleted user',
                'alert-type' => 'success',
            );
            return redirect()->route('alluser')->with($notification);
        } else {

            $notification = array(
                'message' => 'something went wrong,try again',
                'alert-type' => 'error',
            );
            return redirect()->route('alluser')->with($notification);
        }
    }
}
