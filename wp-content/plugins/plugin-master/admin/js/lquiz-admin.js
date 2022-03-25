document.addEventListener("DOMContentLoaded", function(event) {
    if(document.body.classList.contains('post-php')) {
        jQuery(document).ready(function () {
            jQuery(document).on('click', '#remove-result', function (e) {
                e.preventDefault();
                let jQuerythis = jQuery(this);
                let li = jQuery('#the-list tr').length;
                if (li > 1) {
                    swal({
                        title: "Usunąć pytanie?",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55 ",
                        cancelButtonColor: "#DD6B55",
                        confirmButtonText: "Tak",
                        cancelButtonText: "Nie",
                        closeOnConfirm: true
                    }, function (isConfirm) {
                        if (!isConfirm) return;
                        if (isConfirm) jQuery('.remove-result-form').submit();
                    });
                } else {
                    swal("Nie możesz usunąć tego pytania", "", "error");
                }
            });

            let addNewQuestionButton = document.querySelector('#add-row');
            addNewQuestionButton.addEventListener('click', () => {
                addNewQuestion();
                setAllAtributes();
            })

            document.querySelectorAll('.remove-row')
                .forEach(item => {
                    item.addEventListener('click', function () {
                        let elem = document.querySelector('.custom-repeter-text');
                        this.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.remove();
                        let allAccordion = document.querySelectorAll('.accordion-item').length;
                        let allAnswers = document.querySelectorAll('.accordion-button')
                        for (i = 0; i <= allAnswers.length - 1; i++) {
                            allAnswers[i].parentElement.nextElementSibling.setAttribute('id', 'accordion' + i)
                            allAnswers[i].setAttribute('data-bs-target', '#accordion' + i)
                            allAnswers[i].setAttribute('aria-controls', 'accordion' + i)
                            allAnswers[i].innerHTML = "Question " + (i + 1);
                        }
                    })
                });

            document.querySelectorAll('.add-answer')
                .forEach(item => {
                    item.addEventListener('click', function () {
                        let lastRow = item.parentNode.previousElementSibling;
                        let clone = lastRow.cloneNode(true);
                        lastRow.before(clone);

                    })
                });

            document.querySelectorAll('.remove-answer').forEach(item => {
                item.addEventListener('click', () => {
                    let lengthOfAnswers = item.parentElement.parentElement.parentElement.children.length
                    if (lengthOfAnswers > 2) {
                        item.parentElement.parentElement.remove()
                    }
                })
            })
            let arrayWithAllAnswers = []
            let allAnswers = document.querySelectorAll('.textarea-field')

            for (i = 0; i < allAnswers.length; i++) {
                let singleAnswers = allAnswers[i].value;
                let singleAnswersSplit = singleAnswers.split(/\n/);

                singleAnswersSplit.forEach(element =>
                    arrayWithAllAnswers.push(element)
                )
            }

            let allAnswersLabel = document.querySelectorAll('#answer-label')
            let arrayWithAllAnswersLabels = [];
            for (i = 0; i < allAnswersLabel.length; i++) {
                arrayWithAllAnswersLabels.push(allAnswersLabel[i])
            }
            // const buildMap = (keys, values) => {
            //     const map = new Map();
            //     for (let i = 0; i < keys.length; i++) {
            //
            //         values[i].innerText = "Answer for: (" + keys[i] + ")";
            //         map.set(keys[i], values[i]);
            //     }
            //     ;
            //     return map;
            // };
            // let mapAnswerLabel = buildMap(arrayWithAllAnswers, arrayWithAllAnswersLabels);
            // for (i = 0; i < mapAnswerLabel.length; i++) {
            // }

            function addNewQuestion() {
                let lastRow = document.querySelectorAll('.empty-row.custom-repeter-text');
                let newRow = lastRow[lastRow.length - 1];
                let clone = newRow.cloneNode(true);

                let allAccordion = document.querySelectorAll('.accordion-item').length;
                newRow.style.display = "block";
                let allAnswers = document.querySelectorAll('#repeatable-question')

                for (i = 0; i <= allAnswers.length - 1; i++) {
                    newRow.before(clone);
                    newRow.firstElementChild.children[1].firstElementChild.children[2].children[2].firstElementChild.children[1].children[1].setAttribute('name', 'correct[' + (allAccordion) + "][]")
                    newRow.firstElementChild.firstElementChild.firstElementChild.setAttribute('aria-controls', 'new' + (allAccordion));
                    newRow.firstElementChild.firstElementChild.firstElementChild.setAttribute('data-bs-target', '#new' + (allAccordion))
                    newRow.firstElementChild.firstElementChild.firstElementChild.innerText = "Question " + (allAccordion + 1);
                    newRow.firstElementChild.childNodes[3].id = 'new' + (allAccordion);
                }
                document.querySelectorAll('.remove-row')
                    .forEach(item => {
                        item.addEventListener('click', function () {
                            let elem = document.querySelector('.custom-repeter-text');
                            this.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.remove();
                            let allAccordion = document.querySelectorAll('.accordion-item').length;
                            let allAnswers = document.querySelectorAll('.accordion-button')
                            for (i = 0; i <= allAnswers.length - 1; i++) {
                                allAnswers[i].parentElement.nextElementSibling.setAttribute('id', 'accordion' + i)
                                allAnswers[i].setAttribute('data-bs-target', '#accordion' + i)
                                allAnswers[i].setAttribute('aria-controls', 'accordion' + i)
                                allAnswers[i].innerHTML = "Question " + (i + 1);
                            }
                        })
                    });

                document.querySelectorAll('.remove-answer').forEach(item => {
                    item.addEventListener('click', () => {
                        item.parentElement.parentElement.remove()
                    })
                })
                return false;
            }

            setAllAtributes();

            function setAllAtributes() {

                let allAccordion = document.querySelectorAll('.accordion-item').length;

                let allAnswers = document.querySelectorAll('.accordion-button')
                for (i = 0; i <= allAnswers.length - 1; i++) {
                    allAnswers[i].parentElement.nextElementSibling.setAttribute('id', 'accordion' + i)
                    allAnswers[i].setAttribute('data-bs-target', '#accordion' + i)
                    allAnswers[i].setAttribute('aria-controls', 'accordion' + i)
                }
            }

            let getCategory = document.querySelectorAll(".category");
            let image = document.querySelector('.image-wrapper')
            let radioInputField = document.querySelectorAll('.form-check-input');
            let addAnswerButton = document.querySelector('.add-new-answer')
            let allRepeatableQuestion = document.querySelector('#repeatable-question');

            for (i = 0; i < getCategory.length; i++) {
                allRepeatableQuestion = getCategory[i].nextElementSibling.children[2];
                image = getCategory[i].nextElementSibling.children[3].children[2];

                let valueOfCategory = getCategory[i].value
                if (valueOfCategory == '0') {
                    allRepeatableQuestion.style.display = "block";
                    image.style.display = "none";
                    addAnswerButton.style.display = "block";

                } else if (valueOfCategory == '1') {
                    allRepeatableQuestion.style.display = "block";
                    image.style.display = "block";
                    addAnswerButton.style.display = "block";
                } else if (valueOfCategory == '2') {
                    allRepeatableQuestion.style.display = "block";
                    image.style.display = "none";
                    addAnswerButton.style.display = "block";

                } else if (valueOfCategory == '3') {
                    allRepeatableQuestion.style.display = "block";
                    image.style.display = "none";
                    addAnswerButton.style.display = "block";

                } else if (valueOfCategory == '4') {
                    allRepeatableQuestion.style.display = "block";
                    image.style.display = "none";
                    addAnswerButton.style.display = "block";


                } else if (valueOfCategory == '5') {
                    allRepeatableQuestion.style.display = "none";
                    addAnswerButton.style.display = "none";
                    image.style.display = "none";
                }
            }


            function switchCategoryOption(value, image, radio, answersList, addAnswerButton, allRepeatableQuestion) {
                switch (value) {
                    case '0':
                        allRepeatableQuestion.style.display = "block";
                        addAnswerButton.style.display = "block";

                        answersList.style.display = "block";
                        image.style.display = "none";
                        for (i = 0; i < radio.length; i++) {
                            radio[i].style.setProperty('display', 'none', 'important');
                        }
                        break;
                    case '1':
                        answersList.style.display = "block";
                        allRepeatableQuestion.style.display = "block";
                        addAnswerButton.style.display = "block";

                        image.style.display = "block";
                        for (i = 0; i < radio.length; i++) {
                            radio[i].style.setProperty('display', 'none', 'important');
                        }
                        break;

                    case '2':
                        allRepeatableQuestion.style.display = "block";
                        addAnswerButton.style.display = "block";

                        answersList.style.display = "block";
                        image.style.display = "none";
                        for (i = 0; i < radio.length; i++) {
                            radio[i].style.setProperty('display', 'none', 'important');
                        }
                        break;

                    case '3':
                        answersList.style.display = "block";
                        allRepeatableQuestion.style.display = "block";
                        addAnswerButton.style.display = "block";

                        image.style.display = "none";
                        for (i = 0; i < radio.length; i++) {
                            radio[i].style.setProperty('display', 'none', 'important');
                        }
                        break;

                    case '4':
                        allRepeatableQuestion.style.display = "block";
                        addAnswerButton.style.display = "block";

                        answersList.style.display = "block";
                        image.style.display = "none";
                        for (i = 0; i < radio.length; i++) {
                            radio[i].style.setProperty('display', 'block', 'important');
                        }
                        break;

                    case '5':
                        allRepeatableQuestion.style.display = "none";

                        addAnswerButton.style.display = "none";
                        image.style.display = "none";
                        answersList.style.setProperty('display', 'none', 'important');

                        for (i = 0; i < radio.length; i++) {
                            radio[i].style.setProperty('display', 'none', 'important');
                        }
                        break;
                }
            }

            for (i = 0; i < getCategory.length; i++) {
                getCategory[i].addEventListener('change', (e) => {
                    let dataDiv = (e.target).nextElementSibling;
                    let imageInputField = dataDiv.querySelector('.image-wrapper')
                    let radioInputField = dataDiv.querySelectorAll('.form-check-input');
                    let answersList = dataDiv.querySelector('.row-with-correct-answer')
                    let addAnswerButton = dataDiv.querySelector('.add-new-answer')
                    let allRepeatableQuestion = dataDiv.querySelector('#repeatable-question');
                    switchCategoryOption(e.currentTarget.value, imageInputField, radioInputField, answersList, addAnswerButton, allRepeatableQuestion)
                })
            }
        });

        jQuery(function (jQuery) {

            // on upload button click
            jQuery('body').on('click', '.misha-upl', function (e) {

                e.preventDefault();

                let button = jQuery(this),
                    custom_uploader = wp.media({
                        title: 'Insert image',
                        library: {
                            uploadedTo: wp.media.view.settings.post.id, // attach to the current post?
                            type: 'image'
                        },
                        button: {
                            text: 'Use this image' // button label text
                        },
                        multiple: true
                    }).on('select', function () { // it also has "open" and "close" events
                        let attachment = custom_uploader.state().get('selection').first().toJSON();
                        button.html('<img src="' + attachment.url + '">').next().next().val(attachment.id).next().show();
                    }).open();

            });

            // on remove button click
            jQuery('body').on('click', '.misha-rmv', function (e) {

                e.preventDefault();

                let button = jQuery(this);
                button.next().val(''); // emptying the hidden field
                button.hide().prev().html('Upload image');
            });

        });
    }
    let tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    let tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        this.addEventListener('hide.bs.tooltip', function () {
            new bootstrap.Tooltip(tooltipTriggerEl)
            console.log('xd')
        })
        return new bootstrap.Tooltip(tooltipTriggerEl)
        console.log('xd')

    });
    ///// add new users

    const tabs = document.querySelectorAll(".tab");
    let selectTeacher = document.querySelector('.selectteacher');
    let selectParent = document.querySelector('.selectparent');
    let userRole = document.querySelector('#userrole');
    for (let i = 0; i < tabs.length; i++) {
        tabs[i].addEventListener("click", () => {
            switch (tabs[i].classList.value){
             case "tab teacher":
                 selectTeacher.style.display = "none";
                 selectParent.style.display = "none";
                 userRole.value = 'teacher';
                 break;
             case "tab parent":
                 selectTeacher.style.display = "grid";
                 selectParent.style.display = "none";
                 userRole.value = 'parents';

                 break;
             case "tab student":
                 selectTeacher.style.display = "grid";
                 selectParent.style.display = "grid";
                 userRole.value = 'student';

                 break;

         }
        });
    }

});


