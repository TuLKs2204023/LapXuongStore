export { MyToggle, MyStickyNav };

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
            showToggleList(e, toggle, toggleList);
        });

        toggle.addEventListener("focusout", (e) => {
            toggle.classList.remove("show");
            toggleList.classList.remove("show");
        });
    }

    // To show toggle List
    function showToggleList(e, toggle, toggleList) {
        e.preventDefault();
        if (!toggleList.matches(".show")) {
            toggle.classList.add("show");
            toggleList.classList.add("show");
        } else {
            toggle.classList.remove("show");
            toggleList.classList.remove("show");
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

function MyStickyNav({ headerSelector = ".header-section" }) {
    const headerCont = $(headerSelector);
    const headerTop = $(headerSelector + " > div:first-child");
    const headerBody = $(headerSelector + " > div:nth-child(2)");

    const nextEle = headerCont.nextElementSibling;
    const stickyOffset = headerBody.offsetTop;
    const headerTopHeight = headerCont.offsetHeight;

    window.addEventListener("scroll", (e) => {
        if (window.pageYOffset >= stickyOffset) {
            headerCont.classList.add("sticky");
            nextEle.style.marginTop = `${headerTopHeight}px`;
        } else {
            headerCont.classList.remove("sticky");
            nextEle.style.marginTop = 0;
        }
    });
}
