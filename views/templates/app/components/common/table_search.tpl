<div class="form-group">
    <label class="bmd-label-floating" for="datatable_search">
      <i class="material-icons" style="float: left">search</i> Search
    </label>
    <input id="datatable_search" type="text" class="form-control"
           onkeyup="new TableSearch('{$table}', '{$index}').search(this.value)"/>
</div>