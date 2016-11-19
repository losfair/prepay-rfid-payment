"use strict";

var __awaiter = undefined && undefined.__awaiter || function (thisArg, _arguments, P, generator) {
    return new (P || (P = Promise))(function (resolve, reject) {
        function fulfilled(value) {
            try {
                step(generator.next(value));
            } catch (e) {
                reject(e);
            }
        }
        function rejected(value) {
            try {
                step(generator.throw(value));
            } catch (e) {
                reject(e);
            }
        }
        function step(result) {
            result.done ? resolve(result.value) : new P(function (resolve) {
                resolve(result.value);
            }).then(fulfilled, rejected);
        }
        step((generator = generator.apply(thisArg, _arguments)).next());
    });
};
require("babel-polyfill");
var pageController = require("./page");
var pageUtils = require("./page_utils");
var loginController = require("./login");
var userController = require("./user");
var jQuery = $;
function loadInitialPage() {
    return __awaiter(this, void 0, void 0, regeneratorRuntime.mark(function _callee() {
        var userInfoStr, userInfo;
        return regeneratorRuntime.wrap(function _callee$(_context) {
            while (1) {
                switch (_context.prev = _context.next) {
                    case 0:
                        _context.next = 2;
                        return new Promise(function (callback) {
                            jQuery.post("get_current_user_info.php", {}, function (resp) {
                                callback(resp);
                            });
                        });

                    case 2:
                        userInfoStr = _context.sent;
                        userInfo = null;
                        _context.prev = 4;

                        userInfo = JSON.parse(userInfoStr);
                        _context.next = 12;
                        break;

                    case 8:
                        _context.prev = 8;
                        _context.t0 = _context["catch"](4);

                        loginController.loadLoginPage();
                        return _context.abrupt("return");

                    case 12:
                        if (!(userInfo.err !== 0)) {
                            _context.next = 15;
                            break;
                        }

                        loginController.loadLoginPage();
                        return _context.abrupt("return");

                    case 15:
                        userController.loadUserPage(userInfo.userId.toString());

                    case 16:
                    case "end":
                        return _context.stop();
                }
            }
        }, _callee, this, [[4, 8]]);
    }));
}
function initPage() {
    return __awaiter(this, void 0, void 0, regeneratorRuntime.mark(function _callee2() {
        return regeneratorRuntime.wrap(function _callee2$(_context2) {
            while (1) {
                switch (_context2.prev = _context2.next) {
                    case 0:
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

                    case 2:
                    case "end":
                        return _context2.stop();
                }
            }
        }, _callee2, this);
    }));
}
window.addEventListener("load", initPage);
//# sourceMappingURL=index.js.map