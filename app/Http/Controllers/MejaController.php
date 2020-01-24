<?php
    
    namespace App\Http\Controllers;
    
    use App\Models\Meja;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;

    class MejaController extends Controller
    {
        public function store(Request $request)
        {
            $this->validate($request, [
                'no_meja' => 'required',
                'kursi' => 'required',
                'posisi' => 'required',
                'status' => 'required'
            ]);

            $meja = new Meja();
            $meja->no_meja = $request->input('no_meja');
            $meja->kursi = $request->input('kursi');
            $meja->posisi = $request->input('posisi');
            $meja->status = $request->input('status');
            
            $meja->save();

            
            return response()->json($meja, 200);
        }
        
        public function index(){
            $meja = Meja::OrderBy("id", "DESC")->paginate(10)->toArray();
            $response = [
                "total_count" => $meja["total"],
                "limit" => $meja["per_page"],
                "pagination" =>[
                    "next_page" => $meja["next_page_url"],
                    "current_page" => $meja["current_page"]
                ],
                "data" => $meja["data"],
            ];
            return response()->json($meja, 200);
        }

        public function show($id)
        {
            $meja = Meja::where('id', Auth::user()->id)
                ->where('id',$id)
                ->first();
            return response()->json($meja, 200);
        }
        
        public function destroy($id)
        {
            $meja = Meja::find($id);
            $meja->delete();
            $message = ['message' => 'delete sucessfull', 'id' => $id ];
            return response()->json($meja, 200);
        }
    }
?>
