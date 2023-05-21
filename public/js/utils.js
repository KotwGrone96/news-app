const success = (message = "") => {
    Swal.fire({
        title: message,
        icon: "success",
        toast: true,
        position: "bottom-end",
        showConfirmButton: false,
        color: "#FFFFFF",
        background: "#5cb85c",
        iconColor: "#FFFFFF",
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener("mouseenter", Swal.stopTimer);
            toast.addEventListener("mouseleave", Swal.resumeTimer);
        },
    });
};

const error = (message = "") => {
    Swal.fire({
        title: message,
        icon: "error",
        toast: true,
        position: "bottom-end",
        showConfirmButton: false,
        color: "#FFFFFF",
        background: "#ED4337",
        iconColor: "#FFFFFF",
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener("mouseenter", Swal.stopTimer);
            toast.addEventListener("mouseleave", Swal.resumeTimer);
        },
    });
};

const postRequest = async (url = "", body) => {
    const token = document.querySelector("meta[name=csrf-token]").content;
    let headers = {
        "X-CSRF-TOKEN": token,
    };
    if (!(body instanceof FormData)) {
        headers["Content-Type"] = "application/json";
        body = JSON.stringify(body);
    }
    const data = await fetch(url, {
        method: "POST",
        headers,
        body,
    });
    const res = await data.json();
    return res;
};

const deleteRequest = async (url = "", body) => {
    const token = document.querySelector("meta[name=csrf-token]").content;
    body = JSON.stringify(body);

    const data = await fetch(url, {
        method: "DELETE",
        headers: {
            "X-CSRF-TOKEN": token,
            "Content-Type": "application/json",
        },
        body,
    });
    const res = await data.json();
    return res;
};

const showErrorForms = (errors = {}) => {
    for (const error in errors) {
        const label_error = document.getElementById(`error-${error}`);
        label_error.innerHTML = errors[error][0];
        label_error.classList.remove("hidden");
    }
};

const clearErrorForms = () => {
    const label_errors = document.querySelectorAll(".form-error");
    label_errors.forEach((error) => {
        error.classList.contains("hidden") ? "" : error.classList.add("hidden");
    });
};

const showDeleteAlert = async (title = "", text = "", url = "", body) => {
    const result = await Swal.fire({
        title,
        text,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#5cb85c",
        cancelButtonColor: "#ED4337",
        confirmButtonText: "Sí, eliminar!",
        cancelButtonText: "Cancelar",
        showLoaderOnConfirm: true,
        preConfirm: () => {
            return deleteRequest(url, body)
                .then((response) => {
                    if (!response.ok) {
                        throw new Error(response.message);
                    }
                    return response;
                })
                .catch((error) => {
                    Swal.showValidationMessage(`Request failed: ${error}`);
                });
        },
    });
    if (result.isConfirmed) {
        const { message } = result.value;
        Swal.fire("Eliminado!", message, "success");
        return true;
    }
    return false;
};
