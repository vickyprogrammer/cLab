<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-tabs card-header-info">
            <div class="row">
              <div class="col-md-4">
                <h4 class="card-title"><i class="material-icons">local_shipping</i> Supply List</h4>
              </div>
              <div class="col-md-8 text-right">
                  <button type="button" class="btn btn-white" onclick="printReport()">
                      <i class="material-icons">print</i> Report
                  </button>
                <button type="button" class="btn btn-white" onclick="createSupply();">
                  <i class="material-icons">add</i> Supply
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
                  {include file="../components/common/table_search.tpl" table="supplies-table" index="1,2,3,4,5"}
              </div>
            </div>

            <div class="table-responsive">
              <table id="supplies-table" class="table table-hover table-striped table-shopping">
                <thead class="text-info">
                <tr>
                  <th class="text-center">#</th>
                  <th>Date</th>
                  <th>Supplier</th>
                  <th>Product</th>
                  <th class="text-right">Quantity</th>
                  <th class="text-right">Unit Price</th>
                  <th class="text-right">Total</th>
                  <th class="text-right">Actions</th>
                </tr>
                </thead>
                <tbody>
                {counter start=$data.pagination.offset print=false}
                {foreach $data.supplies as $supply}
                  <tr>
                    <td class="text-center">{counter print=true}</td>
                    <td>{$supply->created_at|date_format}</td>
                    <td>{$supply->supplier_name}</td>
                    <td>{$supply->product_name}</td>
                    <td class="text-right">{$supply->quantity} {$supply->product_unit}</td>
                    <td class="text-right">{$supply->amount}</td>
                    <td class="text-right">{$supply->total_amount}</td>
                    <td class="td-actions text-right">
                      <button onclick="viewSupply({$supply->id})" type="button" rel="tooltip" title="View"
                              class="btn btn-info btn-link ml-1">
                        <i class="material-icons">visibility</i>
                      </button>
                      <button onclick="editSupply({$supply->id})" type="button" rel="tooltip" title="Edit"
                              class="btn btn-success btn-link ml-1">
                        <i class="material-icons">create</i>
                      </button>
                      <button onclick="deleteSupply({$supply->id})" type="button" rel="tooltip" title="Delete"
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
                        <button type="button" class="btn btn-info" onclick="createSupply();">
                          <i class="material-icons">add</i> Supply
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
    const printReport = () => new Report('supplies', {
        supplier_name: 'Supplier',
        product_name: 'Product',
    });
</script>

<script>
    /**
     * Supply form
     */
    const supplyForm = `
        <form class="row">
          <div class="col-md-12">
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                      <i class="material-icons">local_shipping</i>
                  </span>
                </div>
                <select class="custom-select" required="required" name="supplier_id" id="supply_supplier_id" placeholder="Supplier">
                  <option selected disabled>select supplier...</option>
                  {foreach $data.suppliers as $supplier}
                  <option value="{$supplier->id}">{$supplier->name}</option>
                  {/foreach}
                </select>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                      <i class="material-icons">shopping_basket</i>
                  </span>
                </div>
                <select class="custom-select" required="required" name="product_id" id="supply_product_id" placeholder="Product">
                  <option selected disabled>select product...</option>
                  {foreach $data.products as $product}
                  <option value="{$product->id}">{$product->name} ({$product->sku})</option>
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
                <input type="number" min="1" required class="form-control" name="quantity" id="supply_quantity" placeholder="Quantity">
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                      <i class="material-icons">&#8358;</i>
                  </span>
                </div>
                <input type="text" min="0" class="form-control" required="required" name="unit_price" id="product_unit_price" placeholder="Unit Price">
              </div>
            </div>
          </div>
        </form>
    `;
    const supplyController = new CRUDController('Supply');
    const deleteSupply = (id) => supplyController.delete('{$rootUrl}/app/supplies?id=' + id);
    const createSupply = () => supplyController.create(
        '{$rootUrl}/app/supplies', supplyForm,
        ['supply_supplier_id', 'supply_product_id', 'supply_quantity', 'product_unit_price'],
    );
    const editSupply = (id) => supplyController.edit(
        '{$rootUrl}/app/supplies?id=' + id, supplyForm,
        ['supply_supplier_id', 'supply_product_id', 'supply_quantity', 'product_unit_price'],
    );
    const viewSupply = (id) => supplyController.view('{$rootUrl}/app/supplies?id=' + id, {
        'Supplier': 'supplier_name',
        'Product': 'product_name',
        'Quantity': 'quantity',
        'Unit Price': 'amount',
        'Total': 'total_amount',
        'Created By': 'created_by_name',
    });
</script>