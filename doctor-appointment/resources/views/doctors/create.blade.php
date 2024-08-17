@extends('app')

@section('content')
<div class="container">
    <h1>Create Doctor</h1>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <!-- First Form -->
    <form id="mainForm" action="{{ route('doctors.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Doctor Name</label>
            <input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}">
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" name="phone" class="form-control" id="phone" value="{{ old('phone') }}">
        </div>
        <div class="mb-3">
            <label for="fee" class="form-label">Fee</label>
            <input type="number" name="fee" class="form-control" id="fee" value="{{ old('fee') }}">
        </div>
        <div class="mb-3">
            <label for="department_id" class="form-label">Department</label>
            <div class="input-group">
                <select name="department_id" id="department_id" class="form-control">
                    @foreach($departments as $department)
                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                    @endforeach
                </select>
                <button type="button" class="btn btn-outline-secondary" id="addValueButton" data-bs-toggle="modal" data-bs-target="#addValueModal">
                    <i class="bi bi-plus-circle"></i>
                </button>
            </div>
        </div>
        <button type="button" class="btn btn-secondary" id="fillFormTwo">Fill Form Two</button>
        <button type="submit" class="btn btn-primary">Create</button>
    </form>

    <!-- Second Form -->
    <h2 class="mt-5">Review Doctor Information</h2>
    <form id="formTwo" action="{{ route('doctors.review') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nameTwo" class="form-label">Doctor Name</label>
            <input type="text" name="nameTwo" class="form-control" id="nameTwo" readonly>
        </div>
        <div class="mb-3">
            <label for="phoneTwo" class="form-label">Phone</label>
            <input type="text" name="phoneTwo" class="form-control" id="phoneTwo" readonly>
        </div>
        <div class="mb-3">
            <label for="feeTwo" class="form-label">Fee</label>
            <input type="number" name="feeTwo" class="form-control" id="feeTwo" readonly>
        </div>
        <div class="mb-3">
            <label for="departmentTwo" class="form-label">Department</label>
            <input type="text" name="departmentTwo" class="form-control" id="departmentTwo" readonly>
        </div>
        <button type="submit" class="btn btn-success">Review</button>
    </form>

    <!-- Modal for Adding New Value -->
    <div class="modal fade" id="addValueModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="modalForm" method="POST" action="{{ route('departments.store') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Department</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <label for="newValue">New Department</label>
                        <input type="text" id="newValue" name="newValue" class="form-control">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#modalForm').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                data: $(this).serialize(),
                success: function(response) {
                    $('#department_id').append('<option value="' + response.id + '">' + response.name + '</option>');
                    $('#department_id').val(response.id);

                    $('#addValueModal').modal('hide');
                },
                error: function(xhr) {
                    console.log("Error occurred:", xhr.responseText);
                }
            });
        });

        $('#fillFormTwo').click(function() {
            var name = $('#name').val();
            var phone = $('#phone').val();
            var fee = $('#fee').val();
            var department = $('#department_id option:selected').text();

            $('#nameTwo').val(name);
            $('#phoneTwo').val(phone);
            $('#feeTwo').val(fee);
            $('#departmentTwo').val(department);
        });
    });
</script>
@endsection
