import { showSuccessToast } from "./toast.js";
import {
    getParent,
    processUpdateCartPage,
    updateCartHeader,
    deleteItemsCartHeader,
    preventCheckout,
} from "./cart.js";

export { ConfirmDialog, DeleteDialog };

$ = document.querySelector.bind(document);

function ConfirmDialog({
    request = "",
    route = "",
    message = "",
    btnLabel = "Proceed",
}) {
    const configs = {
        scrollY: "",
        offset_top: "",
        offset_left: 0,
    };

    const dialog_container = $("#myDialog");
    if (!dialog_container) return false;

    dialog_container.innerHTML = `
        <div class="dialog-content">
            <div class="dialog-header">
                <div><span class="close-btn cancel-btn"><i class="fa-solid fa-xmark"></i></span></div>
            </div>
            <div class="dialog-body">
                <h6 class="dialog-title">${message}</h6>
            </div>
            <div class="dialog-footer">
                <button class="form-submit standard warning proceed-btn">${btnLabel}</button>
                <button class="form-submit standard cancel-btn">Cancel</button>
            </div>
        </div>
    `;

    const dialog_content = dialog_container.querySelector(".dialog-content");
    if (!dialog_content) return false;

    const proceedBtn = dialog_container.querySelector(".proceed-btn");
    if (proceedBtn) {
        proceedBtn.onclick = (e) => {
            e.preventDefault();
            if (request instanceof ajaxRequest) {
                request.processAjaxReq(closeDialog);
            } else {
                window.location.href = route;
            }
        };
    }
    const cancelBtns = dialog_container.querySelectorAll(".cancel-btn");
    if (cancelBtns) {
        for (let btn of cancelBtns) {
            btn.onclick = (e) => {
                e.preventDefault();
                closeDialog();
            };
        }
    }
    window.onclick = (e) => {
        if (e.target === dialog_container) {
            e.preventDefault();
            closeDialog();
        }
    };

    // Defining function assigned to Delete Confirmation event
    function showDialog() {
        if (
            !dialog_container.style.display ||
            dialog_container.style.display === "none"
        ) {
            configs.scrollY = window.scrollY;
            window.scrollTo(0, configs.scrollY || 0);

            dialog_container.style.display = "block";
            containerAnimate.animate(containerAnimate.type.fadeIn);
            contentAnimate.animate(contentAnimate.type.zoomIn);

            configs.offset_left = dialog_content.offsetLeft;
            configs.offset_top =
                50 -
                (dialog_content.offsetHeight / screen.height / 2) * 100 +
                "%";

            dialog_content.style.top = configs.offset_top;
        }
    }

    // Defining function assigned to Delete Cancelation event
    function closeDialog() {
        containerAnimate.animate(containerAnimate.type.fadeOut);
        contentAnimate.animate(contentAnimate.type.zoomOut);
        // configs.style.position = "";
        // configs.style.top = "";
        window.scrollTo(0, configs.scrollY || 0);
        setTimeout(() => {
            dialog_container.style.display = "none";

            dialog_content.style.left = 0;
            dialog_content.style.top = configs.offset_top;
        }, 300);
    }

    dragElement(dialog_content);

    // Defining function for making dialog Draggable
    function dragElement(ele) {
        let posX_cur = 0,
            posY_cur = 0,
            posX_base = 0,
            posY_base = 0;
        let dialogHeader = dialog_content.firstElementChild;

        if (dialogHeader) {
            // if present, the header is where you move the DIV from:
            dialogHeader.onmousedown = dragMouseDown;
        } else {
            // otherwise, move the DIV from anywhere inside the DIV:
            ele.onmousedown = dragMouseDown;
        }

        function dragMouseDown(e) {
            e = e || window.event;
            e.preventDefault();
            // get the mouse cursor position at startup:
            posX_base = e.clientX;
            posY_base = e.clientY;
            document.onmouseup = closeDragElement;
            // call a function whenever the cursor moves:
            document.onmousemove = elementDrag;
        }

        function elementDrag(e) {
            e = e || window.event;
            e.preventDefault();
            // calculate the new cursor position:
            posX_cur = posX_base - e.clientX + configs.offset_left;
            posY_cur = posY_base - e.clientY;
            posX_base = e.clientX;
            posY_base = e.clientY;
            // set the element's new position:
            ele.style.top = ele.offsetTop - posY_cur + "px";
            ele.style.left = ele.offsetLeft - posX_cur + "px";
        }

        function closeDragElement() {
            // stop moving when mouse button is released:
            document.onmouseup = null;
            document.onmousemove = null;
        }
    }

    const containerAnimate = makeAnimate(dialog_container);
    const contentAnimate = makeAnimate(dialog_content);

    // Defining function to make animation for dialog
    function makeAnimate(ele) {
        const type = {
            fadeIn: "fadeIn ease-in 0.3s",
            fadeOut: "fadeOut ease-out 0.3s 0.15s",
            zoomIn: "zoomIn cubic-bezier(0.36, 0.55, 0.19, 1) 0.4s",
            zoomOut: "zoomOut cubic-bezier(0.36, 0.55, 0.19, 1) 0.4s",
        };

        function animate(type) {
            ele.style.animation = type;
        }
        return { type, animate };
    }
    return {
        showDialog,
        closeDialog,
    };
}

