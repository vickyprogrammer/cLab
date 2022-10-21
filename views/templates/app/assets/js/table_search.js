class TableSearch {
    /**
     * TableSearch constructor
     * @param {string} tableId
     * @param {string} index
     */
    constructor(tableId, index) {
        /**
         * Table Element
         * @type {HTMLElement}
         */
        this.table = document.getElementById(tableId);
        /**
         * Column index to search
         * @type {number[]}
         */
        this.index = index.split(',').map(i => Number(i.trim()));
    }

    /**
     * Search the table
     * @param {string} keyword
     */
    search(keyword) {
        /**
         * Table row element element collection
         * @type {HTMLCollection}
         */
        const tableRows = this.table.children[1].children;
        for(let row of tableRows) {
            if (row.children.length > 1) {
                let found = false;
                for(let col in row.children) {
                    const index = Number(col);
                    if (!isNaN(index)) {
                        if (this.index.includes(index)) {
                            const content = row.children[index].textContent.toLowerCase();
                            if (content.includes(keyword.toLowerCase())) {
                                found = true;
                            }
                        }
                    }
                }
                if (!found) {
                    row.style.display = 'none';
                } else {
                    row.style.display = 'table-row';
                }
            }
        }
    }
}