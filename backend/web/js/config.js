/**
 * Created by Bingo on 2017/5/22.
 */
var app=angular.module('app', ['ionic','ngStorage','oc.lazyLoad','ngFileUpload']);
app.run(function ($rootScope,$state,$stateParams,$sessionStorage,$http,$location) {
    //公共配置
    $rootScope.baseOption={
        active:1//底部激活
    };
    $rootScope.isShow =1;
    //路由改变
    $rootScope.$on('$stateChangeStart',function(event,toState,toParams,fromState,fromParams){
        //动态改变title
        if(toState.title){
            // console.log(toState.title);
            $rootScope.indexTitle=toState.title;
        }else{//空值的情况下通过控制器赋值
            $rootScope.indexTitle=null
        }
    })
});
app.config(function ($provide, $compileProvider, $controllerProvider, $filterProvider) {
    app.controller = $controllerProvider.register;
    app.directive = $compileProvider.directive;
    app.filter = $filterProvider.register;
    app.factory = $provide.factory;
    app.service = $provide.service;
    app.constant = $provide.constant;
});
app.constant('Modules_Config', [
    {
        name: 'treeControl',
        serie: true,
        files: []
    }
]);
app.config(["$ocLazyLoadProvider","Modules_Config",routeFn]);
function routeFn($ocLazyLoadProvider,Modules_Config){
    $ocLazyLoadProvider.config({
        debug:false,
        events:false,
        modules:Modules_Config
    });
};
