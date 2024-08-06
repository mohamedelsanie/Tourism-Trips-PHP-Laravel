<section class="space-y-6">
    <header>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('admin/profile.delete_info') }}
        </p>
    </header>
    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('admin/profile.delete') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('admin.profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('admin/profile.delete_confirm') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('admin/profile.delete_msg') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="Password" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('admin/profile.pass') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('admin/profile.cancel') }}
                </x-secondary-button>

                <x-danger-button class="ml-3">
                    {{ __('admin/profile.delete') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
