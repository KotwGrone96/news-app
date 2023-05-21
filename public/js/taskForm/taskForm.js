window.addEventListener('DOMContentLoaded',()=>{
    const form = document.getElementById('taskForm');
    form.addEventListener('submit',handleSubmit)
})


const handleSubmit = async(e) => {
    e.preventDefault();
    const formData = new FormData(e.target);
    const name = formData.get('taskName');
    const description = formData.get('description');
    const method = e.target._method.value;
    const _token = e.target._token.value;
    const url = e.target.action;
    const params = {name,description,method,url,_token}
    console.log(params)
    try {
        const res = await fetch(url,{
            method,
            body:JSON.stringify(params),
            headers: {
                'Content-Type': 'application/json'
            }
        })
        const data = await res.json();
        console.log(data);
        const alertSuccess = document.getElementById('alertSuccess')
        alertSuccess.style.display = 'block';
        if(!e.target.dataset.edit){
            e.target.reset();
        }
        setTimeout(() => {
            alertSuccess.style.display = 'none'; 
        }, 1500);
    } catch (error) {
        const alertError = document.getElementById('alertError')
        alertError.style.display = 'block';
        setTimeout(() => {
            alertError.style.display = 'none'; 
        }, 1500);
        console.log(error)
    }
 }