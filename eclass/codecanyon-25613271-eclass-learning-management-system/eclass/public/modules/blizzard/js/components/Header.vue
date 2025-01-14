<template>
    <div>
        <!-- header section start -->
        <header class="main-header">
            <div class="container">
                
                <nav class="navbar navbar-expand-lg navbar-light bg-transparent align-items-lg-center ">
                    <!-- Logo -->
                    <router-link to="/" class="navbar-brand">
                        <img :src="settings.logo != null ? `${path}/images/logo/${settings.logo}` : `${baseurl}/modules/blizzard/images/background.jpg`" alt="logo" width="125px" height="40px">
                    </router-link>

                    <!-- Menus -->
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav align-items-lg-center" :class="!loginStatus ? 'margin_left_not_login_header' : ''">
                            <!-- My Courses -->
                            <li class="nav-item" v-if="loginStatus">
                                <router-link to="/myCourses" class="nav-link">
                                    {{ translate('frontstaticword.MyCourses')}}
                                </router-link>
                            </li>

                            <!-- Categories -->
                            <li class="nav-item position-relative" v-if="categoryLength > 0">
                                <div class="navigation">
                                    <div id="cssmenu" class="">
                                        <ul>
                                            <li class="has-sub"><span class="submenu-button"></span>
                                                <a :title="translate('frontstaticword.Categories')">
                                                    <svg
                                                    style="margin-right: 5px; margin-bottom: 2px" xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="20px" height="20px">
                                                    <path fill-rule="evenodd" fill="rgb(137, 137, 137)"
                                                        d="M16.000,20.000 L16.000,16.000 L20.000,16.000 L20.000,20.000 L16.000,20.000 ZM16.000,8.000 L20.000,8.000 L20.000,12.000 L16.000,12.000 L16.000,8.000 ZM16.000,0.000 L20.000,0.000 L20.000,4.000 L16.000,4.000 L16.000,0.000 ZM8.000,16.000 L12.000,16.000 L12.000,20.000 L8.000,20.000 L8.000,16.000 ZM8.000,8.000 L12.000,8.000 L12.000,12.000 L8.000,12.000 L8.000,8.000 ZM8.000,0.000 L12.000,0.000 L12.000,4.000 L8.000,4.000 L8.000,0.000 ZM-0.000,16.000 L4.000,16.000 L4.000,20.000 L-0.000,20.000 L-0.000,16.000 ZM-0.000,8.000 L4.000,8.000 L4.000,12.000 L-0.000,12.000 L-0.000,8.000 ZM-0.000,0.000 L4.000,0.000 L4.000,4.000 L-0.000,4.000 L-0.000,0.000 Z" />
                                                    </svg> 
                                                    <span class="font-18"> 
                                                        {{ translate('frontstaticword.Categories')}} 
                                                    </span>
                                                    <i class="feather icon-chevron-down"></i>
                                                </a>
                                                <ul>
                                                    <li class="has-sub" v-for="(category,index) in category" :key="index">
                                                        <span class="submenu-button"></span>
                                                        <!-- Category -->
                                                        <a @click="go_to_category(category.id,category.title.en)">
                                                            {{category.title.en}}<i class="fa fa-chevron-right"></i>
                                                        </a>
                                                        <ul>
                                                            <!-- Sub Category -->
                                                            <li class="has-sub" v-for="(subcategory,id) in category.subcategory" :key="id">
                                                                <span class="submenu-button"></span>
                                                                <a @click="go_to_sub_category(subcategory.id,subcategory.title)">
                                                                {{subcategory.title}}<i class="fa fa-chevron-right"></i>
                                                                </a>
                                                                <ul>  
                                                                <li v-for="(childcategory,child_id) in subcategory.childcategory" :key="child_id"> 
                                                                    <a @click="go_to_child_category(childcategory.id,childcategory.title)">
                                                                        {{childcategory.title}}
                                                                    </a>
                                                                </li>   
                                                                </ul>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                            
                            <!-- Cart -->
                            <li class="nav-item text-center" v-if="loginStatus">
                                <router-link class="nav-link cart-icon" to="/cart">
                                    <i class="feather icon-shopping-cart"></i>
                                    <span class="red-menu-badge red-bg-success">{{cartTotal}}</span>
                                </router-link>
                            </li>

                            <!-- Wishlist -->
                            <li class="nav-item text-center" v-if="loginStatus">
                                <router-link class="nav-link cart-icon" to="/wishlist">
                                    <i class="feather icon-heart"></i>
                                    <span class="red-menu-badge red-bg-success">{{wishlistTotal}}</span>
                                </router-link>
                            </li>

                            <!-- Notification -->
                            <li class="nav-item text-center" v-if="loginStatus">
                                <a class="nav-link cart-icon" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <!-- <i class="far fa-bell"> <sup>{{totalNotifications}}</sup> </i> -->
                                    <i class="feather icon-bell"></i>
                                    <span class="red-menu-badge red-bg-success">{{totalNotifications}}</span>
                                </a>

                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <div id="notificationTitle">Notifications</div>
                                    <div id="notificationsBody" class="notifications">
                                        
                                        <ul>
                                            <li class="dropdown-item" v-for="(notification,index) in notifications" :key="index"> 
                                            <a @click="readNotification(notification.id)">
                                                <div class="notification-image mr-2">
                                                    <img :src="`${path}/images/course/${notification.data.image}`" alt="course">
                                                </div>
                                                <div class="notification-data text-truncate">
                                                    {{ translate('frontstaticword.In')}} {{notification.data.id}}
                                                    <br>
                                                    {{notification.data.data}}
                                                </div>
                                            </a>
                                            </li>
                                        </ul>
                                        <div id="notificationFooter">
                                            <button type="button" class="btn btn-info" @click="readAllNotification">
                                                {{ translate('frontstaticword.MarkAllRead')}}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <!-- Search -->
                            <li class="nav-item text-center search">
                                <div class="search" id="search">
                                    <form id="searchform" @submit.prevent="sendToSearch">
                                        <div class="search-input-wrap">
                                        <input class="search-input" name="searchTerm" v-model="searchTerm" :placeholder="translate('frontstaticword.SearchinSite')" type="text" id="s"/>
                                        </div>
                                        <input class="search-submit" type="submit" id="go" value="">
                                        <div class="search-icon">
                                            <i class="feather icon-search"></i>
                                        </div>
                                    </form>
                                </div>
                            </li>
                            
                            <!-- User Profile -->
                            <li class="nav-item position-relative" v-if="loginStatus">
                                <ul class="dropmenu position-absolute">
                                    <!-- Admin Dashboard -->
                                    <li>
                                        <a :href="`${baseurl}/admins`" v-if="mainUser.role == 'admin'">
                                            <i class="feather icon-shield mr-2"></i>
                                            {{ translate('frontstaticword.AdminDashboard')}}
                                        </a>
                                    </li>

                                    <!-- Instructor Dashboard -->
                                    <li>
                                        <a :href="`${baseurl}/instructor`" v-if="mainUser.role == 'instructor'">
                                            <i class="feather icon-shield mr-2"></i>
                                            {{ translate('frontstaticword.InstructorDashboard')}}
                                        </a>
                                    </li>

                                    <!-- User Profile -->
                                    <li>
                                        <router-link to="/myProfile">
                                            <i class="feather icon-user mr-2"></i>
                                            {{ translate('frontstaticword.UserProfile')}}
                                        </router-link>
                                    </li>

                                    <!-- Wishlist -->
                                    <li>
                                        <router-link to="/wishlist">
                                            <i class="feather icon-heart mr-2"></i>
                                            {{ translate('frontstaticword.Wishlist')}}
                                        </router-link>
                                    </li>

                                    <!-- Donation Link -->
                                    <li v-if="settings.donation_enable=='1'">
                                        <a :href="settings.donation_link!=null ? settings.donation_link : ''" target="_blank">
                                            <i class="feather icon-thumbs-up mr-2"></i>
                                            {{ translate('frontstaticword.Donation')}}
                                        </a>
                                    </li>

                                    <!-- Purchase History -->
                                    <li>
                                        <router-link to="/purchaseHistory">
                                            <i class="feather icon-clock mr-2"></i>
                                            {{ translate('frontstaticword.PurchaseHistory')}}
                                        </router-link>
                                    </li>

                                    <!-- Logout -->
                                    <li>
                                        <a @click="logout">
                                            <i class="feather icon-power mr-2"></i>
                                            {{ translate('frontstaticword.Logout')}}
                                        </a>
                                    </li>
                                </ul>

                                <a class="nav-link pseudo-icon position-relative ml-lg-4" >
                                    <!-- User image -->
                                    <img 
                                        :src="mainUser.user_img != null ? `${path}/images/user_img/${mainUser.user_img}` : `${baseurl}/modules/blizzard/images/user_default.jpg`" 
                                        :alt="translate('frontstaticword.UserProfile')" 
                                        class="user-img"
                                    > 
                                    <span class="user-name">
                                        {{mainUser.fname}} 
                                        <i class="fa fa-angle-down" aria-hidden="true"></i>
                                    </span>
                                </a>
                            </li>

                            <!-- Login -->
                            <li class="nav-item" v-if="!loginStatus">
                                <router-link class="btn my-3 my-lg-0 mr-lg-1" to="/signIn">
                                    {{ translate('frontstaticword.Login')}}
                                </router-link>
                            </li>
                            <!-- Register -->
                            <li class="nav-item" v-if="!loginStatus">
                                <router-link class="btn" to="/signUp">
                                    {{ translate('frontstaticword.SignUp')}}
                                </router-link>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>

            <!-- responsive sidebar -->
            <div class="small-screen-navigation">
                <nav class="navbar navbar-expand-lg navbar-light bg-transparent align-items-lg-center ">
                    <div class="row">
                        <div class="col-3">
                            <!-- Menus -->
                            <b-button class="navbar-toggler border-0 sidebar-btn" variant="btn-outline-secondary" v-b-toggle.sidebar-backdrop>
                                <span class="navbar-toggler-icon"></span>
                            </b-button>
                                <b-sidebar
                                id="sidebar-backdrop"
                                class="small-screen-sidebar"
                                no-header 
                                backdrop-variant="dark"
                                backdrop
                                shadow
                                >

                                <template v-slot:default="{ hide }">
                                    <div class="collapse navbar-collapse" id="navbarNav">
                                        <div class="dropdown-close-btn">
                                            <div class="row">
                                                <div class="col-9">
                                                    <!-- User Profile -->
                                                    <a class="nav-link pseudo-icon position-relative ml-lg-4" >
                                                        <!-- User image -->
                                                        <img 
                                                            :src="mainUser.user_img != null ? `${path}/images/user_img/${mainUser.user_img}` : `${baseurl}/modules/blizzard/images/user_default.jpg`" 
                                                            :alt="translate('frontstaticword.UserProfile')"
                                                            class="user-img"
                                                        > 
                                                        <span class="user-name">
                                                            <div>{{ translate('frontstaticword.Hi')}},{{mainUser.fname}}</div>
                                                            <div class="welcome-msg" v-if="loginStatus">
                                                                {{ translate('frontstaticword.Welcomeback')}}
                                                            </div> 

                                                            <div class="welcome-msg" v-if="!loginStatus">
                                                                {{ translate('frontstaticword.PleaseLogin')}}
                                                            </div> 
                                                        </span>
                                                    </a>
                                                </div>
                                                <div class="col-3">
                                                    <!-- Close button -->
                                                    <span class="close_btn_sidebar float-right" block @click="hide">
                                                        <i class="feather icon-x-circle"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        

                                        <ul class="navbar-nav align-items-lg-center">

                                            <!-- My Courses -->
                                            <li class="nav-item mt-2" v-if="loginStatus">
                                                <router-link to="/myCourses" class="nav-link">
                                                    <div class="nav-icon">
                                                        <i class="feather icon-book-open"></i>
                                                    </div>
                                                    <span>{{ translate('frontstaticword.MyCourses')}}</span>
                                                </router-link>
                                            </li>

                                            <!-- Categories -->
                                            <li class="nav-item category-block position-relative" v-if="categoryLength > 0">
                                                <div id="accordion">
                                                    <div class="card">
                                                        <div class="card-header" id="heading-1">
                                                            <h5 class="mb-0">
                                                                <a role="button" data-toggle="collapse" href="#collapse-1" aria-expanded="false" aria-controls="collapse-1">
                                                                    <div class="nav-icon">
                                                                        <i class="feather icon-grid"></i>
                                                                    </div>
                                                                    <span class="font-18"> 
                                                                        {{ translate('frontstaticword.Categories')}} 
                                                                    </span>
                                                                    <i class="feather icon-chevron-down"></i>
                                                                </a>
                                                            </h5>
                                                        </div>
                                                        <div id="collapse-1" class="collapse " data-parent="#accordion" aria-labelledby="heading-1">
                                                            <div class="card-body mt-3">
                                                                <div id="accordion-1">
                                                                    
                                                                    <!-- Category -->
                                                                    <div class="card mb-3" v-for="(category,index) in category" :key="index">
                                                                        <div class="card-header" id="heading-1-1">
                                                                            <h5 class="mb-0">
                                                                                <a class="collapsed" role="button" data-toggle="collapse" :href="`#category${category.id}`" aria-expanded="false" aria-controls="collapse-1-1">

                                                                                    <span class="mr-2" @click="go_to_category(category.id,category.title.en)">
                                                                                    {{category.title.en}}
                                                                                    </span>
                                                                                    <i class="feather icon-chevron-down"></i>
                                                                                </a>
                                                                            </h5>
                                                                        </div>

                                                                        <!-- Sub Category -->
                                                                        <div :id="`category${category.id}`" class="collapse" data-parent="#accordion-1" aria-labelledby="heading-1-1">
                                                                            <div class="card-body">
                                                                                <div id="accordion-1-1">
                                                                                    <div class="card mb-3" v-for="(subcategory,id) in category.subcategory" :key="id">
                                                                                        <div class="card-header" id="heading-1-1-1">
                                                                                            <h5 class="mb-0">
                                                                                                
                                                                                                <a class="collapsed" role="button" data-toggle="collapse" :href="`#sub${subcategory.id}`" aria-expanded="false" aria-controls="collapse-1-1-1">
                                                                                                <span class="mr-2" @click="go_to_sub_category(subcategory.id,subcategory.title)">
                                                                                                {{subcategory.title}}
                                                                                                </span>
                                                                                                <i class="feather icon-chevron-down"></i>
                                                                                                </a>
                                                                                            </h5>
                                                                                        </div>

                                                                                        <!-- Child Category -->
                                                                                        <div :id="`sub${subcategory.id}`" class="collapse" data-parent="#accordion-1-1" aria-labelledby="heading-1-1-1">
                                                                                            <div class="card-body" v-for="(childcategory,child_id) in subcategory.childcategory" :key="child_id">

                                                                                                <span @click="go_to_child_category(childcategory.id,childcategory.title)">
                                                                                                {{childcategory.title}}
                                                                                                </span>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            
                                            <!-- Wishlist -->
                                            <li class="nav-item" v-if="loginStatus">
                                                <router-link class="nav-link cart-icon" to="/wishlist">
                                                    <div class="nav-icon">
                                                        <i class="feather icon-heart"></i>
                                                    </div>
                                                    <span>{{ translate('frontstaticword.Wishlist')}}</span>
                                                </router-link>
                                            </li>

                                            <!-- Donation Link -->
                                            <li class="nav-item" v-if="settings.donation_enable=='1'">
                                                <a :href="settings.donation_link!=null ? settings.donation_link : ''">
                                                    <div class="nav-icon">
                                                        <i class="feather icon-thumbs-up mr-2"></i>
                                                    </div>
                                                    {{ translate('frontstaticword.Donation')}}
                                                </a>
                                            </li>

                                            <!-- Notification -->
                                            <li class="nav-item" v-if="loginStatus">
                                                <a class="nav-link cart-icon" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <div class="nav-icon">
                                                        <i class="feather icon-bell"></i>
                                                    </div>
                                                    <span>{{ translate('frontstaticword.Notifications')}}</span>
                                                </a>

                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <div id="notificationTitle">
                                                        {{ translate('frontstaticword.Notifications')}}
                                                    </div>
                                                    <div d="notificationsBody" class="notifications">
                                                        
                                                        <ul>
                                                            <li class="dropdown-item" v-for="(notification,index) in notifications" :key="index"> 
                                                            <a @click="readNotification(notification.id)">
                                                                <div class="notification-image mr-2">
                                                                    <img :src="`${path}/images/course/${notification.data.image}`" alt="course">
                                                                </div>
                                                                <div class="notification-data text-truncate">
                                                                    {{ translate('frontstaticword.In')}} {{notification.data.id}}
                                                                    <br>
                                                                    {{notification.data.data}}
                                                                </div>
                                                            </a>
                                                            </li>
                                                        </ul>
                                                        <div id="notificationFooter">
                                                            <button type="button" class="btn btn-info" @click="readAllNotification">
                                                                {{ translate('frontstaticword.MarkAllRead')}}
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            
                                            <!-- Logout -->
                                            <li class="nav-item" v-if="loginStatus">
                                                <a class="nav-link cart-icon" @click="logout">
                                                    <div class="nav-icon">
                                                        <i class="feather icon-power mr-2"></i>
                                                    </div>
                                                    <span>{{ translate('frontstaticword.Logout')}}</span>
                                                </a>
                                            </li>

                                            <!-- Login -->
                                            <li class="nav-item" v-if="!loginStatus">
                                                <router-link class="btn my-3 my-lg-0 mr-lg-1" to="/signIn">
                                                    <div class="nav-icon">
                                                        <i class="feather icon-log-in"></i>
                                                    </div>
                                                    <span>{{ translate('frontstaticword.Login')}}</span>
                                                </router-link>
                                            </li>
                                            <!-- Register -->
                                            <li class="nav-item" v-if="!loginStatus">
                                                <router-link class="btn" to="/signUp">
                                                    <div class="nav-icon">
                                                        <i class="feather icon-user-plus"></i>
                                                    </div> 
                                                    <span>{{ translate('frontstaticword.SignUp')}}</span>
                                                </router-link>
                                            </li>
                                        </ul>
                                    </div>
                                </template>
                            </b-sidebar>
                        </div>
                        <div class="col-6 text-center">
                            <!-- Logo -->
                            <router-link to="/" class="navbar-brand">
                                <img :src="settings.logo != null ? `${path}/images/logo/${settings.logo}` : `${baseurl}/modules/blizzard/images/background.jpg`" alt="logo" width="125px" height="40px">
                            </router-link>
                        </div>

                        <div class="col-3">

                            <!-- Search -->
                            <div class="nav-item text-center search">
                                <div class="search" id="search-one">
                                    <form id="searchform" @submit.prevent="sendToSearch">
                                        <div class="search-input-wrap">
                                            <input class="search-input" name="searchTerm" v-model="searchTerm" :placeholder="translate('frontstaticword.SearchinSite')" type="text" id="s"/>
                                        </div>
                                        <input class="search-submit" type="submit" id="go" value="">
                                        <div class="search-icon">
                                            <i class="feather icon-search"></i>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Cart -->
                            <div class="nav-item cart-outer-icon" v-if="loginStatus">
                                <router-link class="nav-link cart-icon" to="/cart">
                                    <div class="nav-icon">
                                        <i class="feather icon-shopping-cart"></i>
                                        <span class="red-menu-badge red-bg-success">{{cartTotal}}</span>
                                    </div>
                                </router-link>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </header>
        <!-- header section end -->
    </div>
