@extends('layout.admin')

@push('js')
<style>
    .content table input[type='checkbox']{
        cursor: pointer;
    }
    .item-label{
        margin: 0;
        width: 100%;
        cursor: pointer;
    }
</style>
@endpush

@section('content')

    <div class="col-lg-8 sm-12">
        <h5 class="mt-4 mb-2">{{ ucwords($role->name) }} [ {{ Str::upper($role->guard_name) }} ]</h5>
        <form method="POST">
            @csrf
            <div class="row">
                <div class="form-group col-12 table-responsive ">
                    <table class="table table-hover">
                        <thead>
                            <tr class="table-primary">
                                <th>Model</th>
                                <th>All</th>
                                <th>R</th>
                                <th>C</th>
                                <th>U</th>
                                <th>D</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($permissions as $perm)
                                @php
                                    $cekall = (
                                        isset($role_permissions[$perm.'-R']) &&
                                        isset($role_permissions[$perm.'-C']) &&
                                        isset($role_permissions[$perm.'-U']) &&
                                        isset($role_permissions[$perm.'-D'])
                                        )
                                        ? 'checked' : '';
                                @endphp
                                <tr>
                                    <td>
                                        <label class="item-label" for="item-{{ $perm }}">{{ Str::ucfirst($perm) }}</label>
                                    </td>
                                    <td><input {{ $cekall }} id="item-{{ $perm }}"  class="i-all" type="checkbox"></td>
                                    @foreach ([ 'R','C', 'U', 'D'] as $item)
                                        @php
                                            $val = $perm . '-' . $item;
                                        @endphp
                                        <td><input class="{{ $item=='R' ? 'read' : 'cud' }} item " @if(in_array($val,$role_permissions)) checked  @endif  name="roles[{{ $val }}]" type="checkbox"></td>
                                    @endforeach

                                </tr>
                            @endforeach
                        </tbody>
                    </table>



                    {{-- <input type="text" placeholder="Name" class="form-control " wire:model.debounce.800ms="name.user-C"> --}}
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a wire:ignore href="{{ url()->previous() }}" class="btn btn-default">Kembali</a>
        </form>

    </div>
@endsection

@push('js')
<script>
$(function(){
    $('.i-all').click(function (e) { 
        let item = $(this).closest('tr').find('input.item').prop('checked', $(this).is(':checked'));        
    });

    $('.cud').click(function (e) {         
        if($(this).is(':checked')) $(this).closest('tr').find('input.read').prop('checked',true)
    });
})
</script>
@endpush
