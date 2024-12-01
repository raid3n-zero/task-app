<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->get('query');

        $members = Member::query()->select('name', 'email');

        if(!is_null($query) && $query != '')
        {
            return response([
                'data' => $members->where('name', 'like', '%'.$query.'%')->orderBy('id', 'desc')->paginate(10)
            ], 200);
        }

        return response([
            'data' => $members->paginate(10)
        ], 200);
    }

    public function store(Request $request)
    {
        $fields = $request->all();

        $errors = Validator::make($fields, [
            'name' => 'required',
            'email' => 'required|email'
        ]);

        if($errors->fails())
        {
            return response($errors->errors()->all(), 422);
        }

        Member::query()->create([
            'name' => $request->name,
            'email' => $request->email
        ]);

        return response([
            'message' => 'member created'
        ],200);
    }

    public function update(Request $request)
    {
        $fields = $request->all();

        $errors = Validator::make($fields, [
            'id' => 'required|numeric',
            'name' => 'required',
            'email' => 'required|email'
        ]);

        if($errors->fails())
        {
            return response($errors->errors()->all(), 422);
        }

        Member::where('id', $request->id)->update([
            'name' => $request->name,
            'email' => $request->email
        ]);

        return response([
            'message' => 'member updated'
        ], 200);
    }
}
