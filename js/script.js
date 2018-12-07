let categories_link = "http://tabithabjorkman.com/bifrost_t/json/categories.php";
let categoryTemplate = document.querySelector('.categoryTemplate').content;
let main = document.querySelector('main');
let skills_link = "http://tabithabjorkman.com/bifrost_t/json/skills.php";
let skillsTemplate = document.querySelector('.skillsTemplate').content;


function getCategories(catlink) {
    //console.log(catlink);
    fetch(catlink)
        .then(function (response) {
            return response.json()
        })
        .then(function (data) {
            data.forEach(createCategory);
            getData(categories_link);
        })

}

function createCategory(cat) {
    console.log(cat)
    let clone = categoryTemplate.cloneNode(true);
    clone.querySelector('h1').textContent = cat;

    main.appendChild(clone);
}

function getData(link) {
    fetch(link).then(function (response) {
        return response.json();
    }).then(function (json) {
        return show(json);
    });
}


function show(json) {
    json.forEach(function (cat) {
        let clone = categoryTemplate.cloneNode(true);
        clone.querySelector('.name').textContent = category_name;




    });
}

getCategories(categories_link)

function getSkills(skillslink) {
    //console.log(catlink);
    fetch(skillslink)
        .then(function (response) {
            return response.json()
        })
        .then(function (data) {
            data.forEach(createSkills);
            getData(skills_link);
        })

}

function createSkills(skills) {
    console.log(skills)
    let clone = skillsTemplate.cloneNode(true);
    clone.querySelector('.skill').textContent = skills;

    div.appendChild(clone);
}

getSkills(skills_link)