</template>

<script>
    "use Strict";
    
    import mixin from '../mixin.js';
    import EventBus from '../EventBus.js';

    export default {

        name: 'headerSection',

        mixins: [mixin],

        data() {
            return {
                baseurl : baseurl,
                path: null,
                category: [],
                categoryLength: 0,
                tokendata: '',
                notifications: [],
                cartTotal: 0,
                searchTerm: '',
                totalNotifications: 0,
                wishlistTotal: 0,
                widgets: {}
            }
        },

        methods: {
            
            // To run the menu bar for header in mobile vue
            menumaker(){
                (function($) {

                $.fn.menumaker = function(options) {
                        
                        var cssmenu = $(this), settings = $.extend({
                        title: "Menu",
                        format: "dropdown",
                        breakpoint: 768,
                        sticky: false
                        }, options);

                        return this.each(function() {
                        cssmenu.find('li ul').parent().addClass('has-sub');
                        if (settings.format != 'select') {
                            cssmenu.prepend('<div id="menu-button">' + settings.title + '</div>');
                            $(this).find("#menu-button").on('click', function(){
                            $(this).toggleClass('menu-opened');
                            var mainmenu = $(this).next('ul');
                            if (mainmenu.hasClass('open')) { 
                            mainmenu.hide().removeClass('open');
                            }
                            else {
                            mainmenu.show().addClass('open');
                            if (settings.format === "dropdown") {
                                mainmenu.find('ul').show();
                            }
                            }
                            });

                            multiTg = function() {
                            cssmenu.find(".has-sub").prepend('<span class="submenu-button"></span>');
                            cssmenu.find('.submenu-button').on('click', function() {
                            $(this).toggleClass('submenu-opened');
                            if ($(this).siblings('ul').hasClass('open')) {
                                $(this).siblings('ul').removeClass('open').hide();
                            }
                            else {
                                $(this).siblings('ul').addClass('open').show();
                            }
                            });
                            };

                            if (settings.format === 'multitoggle') multiTg();
                            else cssmenu.addClass('dropdown');
                        }

                        else if (settings.format === 'select')
                        {
                            cssmenu.append('<select style="width: 100%"/>').addClass('select-list');
                            var selectList = cssmenu.find('select');
                            selectList.append('<option>' + settings.title + '</option>', {
                                                                            "selected": "selected",
                                                                            "value": ""});
                            cssmenu.find('a').each(function() {
                            var element = $(this), indentation = "";
                            for (i = 1; i < element.parents('ul').length; i++)
                            {
                            indentation += '-';
                            }
                            selectList.append('<option value="' + $(this).attr('href') + '">' + indentation + element.text() + '</option');
                            });
                            selectList.on('change', function() {
                            window.location = $(this).find("option:selected").val();
                            });
                        }

                        if (settings.sticky === true) cssmenu.css('position', 'fixed');

                        resizeFix = function() {
                            if ($(window).width() > settings.breakpoint) {
                            cssmenu.find('ul').show();
                            cssmenu.removeClass('small-screen');
                            if (settings.format === 'select') {
                            cssmenu.find('select').hide();
                            }
                            else {
                            cssmenu.find("#menu-button").removeClass("menu-opened");
                            }
                            }

                            if ($(window).width() <= settings.breakpoint && !cssmenu.hasClass("small-screen")) {
                            cssmenu.find('ul').hide().removeClass('open');
                            cssmenu.addClass('small-screen');
                            if (settings.format === 'select') {
                            cssmenu.find('select').show();
                            }
                            }
                        };
                        resizeFix();
                        return $(window).on('resize', resizeFix);

                        });
                };
                })(jQuery);
            },

            // Toggle search icon and let it work
            searchScript() {
                this.$nextTick(()=> {
                var $search = $( '#search' ),
                $searchinput = $search.find('input.search-input'),
                $body = $('html,body'),
                openSearch = function() {
                    $search.data('open',true).addClass('search-open');
                    $searchinput.focus();
                    return false;
                },
                closeSearch = function() {
                    $search.data('open',false).removeClass('search-open');
                };
                $searchinput.on('click',function(e) { e.stopPropagation(); $search.data('open',true); });
                $search.on('click',function(e) {
                    e.stopPropagation();
                    if( !$search.data('open') ) {
                        openSearch();
                        $body.off( 'click' ).on( 'click', function(e) {
                            closeSearch();
                        } );
                    }
                    else {
                        if( $searchinput.val() === '' ) {
                            closeSearch();
                            return false;
                        }
                    }
                });
                });
            },

            // Toggle search icon responsive
            searchScriptResponsive() {
                this.$nextTick(()=> {
                var $search = $( '#search-one' ),
                $searchinput = $search.find('input.search-input'),
                $body = $('html,body'),
                openSearch = function() {
                    $search.data('open',true).addClass('search-open');
                    $searchinput.focus();
                    return false;
                },
                closeSearch = function() {
                    $search.data('open',false).removeClass('search-open');
                };
                $searchinput.on('click',function(e) { e.stopPropagation(); $search.data('open',true); });
                $search.on('click',function(e) {
                    e.stopPropagation();
                    if( !$search.data('open') ) {
                        openSearch();
                        $body.off( 'click' ).on( 'click', function(e) {
                            closeSearch();
                        } );
                    }
                    else {
                        if( $searchinput.val() === '' ) {
                            closeSearch();
                            return false;
                        }
                    }
                });
                });
            },


            // Call an homepage API
            async callAPI() 
            {
                this.searchScript();
                this.searchScriptResponsive();
                this.getWidgetData();
                this.getWishlist();
                this.notification();
                this.getCart();
                await axios.get('/api/home?secret=' + this.$secretKey).then(res => {

                    this.category = res.data.allcategory;
                    this.categoryLength = res.data.allcategory.length;

                });
            },

            // Logout function
            logout() {

                localStorage.removeItem('access_token');

                if (this.$router.currentRoute.path == '/') {
                    location.reload();
                } else {
                    this.$router.push('/');
                }

                axios.post('/api/logout?secret=' + this.$secretKey, {
                    //data
                }, {
                    headers: {
                        'Authorization': `Bearer ${this.token}`
                    }
                });

            },

            // Call an API to display all the notification
            notification() 
            {
                if (this.loginStatus == true) 
                {
                    let config = {
                        params: {
                            secret: this.$secretKey
                        },
                        headers: {
                            'Authorization': `Bearer ${this.token}`
                        }
                    }

                    axios.get('/api/notifications', config)
                        .then(res => {

                            this.notifications = res.data.notifications;
                            if (this.notifications.length > 0) {
                                this.totalNotifications = this.notifications.length;
                            }

                        })
                        .catch(err => {

                            if (err.response.status === 401) {
                                console.log(err.response);
                            }

                        });
                }
            },

            // Call read (single) notification API
            async readNotification(id) {
                let apiData = {
                    headers: {
                        'Authorization': `Bearer ${this.token}`
                    }
                }

                await axios.get(`/api/readnotification/${id}?secret=${this.$secretKey}`, apiData)
                    .then(res => {

                        if (res.status == 200) {
                            let config = {
                                text: 'Notification marked as read',
                                button: 'CLOSE'
                            }
                            this.$snack['success'](config);
                            this.notification();
                        }

                    }).catch(err => {

                        console.log(err.response);

                    });

            },

            // Call Read all notification API
            async readAllNotification() {
                await axios.post(`/api/readall/notification?secret=${this.$secretKey}`, {
                        //data
                    }, {
                        headers: {
                            'Authorization': `Bearer ${this.token}`
                        }
                    })
                    .then(res => {

                        if (res.status == 200) {
                            let config = {
                                text: 'All notification are mark read',
                                button: 'CLOSE'
                            }
                            this.$snack['success'](config);
                            this.notification();
                        }

                    })
                    .catch(err => {

                        console.log(err.response);

                    });

            },

            // Call cart API fro cart totals
            getCart() {
                if (this.loginStatus == true) {
                    
                    axios.post(`/api/show/cart?secret=${this.$secretKey}`, {
                            //data
                        }, {
                            headers: {
                                'Authorization': `Bearer ${this.token}`
                            }
                        })
                        .then(res => {

                            this.cartTotal = res.data.cart.length;

                        })
                        .catch(err => {
                            console.log(err.response);
                        });
                }
            },

            // Fetch user wishlist courses
            async getWishlist() {

                if(this.loginStatus == true)
                {
                    await axios.post('/api/show/wishlist?secret=' + this.$secretKey, {
                        //data
                    }, 
                    {
                        headers: {
                            'Authorization': `Bearer ${this.token}`
                        }
                    }).then(res => {

                        this.wishlistTotal = res.data.wishlist.length;
                    });
                }
                else
                { this.loading = false; }
            },

            // On click push to search
            sendToSearch() {

                EventBus.$emit('header_search', this.searchTerm);
                if (this.searchTerm != '') {
                    if (window.location.href == `${baseurl}/search`) {
                        const url = new URL(window.location.href);
                        url.searchParams.set('searchTerm', this.searchTerm);
                        window.history.pushState({}, '', url);
                    }
                    this.$router.push(`/search?searchTerm=${this.searchTerm}`);
                } else {
                    let config = {
                        text: 'Please enter something',
                        button: 'CLOSE'
                    }
                    this.$snack['danger'](config);
                }
            },

            // When click on category send to data
            go_to_category(id,title) 
            {
                var pathname = window.location.pathname.split( '/' );
                
                var one;
                pathname.forEach(findPath=> {
                    if(findPath == 'category_detail')
                    {
                        one = 'category_detail';
                        return false;
                    }
                })
                
                var category_type = 'category';
                
                if(one == `category_detail`)
                {
                    EventBus.$emit('category',category_type,id,title);
                    this.$router.push(`/category_detail/category/${id}/${title.replace(/\s+/g, '_')}`);
                }
                else
                {
                    this.$router.push(`/category_detail/category/${id}/${title.replace(/\s+/g, '_')}`);
                }
            },

            // When click on sub category send data
            go_to_sub_category(id,title)
            {
                var pathname = window.location.pathname.split( '/' );
                var one;
                pathname.forEach(findPath=> {
                    if(findPath == 'category_detail')
                    {
                        one = 'category_detail';
                        return false;
                    }
                })

                var category_type = 'sub_category';
                
                if(one == `category_detail`)
                {
                    EventBus.$emit('category',category_type,id,title);
                    this.$router.push(`/category_detail/sub_category/${id}/${title.replace(/\s+/g, '_')}`);
                }
                else
                {
                    this.$router.push(`/category_detail/sub_category/${id}/${title.replace(/\s+/g, '_')}`);
                }
            },

            // When click on child category send data
            go_to_child_category(id,title)
            {
                var pathname = window.location.pathname.split( '/' );
                
                var one;
                pathname.forEach(findPath=> {
                    if(findPath == 'category_detail')
                    {
                        one = 'category_detail';
                        return false;
                    }
                })
                
                var category_type = 'child_category';
                
                if(one == `category_detail`)
                {
                    EventBus.$emit('category',category_type,id,title);
                    this.$router.push(`/category_detail/child_category/${id}/${title.replace(/\s+/g, '_')}`);
                }
                else
                {
                    this.$router.push(`/category_detail/child_category/${id}/${title.replace(/\s+/g, '_')}`);
                }
            },

            // Get widget details
            async getWidgetData() {
                await axios.get(`/api/footer/widget?secret=${this.$secretKey}`)
                    .then(res => {

                        this.widgets = res.data.widget;

                    })
                    .catch(err => {
                        console.log(err.response);
                    });
            }

        },

        mounted() {

            this.path = axios.defaults.baseURL;
            this.callAPI();

        }

    }
</script>