<?php
    
    namespace App\Http\Controllers;
    
    use App\Models\Booking;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Gate;

    class BookingController extends Controller
    {
        public function store(Request $request)
        {

            $input = $request->all();
            $this->validate($request, [
                'meja_id' => 'required|integer',
                'tarif_id' => 'required|integer',
                'user_id' => 'required|integer',
                'tanggal_booking' => 'required|date',
                'status' => 'required|in:done,cancel,waiting'
            ]);
            $booking = Booking::create($input);
            return response()->json($booking, 200);
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
            
            $booking = Booking::with('meja','tarif')->OrderBy("id", "DESC")->paginate(10)->toArray();
            $response = [
                "total_count" => $booking["total"],
                "limit" => $booking["per_page"],
                "pagination" =>[
                    "next_page" => $booking["next_page_url"],
                    "current_page" => $booking["current_page"]
                ],
                "data" => $booking["data"],
            ];
            return response()->json($booking, 200);
        }

        public function show($id)
        {
            $booking = Booking::where('user_id', Auth::user()->id)->with('meja','tarif')->find($id);
            if(!$booking){
                abort(404);
            }
            return response()->json($booking, 200);
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

            $booking = Booking::find($id);
            $booking->delete();
            $message = ['message' => 'delete sucessfull', 'id' => $id ];
            return response()->json($message, 200);
        }

        public function update(Request $request, $id)
        {

            $input = $request->all();
            $booking = Booking::find($id);
            if (!$booking) {
                abort(404);
            }
            $this->validate($request, [
                'meja_id' => 'required|integer',
                'tarif_id' => 'required|integer',
                'user_id' => 'required|integer',
                'tanggal_booking' => 'required|date',
                'status' => 'required|in:done,cancel,waiting'
            ]);
            $booking->fill($input);
            $booking->save();
            return response()->json($booking, 200);
        }
    }
?>
