<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;

class AdminContactMessageController extends Controller
{
    public function index()
    {
        // Fetch all messages so DataTables handles pagination/search.
        $messages = ContactMessage::latest()->get();

        return view('admin.messages.index', compact('messages'));
    }

    public function show(ContactMessage $message)
    {
        return view('admin.messages.show', compact('message'));
    }
}
