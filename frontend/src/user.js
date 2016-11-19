"use strict";
const pageController = require("./page");
function loadUserPage(userId) {
    pageController.app.$data.pageTitle = "Admin";
    pageController.app.$data.showLoginForm = false;
    pageController.app.$data.mainAlertIsShowed = false;
    pageController.app.$data.showUserInfoTable = true;
    pageController.app.$data.currentUserId = userId;
}
exports.loadUserPage = loadUserPage;
//# sourceMappingURL=user.js.map