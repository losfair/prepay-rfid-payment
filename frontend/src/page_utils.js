"use strict";
const pageController = require("./page");
function hideAlert() {
    pageController.app.$data.mainAlertIsShowed = false;
}
exports.hideAlert = hideAlert;
function showAlert(msg) {
    pageController.app.$data.mainAlertText = msg;
    pageController.app.$data.mainAlertIsShowed = true;
}
exports.showAlert = showAlert;
//# sourceMappingURL=page_utils.js.map