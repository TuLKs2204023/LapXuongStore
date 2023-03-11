export { CustomSelect };

function CustomSelect({ orginialInput = "my-custom-select" }) {
    /*look for any elements with the class "custom-select":*/
    function initNewOpts() {
        const originalInputs = document.getElementsByClassName(orginialInput);
        if (!originalInputs) {
            return false;
        }
        for (let input of originalInputs) {
            const selElmnt = input.getElementsByTagName("select")[0];

            /*for each element, create a new DIV that will act as the selected item:*/
            const newInputCont = document.createElement("DIV");
            if (selElmnt.getAttribute("rules")) {
                const attrs = {
                    tabindex: 0,
                    id: selElmnt.name + "-custom",
                    class: "my-custom-select-cont form-control",
                    "data-name": selElmnt.name + "-custom",
                    "data-value": selElmnt.selectedIndex || "",
                    rules: selElmnt.getAttribute("rules"),
                };
                Object.entries(attrs).forEach(([attrKey, attrVal]) => {
                    newInputCont.setAttribute(attrKey, attrVal);
                });
            }
            input.appendChild(newInputCont);

            handleCustomOpts(selElmnt, newInputCont);

            // Event fired when clicking on the custom select to show items
            addEventToNewOpts(selElmnt, newInputCont);
        }
        if (!originalInputs[0]) {
            return false;
        }
        const formElement = getParent(originalInputs[0], "form");
        formElement.addEventListener("mousemove", (e) => {
            const optsContainer = e.target.closest(".my-custom-select-items");
            const pageX = e.pageX;
            if (optsContainer) {
                scrollBarHover(optsContainer, pageX);
            } else {
                const inputs = formElement.getElementsByClassName(
                    "my-custom-select-items"
                );
                Array.from(inputs).forEach((input) => {
                    input.classList.remove("more-width");
                });
            }
        });

        /* If the user clicks anywhere outside the select box, then close all select boxes:*/
        document.addEventListener("click", closeAllOptions);
    }

    /* Create a new DIV that show up selected option*/
    function getOrCreateNewInput(selElmnt, newInputCont) {
        const originalOpts = selElmnt.options;
        let newInput = newInputCont.querySelector(".select-selected");
        if (!newInput) {
            newInput = document.createElement("DIV");
            newInput.classList.add("select-selected");
            newInputCont.appendChild(newInput);
        }
        newInput.innerHTML = originalOpts[originalOpts.selectedIndex].innerHTML;
        return newInput;
    }

    /* Create a new DIV that will contain the option list:*/
    function getOrCreateNewOptsContainer(newInputCont) {
        let newOptsContainer = newInputCont.querySelector(
            ".my-custom-select-items"
        );
        if (!newOptsContainer) {
            newOptsContainer = document.createElement("DIV");
            newOptsContainer.setAttribute("class", "my-custom-select-items");
        } else {
            const newOpts = newOptsContainer.getElementsByTagName("DIV");
            Array.from(newOpts).forEach((newOpt) => newOpt.remove());
            newInputCont.setAttribute("data-value", " ");
        }
        return newOptsContainer;
    }

    function handleCustomOpts(selElmnt, newInputCont) {
        const originalOpts = selElmnt.options;
        const newInput = getOrCreateNewInput(selElmnt, newInputCont);
        const newOptsContainer = getOrCreateNewOptsContainer(newInputCont);

        /*for each option in the original select element, create a new DIV that will act as an option item:*/
        populateOpts(originalOpts, newOptsContainer);

        /*when an item is clicked, update the original select box, and the selected item:*/
        const newOpts = newOptsContainer.getElementsByTagName("DIV");
        updateSelectedOpt(newOpts, selElmnt, newInput);

        newInputCont.appendChild(newOptsContainer);
        newOptsContainer.addEventListener("mousemove", (e) => {
            scrollBarHover(newOptsContainer, e);
        });
    }

    /*for each option in the original select element, create a new DIV that will act as an option item:*/
    function populateOpts(originalOpts, newOptsContainer) {
        for (let option of originalOpts) {
            if (option.value) {
                createNewOpt(newOptsContainer, option);
            }
        }
        if (originalOpts.length < 2) {
            const option = new Option("Nothing to select", "");
            createNewOpt(newOptsContainer, option);
        }
    }

    /* Create new Option for new Custom-Select */
    function createNewOpt(newOptsContainer, option) {
        const newOpt = document.createElement("DIV");
        newOpt.innerHTML = option.innerHTML;
        newOpt.dataset.value = option.value;
        newOptsContainer.appendChild(newOpt);
    }

    /*when an item is clicked, update the original select box, and the selected item:*/
    function updateSelectedOpt(newOpts, selElmnt, newInput) {
        const originalOpts = selElmnt.options;
        for (let newOpt of newOpts) {
            newOpt.addEventListener("click", (e) => {
                e.preventDefault();
                Array.from(originalOpts).forEach((opt, idx) => {
                    if (opt.innerHTML === e.target.innerHTML) {
                        selElmnt.selectedIndex = idx;
                        newInput.innerHTML = e.target.innerHTML;
                        confirmSelect(e.target);
                        newInput.focus();
                    }
                });
            });
            newOpt.addEventListener("mousemove", (e) => {
                removeFocus(e.target);
            });
        }
    }

    // Event fired when clicking on the custom select to show items
    function addEventToNewOpts(selElmnt, newInputCont) {
        const newOptsContainer = newInputCont.querySelector(
            ".my-custom-select-items"
        );
        const newOpts = newOptsContainer.getElementsByTagName("DIV");

        newInputCont.addEventListener("click", (e) => {
            /*when the select box is clicked, close any other select boxes,
          and open/close the current select box:*/
            e.stopPropagation();
            showOptions(newInputCont);
        });

        // Add event for keyboard shortcut
        newInputCont.addEventListener("keydown", (e) => {
            if (e.altKey) {
                switch (e.key) {
                    case "Down":
                    case "ArrowDown":
                    case "Up":
                    case "ArrowUp":
                        showOptions(e.target);
                        addFocus(newOpts, selElmnt);
                        break;
                }
            }

            if (!e.altKey) {
                switch (e.key) {
                    case "Down":
                    case "ArrowDown":
                    case "Right":
                    case "ArrowRight":
                        nextSelect("down", e, newOpts, selElmnt, addFocus);
                        break;

                    case "Up":
                    case "ArrowUp":
                    case "Left":
                    case "ArrowLeft":
                        nextSelect("up", e, newOpts, selElmnt, addFocus);
                        break;

                    case "Enter":
                        const selectedOpt = findActiveSelect(newOpts, selElmnt);
                        if (selectedOpt) {
                            confirmSelect(selectedOpt);
                            closeAllOptions(newOpts);
                        }
                        break;

                    case "Escape":
                        closeAllOptions(newOpts[selElmnt.selectedIndex]);
                        break;

                    default:
                        closeAllOptions(newOpts[selElmnt.selectedIndex]);
                        return true;
                }
            }
        });
    }

    // Function to detect active Select
    function nextSelect(direction, e, options, selElmnt, cb) {
        e.preventDefault();
        if (!selElmnt) {
            return;
        }
        const firstIndex = selElmnt.options[0].value ? 0 : 1;
        switch (direction) {
            case "up":
                selElmnt.selectedIndex =
                    selElmnt.selectedIndex - 1 < firstIndex
                        ? selElmnt.options.length - 1
                        : selElmnt.selectedIndex - 1;
                break;

            case "down":
                selElmnt.selectedIndex =
                    selElmnt.selectedIndex + 1 > selElmnt.options.length - 1
                        ? firstIndex
                        : selElmnt.selectedIndex + 1;
                break;
        }
        cb(options, selElmnt);
    }

    function addFocus(options, selElmnt) {
        removeFocus(options[0]);

        const selectedOpt = findActiveSelect(options, selElmnt);
        if (!selectedOpt) return;

        selectedOpt.scrollIntoView({
            behavior: "smooth",
            block: "nearest",
            inline: "nearest",
        });
        selectedOpt.classList.add("select-hover");

        confirmSelect(selectedOpt);
    }

    function findActiveSelect(newOpts, originalSelect) {
        const selectedText =
            originalSelect.options[originalSelect.selectedIndex].innerHTML;
        const selectedOption = Array.from(newOpts).find((opt) => {
            return opt.innerHTML === selectedText;
        });
        return selectedOption;
    }

    function removeFocus(opt) {
        const oldSelected =
            opt.parentNode.getElementsByClassName("select-hover")[0];
        if (oldSelected) {
            oldSelected.classList.remove("select-hover");
        }
    }

    function confirmSelect(selectedOpt) {
        const selectedItm =
            selectedOpt.parentNode.getElementsByClassName(
                "same-as-selected"
            )[0];
        if (selectedItm) {
            selectedItm.classList.remove("same-as-selected");
        }
        selectedOpt.classList.add("same-as-selected");
        removeFocus(selectedOpt);

        const newnewInputCont = selectedOpt.parentNode.parentNode;
        const newInput = selectedOpt.parentNode.previousSibling;
        newnewInputCont.dataset.value = selectedOpt.dataset.value;
        newInput.innerHTML = selectedOpt.innerHTML;
    }

    // Function to show options list
    function showOptions(ele) {
        closeAllOptions(ele);
        ele.classList.toggle("select-arrow-active");
        ele.getElementsByClassName(
            "my-custom-select-items"
        )[0].classList.toggle("select-show");
    }

    // Func. that close all custom-select boxes, except the current one
    function closeAllOptions(elmnt) {
        const newInputs = document.getElementsByClassName(
            "my-custom-select-cont"
        );
        for (let input of newInputs) {
            if (elmnt !== input) {
                input.classList.remove("select-arrow-active");
                const optsList = input.getElementsByClassName(
                    "my-custom-select-items"
                )[0];
                optsList.classList.remove("select-show");
                const options = optsList.getElementsByTagName("DIV");
                removeFocus(options[0]);
            }
        }
    }

    function scrollBarHover(optsContainer, pageX) {
        let distance =
            optsContainer.getBoundingClientRect()["x"] +
            optsContainer.offsetWidth -
            pageX;
        distance < 20 && distance > 0
            ? optsContainer.classList.add("more-width")
            : optsContainer.classList.remove("more-width");
    }

    // Get DIV's parent of current input
    function getParent(input, formGrp) {
        let parent = input.parentElement;
        while (parent) {
            if (parent.matches(formGrp)) {
                return parent;
            }
            parent = parent.parentElement;
        }
    }
    return {
        initNewOpts,
        handleCustomOpts,
    };
}
