<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')

</head>

<body>
    <div class="container mx-auto min-h-screen">
        <nav
            class="relative flex w-full flex-wrap items-center justify-between bg-[#FBFBFB] py-2 text-neutral-500 shadow-lg hover:text-neutral-700 focus:text-neutral-700 dark:bg-neutral-600 lg:py-4">
            <div class="flex w-full flex-wrap items-center justify-between px-3">
                <a class="ml-2 text-xl text-neutral-800 dark:text-neutral-200" href="/project">Project Monitoring</a>
                <form action="{{ url('/project') }}" method="GET">
                    <div class="ml-5 flex w-full items-center justify-between">
                        <input type="search"
                            class="relative m-0 block w-full min-w-0 flex-auto rounded border border-solid border-neutral-300 bg-transparent bg-clip-padding px-3 py-[0.25rem] text-base font-normal leading-[1.6] text-neutral-700 outline-none transition duration-200 ease-in-out focus:z-[3] focus:border-primary focus:text-neutral-700 focus:shadow-[inset_0_0_0_1px_rgb(59,113,202)] focus:outline-none motion-reduce:transition-none dark:border-neutral-500 dark:text-neutral-200 dark:placeholder:text-neutral-200 dark:focus:border-primary"
                            placeholder="Search" name="keyword" value="{{ request('keyword') }}" aria-label="Search"
                            aria-describedby="button-addon2" />
                        <!-- Search icon -->
                        <span
                            class="input-group-text flex items-center whitespace-nowrap rounded px-3 py-1.5 text-center text-base font-normal text-neutral-700 dark:text-neutral-200"
                            id="basic-addon2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                class="h-5 w-5">
                                <path fill-rule="evenodd"
                                    d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z"
                                    clip-rule="evenodd" />
                            </svg>
                        </span>
                    </div>
                    <div class="mt-1">
                        <label for="filter_progress" class="block text-neutral-700 dark:text-neutral-200">Filter
                            Progress:</label>
                        <select name="filter_progress" id="filter_progress"
                            class="px-3 py-2 w-full rounded border border-neutral-300 bg-white dark:bg-neutral-700 dark:border-neutral-600 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                            <option value="">Semua Progress</option>
                            <option value="<10"{{ request('filter_progress') === '<10' ? ' selected' : '' }}>Kurang
                                dari 10%</option>
                            <option value="<50"{{ request('filter_progress') === '<50' ? ' selected' : '' }}>Kurang
                                dari 50%</option>
                            <option value="<100"{{ request('filter_progress') === '<100' ? ' selected' : '' }}>Kurang
                                dari 100%</option>
                        </select>
                    </div>
                    <button type="submit"
                        class="ml-2 mt-4 px-4 py-2 text-white bg-red-500 hover:bg-red-600 rounded-lg transition duration-300 ease-in-out">Filter</button>
                </form>
            </div>
        </nav>
        {{-- Table --}}
        @include('pesan.index')
        <div class="flex flex-col border border-white rounded-md shadow-2xl">
            <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                    <a href="/project/create"
                        class="mr-4 ml-4 mt-4 px-4 py-2 text-white bg-red-500 hover:bg-red-600 rounded-lg transition duration-300 ease-in-out">Tambah
                        Data</a>
                    <div class="overflow-hidden">
                        <table class="min-w-full text-center text-sm font-light">
                            <thead class="font-medium">
                                <tr>
                                    <th scope="col" class="px-6 py-4">No</th>
                                    <th scope="col" class="px-6 py-4">Project Name</th>
                                    <th scope="col" class="px-6 py-4">Client</th>
                                    <th scope="col" class="px-6 py-4">Project Leader</th>
                                    <th scope="col" class="px-6 py-4">Star Date</th>
                                    <th scope="col" class="px-6 py-4">End Date</th>
                                    <th scope="col" class="px-6 py-4">Progress</th>
                                    <th scope="col" class="px-6 py-4">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                @foreach ($data as $item)
                                    <tr>
                                        <td class="whitespace-nowrap px-6 py-4 font-medium">{{ $no++ }}</td>
                                        <td class="whitespace-nowrap px-6 py-4">{{ $item->judul }}</td>
                                        <td class="whitespace-nowrap px-6 py-4">{{ $item->nama_klien }}</td>
                                        <td class="whitespace-nowrap px-6 py-4 flex items-center justify-center">
                                            <img src="{{ $item->foto ? url('foto') . '/' . $item->foto : asset('asset') . '/1.png' }}"
                                                class="rounded-full w-12 h-12 mr-2 img-fluid">
                                            <div class="flex flex-col items-start justify-start">
                                                <span>{{ $item->project_leader }}</span>
                                                @if ($item->email)
                                                    <span>{{ $item->email }}</span>
                                                @else
                                                    <span>Tidak ada Email</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4">
                                            {{ date('d M Y', strtotime($item->tanggal_mulai)) }}</td>
                                        <td class="whitespace-nowrap px-6 py-4">
                                            {{ date('d M Y', strtotime($item->tanggal_berakhir)) }}</td>
                                        <td class="whitespace-nowrap px-6 py-4 justify-center items-center">
                                            <div class="flex items-center">
                                                <div class="h-1 mr-2 w-full bg-neutral-200 dark:bg-neutral-600">
                                                    <div class="h-1 bg-blue-600" style="width: {{ $item->progress }}%">
                                                    </div>
                                                </div>
                                                <span>{{ $item->progress }}</span>
                                            </div>
                                        </td>
                                        <td
                                            class="whitespace-nowrap px-6 py-4 flex justify-center items-center space-x-2">
                                            <a href="{{ url('/project/' . $item->id . '/edit') }}"
                                                class="px-4 py-2 text-white bg-green-500 hover:bg-green-600 rounded-lg transition duration-300 ease-in-out">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-4 h-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                                </svg>
                                            </a>
                                            <form onsubmit="return confirm('Apakah Anda Yakin Ingin Hapus Data?')"
                                                action="{{ '/project/' . $item->id }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="px-4 py-2 text-white bg-red-500 hover:bg-red-600 rounded-lg transition duration-300 ease-in-out">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-4 h-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="my-4">
                        {{ $data->links('vendor.paginator.tailwind') }}
                    </div>
                </div>
            </div>
        </div>
        {{-- End Table --}}
    </div>
</body>

</html>
