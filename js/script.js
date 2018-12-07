"use strict"
function getData(){
    fetch("http://tabithabjorkman.com/bifrost_t/json/categories.php")
    //fetch("http://tabithabjorkman.com/bifrost_t/json/skills.php")
    .then(res => res.json())
    .then(showCategories)
    //.then(showSkills);
   
}
getData()

const catTemp = document.querySelector (".categoryTemplate").content; 

function showCategories(data){
    console.log(data);
        data.forEach(cat => {
            console.log(cat)
        const clone = catTemp.cloneNode(true);
        clone.querySelector(".name").textcontent = cat.category_name;
        console.log();
      
        document.querySelector("main").appendChild(clone);
        
    });
}
