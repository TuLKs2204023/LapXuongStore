$ = document.querySelector.bind(document);

function WishListHandler({
    url = "",
    token = "",
    loginUrl = "",
    productHearts = ".product-list-icon",
    headerHeart = ".heart-icon",
    productHeart = ".product-details .heart-icon",
}) {
    function initList(productList) {
        const heartIcons = productList.querySelectorAll(productHearts);
        if (!heartIcons) return false;
        Array.from(heartIcons).forEach((heart) => {
            heart.addEventListener("click", handleHeartEvent, false);
        });
    }

    function initItem() {
        const pHeart = $(productHeart);
        if (!pHeart) return false;
        pHeart.addEventListener("click", handleHeartEvent, false);
    }

    function handleHeartEvent(e) {
        e.preventDefault();
        // Process to call HttpRequest
        processUpdateWishList(e.currentTarget, renderWishList);
    }

    // Function to update view
    function renderWishList(res, heart) {
        const headerHeartIcon = $(headerHeart);
        const headerHeartText = headerHeartIcon.querySelector(
            ".icon_heart_alt + span"
        );
        headerHeartText.innerHTML = res.totalWishlist;
        const heartIcon = heart.querySelector("i");
        if (res.action === "add") {
            heartIcon.classList.replace("fa-heart-o", "fa-heart");
        } else {
            heartIcon.classList.replace("fa-heart", "fa-heart-o");
        }
    }

    // Process to call HttpRequest to update WishList
    function processUpdateWishList(heart, cb) {
        const params = {
            url,
            _token: token,
            pId: heart.closest(".product-index").dataset.index,
        };

        const ajaxReq = new XMLHttpRequest();

        ajaxReq.onreadystatechange = () => {
            if (ajaxReq.readyState == 4 && ajaxReq.status == 200) {
                const res = JSON.parse(ajaxReq.responseText);
                if (res.status === "aborted") {
                    import("../KienJs/confirmDialog.js").then((mDialog) => {
                        const confirmWishlist = mDialog.ConfirmDialog({
                            route: loginUrl,
                            message:
                                "Before adding or removing items in the Wishlist, please try to login first. Thank you.",
                            btnLabel: "Login",
                        });
                        confirmWishlist.showDialog();
                    });
                } else {
                    import("../KienJs/toast.js").then((mToast) => {
                        const type = {
                            add: "Item has been ADDED to your Wishlist successfully.",
                            remove: "Item has been REMOVED from your Wishlist successfully.",
                        };
                        cb(res, heart);
                        mToast.showSuccessToast({
                            message: type[res.action],
                        });
                    });
                }
            }
        };

        ajaxReq.open("POST", url, true);
        ajaxReq.setRequestHeader(
            "Content-type",
            "application/json;charset=UTF-8"
        );
        ajaxReq.send(JSON.stringify(params));
    }
    return {
        initList,
        initItem,
    };
}
