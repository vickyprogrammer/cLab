<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-4 col-md-6 col-sm-6">
        <div class="card card-stats">
          <div class="card-header card-header-info card-header-icon">
            <div class="card-icon">
              <i class="material-icons">shopping_basket</i>
            </div>
            <p class="card-category">Products</p>
            <h3 class="card-title">{$data.stats->products}</h3>
          </div>
          <div class="card-footer">
            <div class="stats">
              <i class="material-icons">shopping_basket</i>
              <a href="{$baseUrl}/app/products" class="text-info">View Products</a>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-6 col-sm-6">
        <div class="card card-stats">
          <div class="card-header card-header-primary card-header-icon">
            <div class="card-icon">
              <i class="material-icons">local_shipping</i>
            </div>
            <p class="card-category">Stock In</p>
            <h3 class="card-title">{$data.stats->stock_in}</h3>
          </div>
          <div class="card-footer">
            <div class="stats">
              <i class="material-icons">local_shipping</i>
              <a href="{$baseUrl}/app/supplies" class="text-info">View Stock In</a>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-6 col-sm-6">
        <div class="card card-stats">
          <div class="card-header card-header-success card-header-icon">
            <div class="card-icon">
              <i class="material-icons">shopping_cart</i>
            </div>
            <p class="card-category">Stock Out</p>
            <h3 class="card-title">{$data.stats->stock_out}</h3>
          </div>
          <div class="card-footer">
            <div class="stats">
              <i class="material-icons">shopping_cart</i>
              <a href="{$baseUrl}/app/orders" class="text-info">View Stock Out</a>
            </div>
          </div>
        </div>
      </div>

      <!-- Line 2 -->
      <div class="col-lg-4 col-md-6 col-sm-6">
        <div class="card card-stats">
          <div class="card-header card-header-warning card-header-icon">
            <div class="card-icon">
              <i class="material-icons">group</i>
            </div>
            <p class="card-category">Suppliers</p>
            <h3 class="card-title">{$data.stats->suppliers}</h3>
          </div>
          <div class="card-footer">
            <div class="stats">
              <i class="material-icons">group</i>
              <a href="{$baseUrl}/app/suppliers" class="text-info">View Suppliers</a>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-6 col-sm-6">
        <div class="card card-stats">
          <div class="card-header card-header-success card-header-icon">
            <div class="card-icon">
              <i class="material-icons fa-rotate-90">double_arrow</i>
            </div>
            <p class="card-category">Income</p>
            <h3 class="card-title">{$data.stats->income}</h3>
          </div>
          <div class="card-footer">
            <div class="stats">
              <i class="material-icons fa-rotate-90">double_arrow</i> Total Income
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-6 col-sm-6">
        <div class="card card-stats">
          <div class="card-header card-header-rose card-header-icon">
            <div class="card-icon">
              <i class="material-icons fa-rotate-270">double_arrow</i>
            </div>
            <p class="card-category">Expenses</p>
            <h3 class="card-title">{$data.stats->expenses}</h3>
          </div>
          <div class="card-footer">
            <div class="stats">
              <i class="material-icons fa-rotate-270">double_arrow</i> Total Expenses
            </div>
          </div>
        </div>
      </div>

    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="card card-chart">
          <div class="card-header card-header-success">
            <div class="ct-chart" id="dailySalesChart"></div>
          </div>
          <div class="card-body">
            <h4 class="card-title">Income History</h4>
            <p class="card-category">Income for the month of {date("M Y")}</p>
          </div>
          <div class="card-footer">
            <div class="stats">
              <i class="material-icons">access_time</i>
              &nbsp;Last Updated&nbsp;<strong>{date("D d M Y h:mA")}</strong>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="card card-chart">
          <div class="card-header card-header-warning">
            <div class="ct-chart" id="completedTasksChart"></div>
          </div>
          <div class="card-body">
            <h4 class="card-title">Expenses History</h4>
            <p class="card-category">Expenses for the month of {date("M Y")}</p>
          </div>
          <div class="card-footer">
            <div class="stats">
              <i class="material-icons">access_time</i>
              &nbsp;Last Updated&nbsp;<strong>{date("D d M Y h:mA")}</strong>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header card-header-tabs card-header-primary">
            <h4 class="card-title">
              <i class="material-icons">local_shipping</i> Stock In
            </h4>
          </div>
          <div class="card-body">
            <div class="tab-pane" id="stockOut">
              <table class="table">
                <thead class="text-primary">
                <tr>
                  <th class="text-center">#</th>
                  <th>Product</th>
                  <th class="text-right">Quantity</th>
                  <th class="text-right">Total</th>
                </tr>
                </thead>
                <tbody>
                {counter start=0 print=false}
                {foreach $data.stockIn as $stockIn}
                  <tr>
                    <td class="text-center">{counter print=true}</td>
                    <td>{$stockIn->product_name}</td>
                    <td class="text-right">{$stockIn->quantity}</td>
                    <td class="text-right">{$stockIn->total_amount}</td>
                  </tr>
                    {foreachelse}
                  <tr>
                    <td colspan="5" class="text-center">No Content</td>
                  </tr>
                {/foreach}
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="card">
          <div class="card-header card-header-tabs card-header-success">
            <h4 class="card-title">
              <i class="material-icons">shopping_cart</i> Stock Out
            </h4>
          </div>
          <div class="card-body">
            <div class="tab-pane" id="stockOut">
              <table class="table">
                <thead class="text-success">
                <tr>
                  <th class="text-center">#</th>
                  <th>Product</th>
                  <th class="text-right">Quantity</th>
                  <th class="text-right">Total</th>
                </tr>
                </thead>
                <tbody>
                {counter start=0 print=false}
                {foreach $data.stockOut as $stockOut}
                  <tr>
                    <td class="text-center">{counter print=true}</td>
                    <td>{$stockOut->product_name}</td>
                    <td class="text-right">{$stockOut->quantity}</td>
                    <td class="text-right">{$stockOut->total_amount}</td>
                  </tr>
                    {foreachelse}
                  <tr>
                    <td colspan="5" class="text-center">No Content</td>
                  </tr>
                {/foreach}
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>