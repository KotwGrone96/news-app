window.addEventListener("DOMContentLoaded", () => {
    const btn_create_post = document.getElementById("create-post");
    btn_create_post.addEventListener("click", modalCreatePost);

    const btn_actions = document.querySelectorAll("button.btn-action");
    btn_actions.forEach((btn) => {
        btn.addEventListener("click", () => handleActionBtn(btn));
    });

    const btn_show_post = document.querySelectorAll(".show_post");
    btn_show_post.forEach((btn) => {
        btn.addEventListener("click", () => handleShowPost(btn));
    });
});

const handleShowPost = async (btn) => {
    const { state, post_id } = btn.dataset;
    if (state == "DRAFT") {
        Swal.fire(
            "Denegado",
            "Las publicaciones guardadas como borrador, no pueden ser visibles",
            "error"
        );
        return;
    }
    const url = route("dashboard.posts.update");
    const owner_id = document.getElementById("user_id").value;
    try {
        const data = await postRequest(url, {
            owner_id,
            post_id,
            visible: true,
        });
        if (data.ok) {
            success(data.message);
            document.getElementById(`visible_post_${post_id}`).innerHTML =
                data.html;
            const new_btn = document.getElementById(
                `new_icon_visible_${post_id}`
            );
            new_btn.addEventListener("click", () => handleShowPost(new_btn));
            return;
        }
        error(data.message);
    } catch (err) {
        console.log(err);
        error(err);
    }
};

const handleActionBtn = async (btn) => {
    const { action, post_id } = btn.dataset;
    const user_id = document.getElementById("user_id").value;
    if (action == "DELETE") {
        const url = route("dashboard.posts.delete");
        const result = await showDeleteAlert(
            "Eliminar publicación",
            "¿Está seguro que desea eliminar la publicación?",
            url,
            { user_id, post_id }
        );
        if (result) {
            const card = document.getElementById(`post_card_${post_id}`);
            card.remove();
        }
    }
    if (action == "EDIT") {
        window.location.href = route("dashboard.posts.create", {
            id: post_id,
            type: "EDIT",
        });
    }
};

const modalCreatePost = () => {
    Swal.fire({
        title: "Crear publicación",
        input: "text",
        inputLabel: "Escriba el título",
        inputPlaceholder: "Mi título",
        showCancelButton: true,
        cancelButtonText: "Cancelar",
        confirmButtonText: "Crear",
        cancelButtonColor: "#ED4337",
        confirmButtonColor: "#5cb85c",
        showLoaderOnConfirm: true,
        inputValidator: (value) => {
            if (!value) {
                return "El título es requerido!";
            }
        },
        preConfirm: (title) => {
            const url = route("dashboard.posts.store");
            const user_id = document.getElementById("user_id").value;
            return postRequest(url, { user_id, title })
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
    }).then((result) => {
        if (result.isConfirmed) {
            const { message, id } = result.value;
            success(message);
            window.location.href = route("dashboard.posts.create", {
                id,
                type: "CREATE",
            });
        }
    });
};
