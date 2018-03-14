/**
 * Created by Bingo on 2017/5/23.
 */
app.config(["$stateProvider","$urlRouterProvider",routeFn]);
function routeFn($stateProvider,$urlRouterProvider){
    //默认进入页面
    $urlRouterProvider.otherwise("/home");
    $stateProvider
        .state('layout',{
            abstract: true,
            url: '',
            templateUrl:'views/layout.html'
        })
        .state('layout.home',{
            url: '/home',
            title:'首页',
            // params:{'id':null},
            /*views: {
                "lazyLoadView": {
                    controller: 'homeCtrl',
                    templateUrl: 'views/home/home.html'
                }
            },*/
            templateUrl: 'views/home/home.html',
            controller:'homeCtrl',
            resolve: {
                loadMyCtrl: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load('views/home/home.js');
                }]
            }
        })
        .state('layout.healthy',{
            abstract: true,
            url: '/healthy',
            title:'健康说',
            // params:{'id':null},
            templateUrl: 'views/healthy/healthy.html',
            controller:'healthyCtrl',
            resolve: {
                loadMyCtrl: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load('views/healthy/healthy.js');
                }]
            }
        })
        .state('layout.healthy.tj',{
            url: '/tj',
            title:'健康说-推荐',
            // params:{'id':null},
            templateUrl: 'views/healthy/tj.html'
            // controller:'healthyCtrl',
        })
        .state('layout.healthy.rd',{
            url: '/rd',
            title:'健康说-热点',
            // params:{'id':null},
            templateUrl: 'views/healthy/rd.html'
            // controller:'healthyCtrl',
        })
        .state('healthy_detail',{
            url: '/detail',
            title:'健康说-详情',
            params:{'id':null},
            templateUrl: 'views/healthy/healthy_detail.html'
            // controller:'healthyCtrl',
        })
        .state('layout.serve',{
            abstract: true,
            url: '/serve',
            title:'我的服务',
            // params:{'id':null},
            templateUrl: 'views/serve/serve.html',
            controller:'serveCtrl',
            resolve: {
                loadMyCtrl: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load('views/serve/serve.js');
                }]
            }
        })
        .state('layout.serve.all',{
            url: '/all',
            title:'我的服务-全部',
            // params:{'id':null},
            templateUrl: 'views/serve/all.html',
            controller:'serveCtrl',
            /*resolve: {
                loadMyCtrl: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load('views/serve/serve.js');
                }]
            }*/
        })
        .state('layout.serve.dfk',{
            url: '/dfk',
            title:'我的服务-待付款',
            // params:{'id':null},
            templateUrl: 'views/serve/dfk.html',
            controller:'serveCtrl',
            /*resolve: {
                loadMyCtrl: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load('views/serve/serve.js');
                }]
            }*/
        })
        .state('layout.serve.yfk',{
            url: '/yfk',
            title:'我的服务-已付款',
            // params:{'id':null},
            templateUrl: 'views/serve/yfk.html',
            controller:'serveCtrl',
            /*resolve: {
                loadMyCtrl: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load('views/serve/serve.js');
                }]
            }*/
        })
        .state('layout.serve.ywc',{
            url: '/ywc',
            title:'我的服务-已完成',
            // params:{'id':null},
            templateUrl: 'views/serve/ywc.html',
            controller:'serveCtrl',
            /*resolve: {
                loadMyCtrl: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load('views/serve/serve.js');
                }]
            }*/
        })
        .state('layout.serve.tk',{
            url: '/tk',
            title:'我的服务-退款',
            // params:{'id':null},
            templateUrl: 'views/serve/tk.html',
            controller:'serveCtrl',
            /*resolve: {
                loadMyCtrl: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load('views/serve/serve.js');
                }]
            }*/
        })
        .state('pj',{
            url: '/pj',
            title:'我的服务-评价',
            // params:{'id':null},
            templateUrl: 'views/serve/pj.html',
            controller:'serveCtrl',
            resolve: {
                loadMyCtrl: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load('views/serve/serve.js');
                }]
            }
        })
        .state('layout.mine',{
            url: '/mine',
            title:'个人中心',
            // params:{'id':null},
            templateUrl: 'views/mine/mine.html',
            controller:'mineCtrl',
            resolve: {
                loadMyCtrl: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load('views/mine/mine.js');
                }]
            }
        })
        .state('setting',{
            url: '/setting',
            title:'个人中心-设置',
            // params:{'id':null},
            templateUrl: 'views/mine/setting.html',
            controller:'mineCtrl',
            resolve: {
                loadMyCtrl: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load('views/mine/mine.js');
                }]
            }
        })
        .state('setting_password',{
            url: '/setting_password',
            title:'个人中心-设置-修改密码',
            // params:{'id':null},
            templateUrl: 'views/mine/setting-password.html',
            controller:'mineCtrl',
            resolve: {
                loadMyCtrl: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load('views/mine/mine.js');
                }]
            }
        })
        .state('setting_yj',{
            url: '/setting_yj',
            title:'个人中心-设置-意见反馈',
            // params:{'id':null},
            templateUrl: 'views/mine/setting-yj.html',
            controller:'mineCtrl',
            resolve: {
                loadMyCtrl: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load('views/mine/mine.js');
                }]
            }
        });
};
