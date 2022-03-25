let checkStatus;
if(document.querySelector('.status')){
     checkStatus = document.querySelector('.status').value;
}
let formQuestions = document.querySelector(".form-questions")
let startTestButton = document.querySelector("#start-test")
let testContent = document.querySelector(".test-content")
let testTime = document.querySelector(".test-time")


if (checkStatus == 'finished') {
    formQuestions.remove();
    startTestButton.style.display = "none";
    testContent.remove();

   let afterSubmit =  document.querySelector(".after-submit");
    afterSubmit.style.display = "flex";
    afterSubmit.style.justifyContent = "space-around";
}
else if(checkStatus == "running") {
    formQuestions.style.display = "block"
    startTestButton.style.display = "none";
    testContent.style.display = "none";
    testTime.style.display = "none";


}
window.addEventListener('DOMContentLoaded', () => {
    let questionNumberDots = document.querySelectorAll('.question_form').length
    let listDotNav = document.querySelector(".navigation-dots-ul");
    for(i = 0; i < questionNumberDots ; i++) {
        let li = document.createElement("li");
        li.classList.add('navigation-dots-li');
        li.id = 'list-item-' + (i + 1);
        li.appendChild(document.createTextNode(""));
        listDotNav.appendChild(li);
    }

    let allQuestions = document.querySelectorAll('.question_form');
    showTab();

    function showTab(tabNumber = 0) {
        let allQuestionSpan = document.querySelector('.question-all')
        if(allQuestionSpan)
        allQuestionSpan.innerHTML = allQuestions.length;

        for (i = 0; i < allQuestions.length; i++) {
            allQuestions[i].classList.add('hide');
            allQuestions[i].classList.remove('show');

        }
        if(allQuestions[tabNumber])
        if (allQuestions <= allQuestions[tabNumber]) ;
        {
            allQuestions[tabNumber].classList.add('show');

            fixStepIndicator(tabNumber)



        }
    }
    function markDot(number = 0) {
        let dots = document.querySelectorAll('.navigation-dots-li')
        let allQuestions = document.querySelectorAll('.question_form');

        for(i = 0; i < allQuestions.length; i++) {
           let allInputs = allQuestions[i].getElementsByTagName("input")
            check = 0;
          for(j = 0; j < allInputs.length; j++) {
              if(allInputs[j].value.length > 0){
                  check = 1;
              }
              if(check == 0) {
                  dots[i].style.backgroundColor = "";
              }
              else{
                  dots[i].style.backgroundColor = "#505050";

              }
          }
        }

    }

    let allNavigationDots = document.querySelectorAll('.navigation-dots-li')
    let currentStepDot = document.querySelector('.question-current')


    for(i = 0; i < allNavigationDots.length; i++) {
        allNavigationDots[i].onclick = function() {
            let index = this.getAttribute('id');
            currentTab = index.slice(10);
            showTab(parseInt(currentTab -1))
            currentStepDot.innerHTML = currentTab;
            markDot(currentTab -1)
        };
    }

    function fixStepIndicator(n) {
        let i, x = document.getElementsByClassName("question_form");
        let  navigationDots = document.getElementsByClassName("navigation-dots-li");

        for (i = 0; i < x.length; i++) {
            x[i].className = x[i].className.replace(" active-dot", "");
        }
        for (i = 0; i < navigationDots.length; i++) {
            navigationDots[i].className = navigationDots[i].className.replace(" active-dot", "");
        }
        if(x[n].classList.contains('passed')){

        }
        else{
            x[n].className += " passed";

        };
        x[n].className += " active-dot";

        navigationDots[n].className += " active-dot";
    }

    function currentStepNumber(nav) {
        let stepNum = 1;
        for (i = 0; i < allQuestions.length; i++) {
                if (!allQuestions[i].classList.contains('show')) {
                    continue;
                } else  {
                    stepNum += i;
                }
            }
        return stepNum;

    };
    let currentStep = currentStepNumber(1);
    let navNumber = document.querySelector('.question-current')

    let nextButton = document.querySelector('#nextButton')
    nextButton.addEventListener('click', () => {
        if(currentStepNumber(currentStep) < 9) {
            showTab(currentStepNumber(currentStep));
            navNumber.innerHTML = currentStepNumber(currentStep)
            markDot(currentStep -1)

        }
    })

    let currentStepMinus = currentStepNumber(0);
    let prevButton = document.querySelector('#prevButton')
    prevButton.addEventListener('click', () => {
        showTab(currentStepMinus);

    })



});