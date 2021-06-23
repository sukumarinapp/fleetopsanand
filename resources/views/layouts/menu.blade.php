<li class="nav-item menu-open">
  <a href="{{ route('home') }}" class="nav-link {{ (request()->is('home')) ? 'active' : '' }}">
      <i class="nav-icon fas fa-home"></i>
      <p>
        Dashboard
      </p>
  </a>
</li>
@if(Auth::user()->usertype == "Admin")
<li class="nav-item {{ (request()->is('parameter') || request()->is('rhplatform')) ? 'menu-open' : '' }}">
  <a href="#" class="nav-link">
    <i class="nav-icon fas fa-cog"></i>
    <p>
      Parameter Settings
      <i class="right fas fa-angle-left"></i>
    </p>
  </a>
  @if(Auth::user()->usertype == "Admin" || Auth::user()->BPI == true)
  <ul class="nav nav-treeview">
    <li class="nav-item">
      <a href="{{ route('parameter') }}" class="nav-link {{ (request()->is('parameter')) ? 'active' : '' }}">
        <i class="nav-icon fas fa-cog"></i>
        <p>General Settings</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{ route('rhplatform.index') }}" class="nav-link {{ (request()->is('rhplatform')) ? 'active' : '' }}">
        <i class="nav-icon fas fa-cog"></i>
        <p>RH Platform Settings</p>
      </a>
    </li>
  </ul>
  @endif
</li>
@endif
@if(Auth::user()->usertype == "Admin")
<li class="nav-item menu-open">
  <a href="{{ route('sms') }}" class="nav-link {{ (request()->segment(1) =='sms' ) ? 'active' : '' }}">
      <i class="nav-icon fas fa-bell"></i>
      <p>
        Notification Setup
      </p>
  </a>
</li>
@endif
@if(Auth::user()->usertype != "Client")
<li class="nav-item {{ (request()->segment(1) == 'manager' || request()->segment(1) == 'client' || request()->segment(1) == 'vehicle' || request()->segment(1) == 'fdriver' || request()->segment(1) == 'assignvehicle' || request()->segment(1) == 'removevehicle') ? 'menu-open' : '' }}">
  <a href="#" class="nav-link">
    <i class="nav-icon fas fa-user"></i>
    <p>
      Manage Account
      <i class="right fas fa-angle-left"></i>
    </p>
  </a>
  <ul class="nav nav-treeview">
     @if(Auth::user()->usertype == "Admin" || Auth::user()->BPA == true || Auth::user()->BPD == true)
    <li class="nav-item">
      <a href="{{ route('manager.index') }}" class="nav-link {{ (request()->segment(1) == 'manager') ? 'active' : '' }}">
        <i class="nav-icon fas fa-user"></i>
        <p>User Account</p>
      </a>
    </li>
    @endif
    @if(Auth::user()->usertype == "Admin" || Auth::user()->BPB == true || Auth::user()->BPE == true)
    <li class="nav-item">
      <a href="{{ route('client.index') }}" class="nav-link {{ (request()->segment(1) == 'client') ? 'active' : '' }}">
        <i class="nav-icon fas fa-user"></i>
        <p>Client Account</p>
      </a>
    </li>
    @endif
    @if(Auth::user()->usertype == "Admin" || Auth::user()->BPC == true || Auth::user()->BPF == true)
    <li class="nav-item">
      <a href="{{ route('vehicle.index') }}" class="nav-link {{ (request()->segment(1) == 'vehicle' || request()->segment(1) == 'assignvehicle' || request()->segment(1) == 'removevehicle') ? 'active' : '' }}">
        <i class="nav-icon fas fa-car"></i>
        <p>Manage Vehicle</p>
      </a>
    </li>
    @endif
    @if(Auth::user()->usertype == "Admin" || Auth::user()->BPF == true)
    <li class="nav-item">
      <a href="{{ route('fdriver.index') }}" class="nav-link {{ (request()->segment(1) == 'fdriver') ? 'active' : '' }}">
        <i class="nav-icon fas fa-id-card"></i>
        <p>Manage Driver</p>
      </a>
    </li>
    @endif
  </ul>
</li>
@endif
<li class="nav-item menu-open">
  <a href="{{ route('workflow') }}" class="nav-link {{ (request()->segment(1) == 'workflow' || request()->segment(1) == 'workflow1') ? 'active' : '' }}">
      <i class="nav-icon fas fa-tasks"></i>
      <p>
        Workflow Manager
      </p>
  </a>
</li>
<li class="nav-item menu-open">
  <a href="{{ route('auditing') }}" class="nav-link {{ (request()->segment(1) == 'auditing' || request()->segment(1) == 'auditing1') ? 'active' : '' }}">
      <i class="nav-icon fas fa-history"></i>
      <p>
        Sales Auditing
      </p>
  </a>
</li>