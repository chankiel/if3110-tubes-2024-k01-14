const applyForm = document.querySelector(".apply-form");
const inputCV = document.getElementById("cv");
const backBtn = document.getElementById("back-btn");

applyForm.addEventListener("submit",function(e){
    e.preventDefault();
    console.log(inputCV.files.length);
    if(inputCV.files.length === 0){
        document.querySelector(".error-details").classList.remove("hidden");
    }else{

    }
})

inputCV.addEventListener("change", function(e){
    if(!inputCV.classList.contains("hidden")){
        console.log("HEHE")
        document.querySelector(".error-details").classList.add("hidden");
    }
})

if(window.history.length>1){
    backBtn.classList.remove("hidden");
}

backBtn.addEventListener("click",function(){
    if(window.history.length>1){
        window.history.back();
    }
})