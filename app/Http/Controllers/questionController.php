<?php

namespace App\Http\Controllers;

use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use App\Models\questionModel;

class questionController extends Controller
{
    use HttpResponses;
    //
    public function index(Request $request){
        $bookId = $request->input('bookId');
        $pageId = $request->input('pageId');

        $questionData = questionModel::where('pageId', $pageId)->where('bookId', $bookId)->get();
        return $this->success([
            'data' => $questionData
        ]);
    }


    public function countQuestionsOnPage(Request $request){
        $bookId = $request->input('bookId');
        $pageId = $request->input('pageId');

        $countQuestions = questionModel::where('pageId', $pageId)->where('bookId', $bookId)->count();
        return $this->success([
            'data' => $countQuestions
        ]);
    }


    public function storeQuestion(Request $request){
        $question = new questionModel;
        $question->bookId = $request->bookId;
        $question->pageId = $request->pageId;
        $question->authorId = $request->authorId;
        $question->questionNo = $request->questionNo;
        $question->question = $request->question;
        $question->questionHint = $request->questionHint;
        $question->options = $request->options;
        $question->answer = $request->answer;
        $question->images = $request->imageUpload;
        $res = $question->save();
        if($res){
            return $this->success([
                'data' => $question
            ]);
        }
    }


    public function updateQuestion(Request $request, $id){
        $formField = [
            'questionHint' => $request->questionHint,
            'question' => $request->question,
            'options' => $request->options,
            'answer' => $request->answer,
            'images' => $request->imageUpload
        ];

        $res = questionModel::where('id', $id)->update($formField);
        if($res){
            return $this->success([
                'data' => $res
            ]);
        }
    }

    public function deleteQuestion(Request $request, $id){
        $res = questionModel::where('id', $id)->delete();
        return $this->success([
            'message' => "Delete Question"
        ]);
    }
}
