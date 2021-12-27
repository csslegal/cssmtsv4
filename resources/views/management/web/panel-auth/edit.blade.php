@extends('sablon.yonetim')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb ">
            <li class="breadcrumb-item"><a href="/yonetim">Yönetim İşlemleri</a></li>
            <li class="breadcrumb-item"><a href="/yonetim/web">Web İşlemleri</a></li>
            <li class="breadcrumb-item"><a href="/yonetim/web/panel-auth">Panel Yetkileri</a></li>
            <li class="breadcrumb-item active" aria-current="page">Düzenle</li>
        </ol>
    </nav>
    <div class="card card-primary mb-3">
        <div class="card-header bg-primary text-white">Düzenle</div>
        <div class="card-body">
            <form method="POST" action="/yonetim/web/panel-auth/{{ $result->id }}">
                @method('PUT')
                @csrf
                <div class="mb-3">
                    <label class="">Kullanıcı Adı - Tipi </label>
                    <select name="kullanici" id="" class="form-control">
                        <option value="">Seçim yapınız</option>
                        @foreach ($users as $user)
                            <option {{ $result->user_id == $user->id ? 'selected' : '' }} value="{{ $user->id }}">
                                {{ $user->name }} - {{ $user->ut_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('kullanici')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="">Erişim Tipi</label>
                    <select name="erisim" id="" class="form-control">
                        <option {{ $result->access == 0 ? 'selected' : '' }} value="0">Temel Erişim</option>
                        <option {{ $result->access == 1 ? 'selected' : '' }} value="1">Full Erişim</option>
                    </select>
                    @error('erisim')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label>Başlangıç Tarihi</label>
                    <input type="text" class="form-control datepicker1" value="{{ $result->start_time }}"
                        name="baslangic" />
                    @error('baslangic')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label>Bitiş Tarihi</label>
                    <input type="text" class="form-control datepicker2" value="{{ $result->and_time }}" name="bitis" />
                    @error('bitis')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-12 mb-3">
                    <label class="fw-bold">Sistemde Kayıtlı Paneller</label>
                    <hr>
                    <div class="row">
                        @foreach ($groups as $group)
                            <div class="col-xxl-4 col-xl-4 col-lg-6 col-md-6 mb-3">
                                <label class="fw-bold">{{ $group->name }}</label>
                                <br>
                                <ol>
                                    @foreach ($panels->where('group_id', '=', $group->id) as $panel)
                                        <li>
                                            <input type="checkbox" {{ in_array($panel->id, $panelIDs) ? 'checked' : '' }}
                                                name="panels[]" value="{{ $panel->id }}" />
                                            {{ $panel->name }}
                                        </li>
                                    @endforeach
                                </ol>
                            </div>
                        @endforeach
                    </div>
                </div>
                <button class="w-100 mt-3 btn btn-danger text-white btn-lg" type="submit">Tamamla</button>
            </form>
        </div>
    </div>
@endsection
