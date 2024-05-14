<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }} |
            <a href="{{ route('posts.index') }}">{{ __('Posts') }}</a> |
            <a href="{{ route('categories.index') }} ">{{ __('Categories') }}</a> |
            <a href="{{ route('category-audit-logs.index') }} ">{{ __('Category Audit Log') }}</a> |
            <a href="{{ route('roles.index') }}">{{ __('Roles') }}</a> |
            <a href="{{ route('roleUsers.index') }}">{{ __('Role Users') }}</a> |
            <a href="#">{{ __('Category Posts') }}</a> |
            <a href="#">{{ __('Tags') }}</a> |
            <a href="#">{{ __('Privacy') }}</a> |

            <a href="#">{{ __('Tag Posts') }}</a>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
