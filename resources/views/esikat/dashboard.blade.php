@php
    use Illuminate\Support\Str;

    function formatHeader($key) {
        return Str::title(str_replace(['_', '-'], ' ', $key));
    }

    function isComplexData($data) {
        return is_array($data) && count($data) > 3;
    }

    function getDataPreview($data, $limit = 3) {
        if (is_array($data)) {
            return array_slice($data, 0, $limit);
        }
        return $data;
    }

    function formatValue($value) {
        if (is_array($value)) {
            return 'Array (' . count($value) . ' items)';
        }
        if (is_bool($value)) {
            return $value ? 'Yes' : 'No';
        }
        if (is_null($value)) {
            return '-';
        }
        if (is_numeric($value) && $value > 1000000) {
            return number_format($value);
        }
        return Str::limit($value, 50);
    }

    function getRowId($row, $index) {
        return $row['id'] ?? $row['uuid'] ?? $row['code'] ?? $index;
    }
@endphp

@extends('layouts.app')


@section('page-title', 'Module ' . ucfirst($activeModule))
@section('page-description', 'Data overview and management for ' . $activeModule . ' module')

@section('header-actions')
    <div class="d-flex gap-2">
        <button class="btn btn-outline-light btn-modern" onclick="refreshData()">
            <i class="fas fa-refresh me-2"></i>Refresh
        </button>
        <button class="btn btn-light btn-modern" onclick="exportData()">
            <i class="fas fa-download me-2"></i>Export
        </button>
    </div>
@endsection

