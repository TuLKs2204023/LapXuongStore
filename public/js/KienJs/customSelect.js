export { CustomSelect };

function CustomSelect(data) {
    /*look for any elements with the class "custom-select":*/
    const originalInputs = document.getElementsByClassName(data.orginialInput);
    if (!originalInputs) {
        return false;
    }
    for (let input of originalInputs) {
        const selElmnt = input.getElementsByTagName("select")[0];
        const originalOpts = selElmnt.options;

        /*for each element, create a new DIV that will act as the selected item:*/
        const newInput = document.createElement("DIV");
        newInput.setAttribute("class", "select-selected form-control");
        newInput.setAttribute("tabindex", "0");
        newInput.setAttribute("data-name", selElmnt.name + "-custom");
        if (selElmnt.getAttribute("rules")) {
            newInput.setAttribute("rules", selElmnt.getAttribute("rules"));
        }

        newInput.innerHTML = originalOpts[originalOpts.selectedIndex].innerHTML;
        input.appendChild(newInput);

        /*for each element, create a new DIV that will contain the option list:*/
        const newOptsContainer = document.createElement("DIV");
        newOptsContainer.setAttribute("class", "my-custom-select-items");

        /*for each option in the original select element, create a new DIV that will act as an option item:*/
        for (let option of originalOpts) {
            if (option.value) {
                const newOpt = document.createElement("DIV");
                newOpt.innerHTML = option.innerHTML;
                newOpt.dataset.value = option.value;
                newOptsContainer.appendChild(newOpt);
            }
        }

        const newOpts = newOptsContainer.getElementsByTagName("DIV");
        for (let newOpt of newOpts) {
            newOpt.addEventListener("click", (e) => {
                /*when an item is clicked, update the original select box, and the selected item:*/
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

        input.appendChild(newOptsContainer);
        newOptsContainer.addEventListener("mousemove", (e) => {
            scrollBarHover(newOptsContainer, e);
        });

        // Event fired when clicking on the custom select to show items
        newInput.addEventListener("click", (e) => {
            /*when the select box is clicked, close any other select boxes,
      and open/close the current select box:*/
            e.stopPropagation();
            showOptions(e);
        });

        // Add event for keyboard shortcut
        newInput.addEventListener("keydown", (e) => {
            if (e.altKey) {
                switch (e.key) {
                    case "Down":
                    case "ArrowDown":
                    case "Up":
                    case "ArrowUp":
                        showOptions(e);
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

        const newInput = selectedOpt.parentNode.previousSibling;
        newInput.dataset.value = selectedOpt.dataset.value;
        newInput.innerHTML = selectedOpt.innerHTML;
    }

    // Function to show options list
    function showOptions(e) {
        closeAllOptions(e.target);
        e.target.classList.toggle("select-arrow-active");
        e.target.nextSibling.classList.toggle("select-show");
    }

    // Func. that close all custom-select boxes, except the current one
    function closeAllOptions(elmnt) {
        const newInputs = document.getElementsByClassName("select-selected");
        for (let input of newInputs) {
            if (elmnt !== input) {
                input.classList.remove("select-arrow-active");
                input.nextSibling.classList.remove("select-show");
                const options = input.nextSibling.getElementsByTagName("DIV");
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

    /* If the user clicks anywhere outside the select box,
  then close all select boxes:*/
    document.addEventListener("click", closeAllOptions);
}
