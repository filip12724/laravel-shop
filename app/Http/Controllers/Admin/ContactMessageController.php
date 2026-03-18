<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    public function index(Request $request)
    {
        $query = ContactMessage::query();

        if ($request->get('unread')) {
            $query->where('read', false);
        }

        $messages = $query->orderByDesc('created_at')->paginate(15)->withQueryString();
        $unreadCount = ContactMessage::where('read', false)->count();

        return view('admin.messages.index', compact('messages', 'unreadCount'));
    }

    public function show(ContactMessage $contactMessage)
    {
        $contactMessage->update(['read' => true]);
        return view('admin.messages.show', compact('contactMessage'));
    }

    public function destroy(ContactMessage $contactMessage)
    {
        $contactMessage->delete();
        return response()->json(['success' => true]);
    }
}
