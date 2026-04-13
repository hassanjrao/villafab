@extends('layouts.backend')

@section('page-name', 'Calendar Feeds')

@section('content')

    {{-- Hero --}}
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-2">Calendar Feeds</h1>
                    <h2 class="fs-base lh-base fw-medium text-muted mb-0">
                        Manage ICS calendar URLs synced for availability.
                    </h2>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item"><a class="link-fx" href="{{ route('admin.dashboard.index') }}">Admin</a></li>
                        <li class="breadcrumb-item" aria-current="page">Calendar Feeds</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    {{-- END Hero --}}

    <div class="content">

        {{-- Success alert --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fa fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Validation errors --}}
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- ══════════════════════════════════════════════
             Add New Feed
        ══════════════════════════════════════════════ --}}
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">
                    <i class="fa fa-plus-circle me-2 text-primary"></i> Add New Feed
                </h3>
            </div>
            <div class="block-content pb-3">
                <form action="{{ route('admin.calendar-feeds.store') }}" method="POST">
                    @csrf
                    <div class="row g-3 align-items-end">
                        <div class="col-sm-3">
                            <label class="form-label fw-semibold" for="add-name">Platform Name</label>
                            <input type="text"
                                   class="form-control"
                                   id="add-name"
                                   name="name"
                                   placeholder="e.g. Airbnb, VRBO, Booking.com"
                                   value="{{ old('name') }}"
                                   required>
                        </div>
                        <div class="col-sm-7">
                            <label class="form-label fw-semibold" for="add-url">ICS Calendar URL</label>
                            <input type="url"
                                   class="form-control"
                                   id="add-url"
                                   name="ics_url"
                                   placeholder="https://calendar.google.com/calendar/ical/..."
                                   value="{{ old('ics_url') }}"
                                   required>
                        </div>
                        <div class="col-sm-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fa fa-plus me-1"></i> Add Feed
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- ══════════════════════════════════════════════
             Existing Feeds
        ══════════════════════════════════════════════ --}}
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">
                    <i class="fa fa-rss me-2 text-primary"></i> Active Feeds
                </h3>
            </div>
            <div class="block-content">
                @if($feeds->isEmpty())
                    <div class="text-center text-muted py-5">
                        <i class="fa fa-calendar-times fa-3x mb-3 d-block"></i>
                        No calendar feeds configured yet. Add one above to get started.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-striped table-vcenter">
                            <thead>
                                <tr>
                                    <th style="width:180px;">Platform</th>
                                    <th>ICS URL</th>
                                    <th class="text-center" style="width:90px;">Active</th>
                                    <th class="text-center" style="width:140px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($feeds as $feed)
                                    <tr id="row-{{ $feed->id }}">
                                        {{-- Display mode --}}
                                        <td class="feed-display" data-id="{{ $feed->id }}">
                                            <strong>{{ $feed->name }}</strong>
                                        </td>
                                        <td class="feed-display" data-id="{{ $feed->id }}">
                                            <span class="text-muted small text-break" style="word-break:break-all;">{{ $feed->ics_url }}</span>
                                        </td>
                                        <td class="feed-display text-center" data-id="{{ $feed->id }}">
                                            @if($feed->is_active)
                                                <span class="badge bg-success">Yes</span>
                                            @else
                                                <span class="badge bg-secondary">No</span>
                                            @endif
                                        </td>
                                        <td class="feed-display text-center" data-id="{{ $feed->id }}">
                                            <button type="button"
                                                    class="btn btn-sm btn-alt-primary me-1"
                                                    onclick="startEdit({{ $feed->id }})">
                                                <i class="fa fa-pencil-alt"></i>
                                            </button>
                                            <form action="{{ route('admin.calendar-feeds.destroy', $feed) }}"
                                                  method="POST"
                                                  id="form-{{ $feed->id }}"
                                                  class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                        class="btn btn-sm btn-alt-danger"
                                                        onclick="confirmDelete({{ $feed->id }})">
                                                    <i class="fa fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </td>

                                        {{-- Edit mode (hidden by default) --}}
                                        <td class="feed-edit d-none" data-id="{{ $feed->id }}" colspan="4">
                                            <form action="{{ route('admin.calendar-feeds.update', $feed) }}"
                                                  method="POST"
                                                  class="d-flex align-items-center gap-2 flex-wrap">
                                                @csrf
                                                @method('PUT')
                                                <input type="text"
                                                       name="name"
                                                       class="form-control form-control-sm"
                                                       value="{{ $feed->name }}"
                                                       style="max-width:160px;"
                                                       required>
                                                <input type="url"
                                                       name="ics_url"
                                                       class="form-control form-control-sm flex-grow-1"
                                                       value="{{ $feed->ics_url }}"
                                                       required>
                                                <div class="form-check form-switch ms-2">
                                                    <input type="hidden" name="is_active" value="0">
                                                    <input class="form-check-input"
                                                           type="checkbox"
                                                           name="is_active"
                                                           value="1"
                                                           {{ $feed->is_active ? 'checked' : '' }}>
                                                    <label class="form-check-label small">Active</label>
                                                </div>
                                                <button type="submit" class="btn btn-sm btn-success">
                                                    <i class="fa fa-check"></i>
                                                </button>
                                                <button type="button"
                                                        class="btn btn-sm btn-alt-secondary"
                                                        onclick="cancelEdit({{ $feed->id }})">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

    </div>

@endsection

@section('js_after')
<script>
    function startEdit(id) {
        document.querySelectorAll('.feed-display[data-id="' + id + '"]').forEach(function(el) {
            el.classList.add('d-none');
        });
        document.querySelectorAll('.feed-edit[data-id="' + id + '"]').forEach(function(el) {
            el.classList.remove('d-none');
        });
    }

    function cancelEdit(id) {
        document.querySelectorAll('.feed-edit[data-id="' + id + '"]').forEach(function(el) {
            el.classList.add('d-none');
        });
        document.querySelectorAll('.feed-display[data-id="' + id + '"]').forEach(function(el) {
            el.classList.remove('d-none');
        });
    }
</script>
@endsection
