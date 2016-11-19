/// <reference path="../typings/node/node.d.ts" />
/// <reference path="../typings/vue/vue.d.ts" />
/// <reference path="../typings/jquery/jquery.d.ts" />

import pageController = require("./page");
import pageUtils = require("./page_utils");
var jQuery = $;

export async function doLogin() {
    var resultStr: any = await new Promise(function(callback) {
        jQuery.post("authenticate.php", JSON.stringify({
            "username": pageController.app.$data.loginUserName,
            "password": pageController.app.$data.loginPassword
        }), function(resp) {
            callback(resp);
        })
    });

    let result = null;

    try {
        result = JSON.parse(resultStr);
    } catch(e) {
        pageUtils.showAlert("Login failed: Unable to parse response");
        return;
    }

    if(result.err !== 0) {
        pageUtils.showAlert("Error " + result.err.toString() + ": " + result.msg);
    } else {
        pageUtils.showAlert("Logged in");
        location.replace(result.location);
    }
}

export function loadLoginPage() {
    pageController.app.$data.pageTitle = "Login";
    pageController.app.$data.showLoginForm = true;
    pageController.app.$data.mainAlertIsShowed = false;
}
