@extends('admin.master')
@section('style_css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css">
@endsection
@section('content')
<div class="container py-4">
        <div class="card">
            @if (session('success'))

            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>

            @endif
           <div class="card-body">
            <div class="col-md-12 py-4">
    <table class="table table-hover my-0" id="usertable">
        <thead>
          <tr>
            <th scope="col">SL.</th>
            <th scope="col">Name</th>
            <th scope="col">Role</th>
            <th scope="col">email</th>
            <th scope="col">Status</th>
            <th scope="col">Edit</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        @php
        $users = App\User::orderBy('id', 'DESC')->get();
        @endphp
        <tbody>

    @foreach ($users as $item)
    <tr>
        <td> {{$item->id}} </td>
        <td> {{$item->name}} </td>
        <td> {{implode(',', $item->roles()->get()->pluck('urole')->toArray()) }} </td>
        <td> {{$item->email}}</td>
        <td>
            @if ($item->status=='1')
            <a href="#" class="btn btn-outline-success"> Active </a>
            @else
            <a href="#" class="btn btn-outline-danger"> Inactive </a>
            @endif
        </td>
        <td>
            @can('edit-users')
            <a href="{{route('admin.users.edit', $item->id)}}">
                <i class="fas fa-user-edit"></i>
            </a>
            @endcan
        </td>
        <td>
            <form action="{{ route('admin.users.destroy', $item->id) }}" method="post">
                @method('DELETE')
                @csrf
                <button onclick="return myFunction();" class="btn btn-outline-danger" type="submit"> <i class="fas fa-trash-alt"></i> </button>
            </form>
        </td>
    </tr>
    @endforeach
        </tbody>
      </table>
    {{ $item->links }}
</div>
</div>
</div>
</div>

@endsection
@section('footer_js')

<script>
    function myFunction() {
        if(!confirm("Are You Sure to delete this"))
        event.preventDefault();
    }
</script>

<script>
    function myFunction() {
        if(!confirm("Are You Sure to delete this"))
        event.preventDefault();
    }
</script>
<script>
    $(document).ready( function () {
    $('#usertable').DataTable();
});
</script>

<script>
    // display a modal (small modal)
    $(document).on('click', '#smallButton', function(event) {
        event.preventDefault();
        let href = $(this).attr('data-attr');
        $.ajax({
            url: href
            , beforeSend: function() {
                $('#loader').show();
            },
            // return the result
            success: function(result) {
                $('#smallModal').modal("show");
                $('#smallBody').html(result).show();
            }
            , complete: function() {
                $('#loader').hide();
            }
            , error: function(jqXHR, testStatus, error) {
                console.log(error);
                alert("Page " + href + " cannot open. Error:" + error);
                $('#loader').hide();
            }
            , timeout: 8000
        })
    });

</script>
@endsection
