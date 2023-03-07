export { Validator };

// Validators
function Validator(form) {
    const formElement = $(form);
    if (!formElement) return false;

    // Define Rules' function LIST
    const formRules = {
        required(value) {
            return value ? undefined : `This field is required`;
        },
        email(value) {
            const regExMail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/;
            return regExMail.test(value)
                ? undefined
                : ` This field must be in the format: 'abc@xx.xxx'`;
        },
        minLength(min) {
            return (value) => {
                return value.length >= min
                    ? undefined
                    : `This field must not be less than ${min} character(s)`;
            };
        },
        maxLength(max) {
            return (value) => {
                return value.length <= max
                    ? undefined
                    : `This field must not be greater than ${max} character(s)`;
            };
        },
        min(min, include = "") {
            return (value) => {
                if (!include) {
                    return Number(value) >= Number(min)
                        ? undefined
                        : `Value must not be less than ${min}`;
                } else {
                    return Number(value) > Number(min)
                        ? undefined
                        : `Value must be greater than ${min}`;
                }
            };
        },
        max(max, include = "") {
            return (value) => {
                if (!include) {
                    return Number(value) <= Number(max)
                        ? undefined
                        : `Value must not be greater than ${max}`;
                } else {
                    return Number(value) < Number(max)
                        ? undefined
                        : `Value must be less than ${max}`;
                }
            };
        },
        range(min, max) {
            return (value) => {
                return Number(value) >= Number(min) &&
                    Number(value) <= Number(max)
                    ? undefined
                    : `Value must be in the range from ${min} to ${max}`;
            };
        },
        compareMin(selector) {
            return (value) => {
                const selectorVal = formElement.querySelector(selector).value;
                return Number(value) > selectorVal
                    ? undefined
                    : `Value must be greater than ${selectorVal}`;
            };
        },
        confirmed(selector) {
            return (value) => {
                return value === formElement.querySelector(selector).value
                    ? undefined
                    : "Confirmation value does not match";
            };
        },
    };

    let rulesList = {};
    let confirmedList = {};

    const inputElements = Array.from(
        formElement.querySelectorAll("[name][rules]")
    );

    addCustomSelects(inputElements);

    // Loop through inputs for building rulesList{}, then add events
    for (let input of inputElements) {
        const inputName = input.name ? input.name : input.dataset.name;
        if (!Array.isArray(rulesList[inputName])) {
            rulesList[inputName] = [];
        }

        // Build RulesList for tesing
        const rules = input.getAttribute("rules").split("|");
        for (let rule of rules) {
            if (rule.includes(":")) {
                const ruleAttr = rule.split(":");
                rule = ruleAttr[0];
                const ruleVal = ruleAttr[1];

                if (ruleVal.includes(",")) {
                    const ruleValues = ruleVal.split(",");
                    rulesList[inputName].push(
                        formRules[rule](ruleValues[0], ruleValues[1])
                    );
                } else {
                    rulesList[inputName].push(formRules[rule](ruleVal));
                }

                if (rule === "confirmed") {
                    confirmedList[inputName] = ruleVal;
                }
            } else {
                rulesList[inputName].push(formRules[rule]);
            }
        }

        // Input Events
        input.addEventListener("blur", handleValidate);
        input.addEventListener("focus", cancelValidate);
        input.oninput = cancelValidate;

        // Add on-change event for Radio & Checkbox inputs
        switch (input.type) {
            case "radio":
            case "checkbox":
                const inputRadios = formElement.querySelectorAll(
                    `[name="${inputName}"]`
                );
                for (let input of inputRadios) {
                    input.onchange = cancelValidate;
                }
                break;
            default:
                break;
        }
    }

    // Loop through inputs again then add event for inputs that has confirmation
    for (let input of inputElements) {
        const confirmedId = `#${input.getAttribute("id")}`;
        if (Object.values(confirmedList).includes(confirmedId)) {
            input.addEventListener("blur", handleConfirmed);
        }
    }

    // Function for handle confirmed & based inputs
    function handleConfirmed() {
        for (let key in confirmedList) {
            inputBase = formElement.querySelector(`${confirmedList[key]}`);
            inputConfirmed = formElement.querySelector(`[name="${key}"]`);

            if (inputBase.value === inputConfirmed.value) {
                cancelValidate({ target: inputConfirmed });
            } else {
                handleValidate({ target: inputConfirmed });
            }
        }
    }

    function addCustomSelects(inputElements) {
        const customSelects = formElement.getElementsByClassName(
            "my-custom-select-cont"
        );
        if (customSelects) {
            Array.from(customSelects).forEach((custom) => {
                if (custom.getAttribute("rules")) {
                    inputElements.push(custom);
                }
            });
        }
    }

    // On-submit event for main Form
    formElement.onsubmit = (e) => {
        e.preventDefault();

        // Select only Enabled inputs
        const enabledInputs = Array.from(
            formElement.querySelectorAll("[name][rules]:not([disabled])")
        );

        addCustomSelects(enabledInputs);

        if (enabledInputs) {
            let isAllValid = true;

            // Loop through inputs then assigns corresponding validation
            for (let input of enabledInputs) {
                const isValid = handleValidate({
                    target: input,
                });
                isAllValid = isValid && isAllValid;
            }

            // Executing codes if all validations have been sastisfied
            if (isAllValid) {
                const formInputs = formElement.querySelectorAll("[name]");

                // Returning Form Values for further actions
                const formValues = Array.from(formInputs).reduce(
                    (values, input) => {
                        switch (input.type) {
                            case "radio":
                                values[input.name] =
                                    formElement.querySelector(
                                        `[name="${input.name}"]:checked`
                                    )?.value || "";
                                break;
                            case "checkbox":
                                if (!Array.isArray(values[input.name])) {
                                    values[input.name] = [];
                                }
                                if (!input.matches(":checked")) {
                                    return values;
                                }
                                values[input.name].push(input.value);
                                break;
                            case "file":
                                values[input.name] = input.files;
                                break;
                            default:
                                values[input.name] = input.value;
                        }
                        return values;
                    },
                    {}
                );

                // Checking whether there is onSubmit function for Form or not
                if (typeof this.onSubmit === "function") {
                    this.onSubmit(formValues);
                } else {
                    // If not, execute Default submit() function
                    formElement.submit();
                }
            }
        }
    };

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

    // Defining main Validation function for corresponding input
    function handleValidate(e) {
        const inputGrp = getParent(e.target, ".form-group");
        if (inputGrp) {
            const inputName = e.target.name
                ? e.target.name
                : e.target.dataset.name;
            const rules = rulesList[inputName];
            let errMsg = "";

            for (let rule of rules) {
                if (!e.target.type) {
                    errMsg = rule(e.target.dataset.value);
                } else {
                    switch (e.target.type) {
                        case "radio":
                        case "checkbox":
                            errMsg = rule(
                                formElement.querySelector(
                                    `[name='${inputName}']:checked`
                                )
                            );
                            break;
                        default:
                            errMsg = rule(e.target.value);
                            break;
                    }
                }

                if (errMsg) break;
            }

            if (errMsg) {
                const errSpan = inputGrp.querySelector(".form-message");
                if (errSpan) {
                    errSpan.innerText = errMsg;
                    inputGrp.classList.add("invalid");
                }
            }
            return !errMsg;
        }
    }

    // Defining Cancel validation function for corresponding input
    function cancelValidate(e) {
        const inputGrp = getParent(e.target, ".form-group");

        if (inputGrp.matches(".invalid")) {
            const errSpan = inputGrp.querySelector(".form-message");

            if (errSpan) {
                errSpan.innerText = "";
                inputGrp.classList.remove("invalid");
            }
        }
    }
}
