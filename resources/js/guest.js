function ready(fn) {
    if (document.readyState !== "loading") {
        fn();
    } else {
        document.addEventListener("DOMContentLoaded", fn);
    }
}

function initOnly(element = "", regex = null) {
    on(
        [
            "input",
            "keydown",
            "keyup",
            "mousedown",
            "mouseup",
            "select",
            "contextmenu",
            "drop",
        ],
        element,
        (el) => {
            el = el.target;

            if (regex.test(el.value)) {
                el.oldValue = el.value;
                el.oldSelectionStart = el.selectionStart;
                el.oldSelectionEnd = el.selectionEnd;
            } else if (el.hasOwnProperty("oldValue")) {
                el.value = el.oldValue;
                el.setSelectionRange(el.oldSelectionStart, el.oldSelectionEnd);
            } else {
                el.value = "";
            }
        }
    );
}

function onlyNumbers() {
    initOnly(".only-digits", /^\d*$/);
}

function onlyEmail() {
    initOnly(".only-email", /^[a-zA-Z_0-9\.\-@]*$/);
}

function onlyNoSpaces() {
    initOnly(".only-no-spaces", /^\S*$/);
}

ready(() => {
    onlyNumbers();
    onlyEmail();
    onlyNoSpaces();
});
