<button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#modal-settings">
    <i class="fa fa-cog"></i> Ürün Tanımları
</button>
<div class="modal fade" id="modal-settings">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Ürün Tanımları</h4>
            </div>
            <div class="modal-body">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#home-box" data-toggle="tab">Teknik Bilgiler</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="home-box">
                            @include('store::admin.products.partials.settings.techical')
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary pull-left" data-dismiss="modal">KAYDET VE KAPAT</button>
            </div>
        </div>
    </div>
</div>

@push('css-stack')
    <style>
        .modal-header {
            background: #3c8dbc;
            color: #ffffff;
        }

        .modal-footer {
            background: #ececec;
        }

        #modal-settings legend {
            padding: 5px 20px;
            background: #ebebeb;
            font-size: 14px;
            font-weight: bold;
        }
        .btn-block {
            margin-bottom: 10px;
        }
    </style>
@endpush