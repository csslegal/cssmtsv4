@if (isset($customerVisaLogs))
    <div class="card card-primary  mb-3" id="visa">
        <div class="card-header bg-primary text-white">Müşteri Vize Dosyası Logları</div>
        <div class="card-body scroll">
            <table id="dtVisaLogsTable" class="table table-striped table-bordered display table-light" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>İşlem Tarihi</th>
                        <th>Müşteri Adı</th>
                        <th>Aşama</th>
                        <th>İşlem Yapan</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endif
