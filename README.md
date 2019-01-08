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