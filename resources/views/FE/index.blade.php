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
                                        <td class="whitespace-nowrap px-6 py-4  justify-center items-center">
                                            <a href="{{ url('/project/' . $item->id . '/edit') }}"
                                                class="px-4 py-2 text-white bg-yellow-500 hover:bg-yellow-600 rounded-lg transition duration-300 ease-in-out">
                                                Edit
                                            </a>
                                            <form onsubmit="return confirm('Apakah Anda Yakin Ingin Hapus Data?')"
                                                action="{{ '/project/' . $item->id }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="ml-2 px-4 py-2 text-white bg-red-500 hover:bg-red-600 rounded-lg transition duration-300 ease-in-out">Delete</button>
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
