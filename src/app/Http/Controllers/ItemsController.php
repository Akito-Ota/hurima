<?php

namespace App\Http\Controllers; //商品検索および一覧表示

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Category;
use App\Models\User;
use App\Http\Requests\ExhibitionRequest;

class ItemsController extends Controller
{
    public function index()
    {
        // 通常の商品一覧
        $items = Item::with('categories')
            ->when(
                auth()->check(),
                fn($q) =>
                $q->where('user_id', '!=', auth()->id()))
            ->withExists(['purchase as is_sold'])
            ->orderByDesc('created_at')
            ->paginate(12)
            ->withQueryString();

        // いいね済み商品（マイリスト） ログイン時のみ表示
        $likedItems = Item::query()
            ->when(
                auth()->check(),
                fn($q) => $q->whereHas('likes', fn($qq) => $qq->where('user_id', auth()->id())),
                fn($q) => $q->whereRaw('0=1') 
            )
            ->with('categories')
            ->withExists(['purchase as is_sold'])
            ->orderByDesc('created_at')
            ->paginate(12, ['*'], 'liked_page');

        return view('items.index', compact('items', 'likedItems'));
    }

    public function create() //出品フォーム用画面表示
    {   
        $categories = Category::all();
        return view('items.sell',compact('categories')); 
    }

    public function search(Request $request) //検索機能
    {
        $q = trim((string) $request->query('q', ''));

        $items = Item::query()
            ->when(
                auth()->check(),
                fn($q1) =>
                $q1->where('user_id', '!=', auth()->id())
            )
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($qq) use ($q) {
                    $qq->where('name', 'like', "%{$q}%")
                        ->orWhere('brand', 'like', "%{$q}%")
                        ->orWhere('description', 'like', "%{$q}%");
                });
            })
            ->with('categories')
            ->withExists(['purchase as is_sold'])
            ->orderByDesc('created_at')
            ->paginate(12)
            ->withQueryString();

        $likedItems = auth()->check()? Item::with('categories')
            ->whereHas('likes', fn($q) => $q->where('user_id', auth()->id()))
            ->withExists(['purchase as is_sold'])
            ->orderByDesc('created_at')
            ->paginate(12, ['*'], 'liked_page')  
            : collect(); 

        return view('items.index', compact('items', 'likedItems'));
    }
    public function show($id) //詳細画面に遷移
    {
        $item = Item::with(['categories', 'comments.user', 'purchase'])->findOrFail($id);
        $profile = auth()->user()->profile ?? null;

        return view('items.show', compact('item','profile'));
    }

    public function store(ExhibitionRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('item_images')) {
            $data['item_images'] = $request->file('item_images')->store('items', 'public');
        }
        $data['user_id'] = $request->user()->id;
        $item = Item::create($data);
        $item->categories()->sync($request->input('category_ids', []));
        
        return redirect()->route('items.index')->with('success','商品を出品しました');
    }
}
