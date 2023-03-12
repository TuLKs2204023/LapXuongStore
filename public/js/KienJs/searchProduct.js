export { SearchHandler };

$ = document.querySelector.bind(document);

function SearchHandler({
    url = "",
    token = "",
    selectors: { sidebarSelector = ".produts-sidebar-filter" },
}) {
    const selectors = { sidebarSelector };

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

            // Process to call HttpRequest
            processQueries(e, queries);
        });
    });

    // Function to Process to call HttpRequest
    function processQueries(e, queries) {
        setTimeout(() => {
            const params = {
                queries,
                _token: token,
            };

            const ajaxReq = new XMLHttpRequest();

            ajaxReq.onreadystatechange = () => {
                if (ajaxReq.readyState == 4 && ajaxReq.status == 200) {
                    const res = JSON.parse(ajaxReq.responseText);

                    console.log(res);
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
