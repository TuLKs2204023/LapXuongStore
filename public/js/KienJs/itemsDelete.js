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

    tableElement.addEventListener("click", (e) => {
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
    });

    function processDelete(ajaxReq, selectedItm, closeDialog) {
        const res = JSON.parse(ajaxReq.responseText);
        const msg = {
            success: "Item has been removed successfully.",
            aborted:
                "Item cannot be removed. Please make sure that there was no any product's specification references to this item.",
            orderExisted:
                "This product has been placed order(s), please check again.",
            stockExisted:
                "This product has stock movement(s), please check again.",
            priceExisted:
                "This product has stock movement(s), please check again.",
        };
        switch (res.status) {
            case "aborted":
            case "orderExisted":
            case "stockExisted":
            case "priceExisted":
                displayMessage(
                    msg[res.status],
                    showErrorToast,
                    6500,
                    closeDialog
                );
                return false;

            case "success":
                // Remove selected-item in items List
                selectedItm.pRow.remove();
                selectedItm.row.remove();
                displayMessage(
                    msg[res.status],
                    showSuccessToast,
                    3000,
                    closeDialog
                );
                break;

            default:
                break;
        }
    }

    function displayMessage(msg, toast, duration, closeDialog) {
        closeDialog();
        setTimeout(() => {
            toast({
                title: "Error",
                message: msg,
                duration,
            });
        }, 100);
    }
}
