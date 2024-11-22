<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Roles
        </h2>
    </x-slot>
    <div class="w-full pt-4 px-6 sm:px-6 md:px-8 lg:ps-72">
        <!-- Table Section -->
        <div class="max-w-[85rem] px-4 py-4 sm:px-6 lg:px-8 lg:py-5 mx-auto">
            <!-- Card -->
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('roles.update', $role->id) }}" method="post">
                        <div class="flex gap-2 w-full">
                        @method('PUT')
                        @csrf
                            <div class="w-1/2 space-y-3">
                                {{-- {{ $role }} --}}
                                <input type="text" name="roles" id="input-label" value="{{ $role->name }}"
                                    class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                                    placeholder="Roles">
                            </div>
                            <button type="submit"
                                class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-gray-800 text-white hover:bg-gray-900 focus:outline-none focus:bg-gray-900 disabled:opacity-50 disabled:pointer-events-none dark:bg-white dark:text-neutral-800">
                                Update
                            </button>
                        </div>
                        <hr class="mt-2 mb-2 border-yellow-500" />
                        <h1 class="text-lg text-gray-300 mt-2">Permissions:</h1>
                        <ul class="max-w-sm flex flex-col">
                            @foreach ($permissions as $permission)
                                <li
                                    class="inline-flex items-center gap-x-2 py-3 px-4 text-sm font-medium bg-white border text-gray-800 -mt-px first:rounded-t-lg first:mt-0 last:rounded-b-lg dark:bg-neutral-800 dark:border-neutral-700 dark:text-white">
                                    <div class="relative flex items-start w-full">
                                        <div class="flex items-center h-5">
                                            <input value="{{ $permission->id }}" id="hs-list-group-item-checkbox_{{ $permission->id }}"
                                                name="permissions[]" type="checkbox"
                                                class="border-gray-200 rounded disabled:opacity-50 dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800"
                                                {{ $role->permissions->contains($permission) ? 'checked' : '' }}>
                                        </div>
                                        <label for="hs-list-group-item-checkbox_{{ $permission->id }}"
                                            class="ms-3.5 block w-full text-sm text-gray-600 dark:text-neutral-500 ml-2">
                                            {{ $permission->name }}
                                        </label>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </form>
                </div>
            </div>
            <!-- End Card -->
        </div>
        <!-- End Table Section -->
    </div>
</x-app-layout>
