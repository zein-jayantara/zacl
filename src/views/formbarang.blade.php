@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    <h2>Barang</h2>
                    <p>ini data barang</p>
                    <form action="barang" method="post">
                         {{ csrf_field() }}
                        <div class="form-group">
                            <label for="name">Nama Barang:</label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                        <div class="form-group">
                            <label for="name">Kategori</label>
                            <select name="kategori_id">
                                <option value="1">Kayu</option>
                                <option value="2">Besi</option>
                                <option value="3">Lainnya</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-default">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection