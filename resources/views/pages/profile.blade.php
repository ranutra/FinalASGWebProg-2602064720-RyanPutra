@extends('layouts.master')

@section('content')
    <div class="container mt-4">
        <div class="text-center mb-4">
            <h1>{{ Auth::user()->name }}'s Profile</h1>
            <p class="text-muted">{{ Auth::user()->email }}</p>
            <img src="{{ Auth::user()->profile_picture ?: asset('assets/img/avatar/avatar-default.jpg') }}"
                alt="Profile Picture" class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
        </div>
        <div class="row mb-4">
            <div class="col-md-6">
                <h5>@lang('lang.profile_detail')</h5>
                <ul class="list-group">
                    <li class="list-group-item"><strong>@lang('lang.gender'): </strong>{{ Auth::user()->gender }}</li>
                    <li class="list-group-item"><strong>@lang('lang.hobbies'):
                        </strong>{{ implode(', ', json_decode(Auth::user()->hobbies, true)) }}</li>
                    <li class="list-group-item"><strong>Instagram: </strong><a
                            href="https://www.instagram.com/{{ Auth::user()->instagram_username }}" target="_blank"
                            rel="noopener noreferrer">{{ Auth::user()->instagram_username }}</a></li>
                </ul>
            </div>
            @if (session('error'))
                <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1055;">
                    <div class="toast align-items-center text-bg-danger border-0 show" role="alert" aria-live="assertive"
                        aria-atomic="true">
                        <div class="d-flex">
                            <div class="toast-body">{{ session('error') }}</div>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                                aria-label="Close"></button>
                        </div>
                    </div>
                </div>
            @endif
            <div class="col-md-6">
                <h5>@lang('lang.profile_visibility')</h5>
                <form method="POST" action="{{ route('changeVisibility') }}" id="visibilityForm"
                    class="d-flex align-items-center">
                    @csrf
                    <div class="form-check form-switch mt-3">
                        <input class="form-check-input" type="checkbox" id="profileVisibilityToggle"
                            {{ Auth::user()->visibility ? 'checked' : '' }}>
                        <label class="form-check-label"
                            for="profileVisibilityToggle">{{ Auth::user()->visibility ? __('lang.make_profile_invisible') . ' for 50 Coins' : __('lang.make_profile_visible') . ' for 5 Coins' }}</label>
                    </div>
                </form>
                <p class="text-muted mt-2">@lang('lang.toggle_visible')</p>
            </div>
        </div>
        <div class="mb-4">
            <h5>@lang('lang.your_avatar')</h5>
            <div class="row">
                <div class="col-md-3 mb-3">
                    <form method="POST" action="{{ route('changeAvatar') }}">
                        @csrf
                        <input type="hidden" name="avatar_imagepath" value="">
                        <div class="card text-center pt-3 {{ Auth::user()->profile_picture === null ? 'border border-3 border-success shadow' : '' }}"
                            style="cursor: pointer;" onclick="this.closest('form').submit();">
                            <img src="{{ asset('assets/img/avatar/avatar-default.jpg') }}" alt="Avatar"
                                class="card-img-top" style="height: 100px; object-fit: contain;">
                            <div class="card-body">
                                <p class="card-text">Default</p>
                            </div>
                        </div>
                    </form>
                </div>
                @forelse($avatars as $avatar)
                    <div class="col-md-3 mb-3">
                        <form method="POST" action="{{ route('changeAvatar') }}">
                            @csrf
                            <input type="hidden" name="avatar_imagepath" value="{{ $avatar->imagepath }}">
                            <div class="card text-center pt-3 {{ Auth::user()->profile_picture === $avatar->imagepath ? 'border border-3 border-success shadow' : '' }}"
                                style="cursor: pointer;" onclick="this.closest('form').submit();">
                                <img src="{{ $avatar->imagepath }}" alt="Avatar" class="card-img-top"
                                    style="height: 100px; object-fit: contain;">
                                <div class="card-body">
                                    <p class="card-text">{{ $avatar->name }}</p>
                                </div>
                            </div>
                        </form>
                    </div>
                @empty
                    <p class="text-muted">@lang('lang.dont_have_avatar')</p>
                @endforelse
            </div>
        </div>
        <div class="text-center">
            <a href="{{ route('avatarShopPage') }}" class="btn btn-primary">@lang('lang.buy_new_avatar')</a>
        </div>
    </div>
    <script>
        const toggle = document.getElementById('profileVisibilityToggle');
        const form = document.getElementById('visibilityForm');

        toggle.addEventListener('change', () => {
            form.submit();
        });
    </script>
@endsection
