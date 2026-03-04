// Suren Kulasegaram, 101220595
document.addEventListener("DOMContentLoaded", function() { 

    const thumbnail = document.querySelector("#thumbBox");
    const figure = document.querySelector("figure img");
    const captionTitle = document.querySelector("figure figcaption em");
    const captionArtist = document.querySelector("figure figcaption span");
    const sliderBox = document.querySelector("#sliderBox");
    const reset = document.querySelector("#resetFilters");

    thumbnail.addEventListener("click", event => {
        if (event.target.tagName !== "IMG") return;

        let src = event.target.src; // this gives us a full path of where the file is
        // ex: images/medium/http://127.0.0.1:5500/Labs/lab4/images/small/painting2.jpg
        // we need to trim this to what we want, we'll split by '/' so the last element is always the file name
        src = src.split("/");
        src = src[src.length - 1];

        let alt = event.target.alt;
        let title = event.target.title;
            
        figure.src = "images/medium/" + src;
        captionTitle.innerText = alt;
        captionArtist.innerText = title;
    })

    sliderBox.addEventListener("input", event => {
        if (event.target.tagName !== "INPUT") return;

        // to have multiple filters active at once, we need to write each with a space in between at one time, so we need to read and re write every attribute
        const opacity = document.querySelector("#sliderOpacity").value;
        const saturation = document.querySelector("#sliderSaturation").value;
        const brightness = document.querySelector("#sliderBrightness").value;
        const hue = document.querySelector("#sliderHue").value;
        const gray = document.querySelector("#sliderGray").value;
        const blur = document.querySelector("#sliderBlur").value;

        figure.style.filter = `opacity(${opacity}%) saturate(${saturation}%) brightness(${brightness}%) hue-rotate(${hue}deg) grayscale(${gray}%) blur(${blur}px)`;

        // now we need the numbers beside the slider to be updated
        let sliderId = event.target.id;

        // sliderId is always sliderX where X is the changed item, so we slice out the X and add that to numX which is ID for the numbers
        let numId = sliderId.slice(6);
        numId = "#num" + numId;
        sliderId = "#" + sliderId;

        // get value for changed slider
        const sliderValue = document.querySelector(sliderId).value;

        const numberValue = document.querySelector(numId);
        numberValue.innerText = sliderValue;
    })

    reset.addEventListener("click", () => {
        figure.style.filter = "none";
    })

});