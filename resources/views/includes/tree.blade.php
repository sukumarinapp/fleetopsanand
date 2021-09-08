<div id="treeview_container" class="hummingbird-treeview" style="height:380px;overflow-x: auto;overflow-y: auto;">
<ul style="padding-left: 0px;" id="treeview" class="hummingbird-base">
  <li data-id="0">
    <i class="fa fa-plus"></i>
    <label>
      <input id="xnode-0" data-id="custom-{{ Auth::user()->id }}" type="checkbox" /> {{ Auth::user()->name }}
    </label>
    @if($type == "admin")
    <ul>
      @foreach($usertree as $key => $manager)
      <li data-id="{{ $key+1 }}">
        <i class="fa fa-plus"></i>
        <label>
          <input  id="xnode-0-1" data-id="custom-0-1" type="checkbox" /> {{ $manager['name'] }} {{ $manager['UZS'] }}
        </label>
        <ul>
          @foreach($manager['submanager'] as $key2 => $submanager)
          <li data-id="{{ $key2+1 }}">
            <i class="fa fa-plus"></i>
            <label>
              <input  id="xnode-0-1-2" data-id="custom-0-1-2" type="checkbox" /> {{ $submanager['name'] }} {{ $submanager['UZS'] }}
            </label>
            <ul>
              @foreach($submanager['client'] as $key3 => $client)
              <li data-id="{{ $key3+1 }}">
                <i class="fa fa-plus"></i>
                <label>
                  <input  id="xnode-0-1-2-3" data-id="custom-0-1-2-3" type="checkbox" /> {{ $client['name'] }} {{ $client['UZS'] }}
                </label>
                <ul>
                  @foreach($client['vehicle'] as $key4 => $vehicle)
                  <li>
                    <label>
                      <input class="hummingbird-end-node" id="xnode-0-1-2-3-1" data-id="custom-0-1-2-3-1" type="checkbox" /> {{ $vehicle['VNO'] }}
                    </label>
                  </li>
                  @endforeach 
                </ul>
              </li>
              @endforeach    
            </ul>
          </li>                            
          @endforeach
        </ul>
      </li>
      @endforeach
    </ul>
    @endif

    @if($type == "manager")
    <ul>
      @foreach($usertree as $key1 => $submanager)
      <li data-id="{{ $key1+1 }}">
        <i class="fa fa-plus"></i>
        <label>
          <input  id="xnode-0-1" data-id="custom-0-1" type="checkbox" /> {{ $submanager['name'] }} {{ $submanager['UZS'] }}
        </label>
        <ul>
          @foreach($submanager['client'] as $key2 => $client)
          <li data-id="{{ $key2+1 }}">
            <i class="fa fa-plus"></i>
            <label>
              <input  id="xnode-0-1-2" data-id="custom-0-1-2" type="checkbox" /> {{ $client['name'] }} {{ $client['UZS'] }}
            </label>
            <ul>
              @foreach($client['vehicle'] as $key3 => $vehicle)
              <li>
                <label>
                  <input class="hummingbird-end-node" id="xnode-0-1-2-3-1" data-id="custom-0-1-2-3-1" type="checkbox" /> {{ $vehicle['VNO'] }}
                </label>
              </li>
              @endforeach 
            </ul>
          </li>                            
          @endforeach
        </ul>
      </li>
      @endforeach
    </ul>
    @endif

    @if($type == "submanager")
      <ul>
      @foreach($usertree as $key1 => $client)
      <li data-id="{{ $key1+1 }}">
        <i class="fa fa-plus"></i>
        <label>
          <input  id="xnode-0-1" data-id="custom-0-1" type="checkbox" /> {{ $client['name'] }} {{ $client['UZS'] }}
        </label>
        <ul>
              @foreach($client['vehicle'] as $key3 => $vehicle)
              <li>
                <label>
                  <input class="hummingbird-end-node" id="xnode-0-1-2-3-1" data-id="custom-0-1-2-3-1" type="checkbox" /> {{ $vehicle['VNO'] }}
                </label>
              </li>
              @endforeach 
            </ul>
      </li>
      @endforeach
    </ul>
    @endif

    @if($type == "client")
      <ul>
      @foreach($usertree as $key1 => $vehicle)
      <li>
        <label>
          <input class="hummingbird-end-node" id="xnode-0-1-2-3-1" data-id="custom-0-1-2-3-1" type="checkbox" /> {{ $vehicle['VNO'] }}
        </label>
      </li>             
      @endforeach
    </ul>
    @endif
  </li>
</ul>
</div>

