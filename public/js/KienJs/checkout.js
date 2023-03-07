import { showSuccessToast, showErrorToast } from "./toast.js";
export { CheckoutHandler, CouponHandler };

$ = document.querySelector.bind(document);

function CheckoutHandler({
    url = "",
    token = "",
    selectors: {
        checkoutBtnSelector = ".place-btn",
        checkoutSummarySelector = ".order-summaries",
    },
}) {
    const selectors = { checkoutBtnSelector, checkoutSummarySelector };
    const checkoutSummary = $(selectors["checkoutSummarySelector"]);
    if (!checkoutSummary) return false;

    const checkoutBtn = $(selectors["checkoutBtnSelector"]);
    if (!checkoutBtn) return false;
}

function CouponHandler({
    url = "",
    token = "",
    couponContSelector = ".discount-coupon",
    couponBtnSelector = ".coupon-btn",
    orderSummary: {
        orderCont = ".order-table",
        orderSubtotal = ".order-product-subtotal",
        orderDiscount = ".total-discount",
        orderTotal = ".total-price",
    },
}) {
    const couponCont = $(couponContSelector);
    if (!couponCont) return false;

    const couponBtn = couponCont.querySelector(couponBtnSelector);
    if (!couponBtn) return false;

    const orderSummary = {
        orderCont,
        orderSubtotal,
        orderDiscount,
        orderTotal,
    };

    // Add event to 'Apply' button for checking coupon Code
    couponBtn.addEventListener("click", checkCoupon);

    // function to check Coupon
    function checkCoupon(e, orderSummary) {
        e.preventDefault();
        const input = couponCont.querySelector("input");
        if (input) {
            processCheckCoupon(e, input, updateCoupon);
        }
    }

    // Function to update Order-table
    function updateOrder(res, orderSummary) {
        const orderCont = $(orderSummary.orderCont);
        if (!orderCont) return false;

        const orderSub = orderCont.querySelector(orderSummary.orderSubtotal);
        if (!orderSub) return false;

        const orderDiscount = orderCont.querySelector(
            `${orderSummary.orderDiscount} span`
        );
        const orderTotal = orderCont.querySelector(
            `${orderSummary.orderTotal} span`
        );
        if (orderDiscount && orderTotal) {
            const subVal = orderSub.dataset.value;

            // Update Discount Amount
            const discountAmt = subVal * (res.status ? res.coupon.discount : 0);
            const discountAmt_f = new Intl.NumberFormat("vi-VN").format(
                discountAmt
            );
            orderDiscount.innerHTML = discountAmt_f + " VND";
            const discountCont = orderDiscount.parentElement.querySelector("a");
            discountCont.innerHTML = `${
                100 * (res.status ? res.coupon.discount : 0)
            }`;

            // Update Total Amount
            const totalAmt = subVal - discountAmt;
            const totalAmt_f = new Intl.NumberFormat("vi-VN").format(totalAmt);
            orderTotal.innerHTML = totalAmt_f + " VND";
        }
    }

    // Function to update coupon section
    function updateCoupon({ res, input, e }) {
        const type = {
            success: `A coupon with ${
                res.status === "success" ? res?.coupon.discount * 100 : ""
            }% discount has been applied successfully. `,
            null: "Coupon code is incorrect, please try again.",
            false: "Coupon was already used, please try again.",
        };
        const couponBtn = e.target;
        if (input.value) {
            switch (res.status) {
                case "success":
                    // Disable input, change btn from 'Apply' to 'Edit'
                    couponCont.classList.remove("error");
                    const opts = {
                        inputReadOnly: true,
                        btnText: "Edit",
                        btnClassAction: "add",
                        btnListener: "removeEventListener",
                    };
                    updateInputField({
                        input,
                        couponCont,
                        couponBtn,
                        opts,
                    });

                    // Re-enable input, change btn from 'Edit' to 'Apply'
                    couponBtn.addEventListener("click", (e) => {
                        e.preventDefault();
                        const opts = {
                            inputReadOnly: false,
                            btnText: "Apply",
                            btnClassAction: "remove",
                            btnListener: "addEventListener",
                        };
                        updateInputField({
                            input,
                            couponCont,
                            couponBtn,
                            opts,
                        });
                    });
                    showSuccessToast({
                        message: type[res.status],
                    });
                    break;

                case null:
                case false:
                    couponCont.classList.add("error");
                    showErrorToast({
                        message: type[res.status],
                    });
                    break;
            }
        } else {
            couponCont.classList.remove("error");
        }
        // Update order table
        updateOrder(res, orderSummary);
    }

    function updateInputField({
        input,
        couponCont,
        couponBtn,
        opts: {
            inputReadOnly,
            contClass = "applied",
            btnText,
            btnClass = "site-btn-main",
            btnClassAction,
            btnListener,
        },
    }) {
        input.readOnly = inputReadOnly;
        couponCont.classList[btnClassAction](contClass);
        couponBtn.innerHTML = btnText;
        couponBtn.classList[btnClassAction](btnClass);
        couponBtn[btnListener]("click", checkCoupon);
    }

    // Process to call HttpRequest
    function processCheckCoupon(e, input, cb) {
        e.preventDefault();
        setTimeout(() => {
            const params = {
                couponCode: input.value,
                _token: token,
            };

            const ajaxReq = new XMLHttpRequest();

            ajaxReq.onreadystatechange = () => {
                if (ajaxReq.readyState == 4 && ajaxReq.status == 200) {
                    const res = JSON.parse(ajaxReq.responseText);

                    cb({ res, input, e });
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
