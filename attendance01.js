var taskcount = document.getElementsByClassName("personal_task");
console.log(taskcount);
for(var i=0; i < taskcount.length; i++){
    var taskNo[i] = taskcount[i].innerHTML;
    alert("taskNo[i]");
}