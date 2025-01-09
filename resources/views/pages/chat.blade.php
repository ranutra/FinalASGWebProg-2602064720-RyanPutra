@extends('layouts.master')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <strong>@lang('lang.user_chat')</strong>
                    </div>
                    <div class="list-group list-group-flush">
                        @foreach ($users as $user)
                            <a href="{{ route('chatPage', ['current_chat_id' => $user->id]) }}"
                                class="list-group-item list-group-item-action d-flex align-items-center {{ $current_chat_id == $user->id ? 'bg-dark text-white' : '' }}">
                                <img src="{{ $user->profile_picture ?: asset('assets/img/avatar-default.jpg') }}"
                                    alt="{{ $user->name }}'s avatar" class="rounded-circle me-3"
                                    style="width: 40px; height: 40px; object-fit: cover;">
                                <span>{{ $user->name }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
            @if ($chats)
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body" style="height: 500px; overflow-y: scroll;" id="chat-window">
                            @foreach ($chats as $chat)
                                <div
                                    class="d-flex {{ $chat->sender_id === auth()->id() ? 'justify-content-end' : 'justify-content-start' }} mb-2">
                                    <div class="p-3 rounded {{ $chat->sender_id === auth()->id() ? 'bg-dark text-white' : 'bg-light text-dark' }}"
                                        style="max-width: 70%;">
                                        <p class="m-0">{{ $chat->message }}</p>
                                        <small class="text-muted">{{ $chat->created_at->format('d M Y H:i') }}</small>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <form method="POST" action="{{ route('sendMessage', ['receiver_id' => $current_chat_id]) }}"
                        id="chat-form" class="mt-3">
                        @csrf
                        <div class="input-group">
                            <input type="text" name="message" id="message" class="form-control"
                                placeholder="Type your message">
                            <button type="submit" class="btn btn-dark">Send</button>
                        </div>
                        @error('message')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </form>
                </div>
            @endif
        </div>
    </div>
@endsection
