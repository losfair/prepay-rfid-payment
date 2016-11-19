/// <reference path="../typings/node/node.d.ts" />
/// <reference path="../typings/vue/vue.d.ts" />
/// <reference path="../typings/jquery/jquery.d.ts" />

require("babel-polyfill");
import pageController = require("./page");
import pageUtils = require("./page_utils");
import loginController = require("./login");
import userController = require("./user");
var jQuery = $;

async function loadInitialPage() {
    let userInfoStr: any = await new Promise(function(callback) {
        jQuery.post("get_current_user_info.php", {}, function(resp) {
            callback(resp);
        })
    });

    let userInfo = null;
    try {
        userInfo = JSON.parse(userInfoStr);
    } catch(e) {
        loginController.loadLoginPage();
        return;
    }

    if(userInfo.err !== 0) {
        loginController.loadLoginPage();
        return;
    }

    userController.loadUserPage(userInfo.userId.toString());
}

async function initPage() {
    pageController.app = new Vue({
        el: "#container",
        data: {
            "pageTitle": "",
            "mainAlertIsShowed": true,
            "mainAlertText": "Loading",
            "showLoginForm": false,
            "loginUserName": "",
            "loginPassword": "",
            "showUserInfoTable": false,
            "currentUserId": ""
        },
        methods: {
            "doLogin": loginController.doLogin,
            "hideAlert": pageUtils.hideAlert
        }
    });
    loadInitialPage();
}

window.addEventListener("load", initPage);
