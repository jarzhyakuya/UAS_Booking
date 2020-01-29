<?php
    
    namespace App\Http\Controllers;
    
    use App\Models\Pembayaran;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Gate;

    class PembayaranController extends Controller
    {
        public function store(Request $request)
        {
            $input = $request->all();
            $this->validate($request, [
                'total' => 'required|integer',
                'booking_id' => 'required|integer'
            ]);
            $pembayaran = Pembayaran::create($input);
            return response()->json($pembayaran, 200);
        }
        
        public function index()
        {
            // Authorization Admin
            if(Gate::denies('admin')){
                return response()->json([
                    'success' => false,
                    'status' => 403,
                    'message' => 'you are unauthorized'
                ], 403);
            }

            $pembayaran = Pembayaran::with('booking')->OrderBy("id", "DESC")->paginate(10)->toArray();
            $response = [
                "total_count" => $pembayaran["total"],
                "limit" => $pembayaran["per_page"],
                "pagination" =>[
                    "next_page" => $pembayaran["next_page_url"],
                    "current_page" => $pembayaran["current_page"]
                ],
                "data" => $pembayaran["data"],
            ];
            return response()->json($pembayaran, 200);
        }

        public function show($id)
        {
            $pembayaran = Pembayaran::with('booking')->find($id);
            if(!$pembayaran){
                abort(404);
            }
            return response()->json($pembayaran, 200);
        }
        
        public function destroy($id)
        {
            // Authorization Admin
            if(Gate::denies('admin')){
                return response()->json([
                    'success' => false,
                    'status' => 403,
                    'message' => 'you are unauthorized'
                ], 403);
            }
            $pembayaran = Pembayaran::find($id);
            $pembayaran->delete();
            $message = ['message' => 'delete sucessfull', 'id' => $id ];
            return response()->json($message, 200);
        }
    }
?>
