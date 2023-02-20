import { showSuccessToast, showErrorToast } from "./toast.js";
export { CartHandler, getParent, updateCart, updateCartHeader };

$ = document.querySelector.bind(document);

export default function CartHandler({
    url = "",
    token = "",
    isUpdate = false,
    cartOrBtnSelector = ".add-to-cart",
    cartItemSelector = "",
    inputName = "product-quantity",
    summaryContSelector = "",
    summariesSelector = "",
    headerCartSelector = ".minicart",
}) {
    const cartContainer = $(cartOrBtnSelector);

    if (!cartContainer) {
        return false;
    }
    if (isUpdate) {
        const inputs = cartContainer.querySelectorAll(
            `input[name="${inputName}"]`
        );
        if (!inputs) {
            return false;
        }
        for (let input of inputs) {
            const selectedRow = getParent(input, cartItemSelector);
            const pid = selectedRow.dataset.index;
            const btns = input.parentNode.querySelectorAll(".qtybtn");

            for (let btn of btns) {
                btn.addEventListener("click", (e) => {
                    cartUpdateHandler(e, input, pid, updateCart);
                });
            }

            input.oninput = (e) => {
                cartUpdateHandler(e, input, pid, updateCart);
            };
        }
    } else {
        const input = document.querySelector(`input[name="${inputName}"]`);

        if (!input) {
            return false;
        }

        const pid = cartContainer.dataset.id;

        cartContainer.onclick = (e) => {
            cartUpdateHandler(e, input, pid, callback2);
        };

        function callback2(
            ajaxHttpRequest,
            cartOrBtnSelector,
            summaryContSelector,
            summariesSelector,
            input
        ) {
            showSuccessToast();
        }
    }

    function cartUpdateHandler(e, input, pid, callback) {
        e.preventDefault();
        setTimeout(() => {
            const params = {
                pid,
                quantity: input.value,
                update: isUpdate,
                _token: token,
            };

            const ajaxHttpRequest = new XMLHttpRequest();

            ajaxHttpRequest.onreadystatechange = () => {
                if (
                    ajaxHttpRequest.readyState == 4 &&
                    ajaxHttpRequest.status == 200
                ) {
                    callback(
                        ajaxHttpRequest,
                        cartOrBtnSelector,
                        summaryContSelector,
                        summariesSelector,
                        input
                    );
                    updateCartHeader(ajaxHttpRequest, headerCartSelector);
                }
            };

            ajaxHttpRequest.open("POST", url, true);
            ajaxHttpRequest.setRequestHeader(
                "Content-type",
                "application/json;charset=UTF-8"
            );
            ajaxHttpRequest.send(JSON.stringify(params));
        }, 1);
    }
}

// Function to update Total Amount of items
function updateCart(
    ajaxHttpRequest,
    cartOrBtnSelector,
    summaryContSelector,
    summariesSelector,
    input
) {
    const res = JSON.parse(ajaxHttpRequest.responseText);
    if (input) {
        const itmPrice =
            input.parentNode.parentNode.parentNode.nextElementSibling;
        // input.parentNode.parentNode.parentNode.nextElementSibling.querySelector(".total-price");

        if (itmPrice) {
            itmPrice.innerHTML = res.curVal;
        }
    }

    const sumContainer = $(summaryContSelector);
    if (sumContainer) {
        const sums = sumContainer.querySelectorAll(summariesSelector);
        if (sums) {
            for (let sum of sums) {
                sum.innerHTML = res.totalVal + " VND";
            }
        }
    }

    if (!res.totalQty) {
        const cartContainer = $(cartOrBtnSelector);
        cartContainer.innerHTML = `
            <li class="pr-cart-item">No product</li>
        `;
    }
}

// Function to update Header Cart
function updateCartHeader(ajaxHttpRequest, headerCartSelector) {
    const res = JSON.parse(ajaxHttpRequest.responseText);
    const headerContainer = $(headerCartSelector);
    
    if (headerContainer) {
        const headerCart = headerContainer.querySelector(".index");
        if (headerCart) {
            const totalQty = res.totalQty;
            headerCart.innerHTML = totalQty;
            // totalQty > 1 ? `${totalQty} items` : `${totalQty} item`;
        }
    }
}

// Get DIV's parent of current input
function getParent(input, formGrpSelector) {
    let parent = input.parentElement;
    while (parent) {
        if (parent.matches(formGrpSelector)) {
            return parent;
        }
        parent = parent.parentElement;
    }
}