function DeleteDialog({
    processUrl = "",
    processToken = "",
    selectors: {
        rowsContainer = ".products-cart",
        selectedContainer = ".pr-cart-item",
        deleteBtn = "a.btn.btn-delete",
        summaryContSelector = ".order-summary",
        summariesSelector = ".ajax-summary",
        headerCartSelector = ".minicart",
        headerCartItemsSelector = ".cart-header-list",
        checkoutBtnSelector = ".proceed-checkout-btn",
    },
}) {
    const selectors = {
        rowsContainer,
        selectedContainer,
        deleteBtn,
        cartOrBtnSelector: rowsContainer,
        summaryContSelector,
        summariesSelector,
        headerCartSelector,
        headerCartItemsSelector,
        checkoutBtnSelector,
    };

    const selectedItm = {
        code: "",
        row: "",
    };

    // Add Event-Listener for buttons
    const rows = $(selectors["rowsContainer"]);
    if (!rows) return false;

    const confirmBtn = rows.querySelectorAll(selectors["deleteBtn"]);
    if (confirmBtn) {
        for (let btn of confirmBtn) {
            btn.onclick = (e) => {
                e.preventDefault();
                selectedItm.row = getParent(
                    e.target,
                    selectors["selectedContainer"]
                );
                selectedItm.code = selectedItm.row.dataset.index;
                const ajaxReq = new ajaxRequest(
                    selectedItm,
                    processUrl,
                    processToken,
                    deleteSuccess
                );
                // Call confirm Dialog
                const confirmDialog = new ConfirmDialog({
                    request: ajaxReq,
                    message: "Are you sure to DELETE this item?",
                });

                setTimeout(() => {
                    confirmDialog.showDialog();
                }, 0);
            };
        }
    }

    function deleteSuccess(ajaxReq, closeDialog) {
        const res = JSON.parse(ajaxReq.responseText);
        processUpdateCartPage({
            res,
            selectors,
        });

        // Update header-cart total items count
        updateCartHeader(res, selectors);

        // Update quantities of items in header-cart
        const headerCartItems = $(selectors["headerCartItemsSelector"]);
        const cartItems = headerCartItems.querySelectorAll("tr.cart-section");
        deleteItemsCartHeader(res, headerCartItems, cartItems);

        // Check empty Cart
        const checkoutBtn = $(selectors["checkoutBtnSelector"]);
        if (checkoutBtn) {
            const productCart = document.getElementsByClassName(
                selectors["rowsContainer"].substring(1)
            )[0];
            if (productCart) {
                const productItms = productCart.getElementsByTagName("input");
                if (productItms) {
                    preventCheckout(checkoutBtn, !productItms.length);
                }
            }
        }

        closeDialog();

        setTimeout(() => {
            showSuccessToast({
                title: "Success",
                message: "Cart item removed successfully.",
                duration: 3000,
            });
        }, 100);
    }
}

// Define object for calling ajax-request
class ajaxRequest {
    constructor(selector, processUrl, token, callback) {
        this.selector = selector;
        this.processUrl = processUrl;
        this.token = token;
        this.callback = callback;
    }
    // Defining function to proceed Delete confirmation
    processAjaxReq(closeDialog) {
        const iRow = this.selector["row"];
        const params = {
            pid: iRow.dataset.index,
            _token: this.token,
        };

        const ajaxReq = new XMLHttpRequest();

        ajaxReq.onreadystatechange = () => {
            if (ajaxReq.readyState == 4 && ajaxReq.status == 200) {
                iRow.remove();
                this.callback(ajaxReq, closeDialog);
            }
        };

        ajaxReq.open("POST", this.processUrl, true);
        ajaxReq.setRequestHeader(
            "Content-type",
            "application/json;charset=UTF-8"
        );
        ajaxReq.send(JSON.stringify(params));
    }
}
