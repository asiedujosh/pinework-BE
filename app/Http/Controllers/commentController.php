<?php

namespace App\Http\Controllers;
use App\Traits\HttpResponses;
use App\Models\commentModel;

use Illuminate\Http\Request;

class commentController extends Controller
{
    use HttpResponses;
    //
    public function getAuthorBookComment(Request $request, $id){
        $pageNo = $request->input('page');
        $perPage = $request->input('perPage');
        $commentModel = commentModel::where('authorId', $id)->orderBy('id', 'DESC')->paginate($perPage, ['*'], 'page', $pageNo);
        return $this->success([
            'data' => $commentModel,
            'pagination' => [
              'total' => $commentModel->total(),
              'current_page' => $commentModel->currentPage(),
              'last_page' => $commentModel->lastPage()  
            ]
        ]);
    }

    public function countAuthorComment(Request $request, $id){
        $countAuthorComment = commentModel::where('authorId', $id)->count();
        return $this->success([
          'data' => $countAuthorComment
        ]);
    }
}
