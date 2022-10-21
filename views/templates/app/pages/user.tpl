<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header card-header-info">
            <h4 class="card-title">Edit Profile</h4>
            <p class="card-category">Complete your profile</p>
          </div>
          <div class="card-body">
            <form>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="user_first_name" class="bmd-label-floating">First Name</label>
                    <input type="text" autofocus class="form-control" id="user_first_name"
                           value="{$data.user->first_name}">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="bmd-label-floating" for="user_last_name">Last Name</label>
                    <input type="text" class="form-control" id="user_last_name" value="{$data.user->last_name}">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="bmd-label-floating" for="user_email">Email</label>
                    <input type="text" id="user_email" class="form-control" value="{$data.user->email}" readonly>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="bmd-label-floating" for="user_phone">Phone Number</label>
                    <input type="text" class="form-control" id="user_phone" value="{$data.user->phone}">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="bmd-label-floating" for="user_role">Role</label>
                    <select class="form-control" id="user_role" disabled readonly>
                      <option value="0" {if $data.user->role eq 0}selected{/if}>Admin</option>
                      <option value="1" {if $data.user->role eq 1}selected{/if}>Super Admin</option>
                    </select>
                  </div>
                </div>
              </div>
              <button type="button" onclick="updateProfile();" class="btn btn-info pull-right"
                      name="update">Update Profile
              </button>
              <div class="clearfix"></div>
            </form>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card card-profile">
          <div class="card-avatar">
            <a href="javascript:void(0);">
              <img class="img" src="{$baseUrl}/views/templates/app/assets/img/img_avatar.png{$cache}" alt="..."/>
            </a>
          </div>
          <div class="card-body">
            <h6 class="card-category text-gray text-lowercase">{$data.user->email}</h6>
            <h4 class="card-title">{$data.user->first_name} {$data.user->last_name}</h4>
            <p class="card-description">
                {if $data.user->role eq 0}Admin{else}Super Admin{/if}
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
    const updateProfile = () => {
        const alert = new Alert();
        const data = {
            first_name: $('#user_first_name').val(),
            last_name: $('#user_last_name').val(),
            phone: $('#user_phone').val(),
        };
        new Api('{$rootUrl}/app/user/update', 'POST', data)
            .then(value => {
                if (value.success) {
                    alert.notify('Profile Update Successful', value.message, 'success')
                        .then(() => location.reload());
                } else {
                    throw new Error(value.message);
                }
            })
            .catch(reason => {
                alert.notify('Profile Update Failed', reason.message, 'error');
            });
    };
</script>