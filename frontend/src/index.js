var __awaiter = (this && this.__awaiter) || function (thisArg, _arguments, P, generator) {
    return new (P || (P = Promise))(function (resolve, reject) {
        function fulfilled(value) { try { step(generator.next(value)); } catch (e) { reject(e); } }
        function rejected(value) { try { step(generator.throw(value)); } catch (e) { reject(e); } }
        function step(result) { result.done ? resolve(result.value) : new P(function (resolve) { resolve(result.value); }).then(fulfilled, rejected); }
        step((generator = generator.apply(thisArg, _arguments)).next());
    });
};
var jQuery = $;
require("babel-polyfill");
var app;
function loadLoginPage() {
    app.$data.pageTitle = "Login";
    app.$data.showLoginForm = true;
}
function hideAlert() {
    app.$data.mainAlertIsShowed = false;
}
function showAlert(msg) {
    app.$data.mainAlertText = msg;
    app.$data.mainAlertIsShowed = true;
}
function doLogin() {
    return __awaiter(this, void 0, void 0, function* () {
        var resultStr = yield new Promise(function (callback) {
            jQuery.post("authenticate.php", function (resp) {
                callback(resp);
            });
        });
        let result = null;
        try {
            result = JSON.parse(resultStr);
        }
        catch (e) {
            showAlert("Login failed: Unable to parse response");
            return;
        }
        if (result.err !== 0) {
            showAlert("Error " + result.err.toString() + ": " + result.msg);
        }
        else {
            showAlert("Logged in");
            location.replace(result.location);
        }
    });
}
function initPage() {
    app = new Vue({
        el: "#container",
        data: {
            "pageTitle": "",
            "mainAlertIsShowed": false,
            "mainAlertText": "",
            "showLoginForm": false,
            "loginUserName": "",
            "loginPassword": ""
        },
        methods: {
            "doLogin": doLogin,
            "hideAlert": hideAlert
        }
    });
    loadLoginPage();
}
window.addEventListener("load", initPage);
//# sourceMappingURL=index.js.map