"use strict";
require("babel-polyfill");
const pageController = require("./page");
const pageUtils = require("./page_utils");
const loginController = require("./login");
var jQuery = $;
function loadLoginPage() {
    pageController.app.$data.pageTitle = "Login";
    pageController.app.$data.showLoginForm = true;
}
function initPage() {
    pageController.app = new Vue({
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
            "doLogin": loginController.doLogin,
            "hideAlert": pageUtils.hideAlert
        }
    });
    loadLoginPage();
}
window.addEventListener("load", initPage);
//# sourceMappingURL=index.js.map