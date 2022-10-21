<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-tabs card-header-info">
                        <div class="row">
                            <div class="col-md-4">
                                <h4 class="card-title"><i class="material-icons">shopping_cart</i> Order List</h4>
                            </div>
                            <div class="col-md-8 text-right">
                                <button type="button" class="btn btn-white" onclick="printReport()">
                                    <i class="material-icons">print</i> Report
                                </button>
                                <button type="button" class="btn btn-white" onclick="createOrder();">
                                    <i class="material-icons">add</i> Order
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <span class="text-gray">Pagination: {$data.pagination.label}</span>
                            </div>
                            <div class="col-md-6">
                                {include file="../components/common/table_search.tpl" table="orders-table" index="1,2,3,4,5"}
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table id="orders-table" class="table table-hover table-striped table-shopping">
                                <thead class="text-info">
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Date</th>
                                    {* <th>From</th> *}
                                    <th>Receiver</th>
                                    <th>Product</th>
                                    <th class="text-right">Quantity</th>
                                    <th class="text-right">Unit Price</th>
                                    <th class="text-right">Total</th>
                                    <th class="text-right">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                {counter start=$data.pagination.offset print=false}
                                {foreach $data.orders as $order}
                                    <tr>
                                        <td class="text-center">{counter print=true}</td>
                                        <td>{$order->created_at|date_format}</td>
                                        {* <td>{$order->ref}</td> *}
                                        <td>{$order->receiver}</td>
                                        <td>{$order->product_name}</td>
                                        <td class="text-right">{$order->quantity}</td>
                                        <td class="text-right">{$order->amount}</td>
                                        <td class="text-right">{$order->total_amount}</td>
                                        <td class="td-actions text-right">
                                            <button onclick="viewOrder({$order->id})" type="button" rel="tooltip"
                                                    title="View"
                                                    class="btn btn-info btn-link ml-1">
                                                <i class="material-icons">visibility</i>
                                            </button>
                                            <button onclick="editOrder({$order->id})" type="button" rel="tooltip"
                                                    title="Edit"
                                                    class="btn btn-success btn-link ml-1">
                                                <i class="material-icons">create</i>
                                            </button>
                                            <button onclick="deleteOrder({$order->id})" type="button" rel="tooltip"
                                                    title="Delete"
                                                    class="btn btn-danger btn-link ml-1">
                                                <i class="material-icons">delete</i>
                                            </button>
                                        </td>
                                    </tr>
                                    {foreachelse}
                                    <tr>
                                        <td class="text-center" colspan="8">No Content</td>
                                    </tr>
                                {/foreach}
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="8">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <button type="button" class="btn btn-info" onclick="createOrder();">
                                                    <i class="material-icons">add</i> Order
                                                </button>
                                            </div>
                                            <div class="col-sm-9">
                                                {include file="../components/common/table_pagination.tpl"}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const printReport = () => new Report('order', {
        ref: 'From',
        approved_by: 'Approved By',
        receiver: 'Receiver',
        product_name: 'Product',
    });
</script>

