<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Categories
        </h2>
    </x-slot>
    <div class="w-full pt-10 px-6 sm:px-6 md:px-8 lg:ps-72">
       <!-- Table Section -->
<div class="max-w-[85rem] px-4 py-4 sm:px-6 lg:px-8 lg:py-5 mx-auto">
    <!-- Card -->
    <div class="flex flex-col">
      <div class="-m-1.5 overflow-x-auto">
        <div class="p-1.5 min-w-full inline-block align-middle">
          <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden dark:bg-neutral-900 dark:border-neutral-700">
            <!-- Header -->
            <div class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-b border-gray-200 dark:border-neutral-700">
                <div>
                  <h2 class="text-xl font-semibold text-gray-800 dark:text-neutral-200">
                    Categories
                  </h2>
                  <p class="text-sm text-gray-600 dark:text-neutral-400">
                    Add categories, edit and more.
                  </p>
                </div>

                <div>
                  <div class="inline-flex gap-x-2">

                    <a class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none"
                        href="{{route('categories.create')}}">
                      <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                      Add categories
                    </a>
                  </div>
                </div>
              </div>

            <!-- End Header -->

            <!-- Table -->
            <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
              <thead class="bg-gray-50 dark:bg-neutral-800">
                <tr>
                  <th scope="col" class="px-6 py-3 text-start whitespace-nowrap">
                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-neutral-200">
                     No
                    </span>
                  </th>

                  <th scope="col" class="px-6 py-3 text-start whitespace-nowrap min-w-64">
                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-neutral-200">
                      Name
                    </span>
                  </th>

                  <th scope="col" class="px-6 py-3 text-start whitespace-nowrap">
                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-neutral-200">
                      Slug
                    </span>
                  </th>

                  <th scope="col" class="px-6 py-3 text-start whitespace-nowrap">
                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-neutral-200">
                      Icon
                    </span>
                  </th>

                  <th scope="col" class="px-6 py-3 text-start whitespace-nowrap">

                  </th>
                </tr>
              </thead>

              <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
                @forelse ($categories as $index => $categorie)
                <tr>
                  <td class="size-px whitespace-nowrap px-6 py-3">
                    <button type="button" class="flex items-center gap-x-2 text-gray-800 hover:text-gray-600 focus:outline-none focus:text-gray-600 dark:text-neutral-200 dark:hover:text-neutral-400 dark:focus:text-neutral-400">
                      <span class="text-sm text-gray-800 dark:text-neutral-200">{{$index + $categories->firstItem() }}</span>
                    </button>
                  </td>
                  <td class="size-px whitespace-nowrap px-6 py-3">
                    <div class="flex items-center gap-x-3">

                      <span class="font-semibold text-sm text-gray-800 dark:text-white">{{ $categorie->name }}</span>
                    </div>
                  </td>
                  <td class="size-px whitespace-nowrap px-6 py-3">
                    <span class="text-sm text-gray-800 dark:text-neutral-200">{{ $categorie->slug }}</span>
                  </td>

                  <td class="size-px whitespace-nowrap px-6 py-3">
                    <img class="inline-block size-[38px] rounded-full" src="{{ asset('storage/categories/'.$categorie->icon) }}" alt="Avatar">
                  </td>

                  <td class="size-px whitespace-nowrap">
                    <div class="px-6 py-1.5 flex gap-2">
                      <a href="{{ route('categories.edit', $categorie->id) }}" class="inline-flex items-center gap-x-1 text-sm text-blue-600 decoration-2 hover:underline focus:outline-none focus:underline font-medium dark:text-blue-500">
                        Edit
                      </a>
                      <form onsubmit="return confirm('Are you sure?')" action="{{ route('categories.destroy', $categorie->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                          <button type="submit" class="inline-flex items-center gap-x-1 text-sm text-red-600 decoration-2 hover:underline focus:outline-none focus:underline font-medium dark:text-red-500">
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
        <div class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-t border-gray-200 dark:border-neutral-700">

             <div>
              <p class="text-sm text-gray-600 dark:text-neutral-400">
                <span class="font-semibold text-gray-800 dark:text-neutral-200"></span>
              </p>
            </div>

            <div>
              <div class="inline-flex gap-x-2">
                {{ $categories->links('pagination::tailwind') }}
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

