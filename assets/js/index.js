var tools = (function () {
	/**
	 * 页面初始化时执行的函数
	 */
	var _pageInit = function () {
		// 检测当前是否已登录
		$.ajax({
			url: "/api/Number_record/test_login",
			success: function (res) {
				if (res.code === 200) {
					_setLoginBoxName(res.msg.username);
				}
			}
		});
		// 检测当前数据库里的数据量
		$.ajax({
			url: "/api/Number_record/get_count",
			success: function (res) {
				if (res.code === 200) {
					let txt =
						"目前数据库里共有" +
						res.data +
						"个号码。 <a class='btn-floating btn-small waves-effect waves-light' id='getCountBtn'><i class='material-icons'>refresh</i></a>";
					$("#blockquote").html(txt);
				}
			}
		});
	};

	var _bast_url = "127.0.0.1";

	/**
	 * 首页绑定事件函数
	 */
	var _homePageBindEvent = function () {
		// 首页的登录按钮
		$("#login").on("click", function (e) {
			$("#loginBox").removeClass("scale-out");
		});

		// 登录盒子里的登录按钮
		$("#loginBtn").on("click", function (e) {
			_loginEvent();
		});
		$("#login_username").on("keyup", function (e) {
			if (e.keyCode === 13) {
				_loginEvent();
			}
		});
		$("#login_password").on("keyup", function (e) {
			if (e.keyCode === 13) {
				_loginEvent();
			}
		});

		// 登录盒子关闭按钮
		$("#closeBtn").on("click", function (e) {
			$("#loginBox").addClass("scale-out");
		});
	};

	/**
	 * 号码记录分页绑定事件函数
	 */
	var _numberRecordBindEvent = function () {
		// 获取数据库号码总数按钮
		$(document).on("click", "#getCountBtn", function (e) {
			$.ajax({
				url: "/api/Number_record/get_count",
				success: function (res) {
					if (res.code === 200) {
						let txt =
							"目前数据库里共有" +
							res.data +
							"个号码。 <a class='btn-floating btn-small waves-effect waves-light disabled' id='getCountBtn'><i class='material-icons'>refresh</i></a>";
						$("#blockquote").html(txt);
					}
				}
			});
			setTimeout(() => {
				$("#getCountBtn").removeClass("disabled");
			}, 500);
		});

		// 提交号码按钮
		$("#submitBtn").on("click", function (e) {
			_submitTelEvent();
		});
		// 提交号码回车键
		$("#record-input").on("keyup", function (e) {
			if (e.keyCode === 13) {
				_submitTelEvent();
			}
		});

		// 导入txt按钮
		$("#import-hide-txt").on("change", function (e) {
			let f = e.target.files[0];
			let fd = new FormData();
			fd.append("file", f);
			$.ajax({
				url: "/api/Number_record/add_tel_from_txt",
				type: "post",
				data: fd,
				processData: false,
				contentType: false,
				dataType: "json",
				success: function (res) {
					M.toast({
						html: res.msg
					});
				}
			});
			e.target.value = "";
		});

		// 导入excel按钮
		$("#import-hide-excel").on("change", function (e) {
			let f = e.target.files[0];
			let fd = new FormData();
			fd.append("file", f);
			$.ajax({
				url: "/api/Number_record/add_tel_from_xls",
				type: "post",
				data: fd,
				processData: false,
				contentType: false,
				dataType: "json",
				success: function (res) {
					M.toast({
						html: res.msg
					});
				}
			});
			e.target.value = "";
		});

		// 搜索按钮
		$("#searchTelephoneBtn").on("click", function (e) {
			_searchEvent();
		});
		// 搜索回车键
		$("#search-input").on("keyup", function (e) {
			if (e.keyCode === 13) {
				_searchEvent();
			}
		});

		// 标记按钮
		$(document).on("click", "#markBtn", function (e) {
			$("#markMsgBox").removeClass("scale-out");
		});

		// 标记-提交按钮
		$("#submitRemarksMsg").on("click", function (e) {
			_markEvent();
		});
		// 标记-回车键
		$("#remarkMsg").on("keyup", function (e) {
			if (e.keyCode === 13) {
				_markEvent();
			}
		});
	};

	/**
	 * 登录事件
	 */
	var _loginEvent = function () {
		let data = {};
		let form = $("#loginForm").serializeArray();
		data.username = form[0].value;
		data.password = form[1].value;
		if (data.username.length === 0) {
			M.toast({
				html: "请输入用户名"
			});
			return;
		}
		if (data.password.length === 0) {
			M.toast({
				html: "请输入密码"
			});
			return;
		}
		$.post("/api/Number_record/login", data, function (res) {
			if (res.code === 200) {
				_setLoginBoxName(res.msg.username);
				$("#loginBox").addClass("scale-out");
			}
			M.toast({
				html: res.msg.text
			});
		});
	};

	/**
	 * 提交号码按钮事件
	 */
	var _submitTelEvent = function () {
		let text = $("#record-input").val();
		text.trim();
		if (text.length < 1) {
			M.toast({
				html: "请输入号码"
			});
			return;
		}
		if (text.length > 11) {
			M.toast({
				html: "号码不能超过11位"
			});
			return;
		}
		$.ajax({
			url: "/api/Number_record/add_tel/" + text,
			success: function (res) {
				M.toast({
					html: res.msg
				});
			}
		})
	};

	/**
	 * 搜索事件
	 */
	var _searchEvent = function () {
		let text = $("#search-input")
			.val()
			.trim();
		if (text.length === 0) {
			M.toast({
				html: "请输入内容"
			});
			return;
		}
		$.ajax({
			url: "/api/Number_record/search_tel/" + text,
			success: function (res) {
				let data = res.data;
				if (res.code === 200) {
					let ele = "";
					if (data.type == 2) {
						// 类型为2，则为已标记
						ele +=
							"<tr><td>" +
							data.tel +
							"</td><td><a class='btn btn-small' id='remarks' data-position='top'>已标记</a></td></tr>";
						$(".view-list")
							.eq(0)
							.css("display", "block");
						$(".view-tbody")
							.eq(0)
							.html(ele);
						// 初始化tooltips提示框
						$("#remarks").tooltip({
							html: "<p>标记日期:" +
								_formatDate(data.mark_date) +
								"</p><p>标记信息:" +
								data.remarks +
								"</p>"
						});
					} else if (data.type == 1) {
						// 类型为1，则为已未标记
						ele +=
							"<tr><td>" +
							data.tel +
							"</td><td><a class='waves-effect btn-small green lighten-1' id='markBtn'>点击标记</a><input type='hidden' id='currentTel' value=" +
							data.tel +
							"></input></td></tr>";
						$(".view-list")
							.eq(0)
							.css("display", "block");
						$(".view-tbody")
							.eq(0)
							.html(ele);
					} else {
						$(".view-list")
							.eq(0)
							.css("display", "none");
						$(".view-tbody")
							.eq(0)
							.html("");
						M.toast({
							html: data.msg
						});
					}
				}
			}
		})
	};

	/**
	 * 标记事件
	 */
	var _markEvent = function () {
		let tel = $("#currentTel").val();
		let msg =
			$("#remarkMsg")
			.val()
			.trim() || "";
		let data = {
			remarksTel: tel,
			remarksMsg: msg
		};
		$.post("/api/Number_record/mark_tel", data, function (res) {
			if (res.code === 200) {
				$("#markMsgBox").addClass("scale-out");
				M.toast({
					html: res.data.msg
				});
				let ele =
					"<a class='btn btn-small' id='remarks' data-position='top'>已标记</a>";
				$(".view-tbody")
					.children()
					.children()
					.eq(1)
					.html(ele);
				// 初始化tooltips提示框
				$("#remarks").tooltip({
					html: "<p>标记日期:" +
						_formatDate(res.data.list.mark_date) +
						"</p><p>标记信息:" +
						res.data.list.remarks +
						"</p>"
				});
			} else {
				$("#markMsgBox").addClass("scale-out");
				M.toast({
					html: res.data.msg
				});
			}
		});
	};

	/**
	 * 格式化日期
	 * @param {*} date 时间数字串
	 */
	var _formatDate = function (date) {
		date = +date;
		let a = new Date(date);
		let Y = a.getFullYear();
		let M = a.getMonth() + 1;
		M < 10 ? (M = "0" + M) : M;
		let D = a.getDate();
		D < 10 ? (D = "0" + D) : D;
		let h = a.getHours();
		h < 10 ? (h = "0" + h) : h;
		let m = a.getMinutes();
		m < 10 ? (m = "0" + m) : m;
		return Y + "-" + M + "-" + D + " " + h + ":" + m;
	};

	/**
	 * 显示当前登录用户
	 * @param {*} username 用户名
	 */
	var _setLoginBoxName = function (username) {
		let el =
			"<a href='javascript:;' class='waves-effect waves-light btn' id='hasLogin'><i class='material-icons left'>check</i>已登录用户:" +
			username +
			"</a>";
		$("#login").css("display", "none");
		$(".nav-login-box")
			.eq(0)
			.html(el);
	};

	return {
		pageInit: _pageInit,
		numberRecordBindEvent: _numberRecordBindEvent,
		homePageBindEvent: _homePageBindEvent
	};
})();