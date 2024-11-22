<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Permissions
        </h2>
    </x-slot>

    <div class="w-full pt-4 px-6 sm:px-6 md:px-8 lg:ps-72 md:flex justify-between flex-column">
        <!-- Table Section -->
        <div class="md:w-2/3">
            <!-- Card -->
            <div class="flex flex-col">
                <div class="-m-1.5 overflow-x-auto">
                    <div class="p-1.5 min-w-full inline-block align-middle">
                        <div
                            class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden dark:bg-neutral-900 dark:border-neutral-700">
                            <!-- Header -->
                            <div
                                class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-b border-gray-200 dark:border-neutral-700">
                                <div>
                                    <h2 class="text-xl font-semibold text-gray-800 dark:text-neutral-200">
                                        Permissions
                                    </h2>
                                    <p class="text-sm text-gray-600 dark:text-neutral-400">
                                        Add permissions, edit and more.
                                    </p>
                                </div>

                                <div>
                                    <div class="inline-flex gap-x-2">

                                    </div>
                                </div>
                            </div>

                            <!-- End Header -->

                            <!-- Table -->
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700 mx-4">
                                <thead class="bg-gray-50 dark:bg-neutral-800">
                                    @if (count($permissions) > 0)
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-start whitespace-nowrap">
                                                <span
                                                    class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-neutral-200">
                                                    No
                                                </span>
                                            </th>

                                            <th scope="col" class="px-6 py-3 text-start whitespace-nowrap min-w-64">
                                                <span
                                                    class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-neutral-200">
                                                    Name
                                                </span>
                                            </th>

                                            <th scope="col" class="px-6 py-3 text-start whitespace-nowrap">
                                                <span
                                                    class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-neutral-200">
                                                    Roles
                                                </span>
                                            </th>

                                            <th scope="col" class="px-6 py-3 text-start whitespace-nowrap">

                                            </th>
                                        </tr>
                                    @endif
                                </thead>

                                <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
                                    @forelse ($permissions as $index => $permission)
                                        <tr>
                                            <td class="size-px whitespace-nowrap px-6 py-3">
                                                <button type="button"
                                                    class="flex items-center gap-x-2 text-gray-800 hover:text-gray-600 focus:outline-none focus:text-gray-600 dark:text-neutral-200 dark:hover:text-neutral-400 dark:focus:text-neutral-400">
                                                    <span
                                                        class="text-sm text-gray-800 dark:text-neutral-200">{{ $index + $permissions->firstItem() }}</span>
                                                </button>
                                            </td>
                                            <td class="size-px whitespace-nowrap px-6 py-3">
                                                <div class="flex items-center gap-x-3">

                                                    <span
                                                        class="font-semibold text-sm text-gray-800 dark:text-white">{{ $permission->name }}</span>
                                                </div>
                                            </td>
                                            <td class="size-px whitespace-nowrap px-6 py-3">
                                                @foreach ($permission->roles as $role)
                                                    <span
                                                        class="text-sm text-gray-800 dark:text-neutral-200">{{ $role->name }}</span>
                                                @endforeach
                                            </td>

                                            <td class="size-px whitespace-nowrap">
                                                <div class="px-6 py-1.5 flex gap-2">
                                                    <a href="{{ route('permissions.index') }}?edit={{ $permission->id }}"
                                                        class="inline-flex items-center gap-x-1 text-sm text-blue-600 decoration-2 hover:underline focus:outline-none focus:underline font-medium dark:text-blue-500">
                                                        Edit
                                                    </a>
                                                    <form onsubmit="return confirm('Are you sure?')"
                                                        action="{{ route('permissions.destroy', $permission->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="inline-flex items-center gap-x-1 text-sm text-red-600 decoration-2 hover:underline focus:outline-none focus:underline font-medium dark:text-red-500">
                                                            Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <h1 class="mt-4 text-center dark:text-gray-300 text-2xl">No Data</h1>
                                    @endforelse
                                </tbody>
                            </table>
                            <div
                                class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-t border-gray-200 dark:border-neutral-700">

                                <div>
                                    <p class="text-sm text-gray-600 dark:text-neutral-400">
                                        <span class="font-semibold text-gray-800 dark:text-neutral-200"></span>
                                    </p>
                                </div>

                                <div>
                                    <div class="inline-flex gap-x-2">
                                        {{ $permissions->links('pagination::tailwind') }}
                                    </div>
                                </div>
                            </div>
                            <!-- End Table -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Card -->
        </div>
        <!-- End Table Section -->
        <div class="md:w-1/3">
            <!-- Card Section -->
            <div class="max-w-2xl px-4  sm:px-6 lg:px-8  mx-auto">
                <!-- Card -->
                <div class="bg-white rounded-xl shadow p-4 sm:p-7 dark:bg-neutral-900">
                    <div class="text-center mb-8">
                        <h2 class="text-2xl md:text-3xl font-bold text-gray-800 dark:text-neutral-200">
                            @if ($edit)
                                Update Permission
                            @else
                                New Permission
                            @endif
                        </h2>
                        <p class="text-sm text-gray-600 dark:text-neutral-400">
                            Add & Edit Permission.
                        </p>
                    </div>
                    @if ($edit)
                        <form method="POST" action="{{ route('permissions.update', $edit->id) }}">
                        @method('PUT')
                    @else
                        <form method="POST" action="{{ route('permissions.store') }}">
                    @endif
                        @csrf
                        <!-- Section -->
                        <div
                            class="py-6 first:pt-0 last:pb-0 border-t first:border-transparent border-gray-200 dark:border-neutral-700 dark:first:border-transparent">
                            <div class="mt-2 space-y-3">
                                <input id="af-payment-billing-contact" type="text"
                                    class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                                    placeholder="Name Permission" value="@if ($edit)
                                     {{ $edit->name }}
                                    @endif" name="permission">
                                @error('permission')
                                    <span class="text-red-400">{{ $message }}</span>
                                @enderror
                                <select name="roles[]"
                                    class="select-multiple py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                                    multiple>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->name }}" {{ in_array($role->name, $permissionRoles) ? 'selected':''}}>{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mt-5 flex justify-end gap-x-2">
                                <a href="{{ route('permissions.index') }}">
                                    <button type="button"
                                        class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700">
                                        Cancel
                                    </button>
                                </a>
                                @if ($edit)
                                    <button type="submit"
                                        class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-yellow-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-yellow-700 disabled:opacity-50 disabled:pointer-events-none">
                                        Update
                                    </button>
                                @else
                                    <button type="submit"
                                        class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                                        Save
                                    </button>
                                @endif
                            </div>
                        </div>
                        <!-- End Section -->
                    </form>

                </div>
                <!-- End Card -->
            </div>
            <!-- End Card Section -->
        </div>
        @push('scriptjs')
            <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
            <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
            <script>
                $(document).ready(function() {
                    $('.select-multiple').select2();
                });
            </script>
        @endpush
    </div>
</x-app-layout>
