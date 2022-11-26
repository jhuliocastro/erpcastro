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
                <table id="table_products" class="table is-striped" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>Código Barras</th>
                            <th>Produto</th>
                            <th>Preço Compra</th>
                            <th>Preço Venda</th>
                            <th>Estoque</th>
                            <th>Tipo</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
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
                "ajax": "{{route('products.table')}}",
                dom: 'Bfrtip',
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/pt-BR.json"
                }
            });
        });

        function addInventory(id, nameProduct){
            Swal.fire({
                title: 'Adicionar estoque',
                text: nameProduct,
                input: 'text'
            }).then(function(response){
                if(response.isConfirmed === true){
                    if(response.value > 0){
                        axios.post("{{route('products.inventory.add')}}", {
                            id: id,
                            amount: response.value
                        }).then(function(response){
                            if(response.data.status === true){
                                table.ajax.reload();
                                iziToast.success({
                                    message: 'Estoque Atualizado'
                                });
                            }else{
                                iziToast.error({
                                    message: response.data.message
                                });
                            }
                        }).catch(function(response){
                            iziToast.error({
                                title: 'Erro ao alterar estoque',
                                message: 'Contate o administrador do sistema'
                            });
                        });
                    }else{
                        iziToast.error({
                           title: 'Valor deve ser maior que 0'
                        });
                    }
                }
            });
        }

        function deleteProduct(id) {
            iziToast.question({
                title: 'Deseja deletar o produto?',
                message: 'Essa ação não tem volta',
                buttons: [
                    ['<button><b>Sim</b></button>', function (instance, toast) {
                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                        axios.post("{{route('products.delete')}}", {
                            product: id
                        }).then(function(response){
                            if(response.data.status === true){
                                table.ajax.reload();
                                iziToast.success({
                                    message: 'Produto deletado'
                                });
                            }else{
                                iziToast.error({
                                    message: response.data.message
                                });
                            }
                        }).catch(function(response){
                            iziToast.error({
                                title: 'Erro ao deletar produto',
                                message: 'Contate o administrador do sistema'
                            });
                        });
                    }, true],
                    ['<button>Não</button>', function (instance, toast) {
                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                    }],
                ],
            });
        }

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
                    table.ajax.reload();
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
