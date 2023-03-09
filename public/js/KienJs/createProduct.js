import { CustomSelect } from "./customSelect.js";
export { seriesHandler };

const $ = document.querySelector.bind(document);
const $id = document.getElementById.bind(document);

function seriesHandler({
    url = "",
    token = "",
    selectors: {
        formSelector = "#createProduct",
        brandSelector = "#manufacture_id-custom",
        seriesSelector = "#series_id",
    },
}) {
    const selectors = { formSelector, brandSelector, seriesSelector };
    const formElement = $(selectors["formSelector"]);
    if (!formElement) return false;

    const brandInput = $(selectors["brandSelector"]);
    if (!brandInput) return false;

    const brandCustomSelect = brandInput.querySelector(
        ".my-custom-select-items"
    );
    if (!brandCustomSelect) return false;

    const selectItms = brandCustomSelect.querySelectorAll("div");
    if (selectItms) {
        // Add event for select items in custom-select
        for (let selectItm of selectItms) {
            selectItm.addEventListener("click", (e) => {
                seriesUpdateHandler(e, selectors, updateSeries);
            });
        }
    }

    // Function to update content of Series button
    function updateSeries(res, selectors) {
        const originInput = $(selectors["seriesSelector"]);
        populateNewOpts(clearOldOpts(originInput), res);
        const newInputCont = originInput.nextElementSibling;

        const newCustomSelect = new CustomSelect({});
        newCustomSelect.handleCustomOpts(originInput, newInputCont);

    }
    function populateNewOpts(selectEle, items) {
        return appendChildren(
            selectEle,
            items.map((item) => new Option(item.name, item.id))
        );
    }
    function appendChildren(selectEle, children) {
        children.forEach((child) => selectEle.appendChild(child));
        return selectEle;
    }
    function clearOldOpts(selectEle) {
        selectEle.options.length = 0;
        selectEle.appendChild(new Option("--- Select ---", 0));
        return selectEle;
    }

    // Process to call HttpRequest
    function seriesUpdateHandler(e, selectors, callback) {
        e.preventDefault();
        setTimeout(() => {
            const params = {
                bId: e.target.dataset.value,
                _token: token,
            };

            const ajaxReq = new XMLHttpRequest();

            ajaxReq.onreadystatechange = () => {
                if (ajaxReq.readyState == 4 && ajaxReq.status == 200) {
                    const res = JSON.parse(ajaxReq.responseText);

                    callback(res, selectors);
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
