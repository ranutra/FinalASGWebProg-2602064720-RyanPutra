@extends('layouts.master')

@section('content')
    <div class="container mt-4">
        <h2>Notifications</h2>
        <ul class="nav nav-tabs" id="notificationTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="chat-tab" data-bs-toggle="tab" href="#chat" role="tab" aria-controls="chat" aria-selected="true">
                    <i class="fas fa-comment-dots"></i> Chat
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="friend-request-tab" data-bs-toggle="tab" href="#friend-request" role="tab" aria-controls="friend-request" aria-selected="false">
                    <i class="fas fa-user-friends"></i> Friend Request
                </a>
            </li>
        </ul>
        <div class="tab-content mt-3" id="notificationTabContent">
            <div class="tab-pane fade show active" id="chat" role="tabpanel" aria-labelledby="chat-tab">
                <ul class="list-group">
                    @forelse ($chatNotification as $notification)
                        <li class="list-group-item d-flex justify-content-between align-items-center hover-effect">
                            <div>
                                <strong>{{ $notification->sender->name }}:</strong> {{ Str::limit($notification->message, 125, '..') }}
                                <small class="text-muted d-block">{{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}</small>
                            </div>
                            <a href="{{ route('chatPage', ['current_chat_id'=>$notification->sender->id]) }}" class="btn btn-outline-dark btn-sm">See</a>
                        </li>
                    @empty
                        <div class="alert alert-warning text-center" role="alert">
                            No chat notifications available.
                        </div>
                    @endforelse                
                </ul>
            </div>
            <div class="tab-pane fade" id="friend-request" role="tabpanel" aria-labelledby="friend-request-tab">
                <ul class="list-group">
                    @forelse ($friendRequestNotification as $notification)
                        <li class="list-group-item d-flex justify-content-between align-items-center hover-effect">
                            <div>
                                <strong>{{ $notification->name }}</strong> sent you a friend request.
                            </div>
                            <div>
                                <a href="{{ route('friendRequestPage') }}" class="btn btn-outline-primary btn-sm">See</a>
                            </div>
                        </li>
                    @empty
                        <div class="alert alert-warning text-center" role="alert">
                            No friend request notifications available.
                        </div>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
@endsection