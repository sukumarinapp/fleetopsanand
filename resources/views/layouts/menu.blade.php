<li class="nav-item menu-open">
  <a href="{{ route('home') }}" class="nav-link {{ (request()->is('home')) ? 'active' : '' }}">
      <i class="nav-icon fas fa-map-marker"></i>
      <p>
        Dashboard
      </p>
  </a>
</li>
 <!-- <li class="nav-item menu-close">
  <a href="#" class="nav-link">
    <i class="nav-icon fas fa-folder"></i>
    <p>
      Manager
      <i class="right fas fa-angle-left"></i>
    </p>
  </a>
  <ul class="nav nav-treeview">
    <li class="nav-item">
      <a href="http://localhost:8000/manager" class="nav-link active">
        <i class="nav-icon fas fa-folder"></i>
        <p>Client A</p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="#" class="nav-link active">
            <i class="nav-icon fas fa-car"></i>
            <p>Car A</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link ">
            <i class="nav-icon fas fa-car"></i>
            <p>Car B</p>
          </a>
        </li>
      </ul>
    </li>
    <li class="nav-item">
      <a href="http://localhost:8000/client" class="nav-link ">
        <i class="nav-icon fas fa-folder"></i>
        <p>Client B</p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="#" class="nav-link active">
            <i class="nav-icon fas fa-car"></i>
            <p>Car C</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link ">
            <i class="nav-icon fas fa-car"></i>
            <p>Car D</p>
          </a>
        </li>
      </ul>
    </li>
  </ul>
</li>  -->
@if(Auth::user()->usertype == "Admin")
<li class="nav-item {{ (request()->is('parameter') || request()->is('rhplatform') || request()->is('sms')) ? 'menu-open' : '' }}">
  <a href="#" class="nav-link">
    <i class="nav-icon fas fa-cog"></i>
    <p>
      Settings
      <i class="right fas fa-angle-left"></i>
    </p>
  </a>
  @if(Auth::user()->usertype == "Admin" || Auth::user()->BPI == true)
  <ul class="nav nav-treeview">
    <li class="nav-item">
      <a href="{{ route('parameter') }}" class="nav-link {{ (request()->is('parameter')) ? 'active' : '' }}">
        <i class="nav-icon fas fa-cog"></i>
        <p>Parameter Settings</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{ route('rhplatform.index') }}" class="nav-link {{ (request()->is('rhplatform')) ? 'active' : '' }}">
        <i class="nav-icon fas fa-cog"></i>
        <p>RH Platform Settings</p>
      </a>
    </li>
    <li class="nav-item menu-open">
  <a href="{{ route('sms') }}" class="nav-link {{ (request()->segment(1) =='sms' ) ? 'active' : '' }}">
      <i class="nav-icon fas fa-bell"></i>
      <p>
        Notification Setup
      </p>
  </a>
</li>
  </ul>
  @endif
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
  <a href="{{ route('workflow') }}" class="nav-link {{ (request()->segment(1) == 'workflow' || request()->segment(1) == 'override' || request()->segment(1) == 'auditing') ? 'active' : '' }}">
      <i class="nav-icon fas fa-tasks"></i>
      <p>
        Workflow
      </p>
  </a>
</li>
<li class="nav-item {{ (request()->is('workflowlog') || request()->is('vehiclelog') || request()->is('sales')) ? 'menu-open' : '' }}">
  <a href="#" class="nav-link">
    <i class="nav-icon fas fa-file"></i>
    <p>
      Reports
      <i class="right fas fa-angle-left"></i>
    </p>
  </a>
  <ul class="nav nav-treeview">
    <li class="nav-item">
      <a href="{{ route('workflowlog') }}" class="nav-link {{ (request()->is('workflowlog')) ? 'active' : '' }}">
        <i class="nav-icon fas fa-file"></i>
        <p>Workflow Log</p>
      </a>
    </li>
  </ul>
  <ul class="nav nav-treeview">
    <li class="nav-item">
      <a href="{{ route('vehiclelog') }}" class="nav-link {{ (request()->is('vehiclelog')) ? 'active' : '' }}">
        <i class="nav-icon fas fa-file"></i>
        <p>Vehicle Assign Log</p>
      </a>
    </li>
  </ul>
  <ul class="nav nav-treeview">
    <li class="nav-item">
      <a href="{{ route('sales') }}" class="nav-link {{ (request()->is('sales')) ? 'active' : '' }}">
        <i class="nav-icon fas fa-file"></i>
        <p>Sales Ledger (Rental/HP)</p>
      </a>
    </li>
  </ul>
  <ul class="nav nav-treeview">
    <li class="nav-item">
      <a href="{{ route('collection') }}" class="nav-link {{ (request()->is('collection')) ? 'active' : '' }}">
        <i class="nav-icon fas fa-file"></i>
        <p>collection</p>
      </a>
    </li>
  </ul>
</li>
<!-- @if(Auth::user()->usertype == "Admin" || (Auth::user()->RBA4==1 && (Auth::user()->RBA4A==1 || Auth::user()->RBA4B==1 )))
<li class="nav-item menu-open">
  <a href="{{ route('fuelsrch') }}" class="nav-link {{ (request()->segment(1) == 'fuelsrch' || request()->segment(1) == 'fueler') ? 'active' : '' }}">
      <i class="nav-icon fas fa-gas-pump"></i>
      <p>
        Fueler
      </p>
  </a>
</li>
@endif -->