// Suren Kulasegaram, 101220595

document.addEventListener("DOMContentLoaded", function() {

   const url = "https://www.randyconnolly.com/funwebdev/3rd/api/colors/sample-colors.php";
   const article = document.querySelector(".scheme-group");
   const loadGIF = document.querySelector("#loader");

   const h2 = document.querySelector("aside h2");        // get the h2 inside the aside
   const fieldset = document.querySelector("aside fieldset");     // get the fieldset inside the aside
   let schemes = [];       // will store fetched schemes to use for event handler

   loadGIF.style.display = "block";

   fetch(url)
   .then(response => response.json())
   .then(data => {
      loadGIF.style.display = "none";   // remove the load animation
      schemes = data;

      data.forEach(scheme => {
         const h3 = document.createElement("h3");
         h3.textContent = scheme.title;
         article.appendChild(h3);

         const section = document.createElement("section");
         section.classList.add("scheme");

         const preview = document.createElement("div");
         preview.classList.add("preview");

         scheme.scheme.forEach(color => {
            const colorBox = document.createElement("div");
            colorBox.classList.add("color-box");
            colorBox.style.backgroundColor = color.web;
            preview.appendChild(colorBox);
         })

         const action = document.createElement("div");
         action.classList.add("actions");

         const button = document.createElement("button");
         button.textContent = "View";
         button.dataset.id = scheme.id
         
         action.appendChild(button);

         section.appendChild(preview);
         section.appendChild(action);

         article.appendChild(section);
      })
      
      // event delegation
      article.addEventListener("click", event => {
         if (event.target.tagName !== "BUTTON") return;        // excite if button not clicked

         const id = event.target.dataset.id;                   // get id of clicked button
         
         const clickedScheme = schemes.find(scheme => {
            // scheme.id and id are different types so I'm forcing both to be string to compare
            return String(scheme.id) == String(id);       // check if the given id is current scheme id
         })

         fieldset.innerHTML = "";      // clear out the fieldset section before changing
         h2.textContent = clickedScheme.title;

         clickedScheme.scheme.forEach(color => {
            const colorRow = document.createElement("div");
            colorRow.classList.add("colorRow");

            const detailBox = document.createElement("div");
            detailBox.classList.add("detailBox");
            detailBox.style.backgroundColor = color.web;

            const hex = document.createElement("span");
            hex.textContent = color.web;

            const rgb = document.createElement("span");
            rgb.textContent = "rgb(" + color.color.red + "," + color.color.green + "," + color.color.blue + ")";

            const label = document.createElement("label");
            label.textContent = color.name;

            colorRow.appendChild(detailBox);
            colorRow.appendChild(hex);
            colorRow.appendChild(rgb);
            colorRow.appendChild(label);

            fieldset.appendChild(colorRow);
         })
      })


   })
   .catch(error => {
      loadGIF.style.display = "none";
      console.error("Error fetching data:", error)
   });
   
});



 
