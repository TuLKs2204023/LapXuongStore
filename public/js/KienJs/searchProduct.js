$ = document.querySelector.bind(document);

function SearchHandler({
    paginateConfigs: { pageDefaultItems = 16, pageDefaultSort = 0 },
    price: { priceMin = 0, priceMax = 500000000 },
    selectors: {
        sidebarSelector = ".produts-sidebar-filter",
        productListSelector = ".product-search",
        paginateSelector = ".loading-more",
        paginateConfigSelector = ".product-show-option",
        paginateShowSelector = ".nice-select.p-show",
        paginateSortSelector = ".sorting.nice-select",
    },
    wishList,
}) {
    const selectors = {
        sidebarSelector,
        productListSelector,
        paginateSelector,
        paginateConfigSelector,
        paginateShowSelector,
        paginateSortSelector,
    };
    const pageConfigCont = $(selectors.paginateConfigSelector);
    const currentUrl = getCurrentUrlInfo();
    const queries = {
        show: pageDefaultItems,
        sort: pageDefaultSort,
        slug: currentUrl.slug,
        price: [priceMin, priceMax],
    };

    // Add event for filtering Checboxes & Pagination
    function initSearch() {
        const sidebar = $(selectors.sidebarSelector);
        const cateInputs = sidebar.querySelectorAll(
            "input[type='checkbox']:not([disabled])"
        );

        processPaginate(
            appendQueriesToUrl(new URL(currentUrl.mainPath), queries)
        );

        // Add event for filtering Categories-checboxes
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
                    if (!value.length && key !== "show" && key !== "sort")
                        delete queries[key];
                });

                const url = new URL(currentUrl.mainPath);

                // Process to call HttpRequest
                processQueries(appendQueriesToUrl(url, queries));
            });
        });

        // Configuring number of items Displayed per Pagination page
        processPaginateConfig(
            "show",
            selectors.paginateShowSelector,
            pageDefaultItems
        );

        // Configuring Sorting of items on Pagination page
        processPaginateConfig(
            "sort",
            selectors.paginateSortSelector,
            pageDefaultSort
        );

        function processPaginateConfig(type, configSelector, pageDefault) {
            paginateConfigHandler({
                type,
                configCont: pageConfigCont,
                configSelector,
                currentUrl,
                queries,
                pageDefault,
            });
        }
    }

    // Function to configure Sorting of items on Pagination page
    function paginateConfigHandler({
        type,
        configCont,
        configSelector,
        currentUrl,
        queries,
        pageDefault,
    }) {
        const configSelect = configCont.querySelector(configSelector);
        const configOpts = configSelect.querySelectorAll("ul li");

        configOpts.forEach((opt) => {
            opt.addEventListener("click", (e) => {
                const paginateConfig = opt.dataset.value || pageDefault;
                queries[type] = paginateConfig;

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
                const productList = renderSearch(ajaxReq.responseText);
                wishList.initList(productList);
            }
        };
        ajaxReq.open("GET", url, true);
        ajaxReq.setRequestHeader("Content-type", "html");
        ajaxReq.send();
    }

    // Function to render search view
    function renderSearch(res) {
        const productList = $(selectors.productListSelector);
        productList.innerHTML = res;

        // Add ajaxRequest to pagination buttons
        renderPaginateBtns(selectors, queries);
        return productList;
    }

    // Function to add ajaxRequest to pagination buttons
    function renderPaginateBtns(selectors, queries) {
        const paginate = $(selectors.paginateSelector);
        const paginateLinks = paginate.querySelectorAll(".pagination li a");

        paginateLinks.forEach((link) => {
            link.addEventListener("click", (e) => {
                e.preventDefault();
                const url = new URL(link.href);

                // Process to call HttpRequest
                processPaginate(appendQueriesToUrl(url, queries), true);
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
    function processPaginate(page, scrollToTop = false) {
        const ajaxReq = new XMLHttpRequest();
        ajaxReq.onreadystatechange = () => {
            if (ajaxReq.readyState == 4 && ajaxReq.status == 200) {
                const productList = renderSearch(ajaxReq.responseText);
                if (scrollToTop) {
                    window.scrollTo({ top: 60, behavior: "smooth" });
                }
                wishList.initList(productList);
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
