<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('front.pages.notification', compact('notifications'));
    }

    // Optional: Tandai semua sudah dibaca
    public function readAll()
    {
        Notification::where('user_id', Auth::id())->update(['is_read' => true]);
        return redirect()->route('notifications.index')->with('success', 'Semua notifikasi telah ditandai sudah dibaca.');
    }

    // Tandai satu notifikasi sudah dibaca
    public function read($id)
    {
        $notification = Notification::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();
            
        $notification->update(['is_read' => true]);
        
        return redirect()->back()->with('success', 'Notifikasi telah ditandai sudah dibaca.');
    }
}