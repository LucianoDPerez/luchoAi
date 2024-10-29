$(document).ready(function() {
    $('#table-index').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "{{ path('client_datatable') }}",
        "columns": [
            { "data": "name" },
            { "data": "address" },
            { "data": "phone" },
            { "data": "actions" }
        ],
        "language": {
            "url": "{{ asset('assets/js/datatables-es.json') }}"
        }
    });
});