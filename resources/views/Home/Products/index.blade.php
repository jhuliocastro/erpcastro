@extends('Layouts.main')

@section('header')

@endsection
@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header" style="">
                <p class="card-header-title">
                    Produtos
                </p>
                <div class="buttons actions">
                    <button id="btnRegister" class="button is-small is-info">Cadastrar</button>
                </div>
            </div>
            <div class="card-content">
                <table id="table_products" class="display compact" style="width: 100%;">
                    <thead>
                        <tr>
                            <td>ID</td>
                            <td>Código Barras</td>
                            <td>Produto</td>
                            <td>Preço Venda</td>
                            <td>Estoque Atual</td>
                            <td>Tipo</td>
                            <td>Ações</td>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <div id="window-register-product" class="window-action">
            <form id="form-add-product">
                <div class="window-action-header">
                    Cadastrar Produto
                </div>
                <div class="window-action-body">
                    <div class="field">
                        <label class="label is-small">Nome do Produto</label>
                        <div class="control">
                            <input class="input is-small" type="text" required id="txt-name-product-add">
                        </div>
                    </div>
                    <div class="field">
                        <label class="label is-small">Unidade de Medida (Até 3 Dígitos)</label>
                        <div class="control">
                            <input class="input is-small" type="text" required id="txt-unit-add" maxlength="3">
                        </div>
                    </div>
                    <div class="field">
                        <label class="label is-small">Valor Compra</label>
                        <div class="field has-addons">
                            <div class="control">
                                <a class="button is-static is-small">
                                    R$
                                </a>
                            </div>
                            <div class="control is-expanded">
                                <input class="input is-small" type="text" required id="txt-price-purchase-add">
                            </div>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label is-small">Valor Venda</label>
                        <div class="field has-addons">
                            <div class="control">
                                <a class="button is-static is-small">
                                    R$
                                </a>
                            </div>
                            <div class="control is-expanded">
                                <input class="input is-small" type="text" required id="txt-price-sale-add">
                            </div>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label is-small">Estoque</label>
                        <div class="control">
                            <input class="input is-small" type="number" required id="txt-inventory-add">
                        </div>
                    </div>
                    <div class="field">
                        <label class="label is-small">Código de Barras</label>
                        <div class="control">
                            <input class="input is-small" type="number" required id="txt-codebar-add">
                        </div>
                    </div>
                </div>
                <div class="window-action-footer">
                    <div class="buttons">
                        <button id="btnCancelRegister" class="button is-small is-dark">Cancelar</button>
                        <button id="btnSaveRegister" type="submit" class="button is-small is-info">Salvar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        var table;
        $(document).ready( function () {
            table = $('#table_products').DataTable({
                "paging": true,
                dom: 'Bfrtip',
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/pt-BR.json"
                },
                buttons: [
                    'copy', 'excel', 'pdf'
                ]
            });
        });

        $("#btnRegister").click(function(){
            $(".window-action").fadeIn();
            $("#txt-name-product-add").focus();
        });

        $("#btnCancelRegister").click(function(){
           $(".window-action").fadeOut();
        });

        $("#form-add-product").submit(function(event){
           event.preventDefault();
           let params = {
               name: $("#txt-name-product-add").val(),
               unit: $("#txt-unit-add").val(),
               price_purchase: $("#txt-price-purchase-add").val(),
               price_sale: $("#txt-price-sale-add").val(),
               inventory: $("#txt-inventory-add").val(),
               codebar: $("#txt-codebar-add").val(),
           }

            axios.post("{{route('products.store')}}", params).then(function(response){
                if(response.data.status === false){
                    iziToast.error({
                        message: response.data.message
                    });
                }else{
                    $("#form-add-product input").val("");
                    $(".window-action").fadeOut();
                    iziToast.success({
                        message: 'Produto cadastrado com sucesso'
                    });
                }
            }).catch(function(response){
                console.log(response);
                iziToast.error({
                    title: 'Erro ao salvar produto',
                    message: 'Contate o administrador do sistema'
                });
            });
        });
    </script>
@endsection
