<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-tabs card-header-info">
            <div class="row">
              <div class="col-md-4">
                <h4 class="card-title"><i class="material-icons">group</i> Supplier List</h4>
              </div>
              <div class="col-md-8 text-right">
                  <button type="button" class="btn btn-white" onclick="printReport()">
                      <i class="material-icons">print</i> Report
                  </button>
                <button type="button" class="btn btn-white" onclick="createSupplier();">
                  <i class="material-icons">add</i> Supplier
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
                  {include file="../components/common/table_search.tpl" table="suppliers-table" index="1,2,3"}
              </div>
            </div>

            <div class="table-responsive">
              <table id="suppliers-table" class="table table-hover table-striped table-shopping">
                <thead class="text-info">
                <tr>
                  <th class="text-center">#</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th class="text-right">Actions</th>
                </tr>
                </thead>
                <tbody>
                {counter start=$data.pagination.offset print=false}
                {foreach $data.suppliers as $supplier}
                  <tr>
                    <td class="text-center">{counter print=true}</td>
                    <td>{$supplier->name}</td>
                    <td>{$supplier->email}</td>
                    <td>{$supplier->phone}</td>
                    <td class="td-actions text-right">
                      <button onclick="viewSupplier({$supplier->id})" type="button" rel="tooltip" title="View"
                              class="btn btn-info btn-link ml-1">
                        <i class="material-icons">visibility</i>
                      </button>
                      <button onclick="editSupplier({$supplier->id})" type="button" rel="tooltip" title="Edit"
                              class="btn btn-success btn-link ml-1">
                        <i class="material-icons">create</i>
                      </button>
                      <button onclick="deleteSupplier({$supplier->id})" type="button" rel="tooltip" title="Delete"
                              class="btn btn-danger btn-link ml-1">
                        <i class="material-icons">delete</i>
                      </button>
                    </td>
                  </tr>
                    {foreachelse}
                  <tr>
                    <td class="text-center" colspan="5">No Content</td>
                  </tr>
                {/foreach}
                </tbody>
                <tfoot>
                <tr>
                  <td colspan="5">
                    <div class="row">
                      <div class="col-sm-3">
                        <button type="button" class="btn btn-info" onclick="createSupplier();">
                          <i class="material-icons">add</i> Supplier
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
    const printReport = () => new Report('supplier', {
    });
</script>

<script>
    /**
     * Supplier form
     */
    const supplierForm = `
        <form class="row">
          <div class="col-md-12">
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                      <i class="material-icons">group</i>
                  </span>
                </div>
                <input type="text" class="form-control" required="required" name="name" id="supplier_name" placeholder="Name">
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                      <i class="material-icons">email</i>
                  </span>
                </div>
                <input type="email" class="form-control" name="email" id="supplier_email" placeholder="Email">
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                      <i class="material-icons">call</i>
                  </span>
                </div>
                <input type="tel" class="form-control" name="phone" id="supplier_phone" placeholder="Phone Number">
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                      <i class="material-icons">home_work</i>
                  </span>
                </div>
                <input type="text" class="form-control" name="address" id="supplier_address" placeholder="Address">
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
                <input type="text" class="form-control" name="other" id="supplier_other" placeholder="Other">
              </div>
            </div>
          </div>
        </form>
    `;
    const supplierController = new CRUDController('Supplier');
    const deleteSupplier = (id) => supplierController.delete('{$rootUrl}/app/suppliers?id=' + id);
    const createSupplier = () => supplierController.create(
        '{$rootUrl}/app/suppliers', supplierForm,
        ['supplier_name', 'supplier_email', 'supplier_phone', 'supplier_address', 'supplier_other'],
    );
    const editSupplier = (id) => supplierController.edit(
        '{$rootUrl}/app/suppliers?id=' + id, supplierForm,
        ['supplier_name', 'supplier_email', 'supplier_phone', 'supplier_address', 'supplier_other'],
    );
    const viewSupplier = (id) => supplierController.view('{$rootUrl}/app/suppliers?id=' + id, {
        'Name': 'name',
        'Email': 'email',
        'Phone Number': 'phone',
        'Address': 'address',
        'Other': 'other',
    });
</script>