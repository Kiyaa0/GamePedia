@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto space-y-6">
        <div class="bg-[#1a1a1a] border border-white/5 rounded-lg p-6">
            @include('profile.partials.update-profile-information-form')
        </div>

        <div class="bg-[#1a1a1a] border border-white/5 rounded-lg p-6">
            @include('profile.partials.update-password-form')
        </div>

        <div class="bg-[#1a1a1a] border border-white/5 rounded-lg p-6">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
@endsection
