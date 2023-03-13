export { SearchHandler };

$ = document.querySelector.bind(document);

function SearchHandler({
    selectors: {
        sliderSelector = ".price-range",
        sidebarSelector = ".produts-sidebar-filter",
        productListSelector = ".product-search",
        paginateSelector = ".loading-more",
    },
}) {
    const selectors = {
        sliderSelector,
        sidebarSelector,
        productListSelector,
        paginateSelector,
    };

    const priceSlider = $(selectors["sliderSelector"]);
    const queries = {};
    const sidebar = $(selectors["sidebarSelector"]);

    const cateInputs = sidebar.querySelectorAll(
        "input[type='checkbox']:not([disabled])"
    );
    cateInputs.forEach((input) => {
        input.addEventListener("click", (e) => {
            const inputData = input.dataset.value.split("-");
            const cateName = inputData[0];
            const cateVal = inputData[1];
            if (!Array.isArray(queries[cateName])) {
                queries[cateName] = [];
            }
            if (input.matches(":checked")) {
                queries[cateName].push(Number(cateVal));
            } else {
                const cateIndex = queries[cateName].indexOf(cateVal);
                queries[cateName].splice(cateIndex, 1);
            }

            Object.entries(queries).forEach(([key, value]) => {
                if (!value.length) delete queries[key];
            });

            const url = new URL(window.location.href.split("?")[0] + "-search");
            Object.keys(queries).forEach((key) =>
                url.searchParams.append(key, queries[key])
            );
            fetch(url);

            // Process to call HttpRequest
            processQueries(url);
        });
    });

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

                const page = new URL(link.href);
                Object.keys(queries).forEach((key) =>
                    page.searchParams.append(key, queries[key])
                );
                fetch(page);

                // Process to call HttpRequest
                processPaginate(page);
            });
        });
    }

    // Function to Process to call HttpRequest
    function processPaginate(page) {
        setTimeout(() => {
            const ajaxReq = new XMLHttpRequest();
            ajaxReq.onreadystatechange = () => {
                if (ajaxReq.readyState == 4 && ajaxReq.status == 200) {
                    renderSearch(ajaxReq.responseText, page);
                }
            };
            ajaxReq.open("GET", page, true);
            ajaxReq.setRequestHeader("Content-type", "html");
            ajaxReq.send();
        }, 1);
    }
}
