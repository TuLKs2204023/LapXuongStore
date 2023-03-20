export { initTable };

function initTable(tableSelector, showParams, delParams) {
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

    // Controll items displayed on nav-bar & search-page
    if (showParams) {
        initButton(cateTable, showParams, "CateGroupsHandler");
    }

    // Controll delete items on index page
    if (delParams) {
        delParams.tableBodySelector = tableSelector + " tbody";
        initButton(cateTable, delParams, "ItemsDeleteHandler");
    }

    // Initialize funtion for buttons
    function initButton(
        cateTable,
        { sourceJs = "", url = "", token = "", tableBodySelector = "" },
        itemsHandler
    ) {
        import(sourceJs).then((moduleCates) => {
            const mCates = moduleCates[itemsHandler]({
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
