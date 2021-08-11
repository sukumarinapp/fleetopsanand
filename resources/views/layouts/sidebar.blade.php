<aside class="main-sidebar sidebar-light-gray-primary elevation-4">
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false" >
                @include('layouts.menu')
            </ul>
        </nav>
    </div>
</aside>
<nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
    <ul class="navbar-nav">
          <li class="nav nav-tabs">
           <a href="{{ route('home') }}" class="nav-link {{ (request()->is('home')) ? 'active' : '' }}">
      <p><b>
        Dashboard
      </b></p>
  </a>
          </li>
    <div class="container">

     
      <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse order-3" id="navbarCollapse">
       
        <ul class="navbar-nav">
         
        

          @if(Auth::user()->usertype == "Admin")
           <li class="dropdown dropdown-hover nav nav-tabs {{ (request()->is('parameter') || request()->is('rhplatform') || request()->is('sms')) ? 'active' : '' }}">

            <a id="dropdownSubMenu" href="#"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle"><b>Settings</b></a>

            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                 @if(Auth::user()->usertype == "Admin" || Auth::user()->BPI == true)
              <li><a href="{{ route('parameter') }}" class="dropdown-item {{ (request()->is('parameter')) ? 'active' : '' }}" class="dropdown-item"><b>Parameter Settings</b> </a></li>
              <li><a href="{{ route('rhplatform.index') }}" class="dropdown-item {{ (request()->is('rhplatform')) ? 'active' : '' }}" class="dropdown-item"><b>RH Platform Settings</b></a></li>
                @endif
                  @if(Auth::user()->usertype == "Admin")
            <a href="{{ route('sms') }}" class="dropdown-item {{ (request()->segment(1) =='sms' ) ? 'active' : '' }}" class="dropdown-item"><b>Notification Setup</b></a>
          </li>
          @endif
          </ul>
           @endif
     

         @if(Auth::user()->usertype != "Client")
          <li class="dropdown dropdown-hover nav nav-tabs {{ (request()->segment(1) == 'manager' || request()->segment(1) == 'client' || request()->segment(1) == 'vehicle' || request()->segment(1) == 'fdriver' || request()->segment(1) == 'assignvehicle' || request()->segment(1) == 'removevehicle') ? 'active' : '' }}">

            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle"><b> Manage Account</b></a>

            
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                   @if(Auth::user()->usertype == "Admin" || Auth::user()->BPA == true || Auth::user()->BPD == true)
              <li><a href="{{ route('manager.index') }}" class="nav-link {{ (request()->segment(1) == 'manager') ? 'active' : '' }}" class="dropdown-item"><b>User Account</b> </a></li>
              @endif

               @if(Auth::user()->usertype == "Admin" || Auth::user()->BPB == true || Auth::user()->BPE == true)

              <li><a href="{{ route('client.index') }}" class="nav-link {{ (request()->segment(1) == 'client') ? 'active' : '' }}" class="dropdown-item"><b>Client Account</b></a></li>
                @endif

                 @if(Auth::user()->usertype == "Admin" || Auth::user()->BPC == true || Auth::user()->BPF == true)
            <li><a href="{{ route('vehicle.index') }}" class="nav-link {{ (request()->segment(1) == 'vehicle' || request()->segment(1) == 'assignvehicle' || request()->segment(1) == 'removevehicle') ? 'active' : '' }}" class="dropdown-item"><b>Manage Vehicle</b></a></li>
                @endif

                  @if(Auth::user()->usertype == "Admin" || Auth::user()->BPF == true)

              <li><a href="{{ route('fdriver.index') }}" class="nav-link {{ (request()->segment(1) == 'fdriver') ? 'active' : '' }}" class="dropdown-item"><b>Manage Driver</b></a></li>
            </li>
                @endif
          </ul>
           @endif

  

          @if(Auth::user()->usertype == "Admin" || (Auth::user()->BPJ==1 && Auth::user()->BPJ2==1))
       <li class="nav nav-tabs">
       <a href="{{ route('workflow') }}" class="nav-link {{ (request()->segment(1) == 'workflow' || request()->segment(1) == 'override') ? 'active' : '' }}" class="nav-link"><b>Workflow Manager</b></a>
    </li>
     @endif

         @if(Auth::user()->usertype == "Admin" || (Auth::user()->BPJ==1 && Auth::user()->BPJ1==1))
         <li class="nav nav-tabs">
             <a href="{{ route('auditsrch') }}" class="nav-link {{ (request()->segment(1) == 'auditsrch' || request()->segment(1) == 'auditing') ? 'active' : '' }}" class="nav-link"><b>Sales Auditing</b></a>
             </li>
            @endif

            @if(Auth::user()->usertype == "Admin" || (Auth::user()->RBA4==1 && (Auth::user()->RBA4A==1 || Auth::user()->RBA4B==1 )))
             <li class="nav nav-tabs">
             <a href="{{ route('fuelsrch') }}" class="nav-link {{ (request()->segment(1) == 'fuelsrch' || request()->segment(1) == 'fuelsrch') ? 'active' : '' }}" class="nav-link"><b>Fueler</b></a>
            </li>
            @endif

      </ul>
    </div>
  </div>
</ul>
</nav>
