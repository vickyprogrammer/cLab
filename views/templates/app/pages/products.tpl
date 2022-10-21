<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-tabs card-header-info">
            <div class="row">
              <div class="col-md-4">
                <h4 class="card-title"><i class="material-icons">shopping_basket</i> Product List</h4>
              </div>
              <div class="col-md-8 text-right">
                <button type="button" class="btn btn-white" onclick="printReport()">
                  <i class="material-icons">print</i> Report
                </button>
                <button type="button" class="btn btn-white" onclick="browseFiles()">
                  <i class="material-icons">publish</i> Upload
                </button>
                <input type="file" id="upload-file" hidden="hidden" accept=".csv" />
                <button onclick="createProduct()" type="button" class="btn btn-white">
                  <i class="material-icons">add</i> Product
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
                  {include file="../components/common/table_search.tpl" table="products-table" index="1,2,3,4,5"}
              </div>
            </div>

            <div class="table-responsive">
              <table id="products-table" class="table table-hover table-striped table-shopping">
                <thead class="text-info">
                <tr>
                  <th class="text-center">#</th>
                  <th>SKU</th>
                  <th>Name</th>
                  <th>Brand</th>
                  <th>Category</th>
                  <th class="text-right">Stock</th>
                  <th class="text-right">Unit Price</th>
                  <th class="text-right">Actions</th>
                </tr>
                </thead>
                <tbody>
                {counter start=$data.pagination.offset print=false}
                {foreach $data.products as $product}
                  <tr>
                    <td class="text-center">{counter print=true}</td>
                    <td>{$product->sku}</td>
                    <td>{$product->name}</td>
                    <td>{$product->brand}</td>
                    <td>{$product->category_name}</td>
                    <td class="text-right">
                        {$stockIn=0} {$stockOut=0}
                        {if $product->stock_in}{$stockIn=$product->stock_in}{/if}
                        {if $product->stock_out}{$stockOut=$product->stock_out}{/if}
                        {$stock=$stockIn - $stockOut}
                        {$stockStatus=0}
                        {if ($stock gt 0) and ($stock lt 10)} {$stockStatus=1}
                        {elseif $stock eq 0 or $stock lt 0} {$stockStatus=0} {else} {$stockStatus=2} {/if}
                        {$stockData=[['danger','ban','Out of Stock'],['warning','long-arrow-down','Low Stock'],['success', 'long-arrow-up','In Stock']]}
                      <span rel="tooltip" title="{$stockData[$stockStatus][2]}">
                          {$stock} {$product->unit}
                        <span class="text-{$stockData[$stockStatus][0]}">
                          <i class="fa fa-{$stockData[$stockStatus][1]}"></i>
                        </span>
                      </span>
                    </td>
                    <td class="text-right text-info">{$product->amount}</td>
                    <td class="td-actions text-right">
                      <button onclick="viewProduct({$product->id})" type="button" rel="tooltip" title="View"
                              class="btn btn-info btn-link ml-1">
                        <i class="material-icons">visibility</i>
                      </button>
                      <button onclick="editProduct({$product->id})" type="button" rel="tooltip" title="Edit"
                              class="btn btn-success btn-link ml-1">
                        <i class="material-icons">create</i>
                      </button>
                      <button onclick="deleteProduct({$product->id})" type="button" rel="tooltip" title="Delete"
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
                        <button onclick="createProduct()" type="button" class="btn btn-info">
                          <i class="material-icons">add</i> Product
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
    const printReport = () => new Report('product', {
        brand: 'Brand',
        category_name: 'Category'
    });
</script>

