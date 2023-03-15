$ = document.querySelector.bind(document);

function SearchHandler({
    paginateConfig: { pageDefaultItems = 12, pageSorting = "" },
    price: { priceMin = 0, priceMax = 500000000 },
    selectors: {
        sidebarSelector = ".produts-sidebar-filter",
        productListSelector = ".product-search",
        paginateSelector = ".loading-more",
        paginateShowSelector = ".product-show-option",
    },
}) {
    const selectors = {
        sidebarSelector,
        productListSelector,
        paginateSelector,
        paginateShowSelector,
    };

    const currentUrl = getCurrentUrlInfo();
    const queries = {
        show: pageDefaultItems,
        slug: currentUrl.slug,
        price: [priceMin, priceMax],
    };

    // Add event for filtering Checboxes & Pagination
    function initSearch() {
        const sidebar = $(selectors["sidebarSelector"]);
        const cateInputs = sidebar.querySelectorAll(
            "input[type='checkbox']:not([disabled])"
        );

        // Add event for filtering Checboxes
        cateInputs.forEach((input) => {
            input.addEventListener("click", (e) => {
                const inputData = input.dataset.value.split("-");
                const cateName = inputData[0];
                const cateVal = Number(inputData[1]);
                if (!Array.isArray(queries[cateName])) {
                    queries[cateName] = [];
                }
                if (input.matches(":checked")) {
                    queries[cateName].push(cateVal);
                } else {
                    const cateIndex = queries[cateName].indexOf(cateVal);
                    queries[cateName].splice(cateIndex, 1);
                }

                Object.entries(queries).forEach(([key, value]) => {
                    if (!value.length && key !== "show") delete queries[key];
                });

                const url = new URL(currentUrl.mainPath);

                // Process to call HttpRequest
                processQueries(appendQueriesToUrl(url, queries));
            });
        });

        // Add event for filtering Pagination
        const paginateShow = $(selectors["paginateShowSelector"]);
        const paginateSelect = paginateShow.querySelector(
            ".nice-select.p-show"
        );
        const paginateOpts = paginateSelect.querySelectorAll("ul li");

        paginateOpts.forEach((opt) => {
            opt.addEventListener("click", (e) => {
                const paginateItms = opt.dataset.value || pageDefaultItems;
                queries["show"] = paginateItms;

                const url = new URL(currentUrl.mainPath);

                // Process to call HttpRequest
                processQueries(appendQueriesToUrl(url, queries));
            });
        });
    }

    // Function to Process to call HttpRequest
    function processQueries(url) {
        const ajaxReq = new XMLHttpRequest();
        ajaxReq.onreadystatechange = () => {
            if (ajaxReq.readyState == 4 && ajaxReq.status == 200) {
                renderSearch(ajaxReq.responseText);
            }
        };
        ajaxReq.open("GET", url, true);
        ajaxReq.setRequestHeader("Content-type", "html");
        ajaxReq.send();
    }

    // Function to render search view
    function renderSearch(res) {
        const productList = $(selectors["productListSelector"]);
        productList.innerHTML = res;

        const paginate = $(selectors["paginateSelector"]);
        const paginateLinks = paginate.querySelectorAll(".pagination li a");

        paginateLinks.forEach((link) => {
            link.addEventListener("click", (e) => {
                e.preventDefault();
                const url = new URL(link.href);

                // Process to call HttpRequest
                processPaginate(appendQueriesToUrl(url, queries));
            });
        });
    }

    // Function to Append params into URL
    function appendQueriesToUrl(url, params) {
        Object.keys(params).forEach((key) =>
            url.searchParams.append(key, params[key])
        );
        fetch(url);
        return url;
    }

    // Function to Process to call HttpRequest
    function processPaginate(page) {
        const ajaxReq = new XMLHttpRequest();
        ajaxReq.onreadystatechange = () => {
            if (ajaxReq.readyState == 4 && ajaxReq.status == 200) {
                renderSearch(ajaxReq.responseText, page);
                window.scrollTo({ top: 60, behavior: "smooth" });
            }
        };
        ajaxReq.open("GET", page, true);
        ajaxReq.setRequestHeader("Content-type", "html");
        ajaxReq.send();
    }

    // Function to extract information in current URL path
    function getCurrentUrlInfo() {
        const currentHref = window.location.href.replace("/search", "/shop");
        const searchHref = currentHref.search(/shop/);
        const tempSlug =
            searchHref < 0 ? "" : currentHref.substring(searchHref + 4);

        const slugRemovedPage = tempSlug.replace(/.page=[0-9]*/, "");

        const slug = slugRemovedPage.replace(/[\/\?]/, "");

        const mainPath =
            (searchHref < 0
                ? currentHref
                : currentHref.substring(0, searchHref + 4)) + "-search";

        return { slug, mainPath };
    }

    function updatePrice(min, max) {
        queries["price"][0] = Number(min);
        queries["price"][1] = Number(max);

        const url = new URL(currentUrl.mainPath);
        
        // Process to call HttpRequest
        processQueries(appendQueriesToUrl(url, queries));
    }

    return {
        initSearch,
        updatePrice,
    };
}
