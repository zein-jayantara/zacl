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
                    <a href="barangnew" class="btn btn-info" role="button">Data Baru</a>
                    <table class="table table-condensed">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Kategori</th>
                                <th>Barang</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $v)
                            <tr>
                                <td>
                                    {{ $v->id }}
                                </td>
                                <td>
                                    {{ $v->kategori_id }}
                                </td>
                                <td>
                                    {{ $v->name }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection