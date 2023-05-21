window.addEventListener("DOMContentLoaded", () => {
    summaryLength();
    const btns_submit = document.querySelectorAll("button.submit");
    const input_file = document.getElementById("image");

    const quill = new Quill("#body", {
        modules: {
            toolbar: [
                [{ font: [] }],
                ["bold", "italic", "underline"],
                ["link", "blockquote", "code-block"],
                [{ list: "ordered" }, { list: "bullet" }],
                [{ header: [1, 2, 3, 4, 5, 6, false] }],
                [{ color: [] }, { background: [] }],
                [{ align: [] }],
            ],
        },
        placeholder: "Escriba aquí...",
        theme: "snow",
        scrollingContainer: "#body",
        bounds: "#body",
    });
    btns_submit.forEach((btn) =>
        btn.addEventListener("click", () => handleSubmit(btn, quill))
    );
    input_file.addEventListener("change", () =>
        handleInputFileChange(input_file)
    );
});

const reader = new FileReader();

const summaryLength = () => {
    const summary = document.getElementById("summary");
    const summary_count = document.getElementById("summary_count");
    const summary_alert = document.getElementById("summary_alert");

    const count = summary.value.length;
    summary_count.textContent = count;
    summary.addEventListener("input", () => {
        summary_count.textContent = summary.value.length;
        if (summary.value.length > 255) {
            summary_alert.classList.remove("hidden");
            summary_alert.classList.add("flex");
        } else {
            summary_alert.classList.remove("flex");
            summary_alert.classList.add("hidden");
        }
    });
};

const handleSubmit = async (btn, quill) => {
    const { type } = btn.dataset;
    const url = route("dashboard.posts.update") + `?type=${type}`;
    const title = document.getElementById("title").value;
    const summary = document.getElementById("summary").value;
    const body = quill.root.innerHTML;
    const body_content = quill.root.textContent;
    const owner_id = document.getElementById("author").dataset.owner;
    let labels = document.getElementById("labels").value;
    labels = labels.length > 0 ? labels.split(",") : "";
    labels = labels.length > 0 ? JSON.stringify(labels) : "";
    const image = document.getElementById("image").files[0];
    const publication_date = document.getElementById("publication_date").value;
    const post_id = document.getElementById("post_id").value;

    const formData = new FormData();
    formData.append("title", title);
    formData.append("summary", summary);
    formData.append("body", body);
    formData.append("owner_id", owner_id);
    formData.append("labels", labels);
    formData.append("image", image);
    formData.append("publication_date", publication_date);
    formData.append("body_content", body_content);
    formData.append("post_id", post_id);
    clearErrorForms();

    try {
        const data = await postRequest(url, formData);
        if (data.ok) {
            success(data.message);
            console.log(data);
        } else {
            error(data.message);
            if (data.validation_errors) {
                showErrorForms(data.validation_errors);
            }
        }
    } catch (err) {
        error(err);
        console.log(err);
    }
};

const handleInputFileChange = (input_file) => {
    const file = input_file.files[0];
    const type = file.type;
    const input_file_alert = document.getElementById("file_alert");
    const container = document.getElementById("image_preview");

    if (type == "image/jpeg" || type == "image/png") {
        input_file_alert.classList.remove("flex");
        input_file_alert.classList.add("hidden");
        reader.readAsDataURL(file);
        reader.addEventListener("load", () => {
            container.innerHTML = "";
            const img = document.createElement("img");
            img.src = reader.result;
            img.style.width = "100%";
            container.appendChild(img);
        });
    } else {
        input_file_alert.classList.remove("hidden");
        input_file_alert.classList.add("flex");
        container.innerHTML = "";
    }
};
