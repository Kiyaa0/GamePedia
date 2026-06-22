<x-app-layout>
    <div class="max-w-3xl mx-auto space-y-6">
        <div class="bg-gray-900 border border-gray-800 rounded-lg p-6">
            @include('profile.partials.update-profile-information-form')
        </div>

        <div class="bg-gray-900 border border-gray-800 rounded-lg p-6">
            @include('profile.partials.update-password-form')
        </div>

        <div class="bg-gray-900 border border-gray-800 rounded-lg p-6">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</x-app-layout>
