<!-- Nav items -->
<ul class="navbar-nav">
  <li class="nav-item">
    <a class="nav-link {{ Request::is('admin/dashboard*') ? 'active' : '' }}" href="{{ route('admin.dashboard.index') }}">
     <i class="fi fi-rs-dashboard"></i>
      <span class="nav-link-text">{{ __('Dashboard') }}</span>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ Request::is('admin/order*') ? 'active' : '' }}" href="{{ route('admin.order.index') }}">
     <i class="fi  fi-rs-boxes"></i>
      <span class="nav-link-text">{{ __('Orders') }}</span>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ Request::is('admin/plan*') ? 'active' : '' }}" href="{{ route('admin.plan.index') }}">
     <i class="fi  fi-rs-light-switch"></i>
      <span class="nav-link-text">{{ __('Subscriptions') }}</span>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ Request::is('admin/customer*') ? 'active' : '' }}" href="{{ route('admin.customer.index') }}">
     <i class="fi fi-rs-users-alt"></i>
      <span class="nav-link-text">{{ __('Customers') }}</span>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ Request::is('admin/gateways*') ? 'active' : '' }}" href="{{ route('admin.gateways.index') }}">
     <i class="fi fi-rs-bank"></i>
      <span class="nav-link-text">{{ __('Payment Gateways') }}</span>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ Request::is('admin/cron-job*') ? 'active' : '' }}" href="{{ route('admin.cron-job.index') }}">
     <i class="fi fi-rs-calendar-clock"></i>
      <span class="nav-link-text">{{ __('Cron Jobs') }}</span>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ Request::is('admin/support*') ? 'active' : '' }}" href="{{ route('admin.support.index') }}">
     <i class="fi  fi-rs-headset"></i>
      <span class="nav-link-text">{{ __('Help & Supports') }}</span>
    </a>
  </li>
</ul>

<!-- Heading -->
<h6 class="navbar-heading p-0 text-muted mt-4">{{ __('User Logs') }}</h6>
<!-- Navigation -->
<ul class="navbar-nav">
  <li class="nav-item">
    <a class="nav-link {{ Request::is('admin/devices*') ? 'active' : '' }}" href="{{ route('admin.devices.index') }}">
      <i class="fi fi-rs-devices"></i>
      <span class="nav-link-text">{{ __('Devices') }}</span>
    </a>
  </li>
  <li class="nav-item">
     <a class="nav-link {{ Request::is('admin/apps*') ? 'active' : '' }}" href="{{ route('admin.apps.index') }}">
      <i class="fi fi-rs-apps"></i>
      <span class="nav-link-text">{{ __('Apps') }}</span>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ Request::is('admin/contacts*') ? 'active' : '' }}" href="{{ route('admin.contacts.index') }}">
      <i class="fi  fi-rs-address-book"></i>
      <span class="nav-link-text">{{ __('Contacts') }}</span>
    </a>
  </li>
  <li class="nav-item">
   <a class="nav-link {{ Request::is('admin/template*') ? 'active' : '' }}" href="{{ route('admin.template.index') }}">
      <i class="fi  fi-rs-template-alt"></i>
      <span class="nav-link-text">{{ __('Templates') }}</span>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ Request::is('admin/schedules*') ? 'active' : '' }}" href="{{ route('admin.schedules.index') }}">
      <i class="ni ni-calendar-grid-58"></i>
      <span class="nav-link-text">{{ __('Schedules') }}</span>
    </a>
  </li>

  <li class="nav-item">
     <a class="nav-link {{ Request::is('admin/message-transactions*') ? 'active' : '' }}" href="{{ route('admin.message-transactions.index') }}">
      <i class="fi  fi-rs-comments"></i>
      <span class="nav-link-text">{{ __('Messages') }}</span>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ Request::is('admin/notification*') ? 'active' : '' }}" href="{{ route('admin.notification.index') }}">
     <i class="fi fi-rs-envelope-bulk"></i>
      <span class="nav-link-text">{{ __('Notifications') }}</span>
    </a>
  </li>  
