<div>
    @if (session('msg'))
        <div>
            <div role="alert" class="alert alert-success">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>

                <span> {{ session('msg') }}</span>
            </div>
        </div>
    @endif
    <div class="card pt-4">
        <div class="text-center block">
            <h1 class="text-3xl font-extrabold text-center my-6 dark:text-white">Link Share <br />
                <small>Sharing Links For Later</small>
            </h1>

            <button type="button" class="btn btn-primary btn-sm">
                Create new article
            </button>
        </div>
        <div>
            <div class="pt-6">
                <div id="myForm" class="flex sm:flex-2 items-center space-x-2">
                    <div class="relative">
                        <input type="text" id="clinetName" placeholder="Filter by title or url"
                            class="input input-bordered w-56 input-sm">
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <button type="button" class="btn btn-primary text-xs">Filter</button>
                    </div>
                </div>
                <div class="overflow-x-auto pt-4">
                    <table class="table pt-4">
                        <!-- head -->
                        <thead>
                            <tr class="text-center">
                                <th></th>
                                <th>Title</th>
                                <th>Url</th>
                                <th>Description</th>
                                <th>Category</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($articles as $key => $article)
                                <tr class="text-center">
                                    <th>{{ $key + 1 }}</th>
                                    <td>{{ $article->title }}</td>
                                    <td>{{ $article->url }}</td>
                                    <td>{{ $article->description }}</td>
                                    <td>{{ $article->category }}</td>
                                    <td>{{ $article->created_at }}</td>

                                    <td class="flex gap-2">
                                        <button type="button" class="btn btn-error btn-sm">
                                            Edit
                                        </button>
                                        <button type="button" class="btn btn-error btn-sm">
                                            Delete
                                        </button>
                                    </td>
                                </tr>§
                            @endforeach
                            @if ($articles === null)
                                <tr class="text-center ">
                                    <th colspan="6">No articles created yet.</th>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
