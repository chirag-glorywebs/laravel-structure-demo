<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Libraries\CustomErrorHandler;
use App\Libraries\Constant;
use App\Models\User;
use App\Models\WSErrorHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Contracts\Routing\ResponseFactory;
use Yajra\DataTables\DataTablesServiceProvider;

use DB;
use Hash;
use Redirect;
use Validator;
use DataTables;
use File;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $userList = User::select(
                'user_id',
                DB::RAW('CONCAT(first_name," ",last_name) as full_name'),
                'email',
                'user_type',
                'status',
                'profile_picture',
                DB::RAW('DATE_FORMAT(created_at, "%d/%m/%Y") as display_created_at'),
                'created_at'
            );

            if($request->get('filterUserType')){
                $userList = $userList->WHERE('user_type', $request->get('filterUserType'));
            }

            return Datatables::of($userList)
            ->make(true);
       }
       $userTypeList = Constant::getUserType();
       return view('admin.user.list', array('userTypeList' => $userTypeList));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $retData = array(
            'userTypeList'=> Constant::getUserType(),
            'userMenuList'=> Constant::getMenuList()
        );
        return view('admin.user.add',$retData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        try {
            $requestData = $request->all();
            if(isset($requestData['profile_picture_string']) && $requestData['profile_picture_string']){
                $requestData['profile_picture'] = $requestData['profile_picture_string'];
            }
            $userObj = User::create($requestData);
            return redirect(route('user.index'))->with('success', 'User Added Successfully.');
        } catch (\Exception $e) {
            CustomErrorHandler::APIServiceLog($e, "UserController: store");
            return back()->with('error', 'Something Went Wrong.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $retData = array(
            'data' => $user,
            'userTypeList'=> Constant::getUserType()
        );
        return view('admin.user.add',$retData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        try {
            $requestData = $request->all();
            if(isset($requestData['profile_picture_string']) && $requestData['profile_picture_string']){
                $requestData['profile_picture'] = $requestData['profile_picture_string'];
            }
            $userObj = User::findOrFail($requestData['user_id']);
            $userObj->update($requestData);
            return redirect(route('user.index'))->with('success', 'User Updated Successfully.');
        } catch (\Exception $e) {
            // CustomErrorHandler::APIServiceLog($e, "UserController: update");
            return back()->with('error', 'Something Went Wrong.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            User::destroy($id);
            return response()->json([
                'success' => true,
                'message'   => 'User deleted successfully.'
            ], 200);
        } catch (\Exception $e) {
            // CustomErrorHandler::APIServiceLog($e, "UserController: destroy");
            return response()->json([
                'success' => false,
                'message'   => 'Something Went Wrong.'
            ], 200);
        }
    }


    /**
     * Display User Image from storage.
     *
     * @param  use File $filename
     * @return \Illuminate\Http\Response
     */
    public function displayUserImage($filename){
        $path = storage_path('app/public/user_images/' . $filename);
        if (!File::exists($path)) {
            //admin-panel/img
            $path = public_path('admin-panel/img/avatar5.png');
        }
        $file = File::get($path);
        $type = File::mimeType($path);
        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);
        return $response;
    }


    /**
     * Active\Inactive User status.
     *
     * @param  use File $filename
     * @return \Illuminate\Http\Response
     */
    public function ActiveDeactiveStatus(Request $request){
        $requestData = $request->all();
        try {
            $userObj = User::findOrFail($requestData['id']);
            if($userObj->status == 1){
                $project = User::updateOrCreate(
                    ['user_id' => $requestData['id']],
                    ['status'=> 0]
                );
            }
            if($userObj->status == 0){
                $project = User::updateOrCreate(
                    ['user_id' => $requestData['id']],
                    ['status'=> 1]
                );
            }
            DB::commit();
            return response()->json([
                'success' => true,
                'message'   => 'Status Update successfully.'
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
            //CustomErrorHandler::APIServiceLog($e, "UserController: ActiveDeactiveStatus");
            return response()->json([
                'success' => false,
                'message'   => 'Something Went Wrong.'
            ], 200);
        }
    }

    // Error Logs
    public static function getErrorLogs(){
        return \View::make('admin.common.errorlogs', array());
    }

    public static function getErrorLogsList(){
        $prefix = 'glory_';
        $query = WSErrorHandler::SELECT(
            'error_handler.*',
            // DB::RAW('CONCAT('.$prefix.'users.first_name," ",'.$prefix.'users.last_name) as user_name')
        );
        // $query = $query->LEFTJOIN('users', 'users.user_id', '=', 'error_handler.created_by');
        $query = $query->ORDERBY('error_handler.created_at','DESC');

        return Datatables::of($query)
        ->addColumn('user_name', function($row){
            return $row->name;
        })
        ->make(true);
    }

    /**
     * @uses Filter Functions
     * @author author-name <author-gmail>
     * @return
     */
    public static function listUserType($user){
        $recs = User::select('user_id', 'first_name', 'last_name', 'email', 'profile_picture', 'user_type', 'status', 'created_at')
            ->where('user_type', $user)
            ->orderBy('created_at')
            ->get();

        for($i = 0; $i < count($recs); $i++) {
            $recs[$i]->created_at = (new \DateTime($recs[$i]->created_at))->format('d M Y');
            unset($recs[$i]->created_at);
        }
        dd($recs);
    }



}