@section('content')
    @if(
        (isset($data['status']) && $data['status'] == 1 && !empty($data['data'])) ||
        (isset($data['success']) && $data['success'] == 1 && !empty($data['data']))
    )
        @php
            $records = $data['data'];
            $totalRecords = count($records);
            $hasComplexData = false;
            
            // Check if any record has complex data
            foreach($records as $record) {
                foreach($record as $value) {
                    if (is_array($value)) {
                        $hasComplexData = true;
                        break 2;
                    }
                }
            }
        @endphp

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="stats-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="text-primary mb-1">{{ number_format($totalRecords) }}</h3>
                            <p class="text-muted mb-0">Total Records</p>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded-3">
                            <i class="fas fa-database text-primary fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="stats-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="text-success mb-1">{{ count(array_keys($records[0] ?? [])) }}</h3>
                            <p class="text-muted mb-0">Data Columns</p>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded-3">
                            <i class="fas fa-columns text-success fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="stats-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="text-warning mb-1">{{ $hasComplexData ? 'Yes' : 'No' }}</h3>
                            <p class="text-muted mb-0">Complex Data</p>
                        </div>
                        <div class="bg-warning bg-opacity-10 p-3 rounded-3">
                            <i class="fas fa-project-diagram text-warning fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="stats-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="text-info mb-1">{{ now()->format('H:i') }}</h3>
                            <p class="text-muted mb-0">Last Updated</p>
                        </div>
                        <div class="bg-info bg-opacity-10 p-3 rounded-3">
                            <i class="fas fa-clock text-info fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter and Search -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="row align-items-end">
                    <div class="col-md-4">
                        <label class="form-label">Search Records</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input type="text" class="form-control" id="searchInput" 
                                   placeholder="Type to search..." onkeyup="filterTable()">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Show Entries</label>
                        <select class="form-select" id="entriesSelect" onchange="changeEntries()">
                            <option value="10">10 entries</option>
                            <option value="25" selected>25 entries</option>
                            <option value="50">50 entries</option>
                            <option value="100">100 entries</option>
                        </select>
                    </div>
                    <div class="col-md-5 text-end">
                        <div class="btn-group" role="group">
                            <button class="btn btn-outline-primary" onclick="toggleView('table')" id="tableViewBtn">
                                <i class="fas fa-table me-2"></i>Table View
                            </button>
                            <button class="btn btn-outline-primary" onclick="toggleView('card')" id="cardViewBtn">
                                <i class="fas fa-th me-2"></i>Card View
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table View -->
        <div id="tableView" class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-modern mb-0" id="dataTable">
                        <thead>
                            <tr>
                                @foreach(array_keys($records[0]) as $col)
                                    <th class="sortable" onclick="sortTable({{ $loop->index }})">
                                        {{ formatHeader($col) }}
                                        <i class="fas fa-sort ms-2"></i>
                                    </th>
                                @endforeach
                                <th width="120">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($records as $index => $row)
                                <tr data-index="{{ $index }}">
                                    @foreach($row as $col => $val)
                                        <td>
                                            @if(is_array($val) && count($val) > 0)
                                                <div class="d-flex align-items-center">
                                                    <span class="badge bg-secondary me-2">
                                                        {{ count($val) }} items
                                                    </span>
                                                    <button class="btn btn-sm btn-outline-primary" 
                                                            onclick="showDetailModal('{{ $col }}', {{ json_encode($val) }}, '{{ getRowId($row, $index) }}')">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </div>
                                            @else
                                                <span title="{{ $val }}">{{ formatValue($val) }}</span>
                                            @endif
                                        </td>
                                    @endforeach
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-outline-primary" 
                                                    onclick="showDetailModal('Record Details', {{ json_encode($row) }}, '{{ getRowId($row, $index) }}')">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-outline-secondary" 
                                                    onclick="copyToClipboard({{ json_encode($row) }})">
                                                <i class="fas fa-copy"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Card View -->
        <div id="cardView" class="row" style="display: none;">
            @foreach($records as $index => $row)
                <div class="col-xl-4 col-lg-6 mb-4 card-item" data-index="{{ $index }}">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">
                                <i class="fas fa-file-alt me-2"></i>
                                Record #{{ getRowId($row, $index + 1) }}
                            </h6>
                        </div>
                        <div class="card-body">
                            @foreach(array_slice($row, 0, 4, true) as $col => $val)
                                <div class="row mb-2">
                                    <div class="col-5">
                                        <strong class="text-muted">{{ formatHeader($col) }}:</strong>
                                    </div>
                                    <div class="col-7">
                                        @if(is_array($val))
                                            <span class="badge bg-info">{{ count($val) }} items</span>
                                        @else
                                            {{ formatValue($val) }}
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                            
                            @if(count($row) > 4)
                                <small class="text-muted">
                                    <i class="fas fa-ellipsis-h"></i> 
                                    {{ count($row) - 4 }} more fields
                                </small>
                            @endif
                        </div>
                        <div class="card-footer bg-transparent">
                            <button class="btn btn-primary btn-sm w-100" 
                                    onclick="showDetailModal('Record Details', {{ json_encode($row) }}, '{{ getRowId($row, $index) }}')">
                                <i class="fas fa-eye me-2"></i>View Details
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-between align-items-center mt-4">
            <div>
                <span class="text-muted">
                    Showing <span id="showingStart">1</span> to <span id="showingEnd">{{ min(25, $totalRecords) }}</span> 
                    of <span id="totalEntries">{{ $totalRecords }}</span> entries
                </span>
            </div>
            <nav>
                <ul class="pagination pagination-sm" id="pagination">
                    <!-- Pagination will be generated by JavaScript -->
                </ul>
            </nav>
        </div>

    @else
        <!-- Empty State -->
        <div class="text-center py-5">
            <div class="mb-4">
                <i class="fas fa-database text-muted" style="font-size: 4rem; opacity: 0.3;"></i>
            </div>
            <h4 class="text-muted mb-3">No Data Available</h4>
            <p class="text-muted mb-4">There's no data to display for this module at the moment.</p>
            
            <div class="btn-group">
                <button class="btn btn-primary btn-modern" onclick="refreshData()">
                    <i class="fas fa-refresh me-2"></i>Try Refresh
                </button>
                <button class="btn btn-outline-secondary btn-modern" onclick="showRawData()">
                    <i class="fas fa-code me-2"></i>Show Raw Data
                </button>
            </div>
            
            <div id="rawData" class="collapse mt-4">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">Raw API Response</h6>
                    </div>
                    <div class="card-body">
                        <pre class="bg-light p-3 rounded"><code>{{ json_encode($data, JSON_PRETTY_PRINT) }}</code></pre>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Detail Modal -->
    <div class="modal fade" id="detailModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalTitle">Detail View</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="detailModalBody">
                    <!-- Content will be populated by JavaScript -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="copyModalContent()">
                        <i class="fas fa-copy me-2"></i>Copy Data
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('js/dashboard.js') }}"></script>
@endpush
