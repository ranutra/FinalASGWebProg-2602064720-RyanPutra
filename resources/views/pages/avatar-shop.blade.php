@extends('layouts.master')

@section('content')
    <div class="container mt-4">
        <div class="text-center mb-4">
            <h1>@lang('lang.avatar_shop')</h1>
            <p>@lang('lang.avatar_shop_tag')</p>
        </div>
        <div class="row">
            @foreach ($avatars as $avatar)
                <div class="col-md-4 mb-4">
                    <div class="card pt-3">
                        <img src="{{ asset($avatar->imagepath) }}" class="card-img-top" alt="{{ $avatar->name }}"
                            style="height: 200px; object-fit: contain;">
                        <div class="card-body text-center">
                            <h5 class="card-title">{{ $avatar->name }}</h5>
                            <p class="card-text">{{ $avatar->description }}</p>
                            <p class="text-primary fw-bold">{{ $avatar->price }} Coins</p>
                            @if (Auth::user()->coin >= $avatar->price)
                                <form method="POST" action="{{ route('purchaseAvatar', ['avatar_id' => $avatar->id]) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-dark btn-sm">@lang('lang.buy_now')</button>
                                </form>
                            @else
                                <button class="btn btn-dark btn-sm" disabled>@lang('lang.insufficient_coins')</button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-center mt-4">
            {{ $avatars->links() }}
        </div>
    </div>
@endsection
