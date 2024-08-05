<?php

namespace App\Http\Controllers;
use App\Traits\HttpResponses;
use App\Models\bookModel;
use App\Models\pageModel;
use App\Models\questionModel;

use Illuminate\Http\Request;

class bookController extends Controller
{
    use HttpResponses;
    //
    public function index(Request $request){
        $pageNo = $request->input('page');
        $perPage = $request->input('perPage');
        $bookModel = bookModel::orderBy('id', 'DESC')->paginate($perPage, ['*'], 'page', $pageNo);
        return $this->success([
            'data' => $bookModel,
            'pagination' => [
              'total' => $bookModel->total(),
              'current_page' => $bookModel->currentPage(),
              'last_page' => $bookModel->lastPage()  
            ]
        ]);
    }


    public function countBooksNotPublishedByAuthor(Request $request, $id){
        $countBooksNotPublished = bookModel::where('authorId', $id)->where('status', '!=', 'live')->count();
        return $this->success([
          'data' => $countBooksNotPublished
        ]);
    }

    public function countBooksPublishedByAuthor(Request $request, $id){
        $countBooksPublished = bookModel::where('authorId', $id)->where('status', 'live')->count();
        return $this->success([
            'data' => $countBooksPublished
          ]);
    }


    public function getAuthorBooks(Request $request){
        $pageNo = $request->input('page');
        $perPage = $request->input('perPage');
        $authorId = $request->input('authorId');
        $authorBooks = bookModel::where('authorId', $authorId)->Where('status','!=','live')->orderBy('id', 'DESC')->paginate($perPage, ['*'], 'page', $pageNo);
        return $this->success([
            'data' => $authorBooks,
            'pagination' => [
              'total' => $authorBooks->total(),
              'current_page' => $authorBooks->currentPage(),
              'last_page' => $authorBooks->lastPage()  
            ]
        ]);
    }


    public function getAuthorPublish(Request $request){
        $pageNo = $request->input('page');
        $perPage = $request->input('perPage');
        $authorId = $request->input('authorId');
        $authorPublish = bookModel::where('authorId', $authorId)->where('status','live')->orderBy('id', 'DESC')->paginate($perPage, ['*'], 'page', $pageNo);
        return $this->success([
            'data' => $authorPublish,
            'pagination' => [
              'total' => $authorPublish->total(),
              'current_page' => $authorPublish->currentPage(),
              'last_page' => $authorPublish->lastPage()  
            ]
        ]);
    }


    public function searchBook(Request $request){
        $results = bookModel::latest()->filter(request(['keyword']))->get();
        return $this->success([
            'data' => $results
        ]);
    }


    public function searchAuthorBook(Request $request){
        $authorId = $request->input('authorId');
        $results = bookModel::where('authorId', $authorId)->latest()->filter(request(['keyword']))->get();
        return $this->success([
            'data' => $results
        ]);
    }


    public function searchAuthorPublish(Request $request){
        $authorId = $request->input('authorId');
        $results = bookModel::where('authorId', $authorId)->where('status', 'live')->latest()->filter(request(['keyword']))->get();
        return $this->success([
            'data' => $results
        ]);
    }


    public function storeBook(Request $request){
        $book = new bookModel;
        $book->bookName = $request->bookName;
        $book->bookType = $request->bookType;
        $book->class = $request->classId;
        $book->description = $request->description;
        $book->authorId = $request->authorId;
        $book->coverImage = $request->coverImage;
        $book->status = "unpublish";
        $res = $book->save();
        if($res){
            return $this->success([
                'data' => $book
            ]);
        }
    }


    public function updateBook(Request $request, $id){
       $formField = [
        'bookName' => $request->bookName,
        'bookType' => $request->bookType,
        'class' => $request->classId,
        'description' => $request->description,
        'coverImage' => $request->imageUpload,
       ];

       $res = bookModel::where('id', $id)->update($formField);
       if($res){
           return $this->success([
               'data' => $res
               ]);
       }
    }

    public function updateBookStatus(Request $request, $id){
        $formField = [
           'status' => $request->status
        ];

        $res = bookModel::where('id', $id)->update($formField);
        if($res){
            return $this->success([
                'data' => $res
                ]);
        }
    }


    public function deleteBook(Request $request, $id){
        $resQues = questionModel::where('bookId', $id)->delete();
        $resPage = pageModel::where('bookId', $id)->delete();
        $res = bookModel::where('id', $id)->delete();
        if($res){
            return $this->success([
                'data' => "Delete Book"
                ]);
        }
     }


}
