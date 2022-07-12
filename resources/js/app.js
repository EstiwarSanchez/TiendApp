require("./bootstrap");
import tippy from "tippy.js";
import "tippy.js/dist/tippy.css";
import "tippy.js/animations/scale-subtle.css";
import moment from "moment";
import "moment/locale/es";
window.moment = moment;
window.tippy = tippy;
var locale =
    document.documentElement.lang ||
    document.getElementsByTagName("html")[0].getAttribute("lang");
if (locale === "es" || locale === "base") {
    moment.locale("es");
}

function btnLoading(enable = true) {
    document.querySelectorAll(".btn-loading").forEach((elem) => {
        elem.disabled = enable;
        var classlist = elem.classList;
        !enable
            ? classlist.remove("pointer-events-none")
            : classlist.add("pointer-events-none");
        !enable ? classlist.remove("disabled") : classlist.add("disabled");
        if (elem.querySelectorAll(".button-loading").length) {
            if (enable) {
                elem.querySelector(".button-loading").classList.remove(
                    "hidden"
                );
                elem.querySelector(".button-text").classList.add("hidden");
            } else {
                elem.querySelector(".button-loading").classList.add("hidden");
                elem.querySelector(".button-text").classList.remove("hidden");
            }
        }
    });
}

axios.interceptors.request.use(
    function (config) {
        btnLoading();
        return config;
    },
    function (error) {
        btnLoading(false);
        return Promise.reject(error);
    }
);

axios.interceptors.response.use(
    function (response) {
        btnLoading(false);
        return response;
    },
    function (error) {
        btnLoading(false);
        return Promise.reject(error);
    }
);
