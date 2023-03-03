import { showSuccessToast } from "./toast.js";
import { getParent, updateCartPage, updateCartHeader } from "./cart.js";

export { ConfirmDialog };

$ = document.querySelector.bind(document);

function ConfirmDialog({
    processUrl = "",
    processToken = "",
    rowsContainer = ".products-cart",
    selectedContainer = ".pr-cart-item",
    deleteBtn = "a.btn.btn-delete",
    cartOrBtnSelector = ".products-cart",
    summaryContSelector = ".order-summary",
    summariesSelector = ".ajax-summary",
    headerCartSelector = ".minicart",
}) {
    const selectedItm = {
        code: "",
        row: "",
        scrollY: "",
    };

    const dialog = {
        offset_top: "",
        offset_left: 0,
    };

    const dialog_container = $(".dialog-container");

    if (!dialog_container) {
        return false;
    }
    const dialog_content = dialog_container.querySelector(".dialog-content");

    if (!dialog_content) {
        return false;
    }

    // Add Event-Listener for buttons
    const rows = $(rowsContainer);
    if (!rows) {
        return false;
    }
    const confirmBtn = rows.querySelectorAll(deleteBtn);
    if (confirmBtn) {
        for (let btn of confirmBtn) {
            btn.onclick = (e) => {
                e.preventDefault();
                selectedItm.row = getParent(e.target, selectedContainer);
                selectedItm.code = selectedItm.row.dataset.index;
                setTimeout(() => {
                    showDialog();
                }, 0);
            };
        }
    }

    const proceedBtn = dialog_container.querySelector(".proceed-btn");
    if (proceedBtn) {
        proceedBtn.onclick = (e) => {
            e.preventDefault();
            const phpRequest = new PhpAjaxRequest(
                selectedItm,
                processUrl,
                processToken,
                deleteSuccess
            );
            phpRequest.processDelete();
        };
    }
    const cancelBtns = dialog_container.querySelectorAll(".cancel-btn");
    if (cancelBtns) {
        for (let btn of cancelBtns) {
            btn.onclick = (e) => {
                e.preventDefault();
                hideDialog();
            };
        }
    }
    window.onclick = (e) => {
        if (e.target === dialog_container) {
            e.preventDefault();
            hideDialog();
        }
    };

    // Defining function assigned to Delete Confirmation event
    function showDialog() {
        if (
            !dialog_container.style.display ||
            dialog_container.style.display === "none"
        ) {
            selectedItm.scrollY = window.scrollY;
            window.scrollTo(0, selectedItm.scrollY || 0);

            dialog_container.style.display = "block";
            containerAnimate.animate(containerAnimate.type.fadeIn);
            contentAnimate.animate(contentAnimate.type.zoomIn);

            dialog.offset_left = dialog_content.offsetLeft;
            dialog.offset_top =
                50 -
                (dialog_content.offsetHeight / screen.height / 2) * 100 +
                "%";

            dialog_content.style.top = dialog.offset_top;
        }
    }

    // Defining function assigned to Delete Cancelation event
    function hideDialog() {
        containerAnimate.animate(containerAnimate.type.fadeOut);
        contentAnimate.animate(contentAnimate.type.zoomOut);
        // dialog.style.position = "";
        // dialog.style.top = "";
        window.scrollTo(0, selectedItm.scrollY || 0);
        setTimeout(() => {
            dialog_container.style.display = "none";

            dialog_content.style.left = 0;
            dialog_content.style.top = dialog.offset_top;
        }, 300);
    }

    function deleteSuccess(ajaxHttpRequest) {
        const res = JSON.parse(ajaxHttpRequest.responseText);
        updateCartPage({
            res,
            cartOrBtnSelector,
            summaryContSelector,
            summariesSelector,
            headerCartSelector,
        });
        updateCartHeader(res, headerCartSelector);
        hideDialog();

        setTimeout(() => {
            showSuccessToast({
                title: "Success",
                message: "Cart item removed successfully.",
                duration: 3000,
            });
        }, 100);
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
            posX_cur = posX_base - e.clientX + dialog.offset_left;
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

    // Defining for calling PhpAjax functions
    class PhpAjaxRequest {
        constructor(selector, processUrl, token, callback) {
            this.selector = selector;
            this.processUrl = processUrl;
            this.token = token;
            this.callback = callback;
        }
        // Defining function to proceed Delete confirmation
        processDelete() {
            const iRow = this.selector["row"];
            const params = {
                pid: iRow.dataset.index,
                _token: this.token,
            };

            const ajaxHttpRequest = new XMLHttpRequest();

            ajaxHttpRequest.onreadystatechange = () => {
                if (
                    ajaxHttpRequest.readyState == 4 &&
                    ajaxHttpRequest.status == 200
                ) {
                    iRow.remove();
                    this.callback(ajaxHttpRequest);
                }
            };

            ajaxHttpRequest.open("POST", this.processUrl, true);
            ajaxHttpRequest.setRequestHeader(
                "Content-type",
                "application/json;charset=UTF-8"
            );
            ajaxHttpRequest.send(JSON.stringify(params));
        }
    }
}
