(window.webpackJsonp=window.webpackJsonp||[]).push([[4],{235:function(t,e,n){"use strict";n.r(e);var r={data:function(){var t;return{token:null!==(t=this.$route.query.token)&&void 0!==t?t:null}},mounted:function(){var t=this;this.$auth.login({data:{token:this.token}}).catch((function(e){return t.$router.push("/auth/register?error=Your Token is Invalid, please try again")}))}},o=n(35),component=Object(o.a)(r,(function(){var t=this.$createElement;this._self._c;return this._m(0)}),[function(){var t=this.$createElement,e=this._self._c||t;return e("div",[e("p",[this._v("Please Wait ......")])])}],!1,null,null,null);e.default=component.exports}}]);