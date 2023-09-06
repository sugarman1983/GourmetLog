<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Models\{User, Restaurant};
use App\Models\Category;

use Validator;

class RestaurantController extends Controller
{
    /**
     * コンストラクタ
     * 
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * レストラン一覧
     * 
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        //$users = User::all();
        $restaurants = Restaurant::with('categories')->orderBy('created_at', 'asc')->where(function ($query)
        {
            // 検索機能
            if ($search = request('search')) {
                $query->where('name', 'LIKE', "%{$search}%")->orWhereHas('categories', function ($query) use ($search) {
                    $query->where('name', 'LIKE', "%{$search}%");
                })
                ;
            }
        })->paginate(10);

        return view('restaurants.index', compact('restaurants'));
    }

    private $formItems = [
        'name',
        'name_katakana',
        // 'food_picture',
        'map_url',
        'phone_number',
        'category_id',
        'comment',
        'review',
    ];

    private $validator_new = [
        'name' => 'required|string|max:20',
        'name_katakana' => 'required|katakana',
        'phone_number' => 'numeric|nullable',
        'category_id' => 'required',
        'review' => 'required|between:1,5',
        'comment' => 'required|max:300',
    ];

    /**
     * 新レストラン作成
     *
     * @param Request  $request
     * @return Response
     */
    public function show(Request $request)
    {
        $categories = Category::all();
        return view('restaurants/form', compact('categories'));
    }

    public function post(Request $request)
    {
        // ディレクトリ名
        $dir = 'tmp/';

        $input = $request->only($this->formItems);
        
        // $this->validate($request, [
        //     'name' => 'required|max:100',
        // ]);
        $validator = Validator::make($input, $this->validator_new);
        if($validator->fails()){
            return redirect()->action([RestaurantController::class, 'show'])->withErrors($validator)->withInput();
        }

        if ( is_file($request->file('food_picture')) ) {
            $image_name = $request->file('food_picture')->getClientOriginalName();
            $request->file('food_picture')->storeAs('public/' . $dir, $image_name);
            // $image_path = $dir . '/' . $image_name;
        } else {
            $image_name = null;
        };

        // セッションにフォームの内容を保存
        $request->session()->put("form_input", $input);
        $request->session()->put("image_name", $image_name);
        
        $categories = Category::all();
        return view("restaurants/form_confirm", compact('input', 'categories', 'image_name'));
    }

    /**
     * 新レストラン送信
     *
     * @param Request  $request
     * @return Response
     */
    public function send(Request $request)
    {
        // セッションからフォームの内容を取得
        $input = $request->session()->get('form_input');
        $image_name = $request->session()->get('image_name');

        // 修正ボタンが押された場合
        if($request->has('back')) {
            return redirect()->action([RestaurantController::class, 'show'])->withInput($input);
        }

        // セッションにフォームの内容がない場合はフォームに戻る
        if (!$input) {
            return redirect()->action([RestaurantController::class, 'show']);
        }

        // ディレクトリ名
        $dir = 'public/pict/';

        // レストラン作成処理
        $restaurant = Restaurant::create([
            'user_id' => Auth::user()->id,
            'name' => $input['name'],
            'name_katakana'=> $input['name_katakana'],
            'food_picture' => $image_name,
            'map_url' => $input['map_url'],
            'phone_number'=> $input['phone_number'],
        ]);

        $restaurant->categories()->attach($input['category_id']);

        $restaurant->users()->attach(Auth::user()->id, ['comment' => $input['comment'], 'review' => $input['review']]);

        if ($image_name){
            Storage::move('public/tmp/'.$image_name, $dir.$restaurant->food_picture);
        }

        // セッションを空にする
        $request->session()->forget('form_input');
        $request->session()->forget('image_name');

        return redirect()->action([RestaurantController::class, 'complete']);
    }

    /**
     * 新レストラン完了
     *
     * @param Request  $request
     * @return Response
     */
    public function complete(Request $request)
    {
        return view('restaurants/form_complete');
    }

