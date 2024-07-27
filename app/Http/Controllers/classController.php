<?php

namespace App\Http\Controllers;
use App\Traits\HttpResponses;
use App\Models\classModel;

use Illuminate\Http\Request;

class classController extends Controller
{
    use HttpResponses;
    //
    public function index (Request $request){
        $pageNo = $request->input('page');
        $perPage = $request->input('perPage');
        $classes = classModel::orderBy('id', 'DESC')->paginate($perPage, ['*'], 'page', $pageNo);
        return $this->success([
            'data' => $classes,
            'pagination' => [
              'total' => $classes->total(),
              'current_page' => $classes->currentPage(),
              'last_page' => $classes->lastPage()  
            ]
        ]);
    }

    public function getAllClasses (Request $request){
        $allClasses = classModel::all();
        return $this->success([
            'data' => $allClasses
        ]);
    }

    public function searchClasses(Request $request){
        $results = classModel::latest()->filter(request(['keyword']))->get();
        return $this->success([
            'data' => $results
        ]);
    }

    public function storeClasses(Request $request){
        $classes = new classModel;
        $classes->classes = $request->class;
        $res = $classes->save();

        if($res){
            return $this->success([
                'data' => $classes
            ]);
        }
    }

    public function updateClasses(Request $request, $id){
        $formField = [
            'classes' => $request->class
        ];

        $res = classModel::where('id', $id)->update($formField);
        if($res){
            return $this->success([
                'data' => $res
                ]);
        }
    }

    public function deleteClasses($id){
        $res = classModel::where('id', $id)->delete();
        return $this->success([
            'data' => "class deleted successfully"
        ]);
    }
}
