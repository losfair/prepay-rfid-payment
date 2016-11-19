/// <reference path="../typings/node/node.d.ts" />
/// <reference path="../typings/vue/vue.d.ts" />
/// <reference path="../typings/jquery/jquery.d.ts" />

import pageController = require("./page");

export function hideAlert() {
    pageController.app.$data.mainAlertIsShowed = false;
}

export function showAlert(msg: string) {
    pageController.app.$data.mainAlertText = msg;
    pageController.app.$data.mainAlertIsShowed = true;
}
