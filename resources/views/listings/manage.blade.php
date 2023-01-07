<x-layout>
    <x-card class="p-10">
            <header>
                <h1
                    class="text-3xl text-center font-bold my-6 uppercase"
                >
                    Manage Gigs
                </h1>
            </header>

            <table class="w-full table-auto rounded-sm">
                <tbody>
                    @unless ($listings->isEmpty())
                    @foreach ($listings as $listing)
                    <tr class="border-gray-300">
                        <td
                            class="px-4 py-8 border-t border-b border-gray-300 text-lg"
                        >
                            <a href="{{ route('listing.show', $listing->id) }}">
                                {{ $listing->company }}
                            </a>
                        </td>
                        <td
                            class="px-4 py-8 border-t border-b border-gray-300 text-lg"
                        >
                            <a
                                href="{{ route('listing.edit', $listing->id) }}"
                                class="text-blue-400 px-6 py-2 rounded-xl"
                                ><i
                                    class="fa-solid fa-pen-to-square"
                                ></i>
                                Edit</a
                            >
                        </td>
                        <td
                            class="px-4 py-8 border-t border-b border-gray-300 text-lg"
                        >

                            <form method="POST" action='{{ route('listing.delete', $listing->id) }}'>
                                @csrf
                                @method('DELETE')
                                    <button type="submit" name="deleteUser" class="text-red-600"><i class="fa-solid fa-trash-can"></i>Delete</button>
                            </form>

                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr class="border-gray-300">
                        <td class="px-4 py-8 border-t border-b border-gray-300">
                            <p class="text-center">No Listings Founded</p>
                        </td>
                    </tr>
                    @endunless

                </tbody>
            </table>
    </x-card>
</x-layout>
