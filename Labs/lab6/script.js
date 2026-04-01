// Suren Kulasegaram, 101220595
document.addEventListener("DOMContentLoaded", function () {
    const questionForm = document.getElementById("questionForm");
    const voteForm = document.getElementById("voteForm");
    const voteAgainBtn = document.getElementById("voteAgainBtn");
    const newQuestionBtn = document.getElementById("newQuestionBtn");

    const makePage = document.getElementById("makePage")
    const votePage = document.getElementById("votePage");
    const tallyPage = document.getElementById("tallyPage");

    const prompt = document.getElementById("prompt");           // prompt on the voting page
    const yesStat = document.getElementById("yesStat");
    const noStat = document.getElementById("noStat");



    let state = 0;      // 0 = make question page, 1 = vote page, 2 = tally page   
    let question = "";
    let yesCount = 0;
    let noCount = 0; 

    renderPage();

    // decide what to show based on state
    function renderPage() {
        if (state === 0) {
            makePage.style.display = "block";
            votePage.style.display = "none";
            tallyPage.style.display = "none";
        }
        else if (state === 1) {
            prompt.innerHTML = question + "?";
            makePage.style.display = "none";
            votePage.style.display = "block";
            tallyPage.style.display = "none";
        }
        else if (state === 2) {
            yesStat.innerHTML = "Yes: " + yesCount;
            noStat.innerHTML = "No: " + noCount;
            makePage.style.display = "none";
            votePage.style.display = "none";
            tallyPage.style.display = "block";
        }
        else {
            state = 0;          // in case we get in bad state
            renderPage()            
        }

    }

    // question submission
    questionForm.addEventListener("submit", function (e) {
        e.preventDefault();             // this is a function to stop the page from refreshing after form submission

        if (state !== 0) return;        // only do something if on question page

        const input = document.getElementById("question");

        question = input.value;
        yesCount = 0;
        noCount = 0;

        state = 1;
        renderPage();
    });

    // vote submission
    voteForm.addEventListener("submit", function (e) {
        e.preventDefault();

        if (state !== 1) return;

        const radios = document.getElementsByName("voteAnswer");        // get all the radios
        
        //checking yes
        if (radios[0].checked) {               // the selected radio has a checked = true attribute
            yesCount += 1;
            state = 2;
            renderPage();
        }
        else if (radios[1].checked) {
            noCount += 1;
            state = 2;
            renderPage();
        }
        else alert("Please pick Yes or No");
    });

    voteAgainBtn.addEventListener("click", function (e) {
        state = 1;
        renderPage();
    });

    newQuestionBtn.addEventListener("click", function (e) {
        state = 0;
        renderPage();
    })
});
