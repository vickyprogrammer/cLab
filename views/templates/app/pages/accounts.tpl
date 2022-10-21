<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-tabs card-header-info">
            <div class="row">
              <div class="col-md-6">
                <h4 class="card-title"><i class="material-icons">supervised_user_circle</i> Account List</h4>
              </div>
              <div class="col-md-6 text-right">
                <button type="button" class="btn btn-white" onclick="createAccount();">
                  <i class="material-icons">add</i> Account
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
                  {include file="../components/common/table_search.tpl" table="accounts-table" index="1,2,3,4"}
              </div>
            </div>

            <div class="table-responsive">
              <table id="accounts-table" class="table table-hover table-striped table-shopping">
                <thead class="text-info">
                <tr>
                  <th class="text-center">#</th>
                  <th>Email</th>
                  <th>First Name</th>
                  <th>Last Name</th>
                  <th>Role</th>
                  <th class="text-right">Actions</th>
                </tr>
                </thead>
                <tbody>
                {counter start=$data.pagination.offset print=false}
                {foreach $data.accounts as $account}
                  <tr>
                    <td class="text-center">{counter print=true}</td>
                    <td>{$account->email}</td>
                    <td>{$account->first_name}</td>
                    <td>{$account->last_name}</td>
                    <td>{if $account->role eq 1}Super Admin{else}Admin{/if}</td>
                    <td class="td-actions text-right">
                      <button onclick="viewAccount({$account->id})" type="button" rel="tooltip" title="View"
                              class="btn btn-info btn-link ml-1">
                        <i class="material-icons">visibility</i>
                      </button>
                      <button onclick="editAccount({$account->id})" type="button" rel="tooltip" title="Edit"
                              class="btn btn-success btn-link ml-1">
                        <i class="material-icons">create</i>
                      </button>
                    </td>
                  </tr>
                    {foreachelse}
                  <tr>
                    <td class="text-center" colspan="6">No Content</td>
                  </tr>
                {/foreach}
                </tbody>
                <tfoot>
                <tr>
                  <td colspan="6">
                    <div class="row">
                      <div class="col-sm-3">
                        <button type="button" class="btn btn-info" onclick="createAccount();">
                          <i class="material-icons">add</i> Account
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
     * Account form
     */
    const accountCreatForm = `
        <form class="row">
          <div class="col-md-12">
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                      <i class="material-icons">email</i>
                  </span>
                </div>
                <input type="email" class="form-control" required="required" name="email" id="account_email" placeholder="Email">
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                      <i class="material-icons">lock</i>
                  </span>
                </div>
                <input type="password" required minlength="6" class="form-control" name="password" id="account_password" placeholder="Password">
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                      <i class="material-icons">account_circle</i>
                  </span>
                </div>
                <select class="custom-select" required="required" name="role" id="account_role" placeholder="Role">
                  <option selected disabled>select role...</option>
                  <option value="0">Admin</option>
                  <option value="1">Super Admin</option>
                </select>
              </div>
            </div>
          </div>
        </form>
    `;

    const accountEditForm = `
        <form class="row">
          <div class="col-md-12">
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                      <i class="material-icons">email</i>
                  </span>
                </div>
                <input type="email" class="form-control" required="required" name="email" id="account_email" placeholder="Email">
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                      <i class="material-icons">lock</i>
                  </span>
                </div>
                <input type="password" class="form-control" name="password" id="account_password" placeholder="Password">
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                      <i class="material-icons">account_circle</i>
                  </span>
                </div>
                <select class="custom-select" required="required" name="role" id="account_role" placeholder="Role">
                  <option selected disabled>select role...</option>
                  <option value="0">Admin</option>
                  <option value="1">Super Admin</option>
                </select>
              </div>
            </div>
          </div>
        </form>
    `;
    const accountController = new CRUDController('Account');
    const deleteAccount = (id) => accountController.delete('{$rootUrl}/app/accounts?id=' + id);
    const createAccount = () => accountController.create(
        '{$rootUrl}/app/accounts', accountCreatForm,
        ['account_email', 'account_password', 'account_role'],
    );
    const editAccount = (id) => accountController.edit(
        '{$rootUrl}/app/accounts?id=' + id, accountEditForm,
        ['account_email', 'account_password', 'account_role'],
    );
    const viewAccount = (id) => accountController.view('{$rootUrl}/app/accounts?id=' + id, {
        'Email': 'email',
        'First Name': 'first_name',
        'Last Name': 'last_name',
        'Phone': 'phone',
        'Role': 'role_name',
    });
</script>