<?php

namespace App\Http\Controllers; //プロフィール登録,編集用

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ProfileRequest;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProfilesController extends Controller
{
    public function create()
    {
        return view('mypage.profile');
    }

    public function store(ProfileRequest $request)
    {
        $user = $request->user();
        $data = $request->validated();
        
        $user->update([
            'name' => $data['name'],
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('profiles', 'public');
        }
        Profile::updateOrCreate(
            ['user_id' => $user->id],               
            [
                'postcode' => $data['postcode'],
                'address'  => $data['address'],
                'building' => $data['building'],
                'image' =>$data['image'] ?? null, 
            ]
        );

        return redirect()->route('items.index')//商品一覧へリダイレクト
            ->with('success', 'プロフィールを登録しました');
    }

    public function edit()//２回目以降の画面表示
    {
        $user = auth()->user();
        $profile = $user->profile;
        return view('mypage.profile_edit', compact('user','profile'));
    }

    public function update(ProfileRequest $request)
    {
        $user  = $request->user();
        $data  = $request->validated();

        $profile = Profile::where('user_id', $user->id)->first();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('profiles', 'public');
        } else {
            $data['image'] = $profile->image ?? null; 
        }

        Profile::updateOrCreate(
            ['user_id' => $user->id],
            [
                'postcode' => $data['postcode'],
                'address'  => $data['address'],
                'building' => $data['building'],
                'image'    => $data['image'] ?? null,
            ]
        );

        return redirect()->route('items.index')->with('success', 'プロフィールを更新しました');
    }
}
