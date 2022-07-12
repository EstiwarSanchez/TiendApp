let charts = [];
const __PATH__ = `${window.location.origin}`;
let __LANG__ =
    document.documentElement.lang ||
    document.getElementsByTagName("html")[0].getAttribute("lang");
let LANG = {};
function ready(fn) {
    if (document.readyState !== "loading") {
        fn();
    } else {
        document.addEventListener("DOMContentLoaded", fn);
    }
}

function fadeOut(el) {
    if (el) {
        el.style.opacity = 1;
        (function fade() {
            if ((el.style.opacity -= 0.03) < -0.03) {
                el.style.display = "none";
            } else {
                requestAnimationFrame(fade);
            }
        })();
    }
}

ready(() => {
    setTimeout(() => {
        fadeOut(document.getElementById("loading"));
    }, 100);

    window.livewire.onError((statusCode) => {
        if (statusCode === 419) {
            alert(LANG["Sorry, your session has expired."]);
            window.location = `${__PATH__}/login`;
        }
    });
});

String.prototype.isRegistered = function () {
    return document.createElement(this).constructor !== HTMLElement;
};

const valid_lang = __LANG__ === 'es' || __LANG__ === 'base' ?
{after: "La fecha debe ser posterior a: '[PARAM]'",afterOrEqual: "La fecha debe ser posterior o igual a: '[PARAM]'",array: "El valor debe ser una matriz",before: "La fecha debe ser anterior a: '[PARAM]'",beforeOrEqual: "La fecha debe ser anterior o igual a: '[PARAM]'",boolean: "El valor debe ser verdadero o falso",date: "El valor debe ser una fecha",different: "El valor debe ser diferente a '[PARAM]'",endingWith: "El valor debe terminar en '[PARAM]'",email: "El valor debe ser una dirección de correo electrónico válida",falsy: "El valor debe ser un valor falso (false, 'falso', 0 o '0')",in: "El valor debe ser una de las siguientes opciones: [PARAM]",integer: "El valor debe ser un número entero",json: "El valor debe ser una cadena de objeto JSON analizable",maximum:    "El valor no debe ser mayor que '[PARAM]' en tamaño o longitud de caracteres",minimum:    "El valor no debe ser menor que '[PARAM]' en tamaño o longitud de caracteres",notIn: "El valor no debe ser una de las siguientes opciones: [PARAM]",numeric: "El valor debe ser numérico",optional: "El valor es opcional",regexMatch: "El valor debe satisfacer la expresión regular: [PARAM]",required: "El valor debe estar presente",same: "El valor debe ser '[PARAM]'",startingWith: "El valor debe comenzar con '[PARAM]'",string: "El valor debe ser una cadena",truthy: "El valor debe ser un valor veraz (true, 'verdadero', 1 o '1')",url: "El valor debe ser una URL válida",uuid: "El valor debe ser un UUID válido"}:
{after:"The date must be after: '[PARAM]'",afterOrEqual:"The date must be after or equal to: '[PARAM]'",array:"Value must be an array",before:"The date must be before: '[PARAM]'",beforeOrEqual:"The date must be before or equal to: '[PARAM]'",boolean:"Value must be true or false",date:"Value must be a date",different:"Value must be different to '[PARAM]'",endingWith:"Value must end with '[PARAM]'",email:"Value must be a valid email address",falsy:"Value must be a falsy value (false, 'false', 0 or '0')",in:"Value must be one of the following options: [PARAM]",integer:"Value must be an integer",json:"Value must be a parsable JSON object string",maximum:"Value must not be greater than '[PARAM]' in size or character length",minimum:"Value must not be less than '[PARAM]' in size or character length",notIn:"Value must not be one of the following options: [PARAM]",numeric:"Value must be numeric",optional:"Value is optional",regexMatch:"Value must satisify the regular expression: [PARAM]",required:"Value must be present",same:"Value must be '[PARAM]'",startingWith:"Value must start with '[PARAM]'",string:"Value must be a string",truthy:"Value must be a truthy value (true, 'true', 1 or '1')",url:"Value must be a valid url",uuid:"Value must be a valid UUID"};

