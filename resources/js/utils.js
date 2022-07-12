//Global variables
let charts = [];

ready(() => {
    var activeMenu = document.querySelectorAll('[x-data="{isOpen: true }"]');
    if (activeMenu.length) {
        activeMenu[activeMenu.length - 1].scrollIntoView({
            block: "end",
            behavior: "smooth",
        });
    }
});

function validateFile(target, multiple = false, extension = true, size = true) {
    var error = 0;
    var file = target;
    if (multiple) {
        for (let index = 0; index < file.files.length; index++) {
            if (extension && !error) {
                error = checkExtension(file.files[index]) ? 1 : 0;
            }
            if (size && !error) {
                error = checkSize(file.files[index]) ? 2 : 0;
            }
        }
    } else {
        if (extension && !error) {
            error = checkExtension(file.files[0]) ? 1 : 0;
        }
        if (size && !error) {
            error = checkSize(file.files[0]) ? 2 : 0;
        }
    }

    return error;
}

function checkSize(file, mb = 2) {
    var FileSize = file.size / 1024 / 1024; // in MB
    if (FileSize > mb) {
        return true;
    } else {
        return false;
    }
}

function checkExtension(file) {
    if (/\.(jpe?g|png|jpg)$/i.test(file.name) === false) {
        return true;
    } else {
        return false;
    }
}

function truncate(value, length = 20) {
    if (value.length > length) {
        value = value.substring(0, length - 3) + "...";
    }
    return value;
}

