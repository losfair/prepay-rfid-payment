"use strict";
var __awaiter = (this && this.__awaiter) || function (thisArg, _arguments, P, generator) {
    return new (P || (P = Promise))(function (resolve, reject) {
        function fulfilled(value) { try { step(generator.next(value)); } catch (e) { reject(e); } }
        function rejected(value) { try { step(generator.throw(value)); } catch (e) { reject(e); } }
        function step(result) { result.done ? resolve(result.value) : new P(function (resolve) { resolve(result.value); }).then(fulfilled, rejected); }
        step((generator = generator.apply(thisArg, _arguments)).next());
    });
};
require("babel-polyfill");
const pageController = require("./page");
const pageUtils = require("./page_utils");
const loginController = require("./login");
const userController = require("./user");
var jQuery = $;
function loadInitialPage() {
    return __awaiter(this, void 0, void 0, function* () {
        let userInfoStr = yield new Promise(function (callback) {
            jQuery.post("get_current_user_info.php", {}, function (resp) {
                callback(resp);
            });
        });
        let userInfo = null;
        try {
            userInfo = JSON.parse(userInfoStr);
        }
        catch (e) {
            loginController.loadLoginPage();
            return;
        }
        if (userInfo.err !== 0) {
            loginController.loadLoginPage();
            return;
        }
        userController.loadUserPage(userInfo.userId.toString());
    });
}
function initPage() {
    return __awaiter(this, void 0, void 0, function* () {
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
    });
}
window.addEventListener("load", initPage);
//# sourceMappingURL=index.js.map