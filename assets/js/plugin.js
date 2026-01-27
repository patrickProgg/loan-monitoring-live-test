document.addEventListener("DOMContentLoaded", function () {
    (function () {
        "use strict";
        if (window.sessionStorage) {
            var t = sessionStorage.getItem("is_visited");
            var bootstrapStyle = document.getElementById("bootstrap-style");
            var appStyle = document.getElementById("app-style");

            if (!bootstrapStyle || !appStyle) {
                console.error("Required style elements not found!");
                return;
            }

            switch (t) {
                case "light-mode-switch":
                    document.documentElement.removeAttribute("dir");
                    bootstrapStyle.setAttribute("href", "assets/css/bootstrap.min.css");
                    appStyle.setAttribute("href", "assets/css/app.min.css");
                    document.documentElement.setAttribute("data-bs-theme", "light");
                    break;
                case "dark-mode-switch":
                    document.documentElement.removeAttribute("dir");
                    bootstrapStyle.setAttribute("href", "assets/css/bootstrap.min.css");
                    appStyle.setAttribute("href", "assets/css/app.min.css");
                    document.documentElement.setAttribute("data-bs-theme", "dark");
                    break;
                case "rtl-mode-switch":
                    bootstrapStyle.setAttribute("href", "assets/css/bootstrap-rtl.min.css");
                    appStyle.setAttribute("href", "assets/css/app-rtl.min.css");
                    document.documentElement.setAttribute("dir", "rtl");
                    document.documentElement.setAttribute("data-bs-theme", "light");
                    break;
                case "dark-rtl-mode-switch":
                    bootstrapStyle.setAttribute("href", "assets/css/bootstrap-rtl.min.css");
                    appStyle.setAttribute("href", "assets/css/app-rtl.min.css");
                    document.documentElement.setAttribute("dir", "rtl");
                    document.documentElement.setAttribute("data-bs-theme", "dark");
                    break;
                default:
                    console.log("Something wrong with the layout mode.");
            }
        }
    })();
});