    /**
     * 指定レストラン削除
     * 
     * @param Request  $request
     * @param Restaurant  $restaurant
     * @return Response
     */
    public function destroy(Request $request ,Restaurant $restaurant)
    {
        $restaurant = Restaurant::where('id', '=', $request->id)->first();        
        $restaurant->delete();
        $restaurant->users()->detach();

        return redirect('/restaurants');
    }

    /**
     * 指定レストラン詳細
     * 
     * @param Request  $request
     * @param Restaurant  $restaurant
     * @return Response
     */
    public function detail(Request $request, $id)
    {

        $restaurant = Restaurant::find($id);

        return view('restaurants.detail', compact('restaurant', 'id'));
    }
    

    private $editItems = [
        'id',
        'name',
        'name_katakana',
        // 'food_picture',
        'map_url',
        'phone_number',
        'category_id',
    ];

    private $validator_edit = [
        'name' => 'required|string|max:20',
        'name_katakana' => 'required|katakana',
        'phone_number' => 'numeric|nullable',
        'category_id' => 'required',
    ];


    /**
     * 指定レストラン編集
     * 
     * @param Request  $request
     * @param Restaurant  $restaurant
     * @return Response
     */
    public function call(Request $request, $id)
    {
        $restaurant = Restaurant::find($id);
        $categories = Category::all();
        $user = Auth::user();

        return view('restaurants/edit', compact('restaurant', 'categories', 'user'));
    }

    public function update(Request $request)
    {
        $input = $request->only($this->editItems);

        $id = $request->id;

        $restaurant = Restaurant::where('id', '=', $request->id)->first();
        
        $validator = Validator::make($input, $this->validator_edit);
        if($validator->fails()){
            return redirect()->action([RestaurantController::class, 'call'], ['id' => $id])->withErrors($validator)->withInput();
        }

        $image_name = $restaurant->food_picture;
        // ディレクトリ名
        $dir = 'pict/';

        if ( is_file($request->file('food_picture')) ) {
            $image_name = $request->file('food_picture')->getClientOriginalName();
            $dir = 'tmp/';
            $request->file('food_picture')->storeAs('public/' . $dir, $image_name);
        };

        // セッションにフォームの内容を保存
        session(['id' => $id]);
        $request->session()->put("edit_input", $input);
        $request->session()->put("image_name", $image_name);
        $request->session()->put("image_dir", $dir);
        
        $categories = Category::all();
        return view("restaurants/edit_confirm", compact('id', 'input', 'categories', 'image_name', 'dir'));
    }

    /**
     * レストラン更新
     *
     * @param Request  $request
     * @return Response
     */
    public function upload(Request $request)
    {
        // セッションからフォームの内容を取得
        $id = $request->session()->get('id');
        $input = $request->session()->get('edit_input');
        $image_name = $request->session()->get('image_name');

        $restaurant = Restaurant::where('id', '=', $id)->first();

        // 修正ボタンが押された場合
        if($request->has('back')) {
            return redirect()->action([RestaurantController::class, 'call'], ['id' => $id])->withInput($input);
        }

        // セッションにフォームの内容がない場合はフォームに戻る
        if (!$input) {
            return redirect()->action([RestaurantController::class, 'call'], ['id' => $id]);
        }

        // ディレクトリ名
        $dir = 'public/pict/';

        // レストラン情報更新
        $restaurant->user_id = Auth::user()->id;
        $restaurant->name = $input['name'];
        $restaurant->name_katakana = $input['name_katakana'];
        $restaurant->food_picture = $image_name;
        $restaurant->map_url = $input['map_url'];
        $restaurant->phone_number = $input['phone_number'];

        $restaurant->categories()->sync($input['category_id']);

        $restaurant->save();

        if ($image_name){
            Storage::move('public/tmp/'.$image_name, $dir.$restaurant->food_picture);
        }

        // セッションを空にする
        $request->session()->forget('form_input');
        $request->session()->forget('image_name');

        return redirect()->action([RestaurantController::class, 'finish'], ['id' => $id]);
    }

    /**
     * レストラン更新完了
     *
     * @param Request  $request
     * @return Response
     */
    public function finish(Request $request)
    {
        return view('restaurants/edit_complete');
    }

    
}
