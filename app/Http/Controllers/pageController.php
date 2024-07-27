<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Models\pageModel;
use App\Models\questionModel;

class pageController extends Controller
{
    //
    use HttpResponses;

    public function storePage(Request $request){
     $pages = new pageModel;
     $pages->title = $request->title;
     $pages->pageNo = $request->pageNo;
     $pages->bookId = $request->bookId;
     $pages->authorId = $request->authorId;
     $res = $pages->save();
     if($res){
        return $this->success([
            'data' => $pages
        ]);
    }
    }


    public function searchPage(Request $request){
        $bookId = $request->input('bookId');
        $results = pageModel::where('bookId', $bookId)->latest()->filter(request(['keyword']))->get();
        return $this->success([
            'data' => $results
        ]);
    }

    
    public function getBookPage(Request $request){
        $pageNo = $request->input('page');
        $perPage = $request->input('perPage');
        $bookId = $request->input('bookId');
        $bookPage = pageModel::where('bookId', $bookId)->orderBy('id', 'DESC')->paginate($perPage, ['*'], 'page', $pageNo);
        return $this->success([
            'data' => $bookPage,
            'pagination' => [
              'total' => $bookPage->total(),
              'current_page' => $bookPage->currentPage(),
              'last_page' => $bookPage->lastPage()  
            ]
        ]);
    }


    public function updatePage(Request $request, $id){
        $formField = [
         'title' => $request->title,
         'pageNo' => $request->pageNo,
        ];
 
        $res = pageModel::where('id', $id)->update($formField);
        if($res){
            return $this->success([
                'data' => $res
                ]);
        }
    }


    public function deletePage(Request $request, $id){
        $resQues = questionModel::where('pageId', $id)->delete();
        $resPage = pageModel::where('id', $id)->delete();
        if($resPage){
            return $this->success([
                'data' => "Delete Pages"
                ]);
        }
     }


}
