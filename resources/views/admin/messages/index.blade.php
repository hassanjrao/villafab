@extends('layouts.backend')

@section('page-name', 'Messages')

@section('content')
<!-- Hero -->
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
            <div class="flex-grow-1">
                <h1 class="h3 fw-bold mb-1">Messages</h1>
                <h2 class="fs-base lh-base fw-medium text-muted mb-0">All contact form submissions.</h2>
            </div>
            <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-alt">
                    <li class="breadcrumb-item"><a class="link-fx" href="{{ route('admin.dashboard.index') }}">Admin</a></li>
                    <li class="breadcrumb-item" aria-current="page">Messages</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<!-- END Hero -->

<div class="content">
    <div class="block block-rounded">
        <div class="block-content">
            @if($messages->isEmpty())
                <div class="text-center py-5 text-muted">
                    <i class="fa fa-envelope fa-3x mb-3 d-block"></i>
                    <p class="mb-0">No messages yet.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover table-vcenter js-dataTable-full">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Reason</th>
                                <th>Message</th>
                                <th class="text-muted">Received</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($messages as $ind => $message)
                                <tr>
                                    <td class="text-muted fs-sm">{{ ++$ind }}</td>
                                    <td class="fw-semibold">{{ $message->fname }} {{ $message->lname }}</td>
                                    <td class="fs-sm text-muted">
                                        @if($message->email)
                                            <a href="mailto:{{ $message->email }}">{{ $message->email }}</a>
                                        @else
                                            —
                                        @endif
                                    </td>
                                    <td class="fs-sm text-muted">{{ $message->phone_number ?: '—' }}</td>
                                    <td class="fs-sm text-muted">{{ $message->reason ?: '—' }}</td>
                                    <td class="fs-sm text-muted">
                                        {{ \Illuminate\Support\Str::limit($message->message, 80) }}
                                    </td>
                                    <td class="fs-sm text-muted">{{ $message->created_at->format('M j, Y g:i A') }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.messages.show', $message) }}" class="btn btn-sm btn-alt-secondary">
                                            <i class="fa fa-eye me-1"></i> View
                                        </a>
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

