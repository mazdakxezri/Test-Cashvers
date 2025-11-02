<div class="col-12 col-xl-6">
    <div class="card">
        <div class="card-header pt-2 pb-0">
            <span class="h4 nav-link active fw-bold">{{ $title }}</span>
        </div>
        <div class="card-body row mt-2 pb-5 sortable-container">
            @foreach ($networks as $network)
                <div class="col-12 col-lg-6 mb-3 networks">
                    <div class="card bg-dark-lt" order-id="{{ $network->network_order }}">
                        <div class="card-header py-2">
                            <img src="{{ url($network->network_image) }}" class="rounded object-fit-cover me-2"
                                width="40" height="40" alt="{{ $network->network_name }}" />
                            <h3 class="card-title text-dark">{{ $network->network_name }}</h3>
                            <div class="card-actions">
                                <a href="{{ route('admin.network.update', ['id' => $network->id]) }}">
                                    Edit
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                        <path
                                            d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                        <path d="M16 5l3 3" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                        <div class="card-body py-3">
                            <dl class="row">
                                <dt class="col-5 text-truncate text-dark h4 my-0">
                                    Status:
                                </dt>
                                <dd class="col-7 text-truncate text-muted h5">
                                    <span class="{{ $network->network_status == 1 ? 'text-green' : 'text-red' }}">
                                        {{ $network->network_status == 1 ? 'Enable' : 'Disable' }}
                                    </span>
                                </dd>
                                <dt class="col-5 text-truncate text-dark h4 my-0">
                                    Postback URL:
                                </dt>
                                <dd class="col-7 text-muted h5 d-flex cevent">
                                    <div class="text-truncate cpy mr-1" data-url="{{ $network->postbackUrl }}">
                                        {{ $network->postbackUrl }}
                                    </div>
                                    <span class="copy-event cursor-pointer" onclick="copyToClipboard(this)">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-copy">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M7 7m0 2.667a2.667 2.667 0 0 1 2.667 -2.667h8.666a2.667 2.667 0 0 1 2.667 2.667v8.666a2.667 2.667 0 0 1 -2.667 2.667h-8.666a2.667 2.667 0 0 1 -2.667 -2.667z" />
                                            <path
                                                d="M4.012 16.737a2.005 2.005 0 0 1 -1.012 -1.737v-10c0 -1.1 .9 -2 2 -2h10c.75 0 1.158 .385 1.5 1" />
                                        </svg>
                                    </span>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="col-xl-6 col-12 mb-3">
                <a href="{{ route('admin.network.add') }}"
                    class="card bg-dark-lt pt-2 justify-content-center text-center h-100">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-plus"
                            style="width: 64px; height: 64px" ;>
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 5l0 14" />
                            <path d="M5 12l14 0" />
                        </svg>
                    </span>
                    <p class="h3">Add a Network</p>
                </a>
            </div>
        </div>
    </div>
</div>
