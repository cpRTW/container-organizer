<!DOCTYPE html>
<html>
<head>
    <title>Warehouse Organizer</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div style="display:flex; justify-content: space-between; align-items:center;background: #7b0707;">
    <h2 style="padding: 10px;color: #fff;">Warehouse Container Organizer</h2>

    <form method="POST" action="{{ route('logout') }}" style="padding: 10px;">
        @csrf
        <button type="submit" style="padding:8px 12px; background:#0d6efd; color:white; border:none;border-radius: 5px;">
            Logout
        </button>
    </form>
</div>

<div class="container mt-5">

    <div class="card shadow">

        <div class="card-body">

            <!-- Size Input -->
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Number of Containers</label>
                    <input type="number" id="size" class="form-control" value="3">
                </div>

                <div class="col-md-4 align-self-end">
                    <button id="generateBtn" class="btn btn-success">Generate Grid</button>
                </div>
            </div>

            <!-- Matrix Table -->
            <form id="matrixForm">
                <div class="table-responsive">
                    <table class="table table-bordered text-center" id="matrixTable"></table>
                </div>

                <button class="btn btn-primary mt-3">Check Organization</button>
            </form>

            <!-- Result -->
            <div id="result" class="mt-4"></div>

        </div>
    </div>

</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>

    $(document).ready(function() {

        $('#generateBtn').click(function() {
            generateGrid();
        });

        $('#matrixForm').submit(function(e) {
            submitMatrix(e);
        });

    });

    function generateGrid() {
        let n = $('#size').val();
        let table = $('#matrixTable');
        table.html("");

        // Header
        let header = "<tr><th>Container \\ Product</th>";
        for (let j = 0; j < n; j++) {
            header += `<th>Product ${j+1}</th>`;
        }
        header += "</tr>";

        table.append(header);

        // Rows
        for (let i = 0; i < n; i++) {
            let row = `<tr><th>Container ${i+1}</th>`;

            for (let j = 0; j < n; j++) {
                row += `<td>
                            <input type="number" min="0" value="0" 
                            class="form-control text-center">
                        </td>`;
            }

            row += "</tr>";
            table.append(row);
        }
    }


    function submitMatrix(e) {
        e.preventDefault();

        let matrix = [];

        $('#matrixTable tr').each(function(i) {

            if (i === 0) return; // skip header

            let row = [];

            $(this).find('td').each(function() {
                let val = $(this).find('input').val();
                row.push(parseInt(val) || 0);
            });

            matrix.push(row);
        });

        if (!matrix || !Array.isArray(matrix) || matrix.length === 0) {
            alert('The matrix field is required.');
            return false;
        }

        console.log(matrix);
        console.log($('meta[name="csrf-token"]').attr('content'));

        $.ajax({
            url: '/organization/check',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({ matrix: matrix }),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            xhrFields: {
                withCredentials: true
            },
            success: function(data) {
                let row = data.rowSums ? data.rowSums.join(', ') : '';
                let col = data.colSums ? data.colSums.join(', ') : '';

                let html = `
                    <div class="alert ${data.possible ? 'alert-success' : 'alert-danger'}">
                        <h5>${data.possible ? '✅ Success' : '❌ Failed'}</h5>
                        <p>${data.message}</p>
                        
                        <hr>

                        <strong>Container Capacities (Row Sums):</strong><br>
                        ${row}
                        <br><br>

                        <strong>Ball Type Totals (Column Sums):</strong><br>
                        ${col}
                    </div>
                `;

                $('#result').html(html);
            },
            error: function(data) {
                console.log(data);
                $('#result').html(
                    `<div class="alert alert-warning">⚠️ Something went wrong</div>`
                );
            }
        });
    }

</script>

</body>
</html>