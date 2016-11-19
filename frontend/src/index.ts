/// <reference path="../typings/node/node.d.ts" />
/// <reference path="../typings/vue/vue.d.ts" />
/// <reference path="../typings/jquery/jquery.d.ts" />

require("babel-polyfill");
import pageController = require("./page");
import pageUtils = require("./page_utils");
import loginController = require("./login");
var jQuery = $;

function loadLoginPage () {
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
