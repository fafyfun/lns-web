
<header class="main-header">
        <!-- Logo -->
        <a href="../../index2.html" class="logo" style="pointer-events: none;">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini">{{ config('app.name', 'Laravel') }}</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg">{{ config('app.name', 'Laravel') }}</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              
              <!-- Notifications: style can be found in dropdown.less -->
              
              <!-- Tasks: style can be found in dropdown.less -->
              
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <!-- <img src="<?php //echo BASE_URL; ?>/dist/img/user2-160x160.jpg" class="user-image" alt="User Image"> -->
                  <span>Welcome {{ Auth::user()->name }}</span>
                </a>

                  <ul class="dropdown-menu">

                      <li class="user-footer">
                          <div class="pull-left">
                              <a href="{{ url('/changepassword') }}" class="btn btn-default btn-flat">Change Password</a>
                          </div>
                          <div class="pull-right">

                              <a href="{{ url('/logout') }}"  onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();" class="btn btn-default btn-flat">Sign out</a>
                              <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                  {{ csrf_field() }}
                              </form>

                          </div>
                      </li>
                      </ul>

              </li>



            </ul>
          </div>
        </nav>
      </header>