<script>
    const editOrderForm = `
        <form class="row">
          <div class="col-md-12">
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                      <i class="material-icons">transfer_within_a_station</i>
                  </span>
                </div>
                <input type="text" class="form-control" required="required" name="ref" id="order_from" placeholder="From">
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                      <i class="material-icons">person</i>
                  </span>
                </div>
                <input type="text" class="form-control" required="required" name="receiver" id="order_receiver" placeholder="Receiver">
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                      <i class="material-icons">person</i>
                  </span>
                </div>
                <input type="text" min="1" required class="form-control" name="approved_by" id="order_approved_by" placeholder="Approved By">
              </div>
            </div>
          </div>

            <div class="col-md-6">
              <div class="form-group">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="material-icons">shopping_basket</i>
                    </span>
                  </div>
                  <select class="custom-select" required id="order_product_id" name="product_id" placeholder="Select Product...">
                    <option selected disabled>select product...</option>
                      {foreach $data.products as $product}
                      {$stockIn=0} {$stockOut=0}
                      {if $product->stock_in}{$stockIn=$product->stock_in}{/if}
                      {if $product->stock_out}{$stockOut=$product->stock_out}{/if}
                      {$stock=$stockIn - $stockOut}
                    <option value="{$product->id}">{$product->name} ({$product->sku}) {$stock}</option>
                      {/foreach}
                  </select>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="material-icons">list</i>
                    </span>
                  </div>
                  <input type="number" min="1" required class="form-control" id="order_quantity" name="quantity" placeholder="Quantity">
                </div>
              </div>
            </div>
        </form>
    `;

    /**
     * Order form
     */
    const orderForm = `
        <form class="row">
          <div class="col-md-12">
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                      <i class="material-icons">transfer_within_a_station</i>
                  </span>
                </div>
                <input type="text" class="form-control" required="required" name="ref" id="order_from" placeholder="From">
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                      <i class="material-icons">person</i>
                  </span>
                </div>
                <input type="text" class="form-control" required="required" name="receiver" id="order_receiver" placeholder="Receiver">
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                      <i class="material-icons">person</i>
                  </span>
                </div>
                <input type="text" min="1" required class="form-control" name="approved_by" id="order_approved_by" placeholder="Approved By">
              </div>
            </div>
          </div>

          <div class="col-md-12">
            <table class="table table table-hover table-striped table-shopping">
                <thead class="text-info">
                    <tr>
                        <th class="text-center">#</th>
                        <th>Name</th>
                        <th>SKU</th>
                        <th style="width: 80px">Quantity</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="prod_table_body"></tbody>
                <tfoot>
                    <tr>
                        <th class="text-center">
                            <i class="material-icons text-info">shopping_basket</i>
                        </th>
                        <th colspan="2">
                            <select class="custom-select" id="prod_id" placeholder="Product">
                              <option selected disabled>select product...</option>
                              {foreach $data.products as $product}
                              {$stockIn=0} {$stockOut=0}
                              {if $product->stock_in}{$stockIn=$product->stock_in}{/if}
                              {if $product->stock_out}{$stockOut=$product->stock_out}{/if}
                              {$stock=$stockIn - $stockOut}
                              <option value="{$product->id};{$product->name};{$product->sku};{$stock}">{$product->name} ({$product->sku}) {$stock}</option>
                              {/foreach}
                            </select>
                        </th>
                        <th>
                            <input type="number" min="1" class="form-control text-center" id="prod_quantity" placeholder="Quantity">
                        </th>
                        <th>
                            <button type="button" class="btn btn-info btn-block" style="padding: 0.46875rem 1rem;" onclick="addProduct();">
                                <i class="material-icons">add</i>
                            </button>
                        </th>
                    </tr>
                </tfoot>
            </table>
          </div>

          <div class="col-sm-12">
              <input type="text" required="required" name="product_ids" id="product_ids" hidden>
              <input type="text" required="required" name="product_qty" id="product_qty" hidden>
          </div>
        </form>
    `;
    const orderController = new CRUDController('Order');
    const deleteOrder = (id) => orderController.delete('{$rootUrl}/app/orders?id=' + id);
    const createOrder = () => orderController.create(
        '{$rootUrl}/app/orders', orderForm,
        ['order_from', 'order_receiver', 'product_qty', 'product_ids', 'order_approved_by'],
    );
    const editOrder = (id) => orderController.edit(
        '{$rootUrl}/app/orders?id=' + id, editOrderForm,
        ['order_from', 'order_receiver', 'order_quantity', 'order_product_id', 'order_approved_by'],
    );
    const viewOrder = (id) => orderController.view('{$rootUrl}/app/orders?id=' + id, {
        'From': 'ref',
        'Receiver': 'receiver',
        'Approved By': 'approved_by',
        'Product': 'product_name',
        'Quantity': 'quantity',
        'Unit Price': 'amount',
        'Total': 'total_amount',
        'Created By': 'created_by_name',
        'Updated By': 'updated_by_name',
    });
</script>

<script>
    const addedProducts = [];

    const displayProducts = () => {
        const tableBody = document.getElementById('prod_table_body');
        const rows = addedProducts.map((p, index) => {
            return (
                '<tr>' +
                '<td class="text-center p-1">' + (index + 1) + '</td>' +
                '<td class="text-center p-1">' + p.name + '</td>' +
                '<td class="text-center p-1">' + p.sku + '</td>' +
                '<td class="text-center p-1">' + p.qty + '</td>' +
                '<td class="text-center p-1">' +
                '<button type="button" class="btn btn-danger btn-link" style="padding: 2px;" onclick="removeProduct(' + index + ');">' +
                '<i class="material-icons">clear</i></button></td>' +
                '</tr>'
            );
        });
        tableBody.innerHTML = rows.join('\n');
    };

    const removeProduct = (id) => {
        addedProducts.splice(id, 1);
        displayProducts();
    };

    const addProduct = () => {
        const prod = document.getElementById('prod_id');
        const qty = document.getElementById('prod_quantity');
        const productIds = document.getElementById('product_ids');
        const productQty = document.getElementById('product_qty');

        if ((prod.value && prod.value !== '') && (qty.value && qty.value !== '')) {
            const [id, name, sku, stock] = prod.value.split(';');
            if (Number(qty.value) <= Number(stock)) {
                addedProducts.push({
                    id, name, sku, qty: qty.value,
                });
                productIds.value = JSON.stringify(addedProducts.map(p => p.id));
                productQty.value = JSON.stringify(addedProducts.map(p => p.qty));
                prod.value = '';
                qty.value = '';
                displayProducts();
            } else {
                new Alert().validation('The quantity selected for "' + name + '" is greater than available stock: ' + stock);
            }
        } else {
            new Alert().validation('Product and Quantity fields are required to be field out');
        }
    };
</script>