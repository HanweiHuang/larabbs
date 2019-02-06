##Http
    Controller
    Middleware
    Requests

##Jobs
    TranslateSlig.php

##Models
    Category
    Model
    Reply
    Topic
    User

##Notifications
    TopicReplied

##Observers
    ReplyObserver
    TopicObserver
    UserObserver

##Policies
    Policy
    ReplyPolicy
    TopicPolicy
    UserPolicy


##Larabbs User Role
    1.guest -> dont need to login
        * can read limited topic
        * can not publish topic
    2.user-> need login 
        * can manage own topics 
        * can read limited topic
    3.administrator -> manage content of bbs
        * can manage all topics
        * can not manage user info
    4.super administrator -> the highest authority role
        * can manage all info

    Customer -> Can be
        1. * admin
           * super admin 
        2. guest
        3. user

    **larabbs use laravel-permission as our extend package**
    this extend package will create 5 database tables
    1.roles 
    2.permissions
    3.role_has_permissions relation between with role and permission
    4.model_has_role relation between with model and role
    5.model_has_permissions

    Permissions : 
        1. manage_contents
        2. manage_users
        3. edit_settings


#上传到qiniu云 处理方式。
基于七牛云没有 文件夹概念， 需要使用前缀来区分文件夹。
1.上传时候确定前缀，在本地创建文件夹。
2.文件夹以数据库存储

Folder
id //primary key
name //fold name
type //gallery(暂时),还可能有vedio
data //url
create_at 
last_visit
visible 
comment //desc




//broadcast 实现reply自动更新
1.后端redis 队列 + laravel的broadcast机制
2.laravel-echo-server 监听broadcast发出的event
3.laravel-echo 在前端获取数据更新
* 要同时开启队列queue的进程和laravel-echo-server进程