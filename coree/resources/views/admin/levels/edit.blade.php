@extends('admin.layouts.master')
@section('title', 'Edit Level')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-cards">
                <div class="card px-0">
                    <div class="col-12">
                        <form method="POST" action="{{ route('admin.levels.update', $level->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="card-header bg-dark-lt h3 text-dark bold pt-2 pb-2">
                                Edit Level {{ $level->level }}
                            </div>
                            <div class="card-body">

                                <div class="row">
                                    <div class="col col-md-4 col-sm-6 col-12 mb-3">
                                        <label class="form-label">Level Number:</label>
                                        <input type="number" class="form-control" name="level_number"
                                            placeholder="Enter level number"
                                            value="{{ old('level_number', $level->level) }}" required />
                                        @error('level_number')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="col col-md-4 col-sm-6 col-12 mb-3">
                                        <label class="form-label">Required Earning</label>
                                        <input type="number" class="form-control" name="required_earning"
                                            placeholder="Enter required balance"
                                            value="{{ old('required_earning', $level->required_earning) }}" required />
                                        @error('required_earning')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col col-md-4 col-sm-6 col-12 mb-3">
                                        <label class="form-label">Reward</label>
                                        <input type="number" class="form-control" name="reward" step="0.01"
                                            placeholder="Enter coin amount" value="{{ old('reward', $level->reward) }}"
                                            required />
                                        @error('reward')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary">Update Level</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
