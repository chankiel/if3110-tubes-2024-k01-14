const applyForm = document.querySelector(".apply-form");
const inputCV = document.getElementById("cv");

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