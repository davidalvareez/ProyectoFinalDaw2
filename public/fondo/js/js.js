$(document).ready(function() {
    var orangeD = "#ffbf05",
        greenD = "#31fc40",
        blueD = "#2397ee",
        roseD = "#e6235f",
        purpleL = "#9c2bae",
        roseL = "#fc2e76",
        bgD = "#2e2e2e",
        bgL = "#fff",
        cont1 = true,
        cont2 = true;
    var toggledl = $(".more-css .toggle-darkl");
    $(".menu .widget-toggle .toggle-label").click(function() {

        if ($(".menu .widget-toggle .input-toggle").is(":checked")) {
            $("body").removeClass("darkmode");
            if (cont2) {
                toggledl.html(`<style> :root{--svgColor1: ${purpleL}; --svgColor2: ${bgL};--svgColor1a: ${roseL}; --svgColor2a: ${bgL}; --bgBody: ${bgL}} </style>`)
                cont2 = false;
            } else {
                toggledl.html(`<style> :root{--svgColor1a: ${purpleL}; --svgColor2a: ${bgL};--svgColor1: ${roseL}; --svgColor2: ${bgL}; --bgBody: ${bgL}} </style>`)
                cont2 = true;
            }
        } else {
            $("body").addClass("darkmode");
            if (cont1) {
                toggledl.html(`<style> :root{--svgColor1: ${orangeD}; --svgColor2: ${roseD}; --svgColor1a: var(--svgColor1); --svgColor2a: var(--svgColor2); --bgBody: ${bgD}} </style>`)
                cont1 = false;
            } else {
                toggledl.html(`<style> :root{--svgColor1: ${blueD}; --svgColor2: ${greenD}; --svgColor1a: var(--svgColor1); --svgColor2a: var(--svgColor2); --bgBody: ${bgD}} </style>`)
                cont1 = true;
            }

        }
    });
});