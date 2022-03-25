window.addEventListener('DOMContentLoaded', () => {

    let startTestButton = document.querySelector('#start-test')
    startTestButton.addEventListener('click', () => {
        let sessionId = document.querySelector('.sessionId').value
        let postId = document.querySelector('.postid').value
        let timeTest = document.querySelector('.minutes').value
        let testContent = document.querySelector('.test-content')
        testContent.style.display = "none";

        let xhttp = new XMLHttpRequest();

        xhttp.open("POST", "http://test.test/wp-content/plugins/test2/public/partials/ajax.php?action=start&session="  + sessionId + '&minutes=' + timeTest + '&postid=' + postId, true);
        xhttp.send();
        showAnswersAfterSubmit('show');

    });


    let saveButton = document.querySelector('#saveButton');
    let testTitle = document.querySelector('.test-title').innerHTML;
    let postId = document.querySelector('.postid').value
    let sessionId = document.querySelector('.sessionId').value
    if(saveButton)
    saveButton.addEventListener('click', () => {
        let data = {
            'postid': postId,
            'sessionid': sessionId,
            'title':testTitle,
            'answer':[]
        };
        let allAnswers = document.getElementsByName('answer[]');

        allAnswers.forEach(e => {
            if(e.type === 'checkbox'){
                if(e.checked){
                    data['answer'].push(e.value);
                }

            }
            else{
                data['answer'].push(e.value);

            }

        })
        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                data = this.responseText;
            }
        };

        xhttp.open("POST", "http://test.test/wp-content/plugins/test2/public/partials/ajax.php?action=save", true);
        xhttp.send(JSON.stringify(data));
        showAnswersAfterSubmit('hide');
    })


    function showAnswersAfterSubmit(option='hide') {
        let validationForm = document.querySelector('.validationSession').value;
        let buttonStart = document.querySelector('#start-test')
        let testDescription = document.querySelector('.test-content')
        let showQuestions = document.querySelector('.form-questions')
        let testTime = document.querySelector('.test-time')
        let afterSubmit = document.querySelector('.after-submit')
        switch (option) {
            case "hide":
                showQuestions.style.display = "none";
                buttonStart.style.display = "none";
                testDescription.style.display = "none";
                testTime.style.display = "none";
                afterSubmit.style.display = "flex";
                afterSubmit.style.justifyContent = "space-around";
                break;
            case 'show':
                showQuestions.style.display = "block";
                buttonStart.style.display = "none";
                testDescription.style.display = "none";
                testTime.style.display = "none";
                afterSubmit.style.display = "none";
                afterSubmit.style.justifyContent = "space-around";
                break;
        }



    }

    let resetSession = document.querySelector('.reset-session')
    resetSession.addEventListener('click', () => {
        let xhttp = new XMLHttpRequest();

        xhttp.open("POST", "http://test.test/wp-content/plugins/test2/public/partials/ajax.php?action=reset", true);
        xhttp.send();

        setTimeout(function() {
            document.location.reload(true);
        }, 1000);
    })

});
