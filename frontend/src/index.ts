/// <reference path="../typings/node/node.d.ts" />
/// <reference path="../typings/vue/vue.d.ts" />
/// <reference path="../typings/jquery/jquery.d.ts" />

var jQuery = $;
require("babel-polyfill");

var app: vuejs.Vue;

function loadLoginPage () {
    app.$data.pageTitle = "Login";
    app.$data.showLoginForm = true;
}

function hideAlert() {
    app.$data.mainAlertIsShowed = false;
}

function showAlert(msg: string) {
    app.$data.mainAlertText = msg;
    app.$data.mainAlertIsShowed = true;
}

async function doLogin() {
    var resultStr: any = await new Promise(function(callback) {
        jQuery.post("authenticate.php", JSON.stringify({
            "username": app.$data.loginUserName,
            "password": app.$data.loginPassword
        }), function(resp) {
            callback(resp);
        })
    });

    let result = null;

    try {
        result = JSON.parse(resultStr);
    } catch(e) {
        showAlert("Login failed: Unable to parse response");
        return;
    }

    if(result.err !== 0) {
        showAlert("Error " + result.err.toString() + ": " + result.msg);
    } else {
        showAlert("Logged in");
        location.replace(result.location);
    }
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
