@extends('sablon.yonetim')

@section('title')
    Web Anasayfa
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol id="breadcrumb" class="breadcrumb p-2">
            <li class="breadcrumb-item"><a href="/yonetim">Yönetim İşlemleri</a></li>
            <li class="breadcrumb-item"><a href="/yonetim/web">Web İşlemleri</a></li>
            <li class="breadcrumb-item active">API Paneller</li>
        </ol>
    </nav>

    <div class="card mb-3">
        <div class="card-header bg-danger text-white">API Paneller</div>
        <div class="card-body">

            @if (in_array(4, $userAccesses))
                @if ($panelsTimeAccess == 1)
                    @foreach ($webGroups as $webGroup)
                        <div class="row">
                            <h5 for="" class="fw-bold"> {{ $webGroup->name }} Panelleri</h5>
                            @if ($webPanels->where('group_id', '', $webGroup->id)->count() == 0)
                                <div class="col-12 mb-3">
                                    <div class="card">
                                        <div class="card-body text-danger fw-bold">Panel yetkileri bulunamadı!</div>
                                    </div>
                                </div>
                            @else
                                @foreach ($webPanels->where('group_id', '', $webGroup->id) as $webPanel)
                                    <div class="col-lg-4 col-md-6 col-sm-6 mb-3">
                                        <div class="card">
                                            <div class="card-body">
                                                <h6 class="card-title fw-bold">{{ $webPanel->name }}</h6>
                                                    <input type="hidden" name="d" value="tr" />
                                                    <a href="api-panels/{{ $webPanel->id }}" class="w-100 mt-2 btn btn-secondary text-white float-end">Panele
                                                        git</a>
                                            </div>
                                        </div>
                                    </div>
                                    @if ($loop->last)
                                        <hr>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    @endforeach
                @elseif ($panelsTimeAccess == 0)
                    <div class="alert alert-warning">
                        Panel yetkileri süresi aşımı oldu.
                    </div>
                @elseif ($panelsTimeAccess == 2)
                    <div class="alert alert-danger">
                        Panel yetkileri kaydı yapılmadı!
                    </div>
                @endif
            @else
                <div class="alert alert-danger">
                    Kullanıcı erişimleri verilmedi!
                </div>
            @endif
        </div>
    </div>
@endsection