<script>
    /**
     * Product form
     */
    const productForm = `
        <form class="row">
          <div class="col-md-12">
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                      <i class="material-icons">shopping_basket</i>
                  </span>
                </div>
                <input type="text" class="form-control" required="required" name="name" id="product_name" placeholder="Product Name">
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                      <i class="material-icons">widgets</i>
                  </span>
                </div>
                <input type="text" class="form-control" name="brand" id="product_brand" placeholder="Product Brand">
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                      <i class="material-icons">category</i>
                  </span>
                </div>
                <select class="custom-select" required="required" name="category" id="product_category" placeholder="Category">
                  <option selected disabled>select category...</option>
                  {foreach $data.categories as $category}
                  <option value="{$category->id}">{$category->name}</option>
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
                      <i class="material-icons">qr_code</i>
                  </span>
                </div>
                <input type="text" class="form-control" required="required" name="sku" id="product_sku" placeholder="SKU">
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
                <input type="text" min="0" class="form-control" required="required" name="price" id="product_price" placeholder="Price">
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                      <i class="material-icons">format_size</i>
                  </span>
                </div>
                <input type="text" class="form-control" name="pack_size" id="product_pack_size" placeholder="Pack Size">
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                      <i class="material-icons">square_foot</i>
                  </span>
                </div>
                <input type="text" class="form-control" name="unit" id="product_unit" placeholder="Unit (Packets, Rolls, Kit, Bags, Units...)">
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                      <i class="material-icons">layers</i>
                  </span>
                </div>
                <input type="text" class="form-control" name="batch" id="product_batch" placeholder="Batch Number">
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                      <i class="material-icons">event_busy</i>
                  </span>
                </div>
                <input type="text" class="form-control" name="expiry_date" id="product_expiry_date" placeholder="Expiry Date">
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                      <i class="material-icons">subject</i>
                  </span>
                </div>
                <input type="text" class="form-control" required="required" name="detail" id="product_detail" placeholder="Detail">
              </div>
            </div>
          </div>
        </form>
    `;

    const toast = new Alert();
    const file = document.getElementById('upload-file');
    const browseFiles = () => {
        const body = `
        Upload a ".csv" file with this format.<br/>
        <code style="font-size: small; text-align: left; display: inline-flex;">
            name, category, sku, price<br/>
            Product-1 Name, 1, PRO-SKU-1, 1000<br/>
            Product-2 Name, 1, PRO-SKU-2, 500<br/>
            ...<br/>
        </code> <br/>
        <strong>Note: </strong> Don't make use of comma(,) in the product name.
        `;
        toast.dialogWizard('Upload Products', body, 'Upload CSV File', () => Promise.resolve(file.click())).then();
    };

    file.addEventListener('change', () => {
        if (file.files[0].type === 'text/csv') {
            const reader = new FileReader();
            reader.onload = () => {
                const csv = reader.result;
                const data = csv.split('\n').map(row => {
                    const cols = row.split(',');
                    return {
                        name: cols[0].trim(),
                        category: cols[1].trim(),
                        sku: cols[2].trim(),
                        price: cols[3].trim(),
                    };
                });
                data.splice(0, 1);
                const body = `
                ${ data.length } records found in CSV, here is the first and last record.<br/>
                <code style="font-size: small; text-align: left; display: inline-flex;">
                    SN, name, category, sku, price<br/>
                    ${ 1 }, ${ data[0].name }, ${ data[0].category }, ${ data[0].sku }, ${ data[0].price }<br/>
                    ...<br/>
                    ${ data.length }, ${ data[data.length-1].name }, ${ data[data.length-1].category }, ${ data[data.length-1].sku }, ${ data[data.length-1].price }<br/>
                </code>
                `;
                toast.dialogWizard('Upload Preview', body, 'Create Products', () => {
                    return new Promise((resolve, reject) => {
                        new Api('{$rootUrl}/app/products/upload', 'POST', data)
                        .then(value => {
                            if (value.success) {
                                console.log(value);
                                toast.notify(value.message, '', 'success')
                                    .then(() => location.reload());
                            } else {
                                toast.notify('Error Creating Products', value.message, 'error').then();
                            }
                        })
                        .catch(reject);
                    });
                }).then();
            };
            reader.readAsText(file.files[0]);
        } else {
            toast.toast(`Invalid file type, ".csv" required`, 'error');
        }
    });

    const productController = new CRUDController('Product');
    const deleteProduct = (id) => productController.delete('{$rootUrl}/app/products?id=' + id);
    const createProduct = () => productController.create(
        '{$rootUrl}/app/products', productForm,
        ['product_name', 'product_brand', 'product_category', 'product_sku', 'product_price', 'product_pack_size', 'product_unit', 'product_batch', 'product_expiry_date', 'product_detail'],
    );
    const editProduct = (id) => productController.edit(
        '{$rootUrl}/app/products?id=' + id, productForm,
        ['product_name', 'product_brand', 'product_category', 'product_sku', 'product_price', 'product_pack_size', 'product_unit', 'product_batch', 'product_expiry_date', 'product_detail'],
    );
    const viewProduct = (id) => productController.view('{$rootUrl}/app/products?id=' + id, {
        'SKU': 'sku',
        'Name': 'name',
        'Brand': 'brand',
        'Category': 'category_name',
        'Stock In': 'stock_in',
        'Stock Out': 'stock_out',
        'Price': 'amount',
        'Pack Size': 'pack_size',
        'Quantity Unit': 'unit',
        'Batch Number': 'batch',
        'Expiry Date': 'expiry_date',
        'Detail': 'detail',
        'Created By': 'create_user_name',
        'Updated By': 'update_user_name',
    });
</script>