@extends('layouts.backend')

@section('page-name', 'Message #' . $message->id)

@section('content')
<!-- Hero -->
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
            <div class="flex-grow-1">
                <h1 class="h3 fw-bold mb-1">Message #{{ $message->id }}</h1>
                <h2 class="fs-base lh-base fw-medium text-muted mb-0">Contact submission details</h2>
            </div>
            <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-alt">
                    <li class="breadcrumb-item"><a class="link-fx" href="{{ route('admin.dashboard.index') }}">Admin</a></li>
                    <li class="breadcrumb-item"><a class="link-fx" href="{{ route('admin.messages.index') }}">Messages</a></li>
                    <li class="breadcrumb-item" aria-current="page">#{{ $message->id }}</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<!-- END Hero -->

<div class="content">
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="block block-rounded h-100">
                <div class="block-header block-header-default">
                    <h3 class="block-title">
                        <i class="fa fa-user me-2 text-primary"></i>Guest Details
                    </h3>
                </div>
                <div class="block-content">
                    <table class="table table-borderless mb-0">
                        <tbody>
                            <tr>
                                <th class="text-muted fw-normal" style="width:140px;">Name</th>
                                <td class="fw-semibold">{{ $message->fname }} {{ $message->lname }}</td>
                            </tr>
                            <tr>
                                <th class="text-muted fw-normal">Email</th>
                                <td>
                                    @if($message->email)
                                        <a href="mailto:{{ $message->email }}">{{ $message->email }}</a>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th class="text-muted fw-normal">Phone</th>
                                <td>{{ $message->phone_number ?: '—' }}</td>
                            </tr>
                            <tr>
                                <th class="text-muted fw-normal">Reason</th>
                                <td>{{ $message->reason ?: '—' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="block block-rounded h-100">
                <div class="block-header block-header-default">
                    <h3 class="block-title">
                        <i class="fa fa-info-circle me-2 text-primary"></i>Meta
                    </h3>
                </div>
                <div class="block-content">
                    <table class="table table-borderless mb-0">
                        <tbody>
                            <tr>
                                <th class="text-muted fw-normal" style="width:160px;">Received</th>
                                <td class="fs-sm text-muted">{{ $message->created_at->format('M j, Y g:i A') }}</td>
                            </tr>
                            <tr>
                                <th class="text-muted fw-normal">IP Address</th>
                                <td class="fs-sm text-muted" style="word-break: break-all;">{{ $message->ip_address ?: '—' }}</td>
                            </tr>
                            <tr>
                                <th class="text-muted fw-normal">User Agent</th>
                                <td class="fs-sm text-muted" style="word-break: break-all;">{{ $message->user_agent ?: '—' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-12 mb-4">
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title">
                        <i class="fa fa-envelope me-2 text-primary"></i>Message
                    </h3>
                </div>
                <div class="block-content">
                    <div class="p-3" style="background:#f8f9fb;border-radius:10px; border:1px solid #eef1f4;">
                        <p class="mb-0" style="white-space: pre-wrap;">{{ $message->message }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <a href="{{ route('admin.messages.index') }}" class="btn btn-alt-secondary">
        <i class="fa fa-arrow-left me-1"></i> Back to Messages
    </a>
</div>
@endsection

