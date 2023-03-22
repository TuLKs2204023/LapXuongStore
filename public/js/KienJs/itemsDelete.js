import { ConfirmDialog, AjaxDeleteRequest } from "./confirmDialog.js";
import { showSuccessToast, showErrorToast } from "./toast.js";

export { ItemsDeleteHandler };

const $ = document.querySelector.bind(document);

function ItemsDeleteHandler({
    url = "",
    token = "",
    cateTable,
    selectors: {
        tableSelector = "#productsMgmt tbody",
        deleteBtnSelector = "item-delete-btn",
    },
}) {
    const selectors = { tableSelector, deleteBtnSelector };
    const tableElement = $(selectors.tableSelector);

    if (!tableElement) return false;

    const processTableEle = (e) => {
        const pRow = cateTable.row(e.target.closest("tr"));
        const pId = e.target.closest("tr").dataset.id;
        const deleteBtnId = `${selectors.deleteBtnSelector}-${pId}`;

        const selectedItm = {
            code: "",
            row: "",
            pRow: "",
        };

        const deleteBtn = e.target.closest(".item-delete-btn");
        if (!deleteBtn) return false;
        if (deleteBtn.id == deleteBtnId) {
            e.preventDefault();
            selectedItm.row = e.target.closest("tr");
            selectedItm.code = selectedItm.row.dataset.id;
            selectedItm.pRow = pRow;

            const ajaxReq = new AjaxDeleteRequest(
                selectedItm,
                url,
                token,
                processDelete
            );
            // Call confirm Dialog
            const confirmDialog = new ConfirmDialog({
                request: ajaxReq,
                message: "Are you sure to DELETE this item?",
            });

            setTimeout(() => {
                confirmDialog.showDialog();
            }, 0);
        }
    };
    tableElement.addEventListener("click", processTableEle, false);

    function processDelete(ajaxReq, selectedItm, closeDialog) {
        const res = JSON.parse(ajaxReq.responseText);
        const msg = {
            success: "Item has been removed successfully.",
            aborted:
                "Item cannot be removed. There was some products belong to this category.",
            orderExisted:
                "Product cannot be removed. There was some orders belong to this product.",
            stockExisted:
                "This product has stock movement(s), please check again.",
            priceExisted:
                "This product has stock movement(s), please check again.",
        };
        switch (res.status) {
            case "success":
                // Remove selected-item in items List
                selectedItm.pRow.remove();
                selectedItm.row.remove();
                displayMessage(
                    "Success",
                    msg[res.status],
                    showSuccessToast,
                    3000,
                    closeDialog
                );
                break;

            default:
                displayMessage(
                    "Error",
                    msg[res.status],
                    showErrorToast,
                    6500,
                    closeDialog
                );
                return false;
        }
    }

    function displayMessage(title, msg, toast, duration, closeDialog) {
        closeDialog();
        setTimeout(() => {
            toast({
                title,
                message: msg,
                duration,
            });
        }, 100);
    }
}
