@extends('layouts.master')

@section('content')
    <style>
        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            background-color: rgba(0, 0, 0, 0.1);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .card-hover:hover .card-title,
        .card-hover:hover .card-text {
            color: black;
        }
    </style>
    <div class="container mt-4">
        <div class="text-center mb-4">
            <img src="{{ asset('assets/img/logo.jpg') }}" class="img-fluid" alt="...">
            <h1>@lang('lang.welcome_to_connect_friend')</h1>
            <p>@lang('lang.find_friends_based_on_your_interests_and_hobbies')</p>
        </div>
        <div class="row" id="userGallery">
            @foreach ($users as $user)
                <div class="col-md-4 mb-4">
                    <a href="{{ route('detailPage', ['user_id' => $user->id]) }}" class="text-decoration-none text-body">
                        <div class="card text-center card-hover">
                            <div class="d-flex justify-content-center mt-4">
                                <img src="{{ $user->profile_picture ?: asset('assets/img/avatar/avatar-default.jpg') }}"
                                    class="card-img-top" alt="User Photo" style="width: 150px; height: 150px;">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">{{ $user->name }}</h5>
                                <p class="card-text">@lang('lang.profession'):
                                    {{ Str::limit(implode(', ', json_decode($user->hobbies, true)), 30, '...') }}</p>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
        <div class="text-center mt-4">
            <a href="{{ route('friendPage') }}" class="btn btn-dark">@lang('lang.see_more')</a>
        </div>
    </div>
@endsection
