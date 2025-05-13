@extends('layouts.app')

@section('contents')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2>Report Assignment Overview</h2>
                    <p class="text-muted mb-0">View approved report assignments</p>
                </div>

                <div class="card-body">
                    @if(session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Report Name</th>
                                    <th>Type</th>
                                    <th>Serial Number</th>
                                    <th>Assigned Department</th>
                                    <th>Assigned To</th>
                                    <th>Issue Date</th>
                                    <th>Status</th>
                                    <th>Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($reports as $report)
                                @foreach($report->inventoryIssues as $issue)
                                <tr>
                                    <td>{{ $report->name }}</td>
                                    <td>{{ $report->type }}</td>
                                    <td>{{ $report->serial_number }}</td>
                                    <td>{{ $issue->department->name ?? 'N/A' }}</td>
                                    <td>{{ $issue->employee->name ?? 'N/A' }}</td>
                                    <td>{{ $issue->issue_date->format('M d, Y') }}</td>
                                    <td>
                                        <span class="badge bg-success">Approved</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('reports.view.show', $report->id) }}" class="btn btn-sm btn-info">
                                            View Details
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center">No approved report assignments found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer">
                    <div class="text-muted">
                        <small>This is a view-only page. No editing or creation of assignments is allowed here.</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection