let currentPage = 1;
let entriesPerPage = 25;
let filteredData = [];
let originalData = [];

document.addEventListener('DOMContentLoaded', function () {
    // Initialize data
    originalData = Array.from(document.querySelectorAll('#dataTable tbody tr'));
    filteredData = [...originalData];
    updatePagination();

    // Set default view
    toggleView('table');

    // Atur margin awal
    adjustMainContent();
});

function refreshData() {
    const btn = event.target.closest('button');
    const originalHtml = btn.innerHTML;
    btn.innerHTML = '<div class="loading"></div> Loading...';
    btn.disabled = true;

    setTimeout(() => {
        location.reload();
    }, 1000);
}

function exportData() {
    const table = document.getElementById('dataTable');
    let csv = [];

    const headers = Array.from(table.querySelectorAll('thead th'))
        .slice(0, -1)
        .map(th => th.textContent.trim());
    csv.push(headers.join(','));

    const rows = table.querySelectorAll('tbody tr');
    rows.forEach(row => {
        const cells = Array.from(row.querySelectorAll('td')).slice(0, -1);
        const rowData = cells.map(cell => {
            let text = cell.textContent.trim();
            if (text.includes(',')) {
                text = `"${text}"`;
            }
            return text;
        });
        csv.push(rowData.join(','));
    });

    const blob = new Blob([csv.join('\n')], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `${document.title}-${new Date().toISOString().split('T')[0]}.csv`;
    a.click();
    window.URL.revokeObjectURL(url);
}

function toggleView(view) {
    const tableView = document.getElementById('tableView');
    const cardView = document.getElementById('cardView');
    const tableBtn = document.getElementById('tableViewBtn');
    const cardBtn = document.getElementById('cardViewBtn');

    if (view === 'table') {
        tableView.style.display = 'block';
        cardView.style.display = 'none';
        tableBtn.classList.add('active');
        cardBtn.classList.remove('active');
    } else {
        tableView.style.display = 'none';
        cardView.style.display = 'flex';
        cardBtn.classList.add('active');
        tableBtn.classList.remove('active');
    }
}

function updatePagination() {
    const total = filteredData.length;
    const totalPages = Math.ceil(total / entriesPerPage);
    const pagination = document.getElementById('pagination');
    pagination.innerHTML = '';

    for (let i = 1; i <= totalPages; i++) {
        const li = document.createElement('li');
        li.className = 'page-item ' + (i === currentPage ? 'active' : '');
        li.innerHTML = `<a class="page-link" href="#">${i}</a>`;
        li.addEventListener('click', function (e) {
            e.preventDefault();
            currentPage = i;
            renderTable();
        });
        pagination.appendChild(li);
    }

    renderTable();
}

function renderTable() {
    const start = (currentPage - 1) * entriesPerPage;
    const end = start + entriesPerPage;
    const rows = filteredData.slice(start, end);

    const tbody = document.querySelector('#dataTable tbody');
    tbody.innerHTML = '';
    rows.forEach(row => tbody.appendChild(row.cloneNode(true)));

    document.getElementById('showingStart').textContent = start + 1;
    document.getElementById('showingEnd').textContent = Math.min(end, filteredData.length);
    document.getElementById('totalEntries').textContent = filteredData.length;
}

function changeEntries() {
    entriesPerPage = parseInt(document.getElementById('entriesSelect').value);
    currentPage = 1;
    updatePagination();
}

function filterTable() {
    const query = document.getElementById('searchInput').value.toLowerCase();
    filteredData = originalData.filter(row =>
        row.textContent.toLowerCase().includes(query)
    );
    currentPage = 1;
    updatePagination();
}

function sortTable(colIndex) {
    const rows = [...filteredData];
    const asc = !rows[0].classList.contains('sorted-asc');

    rows.forEach(r => r.classList.remove('sorted-asc', 'sorted-desc'));

    rows.sort((a, b) => {
        const A = a.querySelectorAll('td')[colIndex].innerText.trim();
        const B = b.querySelectorAll('td')[colIndex].innerText.trim();
        return asc
            ? A.localeCompare(B, 'id', { numeric: true })
            : B.localeCompare(A, 'id', { numeric: true });
    });

    rows.forEach(r => r.classList.add(asc ? 'sorted-asc' : 'sorted-desc'));
    filteredData = rows;
    currentPage = 1;
    updatePagination();
}

function showDetailModal(title, data, id) {
    const modalTitle = document.getElementById('detailModalTitle');
    const modalBody = document.getElementById('detailModalBody');
    modalTitle.textContent = `${title} (ID: ${id})`;

    let html = '';

    if (Array.isArray(data)) {
        if (data.length > 0 && typeof data[0] === 'object') {
            html += `<p><strong>${data.length}</strong> items found</p>`;
            html += '<div class="table-responsive">';
            html += '<table class="table table-modern mb-0">';
            html += '<thead><tr>';
            Object.keys(data[0]).forEach(key => {
                html += `<th>${key.replace(/_/g, ' ').toUpperCase()}</th>`;
            });
            html += '</tr></thead><tbody>';
            data.forEach(item => {
                html += '<tr>';
                Object.values(item).forEach(val => {
                    html += `<td>${val ?? '-'}</td>`;
                });
                html += '</tr>';
            });
            html += '</tbody></table></div>';
        } else {
            html += `<p>${data.join(', ')}</p>`;
        }
    } else if (typeof data === 'object' && data !== null) {
        html += '<div class="table-responsive">';
        html += '<table class="table table-modern mb-0">';
        html += '<tbody>';
        for (const [key, val] of Object.entries(data)) {
            if (Array.isArray(val)) {
                html += `<tr><th style="width:30%">${key.replace(/_/g, ' ').toUpperCase()}</th><td>${val.length} items</td></tr>`;
            } else {
                html += `<tr><th style="width:30%">${key.replace(/_/g, ' ').toUpperCase()}</th><td>${val ?? '-'}</td></tr>`;
            }
        }
        html += '</tbody></table></div>';
    } else {
        html = `<p class="mb-0">${data}</p>`;
    }

    modalBody.innerHTML = html;
    new bootstrap.Modal(document.getElementById('detailModal')).show();
}

function copyModalContent() {
    const text = document.getElementById('detailModalBody').innerText;
    navigator.clipboard.writeText(text);
    alert('Data berhasil disalin!');
}

function copyToClipboard(data) {
    navigator.clipboard.writeText(JSON.stringify(data, null, 2));
    alert('Data berhasil disalin!');
}

function showRawData() {
    const raw = document.getElementById('rawData');
    raw.classList.toggle('show');
}

/* =============================
   Sidebar Control
============================= */
function adjustMainContent() {
    const sidebar = document.getElementById('sidebar');
    const main = document.querySelector('.main-content');

    if (window.innerWidth > 768 && sidebar && !sidebar.classList.contains('collapsed')) {
        main.style.marginLeft = sidebar.offsetWidth + "px";
    } else if (window.innerWidth > 768 && sidebar.classList.contains('collapsed')) {
        main.style.marginLeft = "80px";
    } else {
        main.style.marginLeft = "0";
    }
}

window.addEventListener('resize', adjustMainContent);
