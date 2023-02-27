export { FilesUpload };

$ = document.querySelector.bind(document);

function FilesUpload({
    filesUpload = ".myFilesUpload",
    addBtnSelector = ".btn-add-image",
    inputSelector = "#file_upload",
    inputContSelector = ".list-input-hidden-upload",
    listImagesSelector = ".list-images",
    multiple = true,
}) {
    if (!$(filesUpload)) {
        return false;
    }
    
    const addBtn = $(addBtnSelector);
    let inputOrigin = $(inputSelector);
    const listImages = $(listImagesSelector);
    const inputContainer = $(inputContSelector);

    if (!multiple) {
        inputOrigin.removeAttribute("multiple");
    }
    addBtn.addEventListener("click", (e) => {
        inputOrigin.click();
    });

    addEventForCloseBtn(listImages);
    inputOrigin.addEventListener("change", addImages);

    function addImages(e) {
        const today = new Date();
        const time = today.getTime();
        const files = e.target.files;

        if (multiple) {
            const filesHtmls = Array.from(files).reduce((files, file, idx) => {
                files += `
                            <div class="box-image">
                                <img src="${URL.createObjectURL(
                                    file
                                )}" class="picture-box">
                                <div class="wrap-btn-delete">
                                    <span data-id=${
                                        time + "__" + idx
                                    } class="btn-delete-image">x</span>
                                </div>
                            </div>
                        `;
                return files;
            }, "");

            listImages.insertAdjacentHTML("beforeend", filesHtmls);
            addEventForCloseBtn(listImages);

            e.target.removeAttribute("id");
            e.target.setAttribute("id", time);

            const inputsHtmls = `
                        <input type="file" name="photos[]" id="file_upload" multiple class="myfrm form-control hidden">
                    `;

            inputContainer.insertAdjacentHTML("afterbegin", inputsHtmls);
            inputOrigin = $(inputSelector);
            inputOrigin.addEventListener("change", addImages);
        } else {
            const boxFile = listImages.getElementsByClassName("box-image");
            if (boxFile) {
                Array.from(boxFile).forEach((box) => {
                    box.remove();
                });
            }
            const fileHtmls = `
            <div class="box-image">
                <img src="${URL.createObjectURL(files[0])}" class="picture-box">
                <div class="wrap-btn-delete">
                    <span data-id=${time} class="btn-delete-image">x</span>
                </div>
            </div>
        `;
            listImages.insertAdjacentHTML("beforeend", fileHtmls);
            addEventForCloseBtn(listImages);
        }
    }

    function removeImages(e) {
        const dataId = e.target.dataset.id.split("__");
        e.target.closest(".box-image").remove();

        const inputFiles = document.getElementById(dataId[0]);
        if (inputFiles) {
            const dt = new DataTransfer();
            const { files } = inputFiles;
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                if (Number(dataId[1]) !== i) {
                    dt.items.add(file);
                }
            }
            inputFiles.files = dt.files;
        }
    }

    function addEventForCloseBtn(listImages) {
        const boxFiles = listImages.getElementsByClassName("btn-delete-image");
        if (!boxFiles) {
            return false;
        }
        Array.from(boxFiles).forEach((box) => {
            box.addEventListener("click", removeImages);
        });
    }
}
