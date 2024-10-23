function isHtmlStringEmpty(htmlString) {
  const tempDiv = document.createElement("div");
  tempDiv.innerHTML = htmlString;
  const textOnly = tempDiv.textContent || tempDiv.innerText || "";
  return textOnly.trim() === "";
}

function validateInput(input, errorElement, divElement) {
  if (input.value === "") {
    errorElement.classList.remove("hidden");
    divElement.classList.add("error-state");
    return true;
  } else {
    errorElement.classList.add("hidden");
    divElement.classList.remove("error-state");
    return false;
  }
}

function validateQuil(input, errorElement, divElement) {
  input.value = quill.root.innerHTML;
  console.log(input.value);
  if (isHtmlStringEmpty(input.value)) {
    errorElement.classList.remove("hidden");
    divElement.classList.add("error-state");
    return true;
  } else {
    errorElement.classList.add("hidden");
    divElement.classList.remove("error-state");
    return false;
  }
}

function removeError(inputElement, errorElement, divElement) {
  inputElement.addEventListener("change", function () {
    if (!errorElement.classList.contains("hidden")) {
      errorElement.classList.add("hidden");
      divElement.classList.remove("error-state");
    }
  });
}
