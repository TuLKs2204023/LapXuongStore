<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Http\Traits\ProcessModelData;
use App\Models\User;
use App\Models\Address\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{

    use ProcessModelData;
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



        return view('admin.users.all-user', compact('all'));
    }
    public function InfoUser()
    {
        $all = DB::table('users')->get();



        return view('admin.users.info-user', compact('all'));
    }
    // AddUser,InsertUser
    public function AddUserIndex()
    {

        $imageFiles = false;
        return view('admin.users.add-user')->with([

            'list_images' => $imageFiles
        ]);
    }

    public function InsertUser(Request $request)
    {
        $data = array();
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['role'] = $request->role;
        $data['gender'] = $request->gender;
        $data['address'] = $request->address;
        $data['phone'] = $request->phone;
        $data['password'] = Hash::make($request->password);

        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $extension = $file->getClientOriginalExtension();
            if ($extension != 'jpg' && $extension != 'png' && $extension != 'jpeg') {
                return view('admin.users.add-user')->with('error', 'Only jpg, png, jpeg files are acceptable.');
            }
            $imageName = $file->getClientOriginalName();
            $file->move("images", $imageName);
        } else {
            $imageName = null;
        }
        $data['image'] = $imageName;
        $user = DB::table('users')->insert($data);
        if ($user) {
            $notification = array(
                'message' => 'Successfully added user',
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

    public function EditUser($id)
    {
        // $edit = User::find($id);

        $edit = DB::table('users')->where('id', $id)->first();

        return view('admin.users.edit-user', compact('edit'));
    }
    public function EditByUser($id)
    {
        $edit = User::find($id);

        $city = City::get(["name", "id"]);

        return view('fe.home.edit-profile', compact('edit','city'));
    }

    public function passwordUser($id)
    {
        // $edit = User::find($id);

        $edit = DB::table('users')->where('id', $id)->first();
        return view('fe.home.password-user', compact('edit'));
    }

    public function EditpasswordUser(Request $request, $id)
    {
        $data = array();

        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        $conpass = $request->confirm_new_password;
        $newpass = $request->password;
        if ($newpass == $conpass) {
            if (Hash::check($request->old_confirmation, auth()->user()->password)) {
                $data['password'] = Hash::make($request->password);
                $edit = DB::table('users')->where('id', $id)->update($data);
                if ($edit) {
                    $notification = array(
                        'message' => 'Successfully updated',
                        'alert-type' => 'success',
                    );
                    return redirect()->route('userProfile')->with($notification);
                } else {

                    $notification = array(
                        'message' => 'Something went wrong,try again !',
                        'alert-type' => 'error',
                    );
                    return redirect()->Route('passwordUser', auth()->user()->id)->with($notification);
                }
            } else {
                $notification = array(
                    'message' => 'Plesase confirm old password,try again',
                    'alert-type' => 'error',
                );
                return redirect()->Route('passwordUser', auth()->user()->id)->with($notification);
            }
        } else {
            $notification = array(
                'message' => 'Please confirm new password ,try again',
                'alert-type' => 'error',
            );
            return redirect()->Route('passwordUser', auth()->user()->id)->with($notification);
        }
    }

    public function UpdatetUser(Request $request, $id)
    {
        $data = array();
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['role'] = $request->role;
        $data['gender'] = $request->gender;
        $data['address'] = $request->address;
        $data['phone'] = $request->phone;
        $data['password'] = Hash::make($request->password);

        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');


        $edit = DB::table('users')->where('id', $id)->update($data);
        if ($edit) {
            $notification = array(
                'message' => 'Successfully updated user',
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
    public function UpdateByUser(Request $request, $id)
    {
        $data = array();
        $data['name'] = $request->name;
        $data['gender'] = $request->gender;
        $data['address'] = $request->address;
        $data['phone'] = $request->phone;
        $data['city_id']=$request->city;
        $data['district_id']=$request->district;
        $data['ward_id']=$request->ward;
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');

        $user = User::find($id);
        $image = $user->image;


        if ($request->hasFile('photo')) {
            File::delete(public_path("images/" . $image));
            $file = $request->file('photo');
            $extension = $file->getClientOriginalExtension();
            if ($extension != 'jpg' && $extension != 'png' && $extension != 'jpeg') {
                return redirect()->route('userProfile')->with('error', 'Only jpg, png, jpeg files are acceptable.');
            }
            $imageName = $file->getClientOriginalName();
            $file->move("images", $imageName);
        } else {
            $data['image'] = $image;
        }


        $this->data($user, $data);

        $edit = $user->update($data);

        if ($edit) {

            $notification = array(
                'message' => 'Successfully updated',
                'alert-type' => 'success',
            );
            return redirect()->route('userProfile')->with($notification);
        } else {

            $notification = array(
                'message' => 'Something went wrong,try again',
                'alert-type' => 'error',
            );
            return redirect()->route('userProfile')->with($notification);
        }
    }
    public function DeleteUser($id)
    {
        $user = User::find($id);
        $image = $user->image;
        File::delete(public_path("images/" . $image));
        $delete = $user->delete();

        if ($delete) {
            $notification = array(
                'message' => 'Successfully deleted user',
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
}
