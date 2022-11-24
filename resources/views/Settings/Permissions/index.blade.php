@extends('Layouts.main')

@section('header')
    <style>
        .permissoes{
            display: none;
        }
    </style>
@endsection
@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header" style="background-color: ">
            Permissões
        </div>
        <div class="card-body">
            <label for="userSelect">Usuário</label>
            <select class="js-example-basic-single" id="userSelect" name="userSelect" style="width: 100%" name="state">
                <option value=""></option>
                <option value="AL">Alabama</option>
                <option value="WY">Wyoming</option>
            </select>
            <div id="form" style="width: 100%; height: 100%">
        </div>
    </div>
</div>
@endsection
@section('scripts')
    <script>
    $('#userSelect').select2();
    let form = $("#form").w2form({
    box: '#form',
    name: 'form',
    url: 'server/post',
    tabs: [
        { id: 'dashboard', text: 'Dashboard' },
        { id: 'settings', text: 'Configurações' }
    ],
    fields: [
        { field: 'dashboard_view', type: 'checkbox',
            html: {
                group: 'Dashboard',
                page: 0,
                label: 'Vizualizar',
                span: 0
            }
        },
        { field: 'settings_permissions_view', type: 'checkbox',
            html: {
                group: 'Permissões',
                page: 1,
                label: 'Vizualizar',
                span: 0
            }
        },
        { field: 'settings_permissions_edit', type: 'checkbox',
            html: {
                group: 'Permissões',
                page: 1,
                label: 'Editar',
                span: 0
            }
        },
    ],
    actions: {
        Resetar() {
            this.clear();
        },
        Salvar() {
            if (form.validate().length == 0) {
                w2popup.open({
                    title: 'Form Data',
                    with: 600,
                    height: 550,
                    body: `<pre>${JSON.stringify(this.getCleanRecord(), null, 4)}</pre>`,
                    actions: { Ok: w2popup.close }
                })
            }
        }
    }
})
    </script>
@endsection
