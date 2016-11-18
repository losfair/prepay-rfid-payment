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
var jQuery = $;
require("babel-polyfill");
var app;
function loadLoginPage() {
    return __awaiter(this, void 0, void 0, regeneratorRuntime.mark(function _callee() {
        return regeneratorRuntime.wrap(function _callee$(_context) {
            while (1) {
                switch (_context.prev = _context.next) {
                    case 0:
                        app.$data.pageTitle = "Login";
                        app.$data.showLoginForm = true;

                    case 2:
                    case "end":
                        return _context.stop();
                }
            }
        }, _callee, this);
    }));
}
;
function initPage() {
    app = new Vue({
        el: "#container",
        data: {
            "pageTitle": "",
            "showLoginForm": false,
            "loginUserName": "",
            "loginPassword": ""
        },
        methods: {
            "doLogin": function doLogin() {
                alert("doLogin");
            }
        }
    });
    loadLoginPage();
}
window.addEventListener("load", initPage);
//# sourceMappingURL=index.js.map