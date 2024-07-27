<?php

namespace App\Http\Controllers;
use App\Traits\HttpResponses;
use App\Models\bookTypeModel;

use Illuminate\Http\Request;

class bookTypeController extends Controller
{
    use HttpResponses;
    //
    public function index (Request $request){
        $pageNo = $request->input('page');
        $perPage = $request->input('perPage');
        $bookTypes = bookTypeModel::orderBy('id', 'DESC')->paginate($perPage, ['*'], 'page', $pageNo);
        return $this->success([
            'data' => $bookTypes,
            'pagination' => [
              'total' => $bookTypes->total(),
              'current_page' => $bookTypes->currentPage(),
              'last_page' => $bookTypes->lastPage()  
            ]
        ]);
    }

    public function getAllBookType (Request $request){
        $allBooks = bookTypeModel::all();
        return $this->success([
            'data' => $allBooks
        ]);
    }

    public function searchBookType(Request $request){
        $results = bookTypeModel::latest()->filter(request(['keyword']))->get();
        return $this->success([
            'data' => $results
        ]);
    }

    public function storeBookType(Request $request){
        $bookType = new bookTypeModel;
        $bookType->bookType = $request->bookType;
        $res = $bookType->save();

        if($res){
            return $this->success([
                'data' => $bookType
            ]);
        }
    }

    public function updateBookType(Request $request, $id){
        $formField = [
            'bookType' => $request->bookType
        ];

        $res = bookType::where('id', $id)->update($formField);
        if($res){
            return $this->success([
                'data' => $res
                ]);
        }
    }

    public function deleteBookType($id){
        $res = bookType::where('id', $id)->delete();
        return $this->success([
            'data' => "Fund deleted successfully"
        ]);
    }


}
