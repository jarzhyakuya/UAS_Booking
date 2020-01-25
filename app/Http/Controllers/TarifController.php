<?php
    
    namespace App\Http\Controllers;
    
    use App\Models\Tarif;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;

    class TarifController extends Controller
    {
        public function store(Request $request)
        {
            $input = $request->all();

            $this->validate($request, [
                'biaya' => 'required|integer',
                'kursi' => 'required|in:2,4,6,8,10'
            ]);
            $tarif = Tarif::create($input);
            return response()->json($tarif, 200);
        }
        
        public function index()
        {
            $tarif = Tarif::OrderBy("id", "DESC")->paginate(10)->toArray();
            $response = [
                "total_count" => $tarif["total"],
                "limit" => $tarif["per_page"],
                "pagination" =>[
                    "next_page" => $tarif["next_page_url"],
                    "current_page" => $tarif["current_page"]
                ],
                "data" => $tarif["data"],
            ];
            return response()->json($tarif, 200);
        }
        
        public function destroy($id)
        {
            $tarif = Tarif::find($id);
            $tarif->delete();
            $message = ['message' => 'delete sucessfull', 'id' => $id ];
            return response()->json($message, 200);
        }

        public function update(Request $request, $id)
        {
            $input = $request->all();
            $tarif = Tarif::find($id);
            if (!$tarif) {
                abort(404);
            }
            $this->validate($request, [
                'biaya' => 'required|integer',
                'kursi' => 'required|in:2,4,6,8,10'
            ]);
            $tarif->fill($input);
            $tarif->save();
            return response()->json($tarif, 200);
        }
    }
?>
