window.onload = () => {
    let region = document.querySelector('#visite_choix');
    region.addEventListener("change", function () {
        let form = this.closest("form");
        let data = this.name + " = " + this.value;
        fetch(form.action,{
            method: form.getAttribute("method"),
            body: data,
            header: {
                "Content-Type": "application/x-www-form-urlencoded; charset:utf-8"
            }
        })
        .then(response => response.text())
        .then(html =>{
            let content = document.createElement("html");
            content.innerHTML = html;
            let nouveauSelect = content.querySelector("#visite_visiteurExterne");
            document.querySelector("#visite_visiteurExterne").replaceWith(nouveauSelect)
        })
    });

}