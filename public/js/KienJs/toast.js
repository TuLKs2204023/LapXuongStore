export { toast, showSuccessToast, showErrorToast };

function toast({
    title = "",
    message = "",
    type = "success",
    duration = 3000,
}) {
    const main = document.getElementById("myToast");
    const icons = {
        success: "fas fa-check-circle",
        info: "fas fa-info-circle",
        warning: "fas fa-exclamation-circle",
        error: "fas fa-exclamation-circle",
    };
    const icon = icons[type];
    const slideInDuration = 0.3;
    const fadeOutDuration = 0.8;
    const fadeOutDelay = Number((duration / 1000).toFixed(2));

    if (main) {
        const toast = document.createElement("div");

        toast.classList.add("toast-container", `toast--${type}`);
        toast.style.animation = `slideInLeft ease ${slideInDuration}s, fadeOut linear ${fadeOutDuration}s ${fadeOutDelay}s forwards`;
        toast.innerHTML = `
          <div class="myToast">
            <div class="toast__content">
                <div class="toast__icon">
                    <i class="${icon}"></i>
                </div>
                <div class="toast__body">
                    <h3 class="toast__title">${title}</h3>
                    <p class="toast__msg">${message}</p>
                </div>
                <div class="toast__close">
                    <i class="fas fa-times"></i>
                </div>
            </div>
                
            <div id="toast__line_container" class="toast__line_container">
                <div id="toast__line" class="toast__line"></div>
            </div>
          </div>
          
          
      `;
        main.appendChild(toast);

        const toastLineContainer = toast.querySelector(
            ".toast__line_container"
        );
        const toastLine = toastLineContainer.querySelector(".toast__line");
        toastLine.style.animation = `slideOutRight linear ${fadeOutDelay}s`;
        // toastLineContainer.style.width = toastLineContainer.offsetWidth - 16 + "px";

        const autoRemoveToast = setTimeout(function () {
            main.removeChild(toast);
        }, (slideInDuration + fadeOutDuration + fadeOutDelay) * 1000);

        toast.onclick = function (e) {
            if (e.target.closest(".toast__close")) {
                main.removeChild(toast);
                clearTimeout(autoRemoveToast);
            }
        };
    }
}

function showSuccessToast({
    title = "Success",
    message = "Action performed successfully.",
    duration = 3000,
}) {
    toast({
        title: title,
        message: message,
        type: "success",
        duration: duration,
    });
}
function showErrorToast({
    title = "Error",
    message = "Some errors occurred, please contact the administrator.",
    duration = 3000,
}) {
    toast({
        title: title,
        message: message,
        type: "error",
        duration: duration,
    });
}
