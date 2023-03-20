export { GroupHandler, CateGroupsHandler };

const $ = document.querySelector.bind(document);

function GroupHandler({
    formSelector = "",
    exactContSelector = ".exact-value",
    rangeContSelector = ".range-value",
}) {
    const formElement = $(formSelector);

    const exactCont = formElement.querySelector(exactContSelector);
    const exactBtn = exactCont.querySelector(".exact-value-btn");
    const exactInputs = exactCont.querySelectorAll("input");

    const rangeCont = formElement.querySelector(rangeContSelector);
    const rangeBtn = rangeCont.querySelector(".range-value-btn");
    const rangeInputs = rangeCont.querySelectorAll("input");

    const activateExact = () =>
        addActive(exactCont, exactInputs, rangeCont, rangeInputs);

    const activateRange = () =>
        addActive(rangeCont, rangeInputs, exactCont, exactInputs);

    const isRangeVal = Array.from(rangeInputs)
        .filter((input) => input.name === "min" || input.name === "max")
        .some((input) => input.value > 0);

    isRangeVal ? activateRange() : activateExact();

    exactBtn.addEventListener("click", (e) => activateExact());
    rangeBtn.addEventListener("click", (e) => activateRange());

    function addActive(activeCont, activeInputs, inactiveCont, inactiveInputs) {
        activeCont.classList.add("active");
        inactiveCont.classList.remove("active");
        Array.from(activeInputs).forEach((input) => {
            input.disabled = false;
        });
        Array.from(inactiveInputs).forEach((input) => {
            input.disabled = true;
        });
    }
}

function CateGroupsHandler({
    url = "",
    token = "",
    cateTable,
    selectors: {
        tableBodySelector = "#catesMgmt tbody",
        navSelector = "showOnNav",
        searchSelector = "showOnSearch",
    },
}) {
    const selectors = { tableBodySelector, navSelector, searchSelector };
    const tableElement = $(selectors.tableBodySelector);
    if (!tableElement) return false;
    
    tableElement.addEventListener("click", (e) => {
        const cateData = cateTable.row(e.target.closest("tr")).data();
        const cateId = e.target.closest("tr").dataset.id;
        const navId = `${selectors.navSelector}-${cateId}`;
        const searchId = `${selectors.searchSelector}-${cateId}`;
        const isDisplay = e.target.matches(":checked");
        if (e.target.id == navId) {
            processToggleSwitch("nav", cateId, isDisplay);
        }
        if (e.target.id == searchId) {
            processToggleSwitch("search", cateId, isDisplay);
        }
    });

    // Process to call HttpRequest
    function processToggleSwitch(navOrSearch, cateId, isDisplay) {
        setTimeout(() => {
            const params = {
                cateId,
                navOrSearch,
                isDisplay,
                _token: token,
            };

            const ajaxReq = new XMLHttpRequest();

            ajaxReq.onreadystatechange = () => {
                if (ajaxReq.readyState == 4 && ajaxReq.status == 200) {
                    const res = JSON.parse(ajaxReq.responseText);
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
