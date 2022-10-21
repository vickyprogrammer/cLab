<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-tabs card-header-info">
            <div class="row">
              <div class="col-md-6">
                <h4 class="card-title"><i class="material-icons">category</i> Category List</h4>
              </div>
              <div class="col-md-6 text-right">
                <button type="button" class="btn btn-white" onclick="createCategory();">
                  <i class="material-icons">add</i> Category
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
                  {include file="../components/common/table_search.tpl" table="categories-table" index="1,2"}
              </div>
            </div>

            <div class="table-responsive">
              <table id="categories-table" class="table table-hover table-striped table-shopping">
                <thead class="text-info">
                <tr>
                  <th class="text-center">#</th>
                  <th>Name</th>
                  <th>Description</th>
                  <th class="text-right">Actions</th>
                </tr>
                </thead>
                <tbody>
                {counter start=$data.pagination.offset print=false}
                {foreach $data.categories as $category}
                  <tr>
                    <td class="text-center">{counter print=true}</td>
                    <td>{$category->name}</td>
                    <td>{$category->detail}</td>
                    <td class="td-actions text-right">
                      <button onclick="editCategory({$category->id})" type="button" rel="tooltip" title="Edit"
                              class="btn btn-success btn-link ml-1">
                        <i class="material-icons">create</i>
                      </button>
                      <button onclick="deleteCategory({$category->id})" type="button" rel="tooltip" title="Delete"
                              class="btn btn-danger btn-link ml-1">
                        <i class="material-icons">delete</i>
                      </button>
                    </td>
                  </tr>
                    {foreachelse}
                  <tr>
                    <td class="text-center" colspan="4">No Content</td>
                  </tr>
                {/foreach}
                </tbody>
                <tfoot>
                <tr>
                  <td colspan="4">
                    <div class="row">
                      <div class="col-sm-3">
                        <button type="button" class="btn btn-info" onclick="createCategory();">
                          <i class="material-icons">add</i> Category
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
    /**
     * Category form
     */
    const categoryForm = `
        <form class="row">
          <div class="col-md-12">
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                      <i class="material-icons">category</i>
                  </span>
                </div>
                <input type="text" class="form-control" required="required" name="name" id="category_name" placeholder="Name">
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
                <input type="text" class="form-control" required="required" name="detail" id="category_detail" placeholder="Detail">
              </div>
            </div>
          </div>
        </form>
    `;
    const categoryController = new CRUDController('Category');
    const deleteCategory = (id) => categoryController.delete('{$rootUrl}/app/categories?id=' + id);
    const createCategory = () => categoryController.create(
        '{$rootUrl}/app/categories', categoryForm,
        ['category_name', 'category_detail'],
    );
    const editCategory = (id) => categoryController.edit(
        '{$rootUrl}/app/categories?id=' + id, categoryForm,
        ['category_name', 'category_detail'],
    );
</script>