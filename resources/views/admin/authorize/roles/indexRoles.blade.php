<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Roles
        </h2>
    </x-slot>
    <div class="w-full pt-10 px-6 sm:px-6 md:px-8 lg:ps-72">
        <!-- Table Section -->
        <div class="max-w-[85rem] px-4 py-4 sm:px-6 lg:px-8 lg:py-5 mx-auto">
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
                                        Roles
                                    </h2>
                                    <p class="text-sm text-gray-600 dark:text-neutral-400">
                                        Add roles, edit and more.
                                    </p>
                                </div>

                                <div>
                                    <div class="inline-flex gap-x-2">
                                        <div class="inline-flex gap-x-2">
                                            <form action="{{ route('roles.store') }}" method="POST"
                                                class="inline-flex w-full">
                                                @csrf
                                                <div class="max-w-lg space-y-3">
                                                    <input value="" type="text" name="roles"
                                                        class="py-3 px-5 block w-full border-gray-200 text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                                                        placeholder="Name Roles" required>
                                                </div>
                                                <button type="submit"
                                                    class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none"
                                                   >
                                                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg"
                                                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path d="M5 12h14" />
                                                        <path d="M12 5v14" />
                                                    </svg>
                                                    Add Roles
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- End Header -->

                            <!-- Table -->
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700 mx-4">
                                <thead class="bg-gray-50 dark:bg-neutral-800">
                                    @if (count($roles) > 0)
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
                                                    Total Permission
                                                </span>
                                            </th>

                                            <th scope="col" class="px-6 py-3 text-start whitespace-nowrap">
                                                <span
                                                class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-neutral-200">
                                                Actions
                                            </span>
                                            </th>
                                        </tr>
                                    @endif
                                </thead>

                                <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
                                    @forelse ($roles as $index => $role)
                                        <tr>
                                            <td class="size-px whitespace-nowrap px-6 py-3">
                                                <button type="button"
                                                    class="flex items-center gap-x-2 text-gray-800 hover:text-gray-600 focus:outline-none focus:text-gray-600 dark:text-neutral-200 dark:hover:text-neutral-400 dark:focus:text-neutral-400">
                                                    <span
                                                        class="text-sm text-gray-800 dark:text-neutral-200">{{ $index + $roles->firstItem() }}</span>
                                                </button>
                                            </td>
                                            <td class="size-px whitespace-nowrap px-6 py-3">
                                                <div class="flex items-center gap-x-3">

                                                    <span
                                                        class="font-semibold text-sm text-gray-800 dark:text-white">{{ $role->name }}</span>
                                                </div>
                                            </td>
                                            <td class="size-px whitespace-nowrap px-6 py-3">
                                                <span
                                                    class="text-sm text-gray-800 dark:text-neutral-200">
                                                        {{ $role->permissions->count() }} =>
                                                       @foreach ($role->permissions as $permission)
                                                            {{ $permission->name }},
                                                        @endforeach
                                                </span>
                                            </td>

                                            <td class="size-px whitespace-nowrap">
                                                <div class="px-6 py-1.5 flex gap-2">
                                                    <a href="{{ route('roles.edit', $role->id) }}"
                                                        class="inline-flex items-center gap-x-1 text-sm text-blue-600 decoration-2 hover:underline focus:outline-none focus:underline font-medium dark:text-blue-500">
                                                        Edit
                                                    </a>
                                                    <form onsubmit="return confirm('Are you sure?')"
                                                        action="{{ route('roles.destroy', $role->id) }}" method="POST">
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
                                        {{ $roles->links('pagination::tailwind') }}
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
    </div>
</x-app-layout>
