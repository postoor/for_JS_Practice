<div class="container">
    <div class="row">
        <div class="col-md-6">
            <h2>
                新增使用者
            </h2>
            <div class="form-group">
                <input type="text" class="form-control" name="newUsername" placeholder="New username" required>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="newUsermail" placeholder="e-mail" required>
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Password" required>
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="confirmPassword" placeholder="Confrim Password" required>
            </div>
            <div>
                <button type="button" class="btn btn-success" onclick="create()">新增</button>
            </div>
        </div>

        <div class="col-md-6">
            <h2>
                使用者管理
            </h2>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>修改</th>
                        <th>姓名</th>
                        <th>E-mail</th>
                        <th>X</th>
                    </tr>
                </thead>
                <tbody id="userList">
                </tbody>
            </table>
        </div>
    </div>
</div>