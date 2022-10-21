<nav aria-label="Pagination">
  <ul class="pagination justify-content-end pagination-info">
    <li class="page-item {if $data.pagination.currentPage lt 2}disabled{/if}">
      <a class="page-link"
         href="{if $data.pagination.currentPage lt 2}javascript:void(0);{else}?page={$data.pagination.currentPage - 1}{/if}"
         tabindex="-1">Previous</a>
    </li>
      {for $num=1 to $data.pagination.totalPages}
        <li class="page-item {if $num eq $data.pagination.currentPage}active{/if}">
          <a class="page-link" href="?page={$num}">{$num}</a>
        </li>
      {/for}
    <li class="page-item {if $data.pagination.currentPage eq $data.pagination.totalPages}disabled{/if}">
      <a class="page-link"
         href="{if $data.pagination.currentPage eq $data.pagination.totalPages}javascript:void(0);{else}?page={$data.pagination.currentPage + 1}{/if}">Next</a>
    </li>
  </ul>
</nav>