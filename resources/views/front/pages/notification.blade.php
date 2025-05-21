@extends('front.layouts.app')

@section('title', 'Notifikasi')

@section('content')
<div class="container">
    <div class="notification-header">
        <span class="notification-title"></span>
        <form action="{{ route('notifications.readAll') }}" method="POST">
            @csrf
            <button type="submit" class="btn-read-all">Baca semua</button>
        </form>
    </div>

    @forelse($notifications as $notification)
        <div class="notification-item {{ !$notification->is_read ? 'unread' : '' }}">
            <div class="notification-date">
                <span>{{ $notification->created_at->format('d F Y') }}</span>
                @if(!$notification->is_read)
                    <div class="notification-dot"></div>
                @endif
            </div>
            <div class="notification-title">
                {{ $notification->title }}
            </div>
            <div class="notification-content">
                <div class="content-preview">
                    {{ Str::limit($notification->body, 150) }}
                </div>
                <div class="content-full" style="display: none;">
                    {{ $notification->body }}
                </div>
            </div>
            <div class="notification-action">
                @if(strlen($notification->body) > 150)
                    <button class="btn-detail toggle-content">Selengkapnya</button>
                @endif
                @if(!$notification->is_read)
                    <a href="{{ route('notifications.read', $notification->id) }}" class="btn-detail" style="margin-left:8px;">Tandai sudah dibaca</a>
                @endif
            </div>
        </div>
    @empty
        <div class="notification-empty">
            Tidak ada notifikasi.
        </div>
    @endforelse

    @if($notifications->hasPages())
        <div class="notification-pagination">
            {{ $notifications->links() }}
        </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const toggleButtons = document.querySelectorAll('.toggle-content');
    
    toggleButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const notificationItem = this.closest('.notification-item');
            const preview = notificationItem.querySelector('.content-preview');
            const full = notificationItem.querySelector('.content-full');
            
            if (preview.style.display !== 'none') {
                preview.style.display = 'none';
                full.style.display = 'block';
                this.textContent = 'Tutup';
            } else {
                preview.style.display = 'block';
                full.style.display = 'none';
                this.textContent = 'Selengkapnya';
            }
        });
    });
});
</script>
@endsection

<style>
    .notification-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 8px;
        padding: 16px 16px 8px;
    }

    .notification-title {
        font-size: 14px;
        color: #333;
        font-weight: normal;
    }

    .btn-read-all {
        background: none;
        border: 1px solid #16B8A8;
        color: #16B8A8;
        font-size: 12px;
        font-weight: normal;
        border-radius: 5px;
        cursor: pointer;
        padding: 4px 8px;
        transition: all 0.3s ease;
    }

    .btn-read-all:hover {
        background: #16B8A8;
        color: white;
    }

    .notification-item {
        background: #fff;
        padding: 16px;
        margin-bottom: 1px;
        border-bottom: 1px solid #f2f2f2;
        transition: background-color 0.3s ease;
    }

    .notification-item.unread {
        background: #f8f9fa;
    }

    .notification-date {
        margin-bottom: 6px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .notification-date span {
        font-size: 12px;
        color: #888;
    }

    .notification-dot {
        background-color: #16B8A8;
        width: 8px;
        height: 8px;
        border-radius: 50%;
    }

    .notification-title {
        font-weight: 500;
        font-size: 15px;
        color: #333;
        margin-bottom: 4px;
    }

    .notification-content {
        color: #666;
        font-size: 13px;
        line-height: 1.4;
    }

    .notification-action {
        margin-top: 8px;
        display: flex;
        gap: 10px;
    }

    .btn-detail {
        color: #16B8A8;
        font-size: 13px;
        text-decoration: none;
        transition: color 0.3s ease;
        background: none;
        border: none;
        cursor: pointer;
        padding: 0;
    }

    .btn-detail:hover {
        color: #138f83;
    }

    .notification-empty {
        text-align: center;
        color: #aaa;
        margin: 48px 0;
        padding: 0 16px;
    }

    .notification-pagination {
        text-align: center;
        margin: 16px 0;
        padding: 8px 0;
    }
</style>