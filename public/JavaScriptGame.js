//setting variables from all the html components that will be used in the code

var startBtn= document.getElementById("start");
var answerList = document.querySelector(".list-group");
var liEl = document.querySelectorAll(".list-group-item");
var questionEl = document.getElementById("picture");
var ques =document.getElementById("question")
var test =document.getElementById("Text")
var timerEl = document.getElementById("timer");
var p = document.getElementById("hidden");
var pEl = document.querySelector("p");
//setting var to hold time limit 
var timeLimit = 120;
//setting array with all the questions
var color=[
    {
	   title:"Country/brazil-flag-small.png", 
	   question:" trouver le chiffre cachée dans les points",
       options:["Brazil","Argentine","Mexic","Venzula"],
       answer: "Brazil"
    },
	
	{
		title:"Country/france-flag-small.png", 
		question:" trouver le chiffre cachée dans les points",
		options:["belgique","France","Italie","Russia"],
		answer: "France"
    },
	{
		title:"Country/spain-flag-small.png",
    	question:"trouver le chiffre cachée dans les points",
		options:["Slovakia","Serbia","Portugal","Spain"],
		answer: "5"
    },
	{
		title:"Country/morocco-flag-small.png", 
	    question:"trouver le chiffre cachée dans les points",
		options:["Morocco","Tuis","Algerie","libiya"],
		answer: "Morocco"
    },
	{
		title:"Country/switzerland-flag-small.png", 
		question:"essayez de trouver le chiffre cachée dans les points",
		options:["Australia","Netherlands","switzerland","5"],
		answer: "switzerland"
    },
	{
		title:"Country/united-kingdom-flag-small.png",
		question:"trouver le chiffre cachée dans les points",
		options:["England","united-kingdom","Norway",""],
		answer: "united-kingdom"
    },
	{
		title:"Country/italy-flag-small.png",
	    question:"trouver le chiffre cachée dans les points",
		options:["Hungary","Italy","Ireland","France"],
		answer: "Italy"
    },
	{
		title:"Country/greece-flag-small.png",
		question:"trouver le chiffre cachée dans les points",
		options:["Cyprus","Turkey","Greece","Sweden"],
		answer: "Greece"
	}
	,
	{
		title:"Country/malta-flag-small.png",
		question:"trouver le chiffre cachée dans les points",
		options:["16","15","","Malta"],
		answer: "16"
	},{
		title:"Country/monaco-flag-small.png",
		question:"trouver le chiffre cachée dans les points",
		options:["Monaco","Poland","Austria","10"],
		answer: "Monaco"
	}
	


];
//Lets create a function to grab the questions array and populate the options elements with the array values
function myFunction(i) {
var x = document.createElement("IMG");
x.setAttribute("src", color[i].title);
x.setAttribute("width", "304");
x.setAttribute("height", "228");
x.setAttribute("alt", "The Pulpit Rock");
questionEl.appendChild(x);
}

function fillQuestion(i)
{
    ques.innerHTML="";
    ques.innerHTML+= color[i].question;
    questionEl.innerHTML=""
    myFunction(i)
    for (j= 0; j < liEl.length ; j++)
    {
        liEl[j].textContent = color[i].options[j];
    }
  

}
//Lets check which option the user has clicked then compare with the answer
// If the user picked the wrong answer he loses time


function checkA(time)
{
   var qCount = 0;
   var score = 0;
   
  
 answerList.addEventListener('click', event =>{
     if (event.target.classList.contains('list-group-item'))
     {
        var answer = color[qCount].answer;
         
        if (answer == event.target.textContent)
        {
            qCount++;
            score+=1;
        
          if (qCount < color.length && timeLimit > 0)
          {
            
            
            fillQuestion(qCount)
            console.log(score) 
          
          }
          else
          {
              qCount= 0;
              gameover(time,score)
              return
              
          }
        }
    else
    {
        qCount++;
        
        if (qCount < color.length && timeLimit > 0)
        {

        fillQuestion(qCount)

    
    }
    else
    {
        qCount= 0;
        gameover(time,score)
        return
    }
    }
        
     }
 })
 console.log(score) 
}

//This function takes care of the countdown in seconds and display to the user. 

function countDown() {
    
  
    
    var timeInterval = setInterval(function () {
     timeLimit--
     timerEl.textContent ="Temps: " + timeLimit + " seconds";
     //Game Over!
     if (timeLimit<=0)
     {
       clearInterval(timeInterval);
     
     }
     
    },1000);
    return timeInterval
  }

  //this function deals with the game over aspect of the quiz
  // it will stop the timer and hide the quiz elements
  // then it will show the user it's score which is a sum of the time left and the points for each right question
 

  function gameover(timeInterval,score)
  {
     
      clearInterval(timeInterval);
      pEl.style.display = "block";
      answerList.style.display = "none";
      questionEl.style.display="none";
      ques.style.display="none";
      if (score === 0)
      { 
        p.innerHTML+= " Félicitations!"

      }
      else
      {
       
        score++;  
        p.style.display="block"
        p.innerHTML+="<br>vous avez gagner "+score+" points<br> ";
    
     $.ajax({
   type:'POST',
   enctype: 'multipart/form-data',
   url:"/score" + '/' + score,
   contentType: false,
   processData: false,
   success:function(data){
        $('.alert-success').html(data.success).fadeIn('slow');
        $('.alert-success').delay(3000).fadeOut('slow');
   }
})
      

     


  }
}
  // this function will start the quiz once the startBtn has been clicked
  // It will take away the initial screen , start the timer and load the first question with it's options
function startQuiz(event)
{
timeLimit = 75;
test.style.display = "none";
answerList.style.visibility = "visible";
answerList.style.display = "block";
pEl.style.display = "none";
startBtn.style.display = "none";
timerEl.textContent ="Time: " + timeLimit + " seconds";
// fill up the first index of question and start the function to check if user clicked on the option
var time = countDown();
fillQuestion(0);

checkA(time);
}
startBtn.addEventListener("click",startQuiz)