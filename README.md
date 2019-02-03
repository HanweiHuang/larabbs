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


API部分
#手机注册 API
POST api/captchas (create validated pic)
POST api/verificationCodes (send validated message)
POST api/users (users register)

流程：
1.用户输入手机号
2.通过手机号请求图片验证码，显示给用户
3.用户输入正确的图片验证码，服务器发送验证码至用户手机
4.用户填写，姓名，密码，及正确的短信验证码，完成注册



verificationCodes 接口思路
1.收到手机号的请求
2.生成随机数，发送给短信服务器要求发送短信
3.保存时间和随机数在缓存中，生成一个key
4.返回给调用api的用户端key
5.当手机接到短信，用户端就可以使用刚刚的key和验证信息再次调用注册接口来验证

//