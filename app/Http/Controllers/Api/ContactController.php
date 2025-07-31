<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:100',
            'email'     => 'nullable|email|max:150',
            'phone'     => 'nullable|string|max:20',
            'message'   => 'required|string',
            'type'      => 'nullable|in:contact,support,complain,advice',
        ]);

        $contact = Contact::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Thông tin đã được gửi thành công',
            'data'    => $contact,
        ], 201);
    }
}
