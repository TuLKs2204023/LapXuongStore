import { showSuccessToast, showErrorToast } from "./toast.js";
export {
    CartHandler,
    getParent,
    processUpdateCartPage,
    updateCartHeader,
    preventCheckout,
};

$ = document.querySelector.bind(document);

function CartHandler({
    url = "",
    token = "",
    isUpdate = false,
    inputName = "product-quantity",
    selectors: {
        cartOrBtnSelector = ".add-to-cart",
        cartItemSelector = "",
        summaryContSelector = "",
        summariesSelector = "",
        headerCartSelector = ".minicart",
        headerCartItemsSelector = ".select-items",
        headerCartCheckoutSelector = ".checkout-btn",
        checkoutBtnSelector = ".proceed-checkout-btn",
    },
}) {
    const selectors = {
        cartOrBtnSelector,
        cartItemSelector,
        summaryContSelector,
        summariesSelector,
        headerCartSelector,
        headerCartItemsSelector,
        headerCartCheckoutSelector,
        checkoutBtnSelector,
    };

    const cartContainer = $(selectors["cartOrBtnSelector"]);
    if (!cartContainer) return false;

    if (isUpdate) {
        // Add events in ViewCart page
        const inputs = cartContainer.querySelectorAll(
            `input[name="${inputName}"]`
        );
        if (inputs) {
            const checkoutBtn = $(selectors["checkoutBtnSelector"]);

            // Disable check-out Button if cart is empty
            preventCheckout(checkoutBtn, !inputs.length);

            // Add event for Increase|Decrease button
            for (let input of inputs) {
                // Disable increase button whenever item is out-of-stock
                const incBtn = input.parentNode.querySelector(".inc.qtybtn");
                const stock = Number(input.dataset.stock);
                if (incBtn) {
                    disableButton(stock, 0, incBtn);
                }

                if (checkoutBtn) {
                    disableButton(stock, -1, checkoutBtn);
                }

                // Update ViewCart page whenever quantity is changed
                const selectedRow = getParent(
                    input,
                    selectors["cartItemSelector"]
                );
                const pid = selectedRow.dataset.index;
                const btns = input.parentNode.querySelectorAll(".qtybtn");
                for (let btn of btns) {
                    btn.addEventListener("click", (e) => {
                        cartUpdateHandler(
                            e,
                            input,
                            pid,
                            selectors,
                            processUpdateCartPage
                        );
                    });
                }
                input.oninput = (e) => {
                    cartUpdateHandler(
                        e,
                        input,
                        pid,
                        selectors,
                        processUpdateCartPage
                    );
                };
            }
        }
    } else {
        // Add events in Product page
        const input = document.querySelector(`input[name="${inputName}"]`);
        if (!input) return false;

        const pid = cartContainer.dataset.id;

        cartContainer.onclick = (e) => {
            cartUpdateHandler(e, input, pid, selectors, callback);
        };

        function callback({ res, selectors }) {
            if (res.stockBalance < 0) {
                showErrorToast({
                    message: "Cannot add more items due to out of stock.",
                    duration: 3000,
                });
                return false;
            }

            // Update header cartItems
            updateCartHeader(res, selectors);

            showSuccessToast({
                message: "Card item(s) added successfully.",
                duration: 3000,
            });
        }
    }

    // Process to call HttpRequest
    function cartUpdateHandler(e, input, pid, selectors, callback) {
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
                        input,
                        selectors,
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
}

// Function to update Total Amount of items
function processUpdateCartPage({ res, input, selectors }) {
    // Update header cartItems
    updateCartHeader(res, selectors);

    // Update current item Price
    if (input) {
        const itmPrice =
            input.parentNode.parentNode.parentNode.nextElementSibling;
        // input.parentNode.parentNode.parentNode.nextElementSibling.querySelector(".total-price");

        if (itmPrice) {
            itmPrice.innerHTML = res.curVal;
        }
    }

    // Update Summary section
    const sumContainer = $(selectors["summaryContSelector"]);
    if (sumContainer) {
        const sums = sumContainer.querySelectorAll(
            selectors["summariesSelector"]
        );
        if (sums) {
            for (let sum of sums) {
                sum.innerHTML = res.totalVal + " VND";
            }
        }
    }

    // Update cart content when it becomes empty
    if (!res.totalQty) {
        const cartContainer = $(selectors["cartOrBtnSelector"]);
        cartContainer.innerHTML = `
            <tr class="pr-cart-item">
                <td colspan="6">
                    &#128557; Too cold, you're not going to leave me empty, are you? &#128557;
                </td>
            </tr>
        `;
    }

    // Disable Increase button whenever item comes out-of-stock
    let incBtn;
    if (input) {
        incBtn = input.parentNode.querySelector(".inc.qtybtn");
        disableButton(res.stockBalance, 0, incBtn);
    }

    // Disable Checkout button whenever arbittrary item comes out-of-stock
    const checkoutBtn = $(selectors["checkoutBtnSelector"]);
    if (checkoutBtn) disableButton(res.stockBalance, -1, checkoutBtn);
}

// Function to update Header Cart
function updateCartHeader(res, selectors) {
    const checkoutBtn = $(selectors["checkoutBtnSelector"]);
    if (checkoutBtn) disableButton(res.stockBalance, -1, checkoutBtn);
    
    const headerContainer = $(selectors["headerCartSelector"]);
    const headerCheckoutBtn = headerContainer.querySelector(
        selectors["headerCartCheckoutSelector"]
    );
    if (headerCheckoutBtn)
        disableButton(res.stockBalance, -1, headerCheckoutBtn);

    if (headerContainer) {
        const headerCartCount = headerContainer.querySelector(".index");
        if (headerCartCount) {
            const totalQty = res.totalQty;
            headerCartCount.innerHTML = totalQty;
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

// Function to disable increase button whenever item is out-of-stock
function disableButton(stockBal, num, incBtn) {
    if (stockBal <= num) {
        incBtn.addEventListener("click", disableHandler, true);
    } else {
        incBtn.removeEventListener("click", disableHandler, true);
    }
}

// Function to prevent proceed Check-out while Cart is empty
function preventCheckout(checkoutBtn, isEmpty) {
    if (checkoutBtn) {
        checkoutBtn.addEventListener("click", (e) => {
            if (isEmpty) {
                e.preventDefault();
                showErrorToast({
                    message:
                        "Nothing to carry out, please add some items first.",
                    duration: 3000,
                });
            }
        });
    }
}
