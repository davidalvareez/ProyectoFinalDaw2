$(document).ready(function() {
    checkCookie();
    var orangeD = "#ffbf05",
        greenD = "#31fc40",
        blueD = "#2397ee",
        roseD = "#e6235f",
        purpleL = "#9c2bae",
        roseL = "#fc2e76",
        bgD = "#2e2e2e",
        bgL = "#fff";
    let darkmode = getCookie("darkmode");
    //alert(darkmode);
    var toggledl = $(".more-css .toggle-darkl");
    if (darkmode == 1) {
        toggledl.html(`<style> :root{--svgColor1: ${purpleL}; --svgColor2: ${bgL};--svgColor1a: ${roseL}; --svgColor2a: ${bgL}; --bgBody: ${bgL}} </style>`)
    } else if (darkmode == 2) {
        toggledl.html(`<style> :root{--svgColor1: ${orangeD}; --svgColor2: ${roseD}; --svgColor1a: var(--svgColor1); --svgColor2a: var(--svgColor2); --bgBody: ${bgD}} </style>`)
    } else if (darkmode == 3) {
        toggledl.html(`<style> :root{--svgColor1a: ${purpleL}; --svgColor2a: ${bgL};--svgColor1: ${roseL}; --svgColor2: ${bgL}; --bgBody: ${bgL}} </style>`)
    } else if (darkmode == 4) {
        toggledl.html(`<style> :root{--svgColor1: ${blueD}; --svgColor2: ${greenD}; --svgColor1a: var(--svgColor1); --svgColor2a: var(--svgColor2); --bgBody: ${bgD}} </style>`)
    }
    $(".menu .widget-toggle .toggle-label").click(function() {
        if ($(".menu .widget-toggle .input-toggle").is(":checked")) {
            $("body").removeClass("darkmode");
            if (darkmode == 1) {
                toggledl.html(`<style> :root{--svgColor1: ${purpleL}; --svgColor2: ${bgL};--svgColor1a: ${roseL}; --svgColor2a: ${bgL}; --bgBody: ${bgL}} </style>`)
                darkmode = 2;
                setCookie("darkmode", darkmode, 365);
            } else if (darkmode == 3) {
                toggledl.html(`<style> :root{--svgColor1a: ${purpleL}; --svgColor2a: ${bgL};--svgColor1: ${roseL}; --svgColor2: ${bgL}; --bgBody: ${bgL}} </style>`)
                darkmode = 4;
                setCookie("darkmode", darkmode, 365);
            }
        } else {
            $("body").addClass("darkmode");
            if (darkmode == 2) {
                toggledl.html(`<style> :root{--svgColor1: ${orangeD}; --svgColor2: ${roseD}; --svgColor1a: var(--svgColor1); --svgColor2a: var(--svgColor2); --bgBody: ${bgD}} </style>`)
                darkmode = 3;
                setCookie("darkmode", darkmode, 365);
            } else if (darkmode == 4) {
                toggledl.html(`<style> :root{--svgColor1: ${blueD}; --svgColor2: ${greenD}; --svgColor1a: var(--svgColor1); --svgColor2a: var(--svgColor2); --bgBody: ${bgD}} </style>`)
                darkmode = 1;
                setCookie("darkmode", darkmode, 365);
            }

        }
    });
});

function setCookie(cname, cvalue, exdays) {
    const d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    let expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    let name = cname + "=";
    let ca = document.cookie.split(';');
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function checkCookie() {
    let darkmode = getCookie("darkmode");
    if (darkmode != 0) {
        setCookie("darkmode", darkmode, 365);
    } else {
        darkmode = 1;
        setCookie("darkmode", darkmode, 365);
    }
}