import { showSuccessToast, showErrorToast } from "./toast.js";
export { CartHandler, getParent, updateCartPage, updateCartHeader };

$ = document.querySelector.bind(document);

function CartHandler({
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
            const incBtn = input.parentNode.querySelector(".inc.qtybtn");
            let stock = Number(input.dataset.stock);
            disableIncrease(stock, incBtn);

            const selectedRow = getParent(input, cartItemSelector);
            const pid = selectedRow.dataset.index;
            const btns = input.parentNode.querySelectorAll(".qtybtn");

            for (let btn of btns) {
                btn.addEventListener("click", (e) => {
                    cartUpdateHandler(e, input, pid, updateCartPage);
                    stock = Number(input.dataset.stock);
                    // disableIncrease(stock, incBtn);
                });
            }

            input.onfocusout = (e) => {
                cartUpdateHandler(e, input, pid, updateCartPage);
                if (input.dataset.stock <= 0) {
                    showErrorToast({
                        message: "Cannot add more items due to out of stock.",
                        duration: 3000,
                    });
                    return false;
                }
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
            e,
            res,
            cartOrBtnSelector,
            summaryContSelector,
            summariesSelector,
            headerCartSelector,
            input
        ) {
            if (res.stockBalance < 0) {
                showErrorToast({
                    message: "Cannot add more items due to out of stock.",
                    duration: 3000,
                });
                return false;
            }

            // Update header cartItems
            updateCartHeader(res, headerCartSelector);

            showSuccessToast({
                message: "Card item(s) added successfully.",
                duration: 3000,
            });
        }
    }

    function disableIncrease(stock, incBtn) {
        if (stock <= 0) {
            incBtn.addEventListener("click", disableHandler, true);
        } else {
            incBtn.removeEventListener("click", disableHandler);
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
                    const res = JSON.parse(ajaxHttpRequest.responseText);
                    console.log(res);
                    input.dataset.stock = res.stockBalance;

                    callback(
                        e,
                        res,
                        cartOrBtnSelector,
                        summaryContSelector,
                        summariesSelector,
                        headerCartSelector,
                        input
                    );
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
function updateCartPage(
    e,
    res,
    cartOrBtnSelector,
    summaryContSelector,
    summariesSelector,
    headerCartSelector,
    input
) {
    // Update header cartItems
    updateCartHeader(res, headerCartSelector);

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
            <tr class="pr-cart-item"><td colspan="6">&#128557; Too cold, you're not going to leave me empty, are you? &#128557;</td></tr>
        `;
    }

    let incBtn;
    if (input) {
        incBtn = input.parentNode.querySelector(".inc.qtybtn");
        if (res.stockBalance <= 0) {
            incBtn.addEventListener("click", disableHandler, true);
            return;
        } else {
            incBtn.removeEventListener("click", disableHandler, true);
        }
    }
}

// Function to update Header Cart
function updateCartHeader(res, headerCartSelector) {
    const headerContainer = $(headerCartSelector);

    if (headerContainer) {
        const headerCart = headerContainer.querySelector(".index");
        if (headerCart) {
            const totalQty = res.totalQty;
            headerCart.innerHTML = totalQty;
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

// Disable click event
function disableHandler(e) {
    e.stopPropagation();
    e.preventDefault();
    showErrorToast({
        message: "Cannot add more items due to out of stock.",
        duration: 3000,
    });
}
