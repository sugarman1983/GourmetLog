<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Validation\Rule;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * カテゴリー一覧
     * 
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $categories = Category::orderBy('id', 'asc')->paginate(10);

        return view('categories.index', [
            'categories' => $categories,
        ]);
    }

    /**
     * カテゴリー登録
     * 
     * @param Request $request
     * @return Rexponse
     */
    public function add(Request $request)
    {
        // POSTリクエストのとき
        if ($request->isMethod('post')) {
            // バリデーション
            $this->validate($request, [
                'name' => ['required','max:100',Rule::unique('categories')],
            ]);

            // カテゴリー登録
            Category::create([
                'id' => 0,
                'name' => $request->name,
            ]);

            return redirect('/categories');
        }

        return view('category.cat_add');
    }

    /**
     * 指定カテゴリー削除
     * 
     * @param Request  $request
     * @param Category  $category
     * @return Response
     */
    public function destroy(Request $request ,Category $category)
    {
        $category = Category::where('id', '=', $request->id)->first();        
        $category->delete();

        return redirect('/categories');
    }

    /**
     * 指定カテゴリー編集
     * 
     * @param Request  $request
     * @param Category  $category
     * @return Response
     */
    public function edit(Request $request, $id)
    {
        // POSTリクエストの時
        if ($request->isMethod('post')) {

            $category = Category::where('id', '=', $request->id)->first();

            // バリデーション
            $this->validate($request, [
                'name' => 'required|max:100',
            ]);

            $category->name = $request->name;

            $category->save();

            return redirect('/categories');
        }
        $category = Category::find($id);

        return view('categories.edit', compact('category'));
    }
}
