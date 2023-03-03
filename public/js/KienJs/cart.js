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
    checkoutBtnSelector = ".proceed-checkout-btn",
}) {
    const cartContainer = $(cartOrBtnSelector);
    if (!cartContainer) {
        return false;
    }

    if (isUpdate) {
        // Add events in ViewCart page
        const inputs = cartContainer.querySelectorAll(
            `input[name="${inputName}"]`
        );
        if (inputs) {
            if (inputs.length) {
                for (let input of inputs) {
                    // Disable increase button whenever item is out-of-stock
                    const incBtn =
                        input.parentNode.querySelector(".inc.qtybtn");
                    const stock = Number(input.dataset.stock);
                    if (incBtn) {
                        disableButton(stock, 0, incBtn);
                    }

                    const checkoutBtn = $(checkoutBtnSelector);
                    if (checkoutBtn) {
                        disableButton(stock, -1, checkoutBtn);
                    }

                    // Update ViewCart page whenever quantity is changed
                    const selectedRow = getParent(input, cartItemSelector);
                    const pid = selectedRow.dataset.index;
                    const btns = input.parentNode.querySelectorAll(".qtybtn");
                    for (let btn of btns) {
                        btn.addEventListener("click", (e) => {
                            cartUpdateHandler(e, input, pid, updateCartPage);
                            // stock = Number(input.dataset.stock);
                            // disableButton(stock, 0, incBtn);
                        });
                    }
                    input.oninput = (e) => {
                        cartUpdateHandler(e, input, pid, updateCartPage);
                    };
                }

                // Disable check-out process whenever encounters out-of-stock items
                const checkoutBtn = $(checkoutBtnSelector);
                if (checkoutBtn) {
                    checkoutBtn.addEventListener("click", (e) => {
                        const isAllValid = Array.from(inputs).every((input) => {
                            return input.dataset.stock >= 0;
                        });
                        if (!isAllValid) {
                            e.preventDefault();
                            showErrorToast({
                                message:
                                    "Cannot add more items due to out of stock.",
                                duration: 3000,
                            });
                            return false;
                        }
                    });
                    // const stock = Number(input.dataset.stock);
                    // disableButton(stock, -1, checkoutBtn);
                }
            } else {
                // Disable check-out Button if cart is empty
                const checkoutBtn = $(checkoutBtnSelector);
                if (checkoutBtn) {
                    checkoutBtn.addEventListener("click", (e) => {
                        e.preventDefault();
                        showErrorToast({
                            message: "Nothing in cart for checking out.",
                            duration: 3000,
                        });
                        return false;
                    });
                }
            }
        }
    } else {
        // Add events in Product page
        const input = document.querySelector(`input[name="${inputName}"]`);

        if (!input) {
            return false;
        }

        const pid = cartContainer.dataset.id;

        cartContainer.onclick = (e) => {
            cartUpdateHandler(e, input, pid, callback);
        };

        function callback({ res, headerCartSelector }) {
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

    // Process to call HttpRequest
    function cartUpdateHandler(e, input, pid, callback) {
        e.preventDefault();
        setTimeout(() => {
            const params = {
                pid,
                quantity: input.value,
                update: isUpdate,
                _token: token,
            };

            const ajaxReq = new XMLHttpRequest();

            ajaxReq.onreadystatechange = () => {
                if (ajaxReq.readyState == 4 && ajaxReq.status == 200) {
                    const res = JSON.parse(ajaxReq.responseText);
                    input.dataset.stock = res.stockBalance;

                    callback({
                        e,
                        res,
                        cartOrBtnSelector,
                        summaryContSelector,
                        summariesSelector,
                        headerCartSelector,
                        input,
                    });
                }
            };

            ajaxReq.open("POST", url, true);
            ajaxReq.setRequestHeader(
                "Content-type",
                "application/json;charset=UTF-8"
            );
            ajaxReq.send(JSON.stringify(params));
        }, 1);
    }

    // Function to disable increase button whenever item is out-of-stock
    function disableButton(stockBal, num, incBtn) {
        if (stockBal <= num) {
            incBtn.addEventListener("click", disableHandler, true);
        } else {
            incBtn.removeEventListener("click", disableHandler, true);
        }
    }
}

// Function to update Total Amount of items
function updateCartPage({
    res,
    cartOrBtnSelector,
    summaryContSelector,
    summariesSelector,
    headerCartSelector,
    input,
}) {
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
