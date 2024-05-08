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
            <h1 class="text-3xl font-extrabold text-center my-6 dark:text-white">Dashboard <br />
                <small>OAuth2 - Client credentials grant</small>
            </h1>

            <small class="text-gray w-fill pb-4 text-center block">
                This grant is suitable for machine-to-machine authentication, for example for use in
                a cron job which is performing maintenance tasks over an API. <strong> Another
                    example would be a client making requests to an API that don’t require user’s
                    permission.</strong>
                <br /><a class="underline" href="https://laravel.com/docs/11.x/passport#retrieving-tokens"
                    target="_blank">How
                    to get access toket?</a>

            </small>
        </div>
        <div>
            <div class="pt-6">
                <div class="pb-4">
                    <div id="myForm" class="flex sm:flex-2 items-center space-x-2">
                        <div class="relative">
                            <input type="text" id="clinetName" wire:model="createClient" placeholder="Client name..."
                                class="input input-bordered w-56">
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            <button type="button" class="btn btn-primary text-xs"
                                wire:click="createClientAction">Submit</button>
                            <button type="button" class="btn btn-secondary text-xs"
                                wire:click="archiveRevokedAction({{ $archiveRevoked }})">
                                @if (!$archiveRevoked)
                                    Unarchive revoked
                                @else
                                    Archive revoked
                                @endif
                            </button>
                        </div>
                    </div>
                    @error('createClient')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="overflow-x-auto pt-4">
                    <table class="table pt-4">
                        <!-- head -->
                        <thead>
                            <tr class="text-center">
                                <th></th>
                                <th>Name</th>
                                <th>Id</th>
                                <th>Secret</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($userClients as $key => $client)
                                <tr class="text-center">
                                    <th>{{ $key + 1 }}</th>
                                    <td>{{ $client->name }}</td>
                                    <td>{{ $client->id }}</td>
                                    <td>{{ $client->secret }}</td>
                                    <td>{!! htmlspecialchars_decode(date('j<\s\up>S</\s\up> F Y', strtotime($client->created_at))) !!}</td>
                                    <td>
                                        <button type="button" class="btn btn-error btn-sm"
                                            wire:click="revokeClient({{ $client }})"
                                            @if ($client->revoked) disabled @endif>
                                            @if ($client->revoked)
                                                Revoked
                                            @else
                                                Revoke
                                            @endif
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            @if ($userClients === null)
                                <tr class="text-center ">
                                    <th colspan="6">No clients created yet.</th>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