window.form = (addInit) => {
    return {
        addInit: addInit,
        inputElements: [],
        errors: [],
        init: function () {
            //Set up custom Iodine rules
            Iodine.addRule(
                "matchingPassword",
                (value) => value === document.getElementById("password").value
            );
            Iodine.messages.matchingPassword =
                __LANG__ === "es" || __LANG__ === "base"
                    ? "La confirmación de la contraseña debe coincidir con la contraseña"
                    : "Password confirmation needs to match password";
            Iodine.addRule("max", (value, param) => {
                return isInt(value) && parseInt(value) <= parseInt(param);
            });
            Iodine.messages.max = "El valor no debe ser mayor a [PARAM]";
            Iodine.addRule("min", (value, param) => {
                return isInt(value) && parseInt(value) >= parseInt(param);
            });
            Iodine.messages.min = "El valor no debe ser menor a [PARAM]";

            Iodine.addRule("range", (value) => {
                var valLength =
                    __LANG__ === "es" || __LANG__ === "base" ? 23 : 24;
                if (value.length === valLength) {
                    var dates =
                        __LANG__ === "es" || __LANG__ === "base"
                            ? value.split(" a ")
                            : value.split(" to ");
                    return (
                        dates[0].length === 10 &&
                        dates[1].length === 10 &&
                        moment(dates[0], "YYYY-MM-DD", true).isValid() &&
                        moment(dates[1], "YYYY-MM-DD", true).isValid()
                    );
                } else {
                    return false;
                }
            });
            Iodine.messages.range =
                __LANG__ === "es" || __LANG__ === "base"
                    ? "Seleccione un rango de fechas correcto"
                    : "Please select a correct date range";
            //Store an array of all the input elements with 'data-rules' attributes
            this.updateInputs();
        },
        updateInputs: function () {
            this.loadInputs();
            this.initDomData();
            this.updateErrorMessages();
        },
        loadInputs: function () {
            this.inputElements = [];
            this.inputElements.push(
                ...this.$el.querySelectorAll("input[data-rules]")
            );
            this.inputElements.push(
                ...this.$el.querySelectorAll("select[data-rules]")
            );
            this.inputElements.push(
                ...this.$el.querySelectorAll("textarea[data-rules]")
            );
        },
        initDomData: function (blurred = false) {
            //Create an object attached to the component state for each input element to store its state
            this.inputElements.map((ele) => {
                var rules =
                    ele.dataset.serverErrors.trim() != ""
                        ? ele.dataset.serverErrors.replace(/'/g, '"')
                        : "[]";
                rules = JSON.parse(rules);
                if (rules.length > 0) {
                    rules = rules.length == 1 ? [rules[0]] : rules;
                }
                this[(ele.dataset.validatewith||ele.id)] = {
                    serverErrors: rules,
                    blurred: blurred,
                    val: ele.value,
                };
            });
        },
        getElementForm :(id)=>{
            return this[id];
        },
        updateErrorMessages: function () {
            //map throught the input elements and set the 'errorMessage'
            this.inputElements.map((ele) => {
                this[(ele.dataset.validatewith||ele.id)].errorMessage = this.getErrorMessage(ele);
            });
        },
        getErrorMessage: function (ele) {
            //Return any global.error.servers if they're present
            if (this[(ele.dataset.validatewith||ele.id)].serverErrors.length > 0) {
                return input.serverErrors[0];
            }
            var rules =
                ele.dataset.rules.trim() != ""
                    ? ele.dataset.rules.replace(/'/g, '"')
                    : "[]";
            rules = JSON.parse(rules);
            if (rules.length > 0) {
                rules = rules.length == 1 ? [rules[0]] : rules;
                //Check using iodine and return the error message only if the element has not been blurred
                const error = Iodine.is(ele.value, rules);
                if (this[(ele.dataset.validatewith||ele.id)].blurred) {
                    if (error !== true) {
                        if (this.errors.indexOf((ele.dataset.validatewith||ele.id)) === -1) {
                            this.errors.push((ele.dataset.validatewith||ele.id));
                        }
                        return Iodine.getErrorMessage(error);
                    } else {
                        if (this.errors.indexOf((ele.dataset.validatewith||ele.id)) > -1) {
                            this.errors = this.errors.filter(
                                (item) => item !== (ele.dataset.validatewith||ele.id)
                            );
                        }
                    }
                }
            }

            //return empty string if there are no errors
            return "";
        },
        submitForm(e) {
            const invalidElements = this.inputElements.filter((input) => {
                var rules =
                    input.dataset.rules.trim() != ""
                        ? input.dataset.rules.replace(/'/g, '"')
                        : "[]";
                rules = JSON.parse(rules);
                if (rules.length > 0) {
                    rules = rules.length == 1 ? [rules[0]] : rules;
                    var error = Iodine.is(input.value, rules);
                    if (error !== true) {
                        if (this.errors.indexOf((input.dataset.validatewith||input.id)) === -1) {
                            this.errors.push((input.dataset.validatewith||input.id));
                        }
                    } else {
                        if (this.errors.indexOf((input.dataset.validatewith||input.id)) > -1) {
                            this.errors = this.errors.filter(
                                (item) => item !== (input.dataset.validatewith||input.id)
                            );
                        }
                    }
                    return error !== true;
                }
            });
            if (invalidElements.length > 0) {
                e.preventDefault();
                document
                    .getElementById(invalidElements[0].id)
                    .parentElement.parentElement.scrollIntoView({
                        behavior: "smooth",
                    });
                //We set all the inputs as blurred if the form has been submitted
                this.inputElements.map((input) => {
                    this[(input.dataset.validatewith||input.id)].blurred = true;
                });
                //And update the error messages.
                this.updateErrorMessages();
            } else {
                this.$el.dispatchEvent(new CustomEvent("submit"));
            }
        },
        changeInput: function (event) {
            this.loadInputs();
            // setTimeout(() => {

            //Ignore all events that aren't coming from the inputs we're watching
            if (!this[(event.target.dataset.validatewith||event.target.id)]) {
                return false;
            }
            this[(event.target.dataset.validatewith||event.target.id)].val = event.target.value;
            if (event.type === "input") {
                this[(event.target.dataset.validatewith||event.target.id)].serverErrors = [];
            }
            if (event.type === "change") {
                this[(event.target.dataset.validatewith||event.target.id)].serverErrors = [];
            }
            if (event.type === "focusout") {
                this[(event.target.dataset.validatewith||event.target.id)].blurred = true;
            }

            //Whether blurred or on input, we update the error messages
            this.updateErrorMessages();
            // }, 1000);
        },
    };
};



window.formBuilder = (template_html_id, template_json_id) => {
    return {
        id: null,
        init(json = null) {
            localStorage.removeItem("elementData");
            localStorage.removeItem("currentElement");
            if (json != null) {
                var namedElements= json.filter(
                    (key) => typeof key.name != "undefined"
                );
                var id_ = Math.round(+new Date()/1000)
                if (namedElements.length>0) {
                    id_ = namedElements[0].name;
                    id_ = id_.split("_")[2];
                }
                this.id = id_;
                localStorage.setItem("format_template_edit", true);
                localStorage.setItem("format_template_id", this.id);
                json.forEach((element) => {
                    var el = document
                        .getElementById("form-element")
                        .querySelector(`#item-${element.type}`)
                        .firstElementChild.cloneNode(true);
                    this.defineElement(el, this.id);
                    setTimeout(() => {
                        if (
                            element.type == "text" ||
                            element.type == "digits" ||
                            element.type == "textarea" ||
                            element.type == "select" ||
                            element.type == "file" ||
                            element.type == "date" ||
                            element.type == "radio"
                        ) {
                            el.__x.$data.required = element.required;
                            el.__x.$data.disabled = element.disabled;
                            if (element.type != "file") {
                                el.__x.$data.readonly = element.readonly;
                                el.__x.$data.value = element.value;
                            } else {
                                el.__x.$data.multiple = element.multiple;
                            }
                            if (
                                element.type == "select" ||
                                element.type == "radio"
                            ) {
                                el.__x.$data.options = element.options;
                            } else {
                                el.__x.$data.maxlength = element.maxlength;
                            }
                            el.__x.$data.label = element.label;
                            el.id = element.name;
                            el.name = element.name;
                        } else {
                            el.__x.$data.text = element.text;
                        }
                    }, 100);
                });
                this.saveFormat()
            } else {
                if (localStorage.getItem("format_template_edit") === "true") {
                    localStorage.removeItem("format_template_edit");
                    this.resetFormat();
                }
                document.getElementById("form-preview").innerHTML =
                    localStorage.getItem("format_template_html") || "";

                document.getElementById(template_html_id).value =
                    localStorage.getItem("format_template_html") || "";
                document.getElementById(template_json_id).value = (
                    localStorage.getItem("format_template_json") || ""
                ).replace(/(\r\n|\n|\r)/gm, "\n");
            }
        },
        adding: false,
        removing: false,
        json: localStorage.getItem("format_template_json") || [],
        target: document.getElementById("form-preview"),
        drop(event, id) {
            this.id = localStorage.getItem("format_template_id") || id;
            const element = document
                .getElementById(event.dataTransfer.getData("text/plain"))
                .firstElementChild.cloneNode(true);
            this.defineElement(element, this.id);

            setTimeout(() => {
                localStorage.setItem(
                    "format_template_html",
                    document.getElementById("form-preview").innerHTML
                );
            }, 500);

            localStorage.setItem("format_template_id", this.id);
            this.saveFormat();
        },
        defineElement(element, id) {
            var type =
                element.dataset.type || element.getAttribute("data-type");
            var cnt = this.target.childElementCount + 1;
            element.id = `div_${type}_${id}_${cnt}`;
            this.target.appendChild(element);
            var input = null;
            if (
                type == "text" ||
                type == "digits" ||
                type == "date" ||
                type == "file"
            ) {
                input = element.querySelector("input");
                input.id = `${type}_${id}_${cnt}`;
                element.querySelector('.validate-msg').setAttribute('data-validate',input.id)
                element.querySelector('.validate-msg').setAttribute("x-show.transition.in",`${input.id}.errorMessage`);
                element.querySelector('.validate-msg').setAttribute("x-text",`${input.id}.errorMessage`);
                input.name = `${type}_${id}_${cnt}`;
                element.querySelectorAll("input-label").forEach((lb) => {
                    lb.setAttribute("for", input.id);
                });
            }
            if (type == "select") {
                input = element.querySelector("select");
                input.id = `${type}_${id}_${cnt}`;
                input.name = `${type}_${id}_${cnt}`;
                element.querySelector('.validate-msg').setAttribute('data-validate',input.id)
                element.querySelector('.validate-msg').setAttribute("x-show.transition.in",`${input.id}.errorMessage`);
                element.querySelector('.validate-msg').setAttribute("x-text",`${input.id}.errorMessage`);
            }
            if (type == "textarea") {
                input = element.querySelector("textarea");
                input.id = `${type}_${id}_${cnt}`;
                input.name = `${type}_${id}_${cnt}`;
                element.querySelector('.validate-msg').setAttribute('data-validate',input.id)
                element.querySelector('.validate-msg').setAttribute("x-show.transition.in",`${input.id}.errorMessage`);
                element.querySelector('.validate-msg').setAttribute("x-text",`${input.id}.errorMessage`);
            }
            element.querySelector(".edit-options").classList.remove("hidden");
            element
                .querySelector(".actions-buttons")
                .classList.remove("hidden");
            element.classList.add("relative");
            if (type != "title" && type != "subtitle") {
                setTimeout(() => {
                    element.__x.$data.disabled = false;
                    element.__x.$data.$refresh();
                    var dataEl =
                        element.dataset["x-data"] ||
                        element.getAttribute("x-data");
                    dataEl = dataEl.replace(
                        "disabled: true",
                        "disabled: false"
                    );
                    dataEl = dataEl.replace("disabled:true", "disabled: false");
                    element.setAttribute("x-data", dataEl);
                }, 10);
            }
        },
        saveFormat() {
            setTimeout(() => {
                var form = document
                    .getElementById("form-preview")
                    .cloneNode(true);
                this.json = [];
                form.querySelectorAll(
                    ".edit-options, .actions-buttons, template"
                ).forEach((element) => {
                    element.remove();
                });
                document
                    .getElementById("form-preview")
                    .querySelectorAll("[data-type]")
                    .forEach((element) => {
                        var type =
                            element.dataset.type ||
                            element.getAttribute("data-type");
                        if (
                            type == "text" ||
                            type == "digits" ||
                            type == "textarea"
                        ) {
                            this.json.push({
                                type: type,
                                required: element.__x.$data.required,
                                disabled: element.__x.$data.disabled,
                                readonly: element.__x.$data.readonly,
                                maxlength: element.__x.$data.maxlength,
                                value: element.__x.$data.value,
                                label: element.__x.$data.label,
                                name: element.id,
                            });
                        } else if (type == "select" || type == "radio") {
                            this.json.push({
                                type: type,
                                required: element.__x.$data.required,
                                disabled: element.__x.$data.disabled,
                                readonly: element.__x.$data.readonly,
                                options: element.__x.$data.options,
                                label: element.__x.$data.label,
                                name: element.id,
                                value: element.__x.$data.value,
                            });
                        } else if (type == "date") {
                            this.json.push({
                                type: type,
                                required: element.__x.$data.required,
                                disabled: element.__x.$data.disabled,
                                readonly: true,
                                today: element.__x.$data.today,
                                label: element.__x.$data.label,
                                name: element.id,
                                value: element.__x.$data.value,
                            });
                        } else if (type == "file") {
                            this.json.push({
                                type: type,
                                required: element.__x.$data.required,
                                disabled: element.__x.$data.disabled,
                                multiple: element.__x.$data.multiple,
                                label: element.__x.$data.label,
                                name: element.id,
                            });
                        } else {
                            this.json.push({
                                type: type,
                                text: element.__x.$data.text,
                                name: type,
                            });
                        }
                    });
                form.querySelectorAll("*").forEach((element) => {
                    [
                        "x-data",
                        "x-show",
                        "x-model",
                        "x-text",
                        "x-bind:value",
                        "x-bind:selected",
                        "x-bind:disabled",
                        "x-bind:placeholder",
                        "x-bind:readonly",
                        "x-bind:data-rules",
                        "x-bind:data-server-errors",
                        "x-bind:maxlength",
                        "x-bind:multiple",
                        "x-bind:class",
                        "x-bind:id",
                        "x-bind:init",
                        "x-bind:name",
                    ].forEach((attr) => {
                        var type =
                            element.dataset.type ||
                            element.getAttribute("data-type");
                        if (typeof type != 'undefined' && type=='date' && element.querySelectorAll("[data-wrapper='date']").length>0&& attr=='x-data') {
                            element.querySelector("[data-wrapper='date']").setAttribute(`x-data`, '{}')
                            element.querySelector("[data-wrapper='date']").setAttribute(`x-data`, '{}')
                            element.querySelector("[data-wrapper='date']").setAttribute(
                                "x-bind:class",
                                `{'invalid':${element.querySelector("[data-wrapper='date']").querySelector("input").id}.errorMessage}`
                            );
                            element.querySelector("[data-wrapper='date']").setAttribute(`x-init`, `flatpickr($el.querySelector('input'), { minDate: ${(getParentX(element.id).today ? '"today"' : null)}, enableTime:${(getParentX(element.id).time ? 'today' : null)}, 'locale': '${(__LANG__=="base" ? "es" : "en")}', defaultDate: '${getParentX(element.id).value}'})`);
                            element.removeAttribute(attr);
                        }
                        if (element.dataset.wrapper == undefined && element.tagName!='P') {
                            element.removeAttribute(attr);
                        }

                    });
                });

                form.querySelectorAll('input, select, textarea').forEach(input => {
                    if (input.tagName == "INPUT" && input.type == "radio") {
                        input.setAttribute(
                            "data-validatewith",
                            `${input.name}`
                        );
                        input.setAttribute(
                            "x-bind:class",
                            `{'invalid':${input.name}.errorMessage}`
                        );
                    } else {
                        input.setAttribute("value",input.value);
                        input.setAttribute(
                            "x-bind:class",
                            `{'invalid':${input.id}.errorMessage}`
                        );
                    }
                    var validate= document.querySelector(`[data-validate="${input.id}"]`);

                    validate.setAttribute("x-show.transition.in",`${input.id}.errorMessage`);
                    validate.setAttribute("x-text",`${input.id}.errorMessage`);
                });

                localStorage.setItem(
                    "format_template_json",
                    JSON.stringify(this.json).replace(/(\r\n|\n|\r)/gm, "\n")
                );

                document.getElementById(template_html_id).value =
                    form.innerHTML;
                document.getElementById(template_json_id).value =
                    JSON.stringify(this.json).replace(/(\r\n|\n|\r)/gm, "\n");
            }, 500);
        },
        resetFormat($dispatch) {
            document.getElementById("form-preview").innerHTML = "";
            localStorage.setItem("format_template_html", "");
            localStorage.setItem("format_template_json", "");
            localStorage.removeItem("format_template_id");
            $dispatch("notice", {
                type: "info",
                title: LANG["global.successful"],
                text: "Plantilla limpiada",
            });
        },
    };
};

function getParentX(selector, by = 'id'){
    if (by=='id') {
        return document.getElementById(selector).__x.$data;
    }
    if (by=='selector') {
        return document.querySelector(selector).__x.$data;
    }

}

// function setProperty(element, property, value) {
//     if (typeof element.__x.$data[property] != "undefined") {
//         var dataEl =
//             element.dataset["x-data"] || element.getAttribute("x-data");

//         if (element.id === localStorage.getItem("currentElement")) {
//             dataEl = localStorage.getItem("elementData");
//         }
//         if (property == "options") {
//             // localStorage.setItem(element.id+'_options',JSON.stringify(element.__x.$data[property]))
//         } else {
//             value = value ? "true" : "false";
//             dataEl = dataEl.replace(
//                 `${property}: true`,
//                 `${property} : ${value}`
//             );
//             dataEl = dataEl.replace(
//                 `${property}: false`,
//                 `${property} : ${value}`
//             );
//             dataEl = dataEl.replace(
//                 `${property}:true`,
//                 `${property} : ${value}`
//             );
//             dataEl = dataEl.replace(
//                 `${property}:false`,
//                 `${property} : ${value}`
//             );
//             dataEl = dataEl.replace(
//                 `${property} : true`,
//                 `${property} : ${value}`
//             );
//             dataEl = dataEl.replace(
//                 `${property} : false`,
//                 `${property} : ${value}`
//             );
//             dataEl = dataEl.replace(
//                 `${property} :true`,
//                 `${property} : ${value}`
//             );
//             dataEl = dataEl.replace(
//                 `${property} :false`,
//                 `${property} : ${value}`
//             );
//         }
//         element.__x.$data.$refresh();
//         localStorage.setItem("elementData", dataEl);
//         localStorage.setItem("currentElement", element.id);
//     }
// }

function setElementData(element) {
    if (element.id === localStorage.getItem("currentElement")) {
        element.setAttribute("x-data", localStorage.getItem("elementData"));
        setTimeout(() => {
            localStorage.setItem(
                "format_template_html",
                document.getElementById("form-preview").innerHTML
            );
        }, 100);
        setTimeout(() => {
            document.getElementById("form_builder").__x.$data.saveFormat();
        }, 200);
    }
}

function updateSqueare() {
    document.querySelectorAll(".square").forEach((element) => {
        element.style.height = element.clientWidth + "px";
    });
}

window.addEventListener("resize", function (event) {
    updateSqueare();
});

function proccessErrors(errors) {
    var msg = "";
    if (isObject(errors)) {
        for (let [key, error] of Object.entries(errors)) {
            msg += "• " + error[0] + "<br>";
        }
    }
    return msg;
}

function on(event, querySelector, callback) {
    if (isArray(event)) {
        event.forEach((e) => {
            addEvent(e, querySelector, callback);
        });
    } else {
        addEvent(event, querySelector, callback);
    }
}

function addEvent(e, querySelector, callback) {
    document.querySelector("body").addEventListener(
        e,
        (evt) => {
            var targetElement = evt.target;
            while (targetElement != null) {
                if (targetElement.matches(querySelector)) {
                    callback(evt);
                    return;
                }
                targetElement = targetElement.parentElement;
            }
        },
        true
    );
}

function addOption(id, text, val, selected = true) {
    var el = document.getElementById(id);
    var select = el.parentElement.__x.$data.select;
    select.AppendOption({
        position: "beforeend",
        options: {
            0: {
                inner_text: text,
                value: val,
                selected: selected,
            },
        },
    });
    select.Update();
    el.parentElement.__x.$data.select = select;
    el.parentElement.__x.$data.$refresh();
    setTimeout(() => {
        updateSelect(id);
    }, 100);
}

function isInt(str) {
    return !isNaN(str) && Number.isInteger(parseFloat(str));
}

function isElement(obj) {
    try {
        return obj instanceof HTMLElement;
    } catch (e) {
        return (
            typeof obj === "object" &&
            obj.nodeType === 1 &&
            typeof obj.style === "object" &&
            typeof obj.ownerDocument === "object"
        );
    }
}
async function getRequest(url, params = {}) {
    return new Promise((resolve, reject) => {
        axios({
            method: "get",
            url: url,
            params: params,
        })
            .then((response) => {
                resolve(response.data);
            })
            .catch((error) => {
                reject(error);
            });
    });
}

async function getFormModal(url, modal_id, modal = true, append = false) {
    return new Promise((resolve, reject) => {
        axios({
            method: "get",
            url: url,
        })
            .then(function (response) {
                var content = document.getElementById(modal_id);
                content = modal
                    ? content.querySelector(".content-modal")
                    : content;
                if (append) {
                    content.insertAdjacentHTML("beforeend", response.data);
                } else {
                    content.innerHTML = "";
                    content.innerHTML = response.data;
                }
                if (modal) {
                    showModal(modal_id);
                }
                resolve(response.data);
            })
            .catch(function (error) {
                enableButtons();
                reject(error);
            });
    });
}

function objectToQueryString(obj) {
    var str = [];
    for (var p in obj)
        if (obj.hasOwnProperty(p)) {
            str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
        }
    return str.join("&");
}

async function sendForm(url, formData, modal_id = "", $dispatch, alert = true) {
    return new Promise((resolve, reject) => {
        axios
            .post(url, formData)
            .then(function (response) {
                var data = response.data;
                if (data.status == 0) {
                    if (alert) {
                        if (typeof data.errors != "undefined") {
                            $dispatch("notice", {
                                type: "error",
                                title: data.message,
                                text: proccessErrors(data.errors),
                            });
                        } else {
                            $dispatch("notice", {
                                type: "error",
                                title: "Error",
                                text: data.message,
                            });
                        }
                    }
                } else {
                    if (alert) {
                        $dispatch("notice", {
                            type: "success",
                            title: LANG["global.successful"],
                            text: data.message || "",
                        });
                    }
                    Livewire.emit("table-updated");
                    if (modal_id != "") {
                        hideModal(modal_id);
                    }
                }
                resolve(response.data);
            })
            .catch(function (error) {
                enableButtons();
                if (alert) {
                    $dispatch("notice", {
                        type: "error",
                        title: "Error",
                        text: LANG["global.error.server"],
                    });
                }
                reject(error);
            });
    });
}

async function sendDelete(url, modal_id = "", $dispatch, params = {}) {
    return new Promise((resolve, reject) => {
        axios
            .delete(url, { params: params })
            .then(function (response) {
                var data = response.data;
                if (data.status == 0) {
                    $dispatch("notice", {
                        type: "error",
                        title: data.message,
                        text: proccessErrors(data.errors),
                    });
                } else {
                    $dispatch("notice", {
                        type: "success",
                        title: LANG["global.successful"],
                        text: data.message,
                    });
                    Livewire.emit("table-updated");
                    if (modal_id != "") {
                        hideModal(modal_id);
                    }
                }
                resolve(response.data);
            })
            .catch(function (error) {
                enableButtons();
                $dispatch("notice", {
                    type: "error",
                    title: "Error",
                    text: LANG["global.error.server"],
                });
                reject(error);
            });
    });
}

function runEvent(event, querySelector) {
    if (isArray(event)) {
        event.forEach((e) => {
            callEvent(e, querySelector);
        });
    } else {
        callEvent(event, querySelector);
    }
}

function callEvent(event, querySelector) {
    var e = null;
    if (isElement(querySelector)) {
        e = document.createEvent("HTMLEvents");
        e.initEvent(event, true, false);
        querySelector.dispatchEvent(e);
    }else{
        document.querySelectorAll(querySelector).forEach((el) => {
            e = document.createEvent("HTMLEvents");
            e.initEvent(event, true, false);
            el.dispatchEvent(e);
        });
    }
}

function selectAllOptions(list_id, selected = true){
    var elements = [...document.getElementById(list_id).querySelectorAll('.nice-option')].filter((x)=>{
        if (selected) {
            return x.getAttribute("style") == null ? true : (x.getAttribute("style").indexOf("background-color: rgb(236, 236, 236);") == -1);
        }else{
            return x.getAttribute("style") == null ? false : (x.getAttribute("style").indexOf("background-color: rgb(236, 236, 236);") != -1);
        }
    });
    console.log(elements);
    if (elements.length>0) {
        elements.forEach(element => {
            runEvent("click",element);
        });
    }
}

function proccessOptions(id, options, instance, build = false, preselect = false) {
    options = typeof options === "object" ? options : [];
    var pbSelect = instance.select;
    var select = typeof id == "object" ? id : document.getElementById(id);

    const selectedOpts = [...select.options].filter((x) => x.selected && x.value!='');
    const selectedValues = [...select.options].filter(x => x.selected).map(x=>x.value);

    select.innerHTML = `<option value="" disabled selected>${LANG["global.select.blank"]}</option>`;
    select.options.length =
        typeof select.options.length != "undefined" ? select.options.length : 1;

    if (options.length > 0) {
        options.forEach(element => {
            if (!selectedValues.includes(String(element.id))|| !preselect) {
                select[select.options.length] = new Option(
                    element.text,
                    element.id,
                    false,
                    false
                );
            }
        });
    }
    if (selectedOpts.length>0 && preselect) {
        selectedOpts.forEach(element => {
            select[select.options.length] = new Option(
                element.text,
                element.value,
                true,
                true
            );
        });
    }
    if (pbSelect == null) {
        pbSelect = new PBSelect({
            selector: `#${select.id}`,
            width: "100%",
            searchbox: true,
            placeholder: `${LANG["global.select.blank"]}`,
            search_placeholder: `${LANG["global.button.find"]}...`,
        });
    } else {
        if (build) {
            var config = pbSelect.getOptions();
            pbSelect.Destroy();
            pbSelect = new PBSelect(config);
        }
    }
    setTimeout(() => {
        pbSelect.Update();
        instance.select = pbSelect;
        instance.$refresh();
    }, 10);
}

function updateSelect(id, val = null, disabled = false) {
    var el = document.getElementById(id);
    if (val != null) {
        el.value = val;
    }
    var config = el.parentElement.__x.$data.select.getOptions();
    var select = el.parentElement.__x.$data.select;
    select.Destroy();
    el.parentElement.__x.$data.disabled = disabled;
    el.disabled = disabled;
    if (disabled) {
        el.classList.add("disabled");
    } else {
        el.classList.remove("disabled");
    }

    select = new PBSelect(config);
    el.parentElement.__x.$data.select = select;
    el.parentElement.__x.$data.$refresh();
    runEvent("change", id);
}

Livewire.on('searchSelect', (params) => {
    if (
        params[0].id == "work_center" ||
        params[0].id == "work_center_id" ||
        params[0].id == "novelty_work_center_id" ||
        params[0].id == "create_work_center_id" ||
        params[0].id == "work_center_id_multiple" ||
        params[0].id == "edit_work_center_id"
    ) {
        var url = `${__PATH__}/${__LANG__}/sig_workcenters/get_work_centers`;
        var query = {
            params: {
                select: ["id", "name"],
                search: params[1],
                limit: 10,
            },
        };
        getOptionsByParams(params[0].id, url, "name", "id", query);
    }
})

function getOptionsByParams(
    id,
    url,
    text = "",
    val = "",
    params = { search: "" },
    build = false
) {
    var elm = document.getElementById(id);
    if (elm != null) {
        var instance = elm.parentElement.__x.$data;
        axios({
            method: "get",
            url: url,
            params: params,
        })
            .then(function (response) {
                var data = [];
                response.data.forEach((item) => {
                    var txt = '';
                    var vl = '';

                    if (isArray(text)) {
                        text.forEach((t,i) => {
                            txt += item[t]+ ((i+1)>=text.length ? '' : ' - ')
                        });
                    }else{

                        txt = item[text]
                    }

                    if (isArray(val)) {
                        val.forEach((t,i) => {
                            vl += item[t]+ ((i+1)>=val.length ? '' : '-')
                        });
                    }else{
                        vl = item[val]
                    }

                    data.push({
                        text: txt,
                        id: vl,
                    });
                });
                proccessOptions(id, data, instance, build);
            })
            .catch(function (error) {
                console.log(error);
            });
    }
}

function httpGet(url, params = {}, $dispatch) {
    axios({
        method: "get",
        url: url,
        params: params,
    })
        .then((response) => {
            var data = response.data;
            if (data.status == 0) {
                $dispatch("notice", {
                    type: "error",
                    title: data.message,
                    text: proccessErrors(data.errors),
                });
            } else {
                $dispatch("notice", {
                    type: "success",
                    title: LANG["global.successful"],
                    text: data.message,
                });
                Livewire.emit("table-updated");
            }
        })
        .catch((error) => {
            enableButtons();
            $dispatch("notice", {
                type: "error",
                title: "Error",
                text: LANG["global.error.server"],
            });
        });
}

function enableButtons() {
    document.querySelectorAll(".btn-loading").forEach((elem) => {
        elem.disabled = false;
        elem.classList.remove("pointer-events-none");
        elem.classList.remove("disabled");
        if (elem.querySelectorAll(".button-loading").length) {
            elem.querySelector(".button-loading").classList.add("hidden");
            elem.querySelector(".button-text").classList.remove("hidden");
        }
    });
}

Livewire.on("updateTippy", () => {
    updateTippy();
});

function updateTippy() {
    var count = 0;
    var interval = setInterval(() => {
        document.querySelectorAll("[data-tippy-content]").forEach((element) => {
            if (typeof element._tippy == "undefined") {
                tippy(element, { animation: "scale-subtle" });
            } else {
                //element._tippy.destroy();
                //tippy(element, { animation: "scale-subtle" });
            }
        });
        count++;
        if (count == 20) {
            document
                .querySelectorAll("[data-tippy-content]")
                .forEach((element) => {
                    if (typeof element._tippy == "undefined") count = 0;
                });
            if (count == 20) {
                clearInterval(interval);
            }
        }
    }, 200);
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

function getValueElement(selector) {
    return document.querySelector(selector).value;
}

function selectByRegion(
    region = "region",
    workcenter_id = "workcenter_id",
    location_id = null
) {
    var region_id = document.getElementById(region).value;

    document.getElementById(workcenter_id).setAttribute("data-rules", "[]");

    if (work_center_id != 0) {
        document
            .getElementById(workcenter_id)
            .setAttribute("data-rules", "['required']");

        /*$params_location = [
            "select" => ["id", "name"],
            "where"  => [
                "work_center_id" => $fixedInventory->work_center_id
            ]
        ];*/
        var url = `${__PATH__}/${__LANG__}/sig_workcenters/get_work_centers`;
        var params = {
            search: "",
            region: region_id,
        };
        getOptionsByParams(workcenter_id, url, "name", "id", params, true);
        updateSelect(workcenter_id, "");
        if (location_id != null) {
            updateSelect(location_id, "");
        }
    }
}

function selectByWorkCenter(
    workcenter_id = "work_center_id",
    location_id = "location_id"
) {
    var work_center_id = document.getElementById(workcenter_id).value;

    document.getElementById(location_id).setAttribute("data-rules", "[]");

    if (work_center_id != 0) {
        document
            .getElementById(location_id)
            .setAttribute("data-rules", "['required']");

        var url = `${__PATH__}/${__LANG__}/sig_locations/get_locations/`;
        var params = {
            search: "",
            work_center_id: work_center_id,
        };
        getOptionsByParams(location_id, url, "name", "id", params, true);
    }
}

function selectByResponsibleResource(resource_type) {
    var provider_id = document.getElementById("provider_id").value;

    document
        .getElementById("responsible_resource_id")
        .setAttribute("data-rules", "[]");

    if (provider_id != 0) {
        document
            .getElementById("responsible_resource_id")
            .setAttribute("data-rules", "['required']");

        var url = `${__PATH__}/${__LANG__}/responsible_resources/get_responsibles`;
        var params = {
            search: "true",
            provider_id: provider_id,
            resource_type: resource_type,
        };

        getOptionsByParams(
            "responsible_resource_id",
            url,
            "name",
            "id",
            params,
            true
        );
    }
}

ready(() => {
    tippy("[data-tippy-content]", { animation: "scale-subtle" });
    onlyNumbers();
    onlyEmail();
});
