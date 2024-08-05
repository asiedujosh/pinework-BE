<?php

namespace App\Http\Controllers;
use App\Traits\HttpResponses;
use App\Models\subscriptionModel;

use Illuminate\Http\Request;

class subscriptionController extends Controller
{
    use HttpResponses;
    //
    public function getAuthorSubscribers(Request $request, $id){
        $pageNo = $request->input('page');
        $perPage = $request->input('perPage');
        $subscribeModel = subscriptionModel::where('authorId', $id)->orderBy('id', 'DESC')->paginate($perPage, ['*'], 'page', $pageNo);
        return $this->success([
            'data' => $subscribeModel,
            'pagination' => [
              'total' => $subscribeModel->total(),
              'current_page' => $subscribeModel->currentPage(),
              'last_page' => $subscribeModel->lastPage()  
            ]
        ]);
    }


    public function countAuthorSubscribers(Request $request, $id){
        $countAuthorSubscription = subscriptionModel::where('authorId', $id)->count();
        return $this->success([
          'data' => $countAuthorSubscription
        ]);
    }
}
