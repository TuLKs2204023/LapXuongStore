export { initTable };

function initTable(tableSelector, ...params) {
    const cateTable = $(tableSelector).DataTable({
        responsive: true,
        lengthChange: true,
        autoWidth: true,
        buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"],
    });
    cateTable
        .buttons()
        .container()
        .appendTo(tableSelector + "_wrapper .col-md-6:eq(0)");

    // Control event buttons of table-element
    params.forEach((param) => {
        if (param) {
            param.tableBodySelector = tableSelector + " tbody";
            initButton(cateTable, param);
        }
    });

    // Initialize funtion for buttons
    function initButton(
        cateTable,
        {
            sourceJs = "",
            handler = "",
            url = "",
            token = "",
            tableBodySelector = "",
        }
    ) {
        import(sourceJs).then((moduleCates) => {
            const mCates = moduleCates[handler]({
                url,
                token,
                cateTable,
                selectors: {
                    tableSelector: tableBodySelector,
                },
            });
        });
    }
}
