'use strict';
/**
 * Config for the router
 */
angular.module('app')
    .run(['$rootScope', '$state', '$stateParams','$cookieStore','$sessionStorage','$http','$location','$localStorage','$interval', function ($rootScope,$state,$stateParams,$cookieStore,$sessionStorage,$http,$location,$localStorage,$interval) {
        //公共配置
        if(!$sessionStorage.baseOption){
            $sessionStorage.baseOption={
                active:1, //底部激活
                serveIsShow:1, //服务板块激活
                msgShow:1, //信息板块激活
                healtyhIsShow:-1, //健康说激活
                userLogin:false   //默认未登录
            };
            $sessionStorage.toState={
                name:'',
                type:null,
                id:null
            }
        }
        $rootScope.baseOption=$sessionStorage.baseOption;
        $rootScope.$watch('baseOption',function(newValue){
            // console.log('基础配置更新');
            $sessionStorage.baseOption=newValue;
        },true);

        //返回上一页
        $rootScope.goBack = function () {
            history.go(-1);
            if($rootScope.timer){
                $interval.cancel($rootScope.timer);
            }
        };
        // 联系客服
        $rootScope.contactTel = function () {
            location.href = 'telprompt://' + $sessionStorage.aboutUsTel;
        };
        // 拨打电话
        $rootScope.telPeople = function (phone) {
            location.href = 'telprompt://' + phone;
        };
        $rootScope.healtyhIsShow =1;
        $rootScope.serveIsShow =1;
        $rootScope.userLogin = false;
        // ios 判断
        $rootScope.changeNavH = function () {
            var u = navigator.userAgent;
            var isAndroid = u.indexOf('Android') > -1 || u.indexOf('Adr') > -1; //android终端
            var isiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/); //ios终端
            if(isAndroid){
                $('.scroll-content').css('top',0);
                $('.y-title').css('top','-20px')
            }
        };
        //提前获取地址
        if(!$sessionStorage.addressList){
            var rData=[];
            $http.post('/base/district-option-api/index',{
                pages:9999
            }).success(function (resp) {
                if(resp.errcode==0){
                    var oData=resp.data.list;
                    var pIndex=0;
                    //数据分组
                    angular.forEach(oData,function (pItem) {
                        if(pItem.level==1){
                            rData.push({
                                id:pItem.id,
                                level:pItem.level,
                                name:pItem.name,
                                upid:pItem.upid
                            });
                            rData[pIndex].list=[];
                            var cIndex=0;
                            angular.forEach(oData,function (cItem) {
                                if(cItem.upid==pItem.id && cItem.level==2){
                                    rData[pIndex].list.push({
                                        id:cItem.id,
                                        level:cItem.level,
                                        name:cItem.name,
                                        upid:cItem.upid
                                    });
                                    rData[pIndex].list[cIndex].list=[];
                                    angular.forEach(oData,function (dItem) {
                                        if(dItem.upid==cItem.id && dItem.level==3){
                                            rData[pIndex].list[cIndex].list.push({
                                                id:dItem.id,
                                                level:dItem.level,
                                                name:dItem.name,
                                                upid:dItem.upid
                                            });
                                        }
                                    });
                                    cIndex++
                                }
                            });
                            pIndex++;
                        }
                    });
                    $sessionStorage.addressList=rData;
                    console.log('缓存地址',$sessionStorage.addressList);
                }
            });
        }
        //路由起步
        $rootScope.$on('$stateChangeStart',function(event,toState,toParams,fromState,fromParams){
            //动态改变title
            if(toState.title){
                $rootScope.indexTitle=toState.title;
            }else{//空值的情况下通过控制器赋值
                $rootScope.indexTitle=null
            }
            console.log('toState.name的值是',toState.name);
        });
        //去往信息板块
        $rootScope.goMsg = function (flag) {
            switch(flag){
                case 'home':$sessionStorage.goFlag = 'home';break;
                case 'healthy':$sessionStorage.goFlag = 'healthy';break;
                case 'serve':$sessionStorage.goFlag = 'serve';break;
                case 'mine':$sessionStorage.goFlag = 'mine';break;
            }
            $sessionStorage.toState.name='msg.wdzx';
            if(!$sessionStorage.token){
                $state.go('login');
            }else{
                $state.go($sessionStorage.toState.name);
            }
        };
}]).config(
    ['$stateProvider','$urlRouterProvider',
      function ($stateProvider,$urlRouterProvider) {
          // var version=Math.random();//动态版本
          var version='2.5.3';//动态版本
          $urlRouterProvider
              .otherwise('/layout/mobile/index');
          $stateProvider
              .state('layout', {
                  abstract: true,
                  url: '/layout',
                  templateUrl: 'tpl/layout.html?v='+version
              })
              .state('layout.mobile', {
                  url: '/mobile',
                  views: {
                      '': {
                          templateUrl: 'tpl/layout_mobile.html?v='+version
                      },
                      'footer': {
                          templateUrl: 'tpl/layout_footer_mobile.html?v='+version
                      }
                  },
                  resolve: {
                      deps: ['$ocLazyLoad',
                          function( $ocLazyLoad ){
                              return $ocLazyLoad.load('toaster').then(
                                  function(){
                                      return $ocLazyLoad.load(['js/controllers/layout.js?v='+version]);
                                  }
                              );
                          }]
                  }
              })
              .state('layout.mobile.home', {//首页
                  url: '/index',
                  title:'首页',
                  templateUrl: 'tpl/home/home.html?v='+version,
                  resolve: {
                      deps: ['$ocLazyLoad',
                          function( $ocLazyLoad ){
                              return $ocLazyLoad.load('toaster').then(
                                  function(){
                                      return $ocLazyLoad.load(['js/controllers/home/home.js?v='+version]);
                                  }
                              );
                          }]
                  }
              })
              .state('login', {//登录
                  url: '/login',
                  title:'登录',
                  templateUrl: 'tpl/login/login.html?v='+version,
                  resolve: {
                      deps: ['$ocLazyLoad',
                          function( $ocLazyLoad ){
                              return $ocLazyLoad.load('toaster').then(
                                  function(){
                                      return $ocLazyLoad.load(['js/controllers/login/login.js?v='+version]);
                                  }
                              );
                          }]
                  }
              })
              .state('register', {//注册
                  url: '/register',
                  title:'注册',
                  params:{'forget':null},
                  templateUrl: 'tpl/login/register.html?v='+version,
                  resolve: {
                      deps: ['$ocLazyLoad',
                          function( $ocLazyLoad ){
                              return $ocLazyLoad.load('toaster').then(
                                  function(){
                                      return $ocLazyLoad.load(['js/controllers/login/register.js?v='+version]);
                                  }
                              );
                          }]
                  }
              })
              .state('hospital', {//首页-药店推荐
                  url: '/hospital',
                  title:'首页-药店推荐',
                  // params:{'id':null},
                  templateUrl: 'tpl/home/hospital.html?v='+version,
                  resolve: {
                      deps: ['$ocLazyLoad',
                          function( $ocLazyLoad ){
                              return $ocLazyLoad.load('toaster').then(
                                  function(){
                                      return $ocLazyLoad.load(['js/controllers/home/home_hospital.js?v='+version]);
                                  }
                              );
                          }]
                  }
              })
              .state('tjyy', {//首页-体检预约
                  url: '/tjyy',
                  title:'首页-体检预约',
                  // params:{'id':null},
                  templateUrl: 'tpl/home/tjyy.html?v='+version,
                  resolve: {
                      deps: ['$ocLazyLoad',
                          function( $ocLazyLoad ){
                              return $ocLazyLoad.load('toaster').then(
                                  function(){
                                      return $ocLazyLoad.load(['js/controllers/home/home_tjyy.js?v='+version]);
                                  }
                              );
                          }]
                  }
              })
              .state('tjsc', {//首页-体检商城
                  url: '/tjsc',
                  title:'首页-体检商城',
                  // params:{'id':null},
                  templateUrl: 'tpl/home/tjsc.html?v='+version,
                  resolve: {
                      deps: ['$ocLazyLoad',
                          function( $ocLazyLoad ){
                              return $ocLazyLoad.load('toaster').then(
                                  function(){
                                      return $ocLazyLoad.load(['js/controllers/home/home_tjsc.js?v='+version]);
                                  }
                              );
                          }]
                  }
              })
              .state('online_question', {//首页-在线咨询
                  url: '/online_question',
                  title:'首页-在线咨询',
                  // params:{'id':null},
                  templateUrl: 'tpl/home/online_question.html?v='+version,
                  resolve: {
                      deps: ['$ocLazyLoad',
                          function( $ocLazyLoad ){
                              return $ocLazyLoad.load('toaster').then(
                                  function(){
                                      return $ocLazyLoad.load(['js/controllers/home/online_question.js?v='+version]);
                                  }
                              );
                          }]
                  }
              })
              .state('chat', {//首页-聊天界面
                  url: '/chat',
                  title:'首页-聊天界面',
                  params:{'id':null},
                  templateUrl: 'tpl/home/chat.html?v='+version,
                  resolve: {
                      deps: ['$ocLazyLoad',
                          function( $ocLazyLoad ){
                              return $ocLazyLoad.load('toaster').then(
                                  function(){
                                      return $ocLazyLoad.load(['js/controllers/home/chat.js?v='+version]);
                                  }
                              );
                          }]
                  }
              })
              .state('type_detail', {//首页-体检商城-种类分类详情
                  url: '/type_detail',
                  title:'首页-体检商城-种类分类详情',
                  params:{'id':null,'title':null},
                  templateUrl: 'tpl/home/type_detail.html?v='+version,
                  resolve: {
                      deps: ['$ocLazyLoad',
                          function( $ocLazyLoad ){
                              return $ocLazyLoad.load('toaster').then(
                                  function(){
                                      return $ocLazyLoad.load(['js/controllers/home/home_detail.js?v='+version]);
                                  }
                              );
                          }]
                  }
              })
              .state('tjzx', {//体检中心
                  url: '/tjzx',
                  title:'页-体检中心',
                  params:{'id':null},
                  templateUrl: 'tpl/home/tjzx.html?v='+version,
                  resolve: {
                      deps: ['$ocLazyLoad',
                          function( $ocLazyLoad ){
                              return $ocLazyLoad.load('toaster').then(
                                  function(){
                                      return $ocLazyLoad.load(['js/controllers/home/home_tjzx.js?v='+version]);
                                  }
                              );
                          }]
                  }
              })
              .state('tcdz', {//首页-个性化定制
                  url: '/tcdz',
                  title:'首页-个性化定制',
                  // params:{'id':null},
                  templateUrl: 'tpl/home/tcdz.html?v='+version,
                  resolve: {
                      deps: ['$ocLazyLoad',
                          function( $ocLazyLoad ){
                              return $ocLazyLoad.load('toaster').then(
                                  function(){
                                      return $ocLazyLoad.load(['js/controllers/home/home_tcdz.js?v='+version]);
                                  }
                              );
                          }]
                  }
              })
              .state('tcdz2', {//首页-个性化定制2
                  url: '/tcdz2',
                  title:'首页-个性化定制2',
                  // params:{'id':null},
                  templateUrl: 'tpl/home/tcdz2.html?v='+version,
                  resolve: {
                      deps: ['$ocLazyLoad',
                          function( $ocLazyLoad ){
                              return $ocLazyLoad.load('toaster').then(
                                  function(){
                                      return $ocLazyLoad.load(['js/controllers/home/home_tcdz.js?v='+version]);
                                  }
                              );
                          }]
                  }
              })
              .state('tcdz3', {//首页-个性化定制3
                  url: '/tcdz3',
                  title:'首页-个性化定制3',
                  // params:{'id':null},
                  templateUrl: 'tpl/home/tcdz3.html?v='+version,
                  resolve: {
                      deps: ['$ocLazyLoad',
                          function( $ocLazyLoad ){
                              return $ocLazyLoad.load('toaster').then(
                                  function(){
                                      return $ocLazyLoad.load(['js/controllers/home/home_tcdz.js?v='+version]);
                                  }
                              );
                          }]
                  }
              })
              .state('tcdz4', {//首页-个性化定制4
                  url: '/tcdz4',
                  title:'首页-个性化定制4',
                  // params:{'id':null},
                  templateUrl: 'tpl/home/tcdz4.html?v='+version,
                  resolve: {
                      deps: ['$ocLazyLoad',
                          function( $ocLazyLoad ){
                              return $ocLazyLoad.load('toaster').then(
                                  function(){
                                      return $ocLazyLoad.load(['js/controllers/home/home_tcdz.js?v='+version]);
                                  }
                              );
                          }]
                  }
              })
              .state('tcdz5', {//首页-个性化定制-定金支付
                  url: '/tcdz5',
                  title:'首页-个性化定制-定金支付',
                  // params:{'id':null},
                  templateUrl: 'tpl/home/tcdz5.html?v='+version,
                  resolve: {
                      deps: ['$ocLazyLoad',
                          function( $ocLazyLoad ){
                              return $ocLazyLoad.load('toaster').then(
                                  function(){
                                      return $ocLazyLoad.load(['js/controllers/home/home_tcdz5.js?v='+version]);
                                  }
                              );
                          }]
                  }
              })
              .state('tcdz6', {//首页-个性化定制5-等待定制
                  url: '/tcdz6',
                  title:'首页-个性化定制5-等待定制',
                  // params:{'id':null},
                  templateUrl: 'tpl/home/tcdz6.html?v='+version,
                  resolve: {
                      deps: ['$ocLazyLoad',
                          function( $ocLazyLoad ){
                              return $ocLazyLoad.load('toaster').then(
                                  function(){
                                      return $ocLazyLoad.load(['js/controllers/home/home_tcdz.js?v='+version]);
                                  }
                              );
                          }]
                  }
              })
              .state('tcdz_pay', {//个性化定制支付
                  url: '/tcdz_pay',
                  title:'首页-套餐定制-支付',
                  params:{'id':null},
                  templateUrl: 'tpl/home/tcdz_pay.html?v='+version,
                  resolve: {
                      deps: ['$ocLazyLoad',
                          function( $ocLazyLoad ){
                              return $ocLazyLoad.load('toaster').then(
                                  function(){
                                      return $ocLazyLoad.load(['js/controllers/home/tcdz_pay.js?v='+version]);
                                  }
                              );
                          }]
                  }
              })
              .state('tcxq', {//套餐详情
                  url: '/tcxq?coupon_id=',
                  title:'首页-套餐详情',
                  params:{'listId':null,'coupon_id':null,'serveFlag':null,'code':null},
                  templateUrl: 'tpl/home/tcxq.html?v='+version,
                  resolve: {
                      deps: ['$ocLazyLoad',
                          function( $ocLazyLoad ){
                              return $ocLazyLoad.load('toaster').then(
                                  function(){
                                      return $ocLazyLoad.load(['js/controllers/home/home_tcxq.js?v='+version]);
                                  }
                              );
                          }]
                  }
              })
              .state('choose-data', {//订单详情时间修改
                  url: '/choose-data',
                  title:'服务-时间修改',
                  params:{'id':null,'dateFlag':null,'yfkId':null,'index':null},
                  templateUrl: 'tpl/serve/choose-data.html?v='+version,
                  resolve: {
                      deps: ['$ocLazyLoad',
                          function( $ocLazyLoad ){
                              return $ocLazyLoad.load('toaster').then(
                                  function(){
                                      return $ocLazyLoad.load(['js/controllers/serve/serveChooseData.js?v='+version]);
                                  }
                              );
                          }]
                  }
              })
              .state('gxh', {//首页-个性化体检
                  url: '/gxh',
                  title:'首页-个性化体检',
                  // params:{'id':null},
                  templateUrl: 'tpl/home/gxh.html?v='+version,
                  resolve: {
                      deps: ['$ocLazyLoad',
                          function( $ocLazyLoad ){
                              return $ocLazyLoad.load('toaster').then(
                                  function(){
                                      return $ocLazyLoad.load(['js/controllers/home/home_gxh.js?v='+version]);
                                  }
                              );
                          }]
                  }
              })
              .state('layout.mobile.healthy', {//健康说
                  abstract: true,
                  url: '/healthy',
                  title:'健康说',
                  // params:{'id':null},
                  templateUrl: 'tpl/healthy/healthy.html?v='+version,
                  resolve: {
                      deps: ['$ocLazyLoad',
                          function( $ocLazyLoad ){
                              return $ocLazyLoad.load('toaster').then(
                                  function(){
                                      return $ocLazyLoad.load(['js/controllers/healthy/healthy.js?v='+version]);
                                  }
                              );
                          }]
                  }
              })
              .state('mzyy', {//首页-门诊预约
                  url: '/mzyy',
                  title:'首页-门诊预约',
                  // params:{'id':null},
                  templateUrl: 'tpl/home/mzyy.html?v='+version,
                  resolve: {
                      deps: ['$ocLazyLoad',
                          function( $ocLazyLoad ){
                              return $ocLazyLoad.load('toaster').then(
                                  function(){
                                      return $ocLazyLoad.load(['js/controllers/home/home_mzyy.js?v='+version]);
                                  }
                              );
                          }]
                  }
              })
              .state('zyap', {//首页-住院安排
                  url: '/zyap',
                  title:'首页-住院安排',
                  // params:{'id':null},
                  templateUrl: 'tpl/home/zyap.html?v='+version,
                  resolve: {
                      deps: ['$ocLazyLoad',
                          function( $ocLazyLoad ){
                              return $ocLazyLoad.load('toaster').then(
                                  function(){
                                      return $ocLazyLoad.load(['js/controllers/home/home_zyap.js?v='+version]);
                                  }
                              );
                          }]
                  }
              })
              .state('bqms', {//首页-门诊预约-病情描述
                  url: '/bqms',
                  title:'首页-门诊预约-病情描述',
                  params:{'familyName':null,'mzyy':null},
                  templateUrl: 'tpl/home/bqms.html?v='+version,
                  resolve: {
                      deps: ['$ocLazyLoad',
                          function( $ocLazyLoad ){
                              return $ocLazyLoad.load('toaster').then(
                                  function(){
                                      return $ocLazyLoad.load(['js/controllers/home/home_bqms.js?v='+version]);
                                  }
                              );
                          }]
                  }
              })
              .state('outpatient_pay', {//首页-门诊预约
                  url: '/outpatient_pay',
                  title:'首页-门诊预约',
                  params:{
                      hospital:null,
                      department:null,
                      doctor:null,
                      hope_time:null,
                      sum_price:null,
                      familyName:null
                  },
                  templateUrl: 'tpl/home/outpatient_pay.html?v='+version,
                  resolve: {
                      deps: ['$ocLazyLoad',
                          function( $ocLazyLoad ){
                              return $ocLazyLoad.load('toaster').then(
                                  function(){
                                      return $ocLazyLoad.load(['js/controllers/home/home_outpatient_pay.js?v='+version]);
                                  }
                              );
                          }]
                  }
              })
              .state('outpatient_pay_zyap', {//首页-住院安排
                  url: '/outpatient_pay_zyap',
                  title:'首页-门诊预约-住院安排',
                  params:{
                      sum_price:null,
                      familyName:null,
                      hospital:null,
                      department:null,
                      date:null
                  },
                  templateUrl: 'tpl/home/outpatient_pay_zyap.html?v='+version,
                  resolve: {
                      deps: ['$ocLazyLoad',
                          function( $ocLazyLoad ){
                              return $ocLazyLoad.load('toaster').then(
                                  function(){
                                      return $ocLazyLoad.load(['js/controllers/home/home_outpatient_pay1.js?v='+version]);
                                  }
                              );
                          }]
                  }
              })
              .state('layout.mobile.healthy.tj', {//健康说模块
                  url: '/tj',
                  title:'健康说-推荐',
                  // params:{'id':null},
                  templateUrl: 'tpl/healthy/tj.html?v='+version,
                  resolve: {
                      deps: ['$ocLazyLoad',
                          function( $ocLazyLoad ){
                              return $ocLazyLoad.load('toaster').then(
                                  function(){
                                      return $ocLazyLoad.load(['js/controllers/healthy/tj.js?v='+version]);
                                  }
                              );
                          }]
                  }
              })
              .state('layout.mobile.healthy.rd', {//健康说-热点
                  url: '/rd',
                  title:'健康说-热点',
                  // params:{'id':null},
                  templateUrl: 'tpl/healthy/rd.html?v='+version,
                  resolve: {
                      deps: ['$ocLazyLoad',
                          function( $ocLazyLoad ){
                              return $ocLazyLoad.load('toaster').then(
                                  function(){
                                      return $ocLazyLoad.load(['js/controllers/healthy/rd.js?v='+version]);
                                  }
                              );
                          }]
                  }
              })
              .state('layout.mobile.healthy.type1', {//健康说-type1
                  url: '/type1',
                  title:'健康说-type1',
                  params:{'label_id':null},
                  templateUrl: 'tpl/healthy/type1.html?v='+version,
                  resolve: {
                      deps: ['$ocLazyLoad',
                          function( $ocLazyLoad ){
                              return $ocLazyLoad.load('toaster').then(
                                  function(){
                                      return $ocLazyLoad.load(['js/controllers/healthy/type1.js?v='+version]);
                                  }
                              );
                          }]
                  }
              })
              .state('healthy_detail', {//健康说-详情
                  url: '/detail?id=&scrollTop=',
                  title:'健康说-详情',
                  params:{'id':null,'img':null,'scrollTop':null},
                  templateUrl: 'tpl/healthy/healthyDetail.html?v='+version,
                  resolve: {
                      deps: ['$ocLazyLoad',
                          function( $ocLazyLoad ){
                              return $ocLazyLoad.load('toaster').then(
                                  function(){
                                      return $ocLazyLoad.load(['js/controllers/healthy/healthyDetail.js?v='+version]);
                                  }
                              );
                          }]
                  }
              })
              .state('layout.mobile.serve', {//我的服务
                  abstract: true,
                  url: '/serve',
                  title:'我的服务',
                  // params:{'id':null},
                  templateUrl: 'tpl/serve/serve.html?v='+version,
                  resolve: {
                      deps: ['$ocLazyLoad',
                          function( $ocLazyLoad ){
                              return $ocLazyLoad.load('toaster').then(
                                  function(){
                                      return $ocLazyLoad.load(['js/controllers/serve/serve.js?v='+version]);
                                  }
                              );
                          }]
                  }
              })
              .state('msg', {//消息中心
                  url: '/msg',
                  abstract: true,
                  title:'消息中心',
                  // params:{'id':null},
                  templateUrl: 'tpl/msg/msg.html?v='+version,
                  resolve: {
                      deps: ['$ocLazyLoad',
                          function( $ocLazyLoad ){
                              return $ocLazyLoad.load('toaster').then(
                                  function(){
                                      return $ocLazyLoad.load(['js/controllers/msg/msg.js?v='+version]);
                                  }
                              );
                          }]
                  }
              })
              .state('msg.wdzx', {//消息中心-我的咨询
                  url: '/wdzx',
                  title:'消息中心-我的咨询',
                  // params:{'id':null},
                  templateUrl: 'tpl/msg/wdzx.html?v='+version,
                  resolve: {
                      deps: ['$ocLazyLoad',
                          function( $ocLazyLoad ){
                              return $ocLazyLoad.load('toaster').then(
                                  function(){
                                      return $ocLazyLoad.load(['js/controllers/msg/msg_zx.js?v='+version]);
                                  }
                              );
                          }]
                  }
              })
              .state('msg.fwxx', {//消息中心-服务信息
                  url: '/fwxx',
                  title:'消息中心-服务信息',
                  // params:{'id':null},
                  templateUrl: 'tpl/msg/fwxx.html?v='+version,
                  resolve: {
                      deps: ['$ocLazyLoad',
                          function( $ocLazyLoad ){
                              return $ocLazyLoad.load('toaster').then(
                                  function(){
                                      return $ocLazyLoad.load(['js/controllers/msg/msg.js?v='+version]);
                                  }
                              );
                          }]
                  }
              })
              .state('msg.xtgg', {//消息中心-系统公告
                  url: '/xtgg',
                  title:'消息中心-系统公告',
                  // params:{'id':null},
                  templateUrl: 'tpl/msg/xtgg.html?v='+version,
                  resolve: {
                      deps: ['$ocLazyLoad',
                          function( $ocLazyLoad ){
                              return $ocLazyLoad.load('toaster').then(
                                  function(){
                                      return $ocLazyLoad.load(['js/controllers/msg/msg.js?v='+version]);
                                  }
                              );
                          }]
                  }
              })
              .state('msg_detail', {//消息中心-系统公告
                  url: '/msg_detail',
                  title:'消息中心-系统公告',
                  params:{'id':null},
                  templateUrl: 'tpl/msg/msg_detail.html?v='+version,
                  resolve: {
                      deps: ['$ocLazyLoad',
                          function( $ocLazyLoad ){
                              return $ocLazyLoad.load('toaster').then(
                                  function(){
                                      return $ocLazyLoad.load(['js/controllers/msg/msg_detail.js?v='+version]);
                                  }
                              );
                          }]
                  }
              })
              .state('layout.mobile.serve.all', {//我的服务-全部
                  url: '/all',
                  title:'我的服务-全部',
                  // params:{'id':null},
                  templateUrl: 'tpl/serve/all.html?v='+version,
                  resolve: {
                      deps: ['$ocLazyLoad',
                          function( $ocLazyLoad ){
                              return $ocLazyLoad.load('toaster').then(
                                  function(){
                                      return $ocLazyLoad.load(['js/controllers/serve/serve.js?v='+version]);
                                  }
                              );
                          }]
                  }
              })
              .state('layout.mobile.serve.dfk', {//我的服务-待付款
                  url: '/dfk',
                  title:'我的服务-待付款',
                  // params:{'id':null},
                  templateUrl: 'tpl/serve/dfk.html?v='+version,
                  resolve: {
                      deps: ['$ocLazyLoad',
                          function( $ocLazyLoad ){
                              return $ocLazyLoad.load('toaster').then(
                                  function(){
                                      return $ocLazyLoad.load(['js/controllers/serve/dfk.js?v='+version]);
                                  }
                              );
                          }]
                  }
              })
              .state('layout.mobile.serve.yfk', {//我的服务-已付款
                  url: '/yfk',
                  title:'我的服务-已付款',
                  // params:{'id':null},
                  templateUrl: 'tpl/serve/yfk.html?v='+version,
                  resolve: {
                      deps: ['$ocLazyLoad',
                          function( $ocLazyLoad ){
                              return $ocLazyLoad.load('toaster').then(
                                  function(){
                                      return $ocLazyLoad.load(['js/controllers/serve/yfk.js?v='+version]);
                                  }
                              );
                          }]
                  }
              })
              .state('layout.mobile.serve.ywc', {//我的服务-已完成
                  url: '/ywc',
                  title:'我的服务-已完成',
                  // params:{'id':null},
                  templateUrl: 'tpl/serve/ywc.html?v='+version,
                  resolve: {
                      deps: ['$ocLazyLoad',
                          function( $ocLazyLoad ){
                              return $ocLazyLoad.load('toaster').then(
                                  function(){
                                      return $ocLazyLoad.load(['js/controllers/serve/ywc.js?v='+version]);
                                  }
                              );
                          }]
                  }
              })
              .state('layout.mobile.serve.tk', {//我的服务-退款
                  url: '/tk',
                  title:'我的服务-退款',
                  // params:{'id':null},
                  templateUrl: 'tpl/serve/tk.html?v='+version,
                  resolve: {
                      deps: ['$ocLazyLoad',
                          function( $ocLazyLoad ){
                              return $ocLazyLoad.load('toaster').then(
                                  function(){
                                      return $ocLazyLoad.load(['js/controllers/serve/tk.js?v='+version]);
                                  }
                              );
                          }]
                  }
              })
              .state('pj', {//我的服务-评价
                  url: '/pj',
                  title:'我的服务-评价',
                  params:{'id':null},
                  templateUrl: 'tpl/serve/pj.html?v='+version,
                  resolve: {
                      deps: ['$ocLazyLoad',
                          function( $ocLazyLoad ){
                              return $ocLazyLoad.load('toaster').then(
                                  function(){
                                      return $ocLazyLoad.load(['js/controllers/serve/pj.js?v='+version]);
                                  }
                              );
                          }]
                  }
              })
              .state('ddxq', {//首页-体检预约-待付款
                  url: '/ddxq?coupon_id=',
                  title:'首页-体检预约-待付款',
                  params:{
                      'id':null,
                      'data':null,
                      'familyName':null,
                      'addressName':null,
                      'addressTel':null,
                      'addressFull':null,
                      'invoice':null,
                      'coupon_id':null,
                      'code':null
                  },
                  templateUrl: 'tpl/serve/ddxq.html?v='+version,
                  resolve: {
                      deps: ['$ocLazyLoad',
                          function( $ocLazyLoad ){
                              return $ocLazyLoad.load('toaster').then(
                                  function(){
                                      return $ocLazyLoad.load(['js/controllers/serve/ddxq.js?v='+version]);
                                  }
                              );
                          }]
                  }
              })
              .state('ddxq_dz', {//首页-体检预约-待付款
                  url: '/ddxq_dz?id=&retainage=',
                  title:'定制-订单详情',
                  params:{
                      'id':null,
                      'type':null,
                      'retainage':null
                  },
                  templateUrl: 'tpl/serve/ddxq_dz.html?v='+version,
                  resolve: {
                      deps: ['$ocLazyLoad',
                          function( $ocLazyLoad ){
                              return $ocLazyLoad.load('toaster').then(
                                  function(){
                                      return $ocLazyLoad.load(['js/controllers/serve/ddxq_dz.js?v='+version]);
                                  }
                              );
                          }]
                  }
              })
              /*.state('dfk_ddxq', {//待付款-订单详情
                  url: '/dfk_ddxq',
                  title:'待付款-订单详情',
                  params:{'id':null},
                  templateUrl: 'tpl/serve/dfk_ddxq.html?v='+version,
                  resolve: {
                      deps: ['$ocLazyLoad',
                          function( $ocLazyLoad ){
                              return $ocLazyLoad.load('toaster').then(
                                  function(){
                                      return $ocLazyLoad.load(['js/controllers/serve/dfk_ddxq.js?v='+version]);
                                  }
                              );
                          }]
                  }
              })*/
              .state('invoice', {//首页-体检预约-待付款
                  url: '/invoice',
                  title:'首页-体检预约-待付款',
                  // params:{'id':null},
                  templateUrl: 'tpl/serve/invoice.html?v='+version,
                  resolve: {
                      deps: ['$ocLazyLoad',
                          function( $ocLazyLoad ){
                              return $ocLazyLoad.load('toaster').then(
                                  function(){
                                      return $ocLazyLoad.load(['js/controllers/serve/invoice.js?v='+version]);
                                  }
                              );
                          }]
                  }
              })
              .state('ddxq1', {//我的服务-订单详情-待付款
                  url: '/ddxq1',
                  title:'我的服务-订单详情-待付款',
                  params:{'item':null, 'id':null},
                  templateUrl: 'tpl/serve/ddxq1.html?v='+version,
                  resolve: {
                      deps: ['$ocLazyLoad',
                          function( $ocLazyLoad ){
                              return $ocLazyLoad.load('toaster').then(
                                  function(){
                                      return $ocLazyLoad.load(['js/controllers/serve/ddxq1.js?v='+version]);
                                  }
                              );
                          }]
                  }
              })
              .state('ddxq1Yfk', {//我的服务-订单详情-已付款
                  url: '/ddxq1Yfk',
                  title:'我的服务-订单详情-已付款',
                  params:{'id':null},
                  templateUrl: 'tpl/serve/ddxq1Yfk.html?v='+version,
                  resolve: {
                      deps: ['$ocLazyLoad',
                          function( $ocLazyLoad ){
                              return $ocLazyLoad.load('toaster').then(
                                  function(){
                                      return $ocLazyLoad.load(['js/controllers/serve/ddxq1Yfk.js?v='+version]);
                                  }
                              );
                          }]
                  }
              })
              .state('ddxq1Ywc', {//我的服务-订单详情-已完成
                  url: '/ddxq1Ywc',
                  title:'我的服务-订单详情-已完成',
                  params:{
                      'item':null,
                      'id':null
                  },
                  templateUrl: 'tpl/serve/ddxq1Ywc.html?v='+version,
                  resolve: {
                      deps: ['$ocLazyLoad',
                          function( $ocLazyLoad ){
                              return $ocLazyLoad.load('toaster').then(
                                  function(){
                                      return $ocLazyLoad.load(['js/controllers/serve/ddxq1Ywc.js?v='+version]);
                                  }
                              );
                          }]
                  }
              })
              .state('ddxq1Tk', {//我的服务-订单详情-退款
                  url: '/ddxq1Tk',
                  title:'我的服务-订单详情-退款',
                  params:{'id':null},
                  templateUrl: 'tpl/serve/ddxq1Tk.html?v='+version,
                  resolve: {
                      deps: ['$ocLazyLoad',
                          function( $ocLazyLoad ){
                              return $ocLazyLoad.load('toaster').then(
                                  function(){
                                      return $ocLazyLoad.load(['js/controllers/serve/ddxq1Tk.js?v='+version]);
                                  }
                              );
                          }]
                  }
              })
              .state('ddxq2', {//我的服务-订单详情-门诊预约
                  url: '/ddxq2',
                  title:'我的服务-订单详情-门诊预约',
                  params:{
                      'item':null,
                      'id':null
                  },
                  templateUrl: 'tpl/serve/ddxq2.html?v='+version,
                  resolve: {
                      deps: ['$ocLazyLoad',
                          function( $ocLazyLoad ){
                              return $ocLazyLoad.load('toaster').then(
                                  function(){
                                      return $ocLazyLoad.load(['js/controllers/serve/ddxq2.js?v='+version]);
                                  }
                              );
                          }]
                  }
              })
              .state('ddxq2Yfk', {//我的服务-订单详情-门诊预约-已付款
                  url: '/ddxq2Yfk',
                  title:'我的服务-订单详情-门诊预约-已付款',
                  params:{
                      'item':null,
                      'id':null
                  },
                  templateUrl: 'tpl/serve/ddxq2Yfk.html?v='+version,
                  resolve: {
                      deps: ['$ocLazyLoad',
                          function( $ocLazyLoad ){
                              return $ocLazyLoad.load('toaster').then(
                                  function(){
                                      return $ocLazyLoad.load(['js/controllers/serve/ddxq2Yfk.js?v='+version]);
                                  }
                              );
                          }]
                  }
              })
              .state('ddxq2Ywc', {//我的服务-订单详情-门诊预约-已完成
                  url: '/ddxq2Ywc',
                  title:'我的服务-订单详情-门诊预约-已完成',
                  params:{
                      'item':null,
                      'id':null
                  },
                  templateUrl: 'tpl/serve/ddxq2Ywc.html?v='+version,
                  resolve: {
                      deps: ['$ocLazyLoad',
                          function( $ocLazyLoad ){
                              return $ocLazyLoad.load('toaster').then(
                                  function(){
                                      return $ocLazyLoad.load(['js/controllers/serve/ddxq2Ywc.js?v='+version]);
                                  }
                              );
                          }]
                  }
              })
              .state('ddxq2Tk', {//我的服务-订单详情-门诊预约-退款
                  url: '/ddxq2Tk',
                  title:'我的服务-订单详情-门诊预约-退款',
                  params:{
                      'item':null,
                      'id':null
                  },
                  templateUrl: 'tpl/serve/ddxq2Tk.html?v='+version,
                  resolve: {
                      deps: ['$ocLazyLoad',
                          function( $ocLazyLoad ){
                              return $ocLazyLoad.load('toaster').then(
                                  function(){
                                      return $ocLazyLoad.load(['js/controllers/serve/ddxq2Tk.js?v='+version]);
                                  }
                              );
                          }]
                  }
              })
              .state('ddxq3', {//我的服务-订单详情-住院安排+手术安排
                  url: '/ddxq3',
                  title:'我的服务-订单详情-住院安排+手术安排',
                  params:{
                      'item':null,
                      'id':null
                  },
                  templateUrl: 'tpl/serve/ddxq3.html?v='+version,
                  resolve: {
                      deps: ['$ocLazyLoad',
                          function( $ocLazyLoad ){
                              return $ocLazyLoad.load('toaster').then(
                                  function(){
                                      return $ocLazyLoad.load(['js/controllers/serve/ddxq2.js?v='+version]);
                                  }
                              );
                          }]
                  }
              })
              .state('ddxq3Yfk', {//我的服务-订单详情-住院安排+手术安排-已付款
                  url: '/ddxq3Yfk',
                  title:'我的服务-订单详情-住院安排+手术安排-已付款',
                  params:{
                      'item':null,
                      'id':null
                  },
                  templateUrl: 'tpl/serve/ddxq3Yfk.html?v='+version,
                  resolve: {
                      deps: ['$ocLazyLoad',
                          function( $ocLazyLoad ){
                              return $ocLazyLoad.load('toaster').then(
                                  function(){
                                      return $ocLazyLoad.load(['js/controllers/serve/ddxq2Yfk.js?v='+version]);
                                  }
                              );
                          }]
                  }
              })
              .state('ddxq3Ywc', {//我的服务-订单详情-住院安排+手术安排-已完成
                  url: '/ddxq3Ywc',
                  title:'我的服务-订单详情-住院安排+手术安排-已完成',
                  params:{
                      'item':null,
                      'id':null
                  },
                  templateUrl: 'tpl/serve/ddxq3Ywc.html?v='+version,
                  resolve: {
                      deps: ['$ocLazyLoad',
                          function( $ocLazyLoad ){
                              return $ocLazyLoad.load('toaster').then(
                                  function(){
                                      return $ocLazyLoad.load(['js/controllers/serve/ddxq2Ywc.js?v='+version]);
                                  }
                              );
                          }]
                  }
              })
              .state('ddxq3Tk', {//我的服务-订单详情-住院安排+手术安排-退款
                  url: '/ddxq3Tk',
                  title:'我的服务-订单详情-住院安排+手术安排-退款',
                  params:{
                      'item':null,
                      'id':null
                  },
                  templateUrl: 'tpl/serve/ddxq3Tk.html?v='+version,
                  resolve: {
                      deps: ['$ocLazyLoad',
                          function( $ocLazyLoad ){
                              return $ocLazyLoad.load('toaster').then(
                                  function(){
                                      return $ocLazyLoad.load(['js/controllers/serve/ddxq2Tk.js?v='+version]);
                                  }
                              );
                          }]
                  }
              })
              .state('ddxq4', {//我的服务-订单详情-个性化定制
                  url: '/ddxq4',
                  title:'我的服务-订单详情-个性化定制',
                  params:{
                      'item':null,
                      'id':null
                  },
                  templateUrl: 'tpl/serve/ddxq4.html?v='+version,
                  resolve: {
                      deps: ['$ocLazyLoad',
                          function( $ocLazyLoad ){
                              return $ocLazyLoad.load('toaster').then(
                                  function(){
                                      return $ocLazyLoad.load(['js/controllers/serve/ddxq4.js?v='+version]);
                                  }
                              );
                          }]
                  }
              })
              .state('ddxq4_undone', {//我的服务-订单详情-个性化定制
                  url: '/ddxq4_undone',
                  title:'我的服务-订单详情-个性化定制',
                  params:{
                      'item':null,
                      'id':null
                  },
                  templateUrl: 'tpl/serve/ddxq4_undone.html?v='+version,
                  resolve: {
                      deps: ['$ocLazyLoad',
                          function( $ocLazyLoad ){
                              return $ocLazyLoad.load('toaster').then(
                                  function(){
                                      return $ocLazyLoad.load(['js/controllers/serve/ddxq4_undone.js?v='+version]);
                                  }
                              );
                          }]
                  }
              })
              .state('ddxq4Yfk', {//我的服务-订单详情-个性化定制-已付款
                  url: '/ddxq4Yfk',
                  title:'我的服务-订单详情-个性化定制-已付款',
                  params:{
                      'item':null,
                      'id':null
                  },
                  templateUrl: 'tpl/serve/ddxq4Yfk.html?v='+version,
                  resolve: {
                      deps: ['$ocLazyLoad',
                          function( $ocLazyLoad ){
                              return $ocLazyLoad.load('toaster').then(
                                  function(){
                                      return $ocLazyLoad.load(['js/controllers/serve/ddxq4Yfk.js?v='+version]);
                                  }
                              );
                          }]
                  }
              })
              .state('ddxq4Ywc', {//我的服务-订单详情-个性化定制-已完成
                  url: '/ddxq4Ywc',
                  title:'我的服务-订单详情-个性化定制-已完成',
                  params:{
                      'item':null,
                      'id':null
                  },
                  templateUrl: 'tpl/serve/ddxq4Ywc.html?v='+version,
                  resolve: {
                      deps: ['$ocLazyLoad',
                          function( $ocLazyLoad ){
                              return $ocLazyLoad.load('toaster').then(
                                  function(){
                                      return $ocLazyLoad.load(['js/controllers/serve/ddxq4Ywc.js?v='+version]);
                                  }
                              );
                          }]
                  }
              })
              .state('ddxq4Tk', {//我的服务-订单详情-个性化定制-退款
                  url: '/ddxq4Tk',
                  title:'我的服务-订单详情-个性化定制-退款',
                  params:{
                      'item':null,
                      'id':null
                  },
                  templateUrl: 'tpl/serve/ddxq4Tk.html?v='+version,
                  resolve: {
                      deps: ['$ocLazyLoad',
                          function( $ocLazyLoad ){
                              return $ocLazyLoad.load('toaster').then(
                                  function(){
                                      return $ocLazyLoad.load(['js/controllers/serve/ddxq4Tk.js?v='+version]);
                                  }
                              );
                          }]
                  }
              })
              .state('zf', {//我的服务-支付页面
                  url: '/zf',
                  title:'我的服务-支付页面',
                  // params:{'id':null},
                  templateUrl: 'tpl/serve/zf.html?v='+version,
                  resolve: {
                      deps: ['$ocLazyLoad',
                          function( $ocLazyLoad ){
                              return $ocLazyLoad.load('toaster').then(
                                  function(){
                                      return $ocLazyLoad.load(['js/controllers/serve/serve.js?v='+version]);
                                  }
                              );
                          }]
                  }
              })
              .state('tjyyPay', {//体检预约-支付页面
                  url: '/tjyyPay?id=&isServe=&total_price=&coupon_id=',
                  title:'体检预约-支付页面',
                  params:{'id':null,'isServe':null,'total_price':null,'coupon_id':null,'code':null},
                  templateUrl: 'tpl/serve/tjyyPay.html?v='+version,
                  resolve: {
                      deps: ['$ocLazyLoad',
                          function( $ocLazyLoad ){
                              return $ocLazyLoad.load('toaster').then(
                                  function(){
                                      return $ocLazyLoad.load(['js/controllers/serve/tjyyPay.js?v='+version]);
                                  }
                              );
                          }]
                  }
              })
              .state('layout.mobile.mine', {//个人中心
                  url: '/mine',
                  title:'个人中心',
                  params:{'id':null},
                  templateUrl: 'tpl/mine/mine.html?v='+version,
                  resolve: {
                      deps: ['$ocLazyLoad',
                          function( $ocLazyLoad ){
                              return $ocLazyLoad.load('toaster').then(
                                  function(){
                                      return $ocLazyLoad.load(['js/controllers/mine/mine.js?v='+version]);
                                  }
                              );
                          }]
                  }
              })
              .state('zhgl', {//个人中心-账户管理
                  url: '/zhgl',
                  title:'个人中心-账户管理',
                  // params:{'id':null},
                  templateUrl: 'tpl/mine/zhgl.html?v='+version,
                  resolve: {
                      deps: ['$ocLazyLoad',
                          function( $ocLazyLoad ){
                              return $ocLazyLoad.load('toaster').then(
                                  function(){
                                      return $ocLazyLoad.load(['js/controllers/mine/zhgl.js?v='+version]);
                                  }
                              );
                          }]
                  }
              })
              .state('changeTel', {//个人中心-修改手机号
                  url: '/changeTel',
                  title:'个人中心-账户管理',
                  // params:{'id':null},
                  templateUrl: 'tpl/mine/changeTel.html?v='+version,
                  resolve: {
                      deps: ['$ocLazyLoad',
                          function( $ocLazyLoad ){
                              return $ocLazyLoad.load('toaster').then(
                                  function(){
                                      return $ocLazyLoad.load(['js/controllers/mine/changeTel.js?v='+version]);
                                  }
                              );
                          }]
                  }
              })
              .state('address', {//个人中心-收货地址
                  url: '/address?isDdxq=&isLstd=',
                  title:'个人中心-收货地址',
                  params:{
                      'id':null,
                      'isDdxq':null,
                      'isLstd':null
                  },
                  templateUrl: 'tpl/mine/address.html?v='+version,
                  resolve: {
                      deps: ['$ocLazyLoad',
                          function( $ocLazyLoad ){
                              return $ocLazyLoad.load('toaster').then(
                                  function(){
                                      return $ocLazyLoad.load(['js/controllers/mine/address.js?v='+version]);
                                  }
                              );
                          }]
                  }
              })
              .state('address-choose', {//个人中心-收货地址-省市区选择
                  url: '/address-choose',
                  title:'个人中心-收货地址-省市区选择',
                  params:{'isDdxq':null,'item':null},
                  templateUrl: 'tpl/mine/address-choose.html?v='+version,
                  resolve: {
                      deps: ['$ocLazyLoad',
                          function( $ocLazyLoad ){
                              return $ocLazyLoad.load('toaster').then(
                                  function(){
                                      return $ocLazyLoad.load(['js/controllers/mine/address-choose.js?v='+version]);
                                  }
                              );
                          }]
                  }
              })
              .state('qybd', {//个人中心-企业绑定
                  url: '/qybd',
                  title:'个人中心-企业绑定',
                  // params:{'id':null},
                  templateUrl: 'tpl/mine/qybd.html?v='+version,
                  resolve: {
                      deps: ['$ocLazyLoad',
                          function( $ocLazyLoad ){
                              return $ocLazyLoad.load('toaster').then(
                                  function(){
                                      return $ocLazyLoad.load(['js/controllers/mine/qybd.js?v='+version]);
                                  }
                              );
                          }]
                  }
              })
              .state('wdtyq', {//个人中心-我的体验券
                  url: '/wdtyq',
                  title:'个人中心-我的体验券',
                  // params:{'id':null},
                  templateUrl: 'tpl/mine/wdtyq.html?v='+version,
                  resolve: {
                      deps: ['$ocLazyLoad',
                          function( $ocLazyLoad ){
                              return $ocLazyLoad.load('toaster').then(
                                  function(){
                                      return $ocLazyLoad.load(['js/controllers/mine/mine.js?v='+version]);
                                  }
                              );
                          }]
                  }
              })
              .state('jkda', {//个人中心-健康档案
                  url: '/jkda',
                  title:'个人中心-健康档案',
                  // params:{'id':null},
                  templateUrl: 'tpl/mine/jkda.html?v='+version,
                  resolve: {
                      deps: ['$ocLazyLoad',
                          function( $ocLazyLoad ){
                              return $ocLazyLoad.load('toaster').then(
                                  function(){
                                      return $ocLazyLoad.load(['js/controllers/mine/jkda.js?v='+version]);
                                  }
                              );
                          }]
                  }
              })
              .state('family', {//个人中心-家人管理
                  url: '/family',
                  title:'个人中心-家人管理',
                  params:{
                      'id':null,
                      'chooseFamily':null
                  },
                  templateUrl: 'tpl/mine/family.html?v='+version,
                  resolve: {
                      deps: ['$ocLazyLoad',
                          function( $ocLazyLoad ){
                              return $ocLazyLoad.load('toaster').then(
                                  function(){
                                      return $ocLazyLoad.load(['js/controllers/mine/family.js?v='+version]);
                                  }
                              );
                          }]
                  }
              })
              .state('setting', {//个人中心-设置
                  url: '/setting',
                  title:'个人中心-设置',
                  // params:{'id':null},
                  templateUrl: 'tpl/mine/setting.html?v='+version,
                  resolve: {
                      deps: ['$ocLazyLoad',
                          function( $ocLazyLoad ){
                              return $ocLazyLoad.load('toaster').then(
                                  function(){
                                      return $ocLazyLoad.load(['js/controllers/mine/setting.js?v='+version]);
                                  }
                              );
                          }]
                  }
              })
              .state('setting_password', {//个人中心-设置-修改密码
                  url: '/setting_password',
                  title:'个人中心-设置-修改密码',
                  // params:{'id':null},
                  templateUrl: 'tpl/mine/setting-password.html?v='+version,
                  resolve: {
                      deps: ['$ocLazyLoad',
                          function( $ocLazyLoad ){
                              return $ocLazyLoad.load('toaster').then(
                                  function(){
                                      return $ocLazyLoad.load(['js/controllers/mine/setting.js?v='+version]);
                                  }
                              );
                          }]
                  }
              })
              .state('setting_yj', {//个人中心-设置-意见反馈
                  url: '/setting_yj',
                  title:'个人中心-设置-意见反馈',
                  // params:{'id':null},
                  templateUrl: 'tpl/mine/setting-yj.html?v='+version,
                  resolve: {
                      deps: ['$ocLazyLoad',
                          function( $ocLazyLoad ){
                              return $ocLazyLoad.load('toaster').then(
                                  function(){
                                      return $ocLazyLoad.load(['js/controllers/mine/setting.js?v='+version]);
                                  }
                              );
                          }]
                  }
              })
              .state('setting_about', {//个人中心-设置-关于我们
                  url: '/setting_about',
                  title:'个人中心-设置-关于我们',
                  // params:{'id':null},
                  templateUrl: 'tpl/mine/setting-about.html?v='+version,
                  resolve: {
                      deps: ['$ocLazyLoad',
                          function( $ocLazyLoad ){
                              return $ocLazyLoad.load('toaster').then(
                                  function(){
                                      return $ocLazyLoad.load(['js/controllers/mine/mine_about.js?v='+version]);
                                  }
                              );
                          }]
                  }
              })
      }
    ]
  )
    .filter('to_trusted', ['$sce', function ($sce) {
        return function (text) {
            return $sce.trustAsHtml(text);
        };
    }]);