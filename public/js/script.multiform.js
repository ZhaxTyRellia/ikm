const nextBtns = document.querySelectorAll(".btn-next");
const formSteps = document.querySelectorAll(".form-step");

let formStepsNum = 0;

nextBtns.forEach((btn) => {
  btn.addEventListener("click", () => {
    if (formStepsNum < formSteps.length - 1) {
      formStepsNum++;
      formSteps.forEach((step) => step.classList.remove("form-step-active"));
      formSteps[formStepsNum].classList.add("form-step-active");
    }
  });
});
