<div id="treeview_container" class="hummingbird-treeview" style="height: 600px;">
<ul style="float: left; " id="treeview" class="hummingbird-base">
  <li data-id="0">
    <i class="fa fa-plus"></i>
    <label>
      <input id="xnode-0" data-id="custom-{{ Auth::user()->id }}" type="checkbox" /> {{ Auth::user()->name }}
    </label>
    <ul>
      <li data-id="1">
        <i class="fa fa-plus"></i>
        <label>
          <input  id="xnode-0-1" data-id="custom-0-1" type="checkbox" /> Manager
        </label>
        <ul>
          <li data-id="2">
            <i class="fa fa-plus"></i>
            <label>
              <input  id="xnode-0-1-2" data-id="custom-0-1-2" type="checkbox" /> Sub Manager
            </label>
            <ul>
              <li data-id="3">
                <i class="fa fa-plus"></i>
                <label>
                  <input  id="xnode-0-1-2-3" data-id="custom-0-1-2-3" type="checkbox" /> Client
                </label>
                <ul>
                  <li>
                    <label>
                      <input class="hummingbird-end-node" id="xnode-0-1-2-3-1" data-id="custom-0-1-2-3-1" type="checkbox" /> Alto
                    </label>
                  </li>
                  <li>
                    <label>
                      <input class="hummingbird-end-node" id="xnode-0-1-2-3-2" data-id="custom-0-1-2-3-2" type="checkbox" /> Toyota
                    </label>
                  </li>
                </ul>
              </li>
            </ul>
          </li>                            
        </ul>
      </li>
      <li data-id="1">
        <i class="fa fa-plus"></i>
        <label>
          <input  id="xnode-0-2" data-id="custom-0-2" type="checkbox" /> node-0-2
        </label>
        <ul>
          <li>
            <label>
              <input class="hummingbird-end-node" id="xnode-0-2-1" data-id="custom-0-2-1" type="checkbox" /> node-0-2-1
            </label>
          </li>
          <li>
            <label>
              <input class="hummingbird-end-node" id="xnode-0-2-2" data-id="custom-0-2-2" type="checkbox" /> node-0-2-2
            </label>
          </li>
        </ul>
      </li>
    </ul>
  </li>
</ul>
</div>
@php
  echo "<pre>";
  print_r($users); 
  echo "</pre>";
@endphp