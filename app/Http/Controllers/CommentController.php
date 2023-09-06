<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Restaurant;

use Validator;

class CommentController extends Controller
{
    private $commentItems = [
        'review',
        'comment',
    ];
    
    private $validator_comment = [
        'review' => 'required|between:1,5',
        'comment' => 'required|max:300',
    ];
    
    /**
     * 指定レストランコメント
     * 
     * @param Request  $request
     * @param Restaurant  $restaurant
     * @return Response
     */
    public function comment(Request $request, $id)
    {
        $restaurant = Restaurant::find($id);

        $input = $request->only($this->commentItems);

        $validator = Validator::make($input, $this->validator_comment);
        if($validator->fails()){
            return redirect()->action([RestaurantController::class, 'detail'], ['id' => $id])->withErrors($validator)->withInput();
        }

        $restaurant->users()->attach(Auth::user()->id, ['comment' => $request->comment, 'review' => $request->review]);

        return redirect('/restaurants/detail/'.$restaurant->id);
    }
}
