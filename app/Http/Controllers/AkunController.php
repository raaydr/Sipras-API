<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Redirect;
use DataTables;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Input;
use App\Providers\RouteServiceProvider;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Crypt;

class AkunController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function PembuatanAdmin()
    {
        $title = 'Welcome Admin';
        
        return view('master.dataAdmin',);
    }
    public function DaftarAdmin(Request $request)
    {

        $validator = Validator::make($request->all(), 
        [   
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',

        ],

        $messages = 
        [
            'name.required' => 'Nama tidak boleh kosong!',
            'email.required' => 'E-Mail tidak boleh kosong !',
            'password.required' => 'Password tidak boleh kosong',
            
        ]);     

        if($validator->fails())
        {
        return back()->withErrors($validator)->withInput();  
        }
        
        //Table Users
        $user = new User;
        $user->name =   $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->level = 1;
        $user->save();

        return response()->json(['status'=>1,'success'=>'Berhasil Buat Akun Admin']);
    }

    public function TabelAdmin(Request $request)
    {
        
        $data = User::where('level', 1)->orWhere('level', 2)->orderBy('created_at', 'desc')->get();
            if($request->ajax()){
    
                return datatables()->of($data)                   
                    ->addIndexColumn()
                    ->addColumn('admin', function($row){
                        $level = $row->level;
                        switch ($level) {
                            case '2':
                                return '<p class="text-danger">Tidak Aktif</p>';
                                break;
                            case '1':
                                return '<p class="text-success">Aktif</p>';     
                                break;
                                default:
                                echo "stikes medistra";
                                break;
                        } 
                    }) 
                    ->addColumn('action', function($row){
                        $id = $row->id;
                        $nama = $row->name;
                        $level = $row->level;
                        $detail = route('ubah_Akun',$id); 
                        $actionBtn = '<a class="btn btn-outline-primary m-1" href='.$detail.'>detail</a>';
                        switch ($level) {
                            case '2':
                                $actionBtn =$actionBtn.' <a data-id="'.$id.'" class="btn btn-outline-success m-1 levelAdmin">Aktifkan</a>';
                                break;
                            case '1':
                                $actionBtn =$actionBtn.' 
                                <a id="hapus" data-toggle="modal" data-target="#hapus-barang'.$id.'" class="btn btn-outline-danger m-1">Hapus</a></dl>
                                                            <div class="modal fade" id="hapus-barang'.$id.'">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content bg-danger">
                                                                        <div class="modal-header">
                                                                            <h4 class="modal-title">Penolakan</h4>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">    
                                                                                <p>Apa anda yakin ingin menghapus Admin '.$nama.' ?</p>
                                                                                <div class="modal-footer justify-content-between">
                                                                                <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                                                                                <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$id.'" data-dismiss="modal" data-original-title="Delete" class="btn btn-outline-light levelAdmin">Delete</a>
                                                                                </div>
                                                                            
                                                                        </div>
                                                                    </div>
                                                                    <!-- /.modal-content -->
                                                                </div>
                                                                <!-- /.modal-dialog -->
                                                            </div>
                                                            <!-- /.modal -->';
                         
                                break;
                                default:
                                echo "stikes medistra";
                                break;
                            }
                        return $actionBtn;
                    })->rawColumns(['admin','action'])
                    ->make(true);
            }
    }

    public function LevelAdmin($id)
    {
        
        //$mata_pelatihan_id = Crypt::decrypt($id);
        $val = User::where('id', $id)->value('level');
        switch ($val) {
            case '1':
                User::where('id', $id)->update([
                    'level' => 2,
                    'updated_at' => now(),
                    ]
                );
                return response()->json(['success'=>'Akun admin dihilangkan']);
                break;
            case '2':
                User::where('id', $id)->update([
                    'level' => 1,
                    'updated_at' => now(),
                    ]
                );
                return response()->json(['success'=>'Akun admin diaktifkan']);
                break;
                default:
                echo "stikes medistra";
                break;
        }    
    }

    public function ubah_password(){
        $title = 'Akun ubah password';
        
        

        return view('master.ubahpassword', compact('title'));
    }

    public function change_password(Request $request)

    {

        $request->validate([

            'current_password' => ['required', new MatchOldPassword],

            'new_password' => ['required','string','min:8','required'],

            'new_confirm_password' => ['same:new_password'],
            
            

        ]);

   

        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);

   
        return redirect()->route('general.ubah.password')->with('berhasil', 'berhasil ubah password');
        //return redirect()->route('admin.listPendaftar');

    }

    public function ubah_Akun($id){
        $title = 'ubah akun';
        
        $user = User::where('id',$id)->first();

        return view('master.ubahAkun', compact('title','user'));
    }

    public function change_account(Request $request)

    {

        $id = $request->id;
        $validator = Validator::make($request->all(), 
        [   
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255', Rule::unique('users')->ignore($id, 'id'),
            

            'password' => 'nullable|string|min:8|confirmed',

        ],

        $messages = 
        [
            'name.required' => 'Nama tidak boleh kosong!',
            'email.required' => 'E-Mail tidak boleh kosong !',
            
            
        ]);     

        if($validator->fails())
        {
        return back()->withErrors($validator)->withInput();  
        }
        
        //Table Users
        if($request->name != NULL){
            $update['name'] = $request->name;
        }
        if($request->email != NULL){
            $update['email'] = $request->email;
        }
        if($request->password != NULL){
            $update['password'] = Hash::make($request->password);
        }  
        User::updateOrInsert(
            ['id' => $id], $update
        );


   
        return Redirect::back()->with('berhasil', 'berhasil ubah akun');
        //return redirect()->route('admin.listPendaftar');

    }
}