class e{constructor(){this.locale=void 0,this.messages=this._defaultMessages()}_dateCompare(e,t,r,s=!1){return!!this.isDate(e)&&!(!this.isDate(t)&&!this.isInteger(t))&&(t="number"==typeof t?t:t.getTime(),"less"===r&&s?e.getTime()<=t:"less"!==r||s?"more"===r&&s?e.getTime()>=t:"more"!==r||s?void 0:e.getTime()>t:e.getTime()<t)}_defaultMessages(){return valid_lang}addRule(t,r){e.prototype[`is${t[0].toUpperCase()}${t.slice(1)}`]=r}getErrorMessage(e,t){let r=e.split(":")[0],s=t||e.split(":")[1];return["after","afterOrEqual","before","beforeOrEqual"].includes(r)&&(s=new Date(parseInt(s)).toLocaleTimeString(this.locale,{year:"numeric",month:"short",day:"numeric",hour:"2-digit",minute:"numeric"})),[null,void 0].includes(s)?this.messages[r]:this.messages[r].replace("[PARAM]",s)}isAfter(e,t){return this._dateCompare(e,t,"more",!1)}isAfterOrEqual(e,t){return this._dateCompare(e,t,"more",!0)}isArray(e){return Array.isArray(e)}isBefore(e,t){return this._dateCompare(e,t,"less",!1)}isBeforeOrEqual(e,t){return this._dateCompare(e,t,"less",!0)}isBoolean(e){return[!0,!1].includes(e)}isDate(e){return e&&"[object Date]"===Object.prototype.toString.call(e)&&!isNaN(e)}isDifferent(e,t){return e!=t}isEndingWith(e,t){return this.isString(e)&&e.endsWith(t)}isEmail(e){return new RegExp("^\\S+@\\S+[\\.][0-9a-z]+$").test(String(e).toLowerCase())}isFalsy(e){return[0,"0",!1,"false"].includes(e)}isIn(e,t){return(t="string"==typeof t?t.split(","):t).includes(e)}isInteger(e){return Number.isInteger(e)&&parseInt(e).toString()===e.toString()}isJson(e){try{return"object"==typeof JSON.parse(e)}catch(e){return!1}}isMaximum(e,t){return e="string"==typeof e?e.length:e,parseFloat(e)<=t}isMinimum(e,t){return e="string"==typeof e?e.length:e,parseFloat(e)>=t}isNotIn(e,t){return!this.isIn(e,t)}isNumeric(e){return!isNaN(parseFloat(e))&&isFinite(e)}isOptional(e){return[null,void 0,""].includes(e)}isRegexMatch(e,t){return new RegExp(t).test(String(e))}isRequired(e){return!this.isOptional(e)}isSame(e,t){return e==t}isStartingWith(e,t){return this.isString(e)&&e.startsWith(t)}isString(e){return"string"==typeof e}isTruthy(e){return[1,"1",!0,"true"].includes(e)}isUrl(e){return new RegExp("^(https?:\\/\\/)?((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|((\\d{1,3}\\.){3}\\d{1,3}))(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*(\\?[;&a-z\\d%_.~+=-]*)?(\\#[-a-z\\d_]*)?$").test(String(e).toLowerCase())}isUuid(e){return new RegExp("^[0-9a-f]{8}-[0-9a-f]{4}-[1-5][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$").test(String(e).toLowerCase())}is(e,t=[]){if(!t.length)return!0;if("optional"===t[0]&&this.isOptional(e))return!0;for(let r in t)if("optional"!==t[r]&&!this["is"+(t[r].split(":")[0][0].toUpperCase()+t[r].split(":")[0].slice(1))].apply(this,[e,t[r].split(":")[1]]))return t[r];return!0}setErrorMessages(e){this.messages=e}setLocale(e){this.locale=e}}window.Iodine=new e;
