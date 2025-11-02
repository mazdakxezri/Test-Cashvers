@extends('admin.layouts.master')

@section('title', 'Levels')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-cards">
                <div class="col-12">
                    <x-admin.alert />
                </div>
                <div class="col-12 col-md-8 mb-3">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="card-title">All Levels</h3>
                        </div>

                        <div class="card-body border-bottom py-3">
                            <div class="d-flex">
                                <div class="text-secondary">
                                    Show
                                    <form method="GET" class="d-inline-block">
                                        <input type="number" name="perPage" class="form-control form-control-sm"
                                            value="{{ request('perPage', $levels->perPage()) }}"
                                            onchange="this.form.submit()">
                                    </form>
                                    entries
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table card-table table-vcenter text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Level Number</th>
                                        <th>Required Earning</th>
                                        <th>Reward</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($levels as $level)
                                        <tr>
                                            <td>{{ $level->level }}</td>
                                            <td>{{ $level->required_earning . ' ' . siteSymbol() }}</td>
                                            <td>{{ $level->reward . ' ' . siteSymbol() }}</td>

                                            <td>
                                                <div class="btn-list flex-nowrap">
                                                    <a href="{{ route('admin.levels.edit', $level->id) }}" class="btn">
                                                        Edit
                                                    </a>

                                                    <a href="javascript:void(0)" class="btn btn-danger" data-bs-toggle="modal"
                                                        data-bs-target="#delete-modal" data-level-id="{{ $level->id }}">
                                                        Delete
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @include('components.admin.pagination', ['paginator' => $levels])
                    </div>
                </div>
                <div class="col-12 col-md-4 card px-0 mb-3">
                    <form method="POST" action="{{ route('admin.levels.store') }}">
                        @csrf
                        <div class="card-body">

                            <div class="row">
                                <div class="col-6 mb-3">
                                    <label class="form-label">Level Number</label>
                                    <input type="number" class="form-control" name="level_number"
                                        placeholder="Enter level number" value="{{ old('level_number') }}" required />
                                    @error('level_number')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-6 mb-3">
                                    <label class="form-label">Required Earning</label>
                                    <input type="number" class="form-control" name="required_earning"
                                        placeholder="Enter required balance" value="{{ old('required_earning') }}"
                                        required />
                                    @error('required_earning')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-6 mb-3">
                                    <label class="form-label">Reward</label>
                                    <input type="number" class="form-control" name="reward" step="0.01"
                                        placeholder="Enter coin amount" value="{{ old('reward') }}" required />
                                    @error('reward')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Add New Level</button>

                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal modal-blur fade" id="delete-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-status bg-danger"></div>
                <div class="modal-body text-center py-4">
                    <form method="POST" id="deleteOfferForm">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="level-id" value="" id="level-id">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24"
                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path
                                d="M10.24 3.957l-8.422 14.06a1.989 1.989 0 0 0 1.7 2.983l.014.003h14.338a1.99 1.99 0 0 0 1.7-2.982l-8.436-14.06a1.989 1.989 0 0 0-3.466 0z" />
                            <line x1="12" y1="9" x2="12" y2="13" />
                            <line x1="12" y1="17" x2="12.01" y2="17" />
                        </svg>
                        <h3>Are you sure?</h3>
                        <div class="text-muted">Do you really want to delete this offer? This process cannot be undone.
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" form="deleteOfferForm" class="btn btn-danger">Yes, Delete</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const baseUrl = "{{ route('admin.levels.destroy', ['level' => 'LEVEL_ID_PLACEHOLDER']) }}";

        document.getElementById('delete-modal').addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const levelId = button.getAttribute('data-level-id');
            const form = document.getElementById('deleteOfferForm');

            // Replace placeholder with actual level ID
            form.action = baseUrl.replace('LEVEL_ID_PLACEHOLDER', levelId);

            // Update hidden input if you need it
            document.getElementById('level-id').value = levelId;
        });
    </script>

@endsection
