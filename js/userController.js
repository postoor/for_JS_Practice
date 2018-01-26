var AJAX = function (reqMethon, url, data) {
    this.reqMethon = reqMethon;
    if (reqMethon == "GET") {
        this.url = url;
    } else {
        this.url = url;
        this.data = data;
    }
    this.send = function () {
        if (this.reqMethon == "POST") {
            this.result =
                $.ajax({
                    type: "POST",
                    url: this.url,
                    dataType: "json",
                    data: this.data,
                    success: function (that, data) {
                        that.result = data;
                    },
                    error: function (that, jqXHR) {
                        that.result = jqXHR;
                    }
                })
        } else if (this.reqMethon == "GET") {
            this.result =
                $.ajax({
                    type: "GET",
                    url: this.url,
                    dataType: "json",
                    success: function (that, data) {
                        that.result = data;
                    },
                    error: function (that, jqXHR) {
                        that.result = false;
                    }
                })
        }
    }
}

var BuildTable = function (data, id) {
    this.id = id;
    this.data = data;
    this.build = function () {
        console.log(data);
        var that = this;
        data.forEach(function (element) {
            newItem = '<tr><td><button type="button" class="btn btn-primary" onclick="edit(' +
                element.id + ')">修改</button></td><td><input type="text" id="' +
                element.id + '" name="username[' +
                element.id + ']" value="' +
                element.username + '"></td><td><input type="text" value="' +
                element.email + '" readonly></td><td><button type="button" class="btn btn-danger" onclick="del(' +
                element.id + ')">掰</button></td></tr >';
            $('#' + that.id).append(newItem);
        });
    }
    this.empty = function () {
        $('#' + this.id).empty();
    }
}

function refresh() {
    var userList = new AJAX('GET', '/index.php/user/getlist', '');
    userList.send();
    setTimeout(function () {
        userList.prototype = new BuildTable(userList.result.responseJSON.data, 'userList');
        userList.prototype.empty();
        userList.prototype.build();
    }, 500);
}

function del(id) {
    var delUser = new AJAX('POST', '/index.php/user/delete', { id: id });
    delUser.send();
    refresh();
}

function edit(id) {
    var username = $("#" + id).val();
    var editUser = new AJAX("POST", "index.php/user/edit", { id: id, username: username });
    editUser.send();
    refresh();
}

function create() {
    var username = $('input[name=newUsername]').val();
    var usermail = $('input[name=newUsermail]').val();
    var password = $('input[name=password]').val();
    var confirmPassword = $('input[name=confirmPassword]').val();
    console.log(username);
    var createUser = new AJAX("POST", "/index.php/user/create", {
        username: username,
        usermail: usermail,
        password: password,
        confirmPassword: confirmPassword
    });
    createUser.send();

    inputList.forEach(function (name) {
        $('input[name=' + name + ']').val('');
    });
    refresh();

}

$(document).ready(function () {
    refresh();
})