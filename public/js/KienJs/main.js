export { MyToggle };

$ = document.querySelector.bind(document);

function MyToggle({
    toggleselector = ".my-toggle",
    toggleListSelector = ".my-toggle-content",
}) {
    const toggles = document.querySelectorAll(toggleselector);

    if (!toggles) return false;

    for (let toggle of toggles) {
        const toggleList =
            getNextToggleList(toggle, toggleListSelector) ||
            getChildToggleList(toggle, toggleListSelector);

        toggle.setAttribute("tabindex", "-1");
        // toggleList.style.width = window.innerWidth * 0.8 + "px";
        
        toggle.addEventListener("click", (e) => {
            showToggleList(e, toggleList);
        });

        toggle.addEventListener("focusout", (e) => {
            toggleList.classList.remove("show");
            toggle.classList.remove("show");
        });
    }

    // To show toggle List
    function showToggleList(e, toggleList) {
        e.preventDefault();
        if (!toggleList.matches(".show")) {
            toggleList.classList.add("show");
            e.target.classList.add("show");
        } else {
            toggleList.classList.remove("show");
            e.target.classList.remove("show");
        }
    }

    // Get ToggleList sibling of current toggle
    function getNextToggleList(input, listGrp) {
        let list = input.nextElementSibling;
        while (list) {
            if (list.matches(listGrp)) {
                return list;
            }
            list = list.nextElementSibling;
        }
        return list;
    }
    // Get ToggleList children of current toggle
    function getChildToggleList(input, listGrp) {
        let children = input.children;
        for (let child of children) {
            if (child.matches(listGrp)) {
                return child;
            }
        }
        for (let child of children) {
            let subchilds = child.children;
            for (let subchild of subchilds) {
                if (subchild.matches(listGrp)) {
                    return subchild;
                }
            }
        }
    }
}
