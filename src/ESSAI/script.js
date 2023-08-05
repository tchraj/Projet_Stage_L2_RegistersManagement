window.onload = () =>{
    const modalButtons = document.querySelectorAll("[data-toggle=modal]");
   for (let button of modalButtons) {
    button.addEventListener("click",function(e){
        e.preventDefault();
        let target = this.dataset.target;
        let modal = document.querySelector(target);
        modal.classList.add("show");
    } );
   }
   const modalClose = document.querySelectorAll("[data-dismiss=dialog]");
   for(let close of modalClose){
    close.addEventListener("click", () => {
        
    })
   }

}