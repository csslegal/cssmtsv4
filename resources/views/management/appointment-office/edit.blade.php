@extends('sablon.yonetim')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb ">
            <li class="breadcrumb-item"><a href="/yonetim">Yönetim İşlemleri</a></li>
            <li class="breadcrumb-item"><a href="/yonetim/appointment-office">Randevu Ofisleri</a></li>
            <li class="breadcrumb-item active" aria-current="page">Düzenle</li>
        </ol>
    </nav>
    <div class="card card-primary mb-3">
        <div class="card-header bg-primary text-white">Düzenle</div>
        <div class="card-body">
            <form method="POST" action="/yonetim/appointment-office/{{ $kayit->id }}">
                @method('PUT')
                @csrf
                <div class="col-12">
                    <label class="form-label">Adı</label>
                    <input type="text" value="@isset($kayit){!! $kayit->name !!}@endisset" name="name"
                            class="form-control">
                        @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <button class="w-100 mt-3 btn btn-danger text-white btn-lg" type="submit">Tamamla</button>
                </form>
            </div>
        </div>
    @endsection
