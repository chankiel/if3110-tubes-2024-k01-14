const backBtn = document.querySelector(".back-btn");

backBtn.addEventListener("click",function(){
    if(window.history.length>1){
        window.history.back();
    }
})