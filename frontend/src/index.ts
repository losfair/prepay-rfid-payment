/// <reference path="../typings/node/node.d.ts" />
/// <reference path="../typings/vue/vue.d.ts" />
/// <reference path="../typings/jquery/jquery.d.ts" />

var jQuery = $;
require("babel-polyfill");

var app: vuejs.Vue;

async function loadLoginPage () {
    app.$data.pageTitle = "Login";
    app.$data.showLoginForm = true;
};

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
            "doLogin": function() {
                alert("doLogin");
            }
        }
    });
    loadLoginPage();
}

window.addEventListener("load", initPage);