</ul>
<!-- Heading -->
<h6 class="navbar-heading p-0 text-muted mt-4">{{ __('Appearance') }}</h6>
<!-- Navigation -->
<ul class="navbar-nav">
  <li class="nav-item">
    <a class="nav-link {{ Request::is('admin/blog*') || Request::is('admin/category*') || Request::is('admin/tag*') ? 'active' : '' }}" href="#navbar-forms" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-forms">
      <i class="fi  fi-rs-blog-text"></i>
      <span class="nav-link-text">{{ __('Blogs') }}</span>
    </a>
    <div class="collapse" id="navbar-forms">
      <ul class="nav nav-sm flex-column">
        <li class="nav-item">
          <a href="{{ route('admin.blog.index') }}" class="nav-link">{{ __('Blogs') }}</a>
        </li>
        <li class="nav-item">
          <a href="{{ route('admin.category.index') }}" class="nav-link">{{ __('Category') }}</a>
        </li>
        <li class="nav-item">
          <a href="{{ route('admin.tag.index') }}" class="nav-link">{{ __('Tags') }}</a>
        </li>

      </ul>
    </div>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ Request::is('admin/faq*') ? 'active' : '' }}" href="{{ route('admin.faq.index') }}">
      <i class="fi  fi-rs-comments-question-check"></i>
      <span class="nav-link-text">{{ __('Faq') }}</span>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ Request::is('admin/features*') ? 'active' : '' }}" href="{{ route('admin.features.index') }}">
      <i class="fi fi-rs-dice-alt"></i>
      <span class="nav-link-text">{{ __('Features') }}</span>
    </a>
  </li>
   <li class="nav-item">
    <a class="nav-link {{ Request::is('admin/testimonials*') ? 'active' : '' }}" href="{{ route('admin.testimonials.index') }}">
      <i class="fi  fi-rs-comment-quote"></i>
      <span class="nav-link-text">{{ __('Testimonials') }}</span>
    </a>
  </li>
   <li class="nav-item">
    <a class="nav-link {{ Request::is('admin/team*') ? 'active' : '' }}" href="{{ route('admin.team.index') }}">
      <i class="fi fi-rs-users-alt"></i>
      <span class="nav-link-text">{{ __('Team') }}</span>
    </a>
  </li>
   <li class="nav-item">
    <a class="nav-link {{ Request::is('admin/about*') ? 'active' : '' }}" href="{{ route('admin.about.index') }}">
      <i class="fi fi-rs-comment-question"></i>
      <span class="nav-link-text">{{ __('About Us') }}</span>
    </a>
  </li>
   <li class="nav-item">
    <a class="nav-link {{ Request::is('admin/partner*') ? 'active' : '' }}" href="{{ route('admin.partner.index') }}">
      <i class="fi  fi-rs-animated-icon"></i>
      <span class="nav-link-text">{{ __('Partners') }}</span>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ Request::is('admin/language*') ? 'active' : '' }}" href="{{ route('admin.language.index') }}">
      <i class="fi fi-rs-globe"></i>
      <span class="nav-link-text">{{ __('Language') }}</span>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ Request::is('admin/menu*') ? 'active' : '' }}" href="{{ route('admin.menu.index') }}">
      <i class="fi fi-rs-chart-tree"></i>
      <span class="nav-link-text">{{ __('Menu') }}</span>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ Request::is('admin/page*') ? 'active' : '' }}" href="{{ route('admin.page.index') }}">
      <i class="fi fi-rs-desktop-wallpaper"></i>
      <span class="nav-link-text">{{ __('Custom Pages') }}</span>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ Request::is('admin/seo*') ? 'active' : '' }}" href="{{ route('admin.seo.index') }}">
      <i class="fi fi-rs-chart-line-up"></i>
      <span class="nav-link-text">{{ __('Seo Settings') }}</span>
    </a>
  </li>
</ul>


<h6 class="navbar-heading p-0 text-muted mt-4">{{ __('Site Settings') }}</h6>
<ul class="navbar-nav mb-md-3">

   <li class="nav-item">
    <a class="nav-link" href="{{ route('admin.page-settings.index') }}">
      <i class="fi fi-rs-magic-wand"></i>
      <span class="nav-link-text">{{ __('Page Settings') }}</span>
    </a>
  </li>
  
  <li class="nav-item">
    <a class="nav-link {{ Request::is('admin/admin*') || Request::is('admin/role*') ? 'active' : '' }}" href="#admin-roles" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-forms">
      <i class="fi  fi-rs-shield-check"></i>
      <span class="nav-link-text">{{ __('Admin and Role') }}</span>
    </a>
    <div class="collapse" id="admin-roles">
      <ul class="nav nav-sm flex-column">
        <li class="nav-item">
          <a href="{{ route('admin.admin.index') }}" class="nav-link">{{ __('Admin') }}</a>
        </li>
        <li class="nav-item">
          <a href="{{ route('admin.role.index') }}" class="nav-link">{{ __('Roles') }}</a>
        </li>
      </ul>
    </div>
  </li>
 
  
   <li class="nav-item">
    <a class="nav-link {{  Request::is('admin/developer-settings*') ? 'active' : '' }}" href="#dev-settings" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-forms">
      <i class="fi  fi-rs-settings"></i>
      <span class="nav-link-text">{{ __('Developer Settings') }}</span>
    </a>
    <div class="collapse" id="dev-settings">
      <ul class="nav nav-sm flex-column">
        
        <li class="nav-item">
          <a href="{{ route('admin.developer-settings.show','app-settings') }}" class="nav-link">{{ __('App Settings') }}</a>
        </li>
        
        <li class="nav-item">
          <a href="{{ route('admin.developer-settings.show','mail-settings') }}" class="nav-link">{{ __('SMTP Settings') }}</a>
        </li>

        <li class="nav-item">
          <a href="{{ route('admin.developer-settings.show','wa-settings') }}" class="nav-link">{{ __('Whatsapp Server') }}</a>
        </li>
        
        <li class="nav-item">
          <a href="{{ route('admin.developer-settings.show','storage-settings') }}" class="nav-link">{{ __('Storage Settings') }}</a>
        </li>
       
      </ul>
    </div>
  </li>  
</ul>

<h6 class="navbar-heading p-0 text-muted mt-2">{{ __('My Settings') }}</h6>
<!-- Navigation -->
<ul class="navbar-nav mb-md-3">
  <li class="nav-item">
    <a class="nav-link {{ Request::is('admin/profile') ? 'active' : '' }}" href="{{ url('/admin/profile') }}">
      <i class="fi fi fi-rs-comment-user"></i>
      <span class="nav-link-text">{{ __('Profile Settings') }}</span>
    </a>
  </li>
 
  <li class="nav-item">
    <a class="nav-link logout-button" href="#" >
      <i class="ni ni-button-power"></i>
      <span class="nav-link-text">{{ __('Logout') }}</span>
    </a>
  </li>
</ul>
