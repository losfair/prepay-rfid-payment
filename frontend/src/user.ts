/// <reference path="../typings/node/node.d.ts" />
/// <reference path="../typings/vue/vue.d.ts" />
/// <reference path="../typings/jquery/jquery.d.ts" />

import pageController = require("./page");
import pageUtils = require("./page_utils");

export function loadUserPage(userId: string) {
    pageController.app.$data.pageTitle = "Admin";
    pageController.app.$data.showLoginForm = false;
    pageController.app.$data.mainAlertIsShowed = false;
    pageController.app.$data.showUserInfoTable = true;
    pageController.app.$data.currentUserId = userId;
}
