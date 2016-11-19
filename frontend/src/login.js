"use strict";
var __awaiter = (this && this.__awaiter) || function (thisArg, _arguments, P, generator) {
    return new (P || (P = Promise))(function (resolve, reject) {
        function fulfilled(value) { try { step(generator.next(value)); } catch (e) { reject(e); } }
        function rejected(value) { try { step(generator.throw(value)); } catch (e) { reject(e); } }
        function step(result) { result.done ? resolve(result.value) : new P(function (resolve) { resolve(result.value); }).then(fulfilled, rejected); }
        step((generator = generator.apply(thisArg, _arguments)).next());
    });
};
const pageController = require("./page");
const pageUtils = require("./page_utils");
var jQuery = $;
function doLogin() {
    return __awaiter(this, void 0, void 0, function* () {
        var resultStr = yield new Promise(function (callback) {
            jQuery.post("authenticate.php", JSON.stringify({
                "username": pageController.app.$data.loginUserName,
                "password": pageController.app.$data.loginPassword
            }), function (resp) {
                callback(resp);
            });
        });
        let result = null;
        try {
            result = JSON.parse(resultStr);
        }
        catch (e) {
            pageUtils.showAlert("Login failed: Unable to parse response");
            return;
        }
        if (result.err !== 0) {
            pageUtils.showAlert("Error " + result.err.toString() + ": " + result.msg);
        }
        else {
            pageUtils.showAlert("Logged in");
            location.replace(result.location);
        }
    });
}
exports.doLogin = doLogin;
//# sourceMappingURL=login.js.map