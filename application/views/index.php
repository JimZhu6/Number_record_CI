

  <main>
    <blockquote id="blockquote">
		<!-- 加载视图 -->
		<?php $this->load->view('count') ?>
		</blockquote>
    <div class="input-box center-align">
      <div class="input-field">
        <input type="text" id="record-input" data-length="11" />
        <label for="record-input">请输入要记录的手机号码</label>
      </div>
      <br />
      <a href="javascript:;" class="waves-effect waves-light btn" id="submitBtn">
        <i class="material-icons left">airplay</i>
        提交</a>
      <a href="javascript:;" class="waves-effect waves-light btn" id="import-txt">
        <i class="material-icons left">cloud_upload</i>
        导入txt
        <input type="file" accept="text/plain" id="import-hide-txt" name="txtFile" />
      </a>
      <a href="javascript:;" class="waves-effect waves-light btn" id="import-excel">
        <i class="material-icons left">cloud_upload</i>
        导入xls
        <input type="file" accept="application/vnd.ms-excel" id="import-hide-excel" name="xlsFile" />
      </a>
    </div>
    <div class="view-box">
      <div class="search-box">
        <div class="input-field">
          <input type="text" id="search-input" />
          <label for="search-input">请输入要查询的号码</label>
        </div>
        <a href="javascript:;" class="waves-effect waves-light btn" id="searchTelephoneBtn">
          <i class="material-icons left">search</i>查询
        </a>
      </div>
      <div class="view-list scale-transition">
        <table class="centered">
          <thead>
            <tr>
              <th>号码</th>
              <th>是否被标记</th>
            </tr>
          </thead>
          <tbody class="view-tbody"></tbody>
        </table>
      </div>
    </div>
  </main>
  <!-- <footer class="page-footer">
    <div class="container">
      <div class="row">
        <div class="col l6 s12">
          <h5 class="white-text">Footer Content</h5>
          <p class="grey-text text-lighten-4">You can use rows and columns here to organize your footer content.</p>
        </div>
        <div class="col l4 offset-l2 s12">
          <h5 class="white-text">Links</h5>
          <ul>
            <li><a class="grey-text text-lighten-3" href="#!">Link 1</a></li>
            <li><a class="grey-text text-lighten-3" href="#!">Link 2</a></li>
            <li><a class="grey-text text-lighten-3" href="#!">Link 3</a></li>
            <li><a class="grey-text text-lighten-3" href="#!">Link 4</a></li>
          </ul>
        </div>
      </div>
    </div>
    <div class="footer-copyright">
      <div class="container">
        © 2014 Copyright Text
        <a class="grey-text text-lighten-4 right" href="https://materializecss.com/">UI:Materialize</a>
      </div>
    </div>
  </footer> -->
  <!-- 登录盒子 -->
  <div class="mask center-align scale-transition scale-out" id="loginBox">
    <div class="mask-box card">
      <div class="mask-box-title card-title">请先登录</div>
      <div class="mask-box-main">
        <form id="loginForm">
          <table>
            <tbody>
              <tr>
                <td class="input-field">
                  <i class="material-icons prefix">account_circle</i>
                  <input type="text" class="validate" name="username" id="login_username" />
                  <label for="login_username">请输入账号</label>
                </td>
              </tr>
              <tr>
                <td class="input-field">
                  <i class="material-icons prefix">lock</i>
                  <input type="password" class="validate" name="password" id="login_password" />
                  <label for="login_password">请输入密码</label>
                </td>
              </tr>
            </tbody>
          </table>
          <div class="card-action">
            <a href="javascript:;" class="waves-effect waves-light btn" id="loginBtn">登录</a>
            <a href="javascript:;" class="waves-effect waves-light btn" id="closeBtn">关闭</a>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- 标记信息盒子 -->
  <div class="mask center-align scale-transition scale-out" id="markMsgBox">
    <div class="mask-box card">
      <div class="mask-box-title card-title">请输入标记信息或直接点击提交</div>
      <div class="mask-box-main">
        <table>
          <tbody>
            <tr>
              <td class="input-field">
                <i class="material-icons prefix">border_color</i>
                <input type="text" class="validate" name="remarkMsg" id="remarkMsg" />
                <label for="remarkMsg">请输入标记信息</label>
              </td>
            </tr>
          </tbody>
        </table>
        <div class="card-action">
          <a href="javascript:;" class="waves-effect waves-light btn" id="submitRemarksMsg">提交</a>
        </div>
      </div>
    </div>
  </div>
</body>
<script src="/assets/js/jq.min.js"></script>
<script src="/assets/js/materialize.min.js"></script>
<script src="/assets/js/index.js"></script>
<script>
  $(document).ready(function () {
    M.AutoInit();
    tools.numberRecordBindEvent();
    tools.homePageBindEvent();
  });
</script>

</html>
