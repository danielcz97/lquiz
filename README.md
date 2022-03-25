# L-Quiz Plugin

This plugin allow you to creating multiple language question tests as an administrator, then you can pass the test to users and they have possibility to pass the exam. You could also see theirs results, score, wrong answers and export it to PDF.

## Installation

Download this plugin and insert it to wp-content/plugins directory, then turn ON the plugin in yours WP-ADMIN section on "Plugins"

## Creating new questions Test

1. Go to Test post type.
2. Click on the "Add Test"

## Settings
![alt text](<https://gitlab.polcode.com/dczerepak/plugin/-/raw/master/images-readme/settings.PNG>)

1. You should input numbers of minutes that user have for pass the exam.
2. You can allow user pass the test multiple times.
3. You can allow user to show the result in the end of the exam.
4. You should allow to pass the exam for not logged in users.

## All new questions should be in the new line, after write one please press enter to go to the next line
## Questions Category 
### Insert a letter
![alt text](<https://gitlab.polcode.com/dczerepak/plugin/-/raw/master/images-readme/insertLetters.PNG>)

1. You should add each new question in new line in "Question" text area, the missing letter/'s replace with  doubel underscore "__". For example "du__y"
2. Answer list should has the same length to questions list
3. Answer should have only missing letter/letters for example "ch"

### Insert date
![alt text](<https://gitlab.polcode.com/dczerepak/plugin/-/raw/master/images-readme/insertDate.PNG>)

1. You should add each new question in new line in "Question" text area, the missing letter/'s replace with  triple percentage dots "%%%". For example "1. Taras Szewczenko urodził się %%% ".
2. Answer list should has the same length to questions list.
3. Answer should have the correct date matched to image. For Example "Dziewiątego marca".
4. On this question type you can also upload image to present date on img.

### Insert word
![Screenshot](https://gitlab.polcode.com/dczerepak/plugin/-/raw/master/images-readme/insertWord.PNG)

1. You should add each new question in new line in "Question" text area, the missing letter/'s replace with  triple percentage "%%%". For example "Chętnie piję (zielona herbata) %%%".
2. Answer list should has the same length to questions list.
3. Answer should have the correct word/words matched to question. For Example "zieloną herbatę".

### Insert time
![alt text](<https://gitlab.polcode.com/dczerepak/plugin/-/raw/master/images-readme/insertTime.PNG>)


1. You should add each new question in new line in "Question" text area. For example "6:25".
2. Answer list should has the same length to questions list.
3. Answer should have the correct time matched to question. For Example "szósta dwadzieścia pięć".

### Choice correct answer
![alt text](<https://gitlab.polcode.com/dczerepak/plugin/-/raw/master/images-readme/choiceCorrect.PNG>)


1. You should add each new question in new line in "Question" text area. Every word that would be choice input should be seperated by "/" also put "/" before or after rest of the answer, for example "Młode/młodzi /ludzie lubią się bawić w pubach.".
2. Answer list should has the same length to questions list.
3. Answer should have the correct answer matched to question. For Example "młodzi".

### Description task
![alt text](<https://gitlab.polcode.com/dczerepak/plugin/-/raw/master/images-readme/descriptTask.PNG>)


1. You should add question i "Question" text area.
2. Put maximum points that user could get from this question.




