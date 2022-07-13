//this function show temporary alert on screen
function showMessage(msg, type) {
    if (msg !== '') {
        var el = document.createElement("div");
        if (type === "warning")
            el.setAttribute("class", "popUp warning");
        else if (type === "information")
            el.setAttribute("class", "popUp information");
        el.setAttribute("role=", "tooltip");
        el.innerHTML = msg;
        document.body.appendChild(el);
        setTimeout(function () {
            el.parentNode.removeChild(el);
        }, 3000);
    }
    window.history.pushState('', document.title, removeParam("message", document.location.href));
    window.history.pushState('', document.title, removeParam("messageType", document.location.href));
}

//this function remove GET parameter from URL
function removeParam(key, sourceURL) {
    var rtn = sourceURL.split("?")[0],
        param,
        params_arr = [],
        queryString = (sourceURL.indexOf("?") !== -1) ? sourceURL.split("?")[1] : "";
    if (queryString !== "") {
        params_arr = queryString.split("&");
        for (var i = params_arr.length - 1; i >= 0; i -= 1) {
            param = params_arr[i].split("=")[0];
            if (param === key) {
                params_arr.splice(i, 1);
            }
        }
        rtn = rtn + "?" + params_arr.join("&");
    }
    return rtn;
}

//this function show a confirm Massage
function confirmMessage(m) {
    return confirm(m);
}

//this function hide and unHide Category menu
function changeVisibleCatMenu(showMenu) {
    const collection = document.getElementsByClassName("catItem");
    if (showMenu.value) {
        for (var i = 0; i < collection.length; i++) {
            collection[i].classList.add("hide");
            setTimeout(function () {
                const collection = document.getElementsByClassName("catItem");
                for (var i = 0; i < collection.length; i++) {
                    collection[i].classList.add("remove");
                }
            }, 800);
        }
        showMenu.value = false;
    } else {
        for (var i = 0; i < collection.length; i++) {
            collection[i].classList.remove("remove");
            setTimeout(function () {
                const collection = document.getElementsByClassName("catItem");
                for (var i = 0; i < collection.length; i++) {
                    collection[i].classList.remove("hide");
                }
            }, 10);
        }
        showMenu.value = true;
    }
}

//this function submit form by id
function submitForm(form_id, valid) {
    if (valid)
        document.getElementById(form_id).submit();
}