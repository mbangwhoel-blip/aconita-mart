<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;

class MemberApiController extends Controller
{
    public function index(Request $request)
    {
        $query = Member::where('is_active', true);

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('member_no', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        return response()->json([
            'success' => true,
            'data' => $query->orderBy('name')->get(),
        ]);
    }

    public function show($id)
    {
        $member = Member::where('id', $id)
            ->orWhere('member_no', $id)
            ->first();

        if (!$member) {
            return response()->json([
                'success' => false,
                'message' => 'Anggota tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $member,
        ]);
    }
}
