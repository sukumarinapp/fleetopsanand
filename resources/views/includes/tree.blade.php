<div id="treeview_container" class="hummingbird-treeview" style="height: 600px;">
<ul style="float: left;padding-left: 0px;" id="treeview" class="hummingbird-base">
  <li data-id="0">
    <i class="fa fa-plus"></i>
    <label>
      <input id="xnode-0" data-id="custom-{{ Auth::user()->id }}" type="checkbox" /> {{ Auth::user()->name }}
    </label>
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
              <input  id="xnode-0-1-2" data-id="custom-0-1-2" type="checkbox" /> {{ $submanager['UZS'] }} {{ $submanager['name'] }}
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
  </li>
</ul>
</div>
<ul>
<!-- 
@foreach($usertree as $key => $manager)
  <li>{{ $key+1 }} {{ $manager['name'] }} {{ $manager['UZS'] }}:{{ $manager['usertype'] }}:{{ $manager['level'] }}</li>
  <ul>
  @foreach($manager['client'] as $client)
    <li>{{ $client['name'] }} {{ $client['UZS'] }}:{{ $client['usertype'] }}:{{ $client['level'] }}</li>
    <ul>
      @foreach($client['vehicle'] as $vehicle)
        <li>{{ $vehicle['VNO'] }}:{{ $vehicle['usertype'] }}:{{ $vehicle['level'] }}</li>
      @endforeach    
    </ul>
  @endforeach
  </ul>
  <ul>
  @foreach($manager['submanager'] as $submanager)
    <li>{{ $submanager['name'] }} {{ $submanager['UZS'] }}:{{ $submanager['usertype'] }}:{{ $submanager['level'] }}</li>
    <ul>
      @foreach($submanager['client'] as $client)
        <li>{{ $client['name'] }} {{ $client['UZS'] }}:{{ $client['usertype'] }}:{{ $client['level'] }}</li>
        <ul>
          @foreach($client['vehicle'] as $vehicle)
            <li>{{ $vehicle['VNO'] }}:{{ $vehicle['usertype'] }}:{{ $vehicle['level'] }}</li>
          @endforeach  
        </ul>
      @endforeach
    </ul>
  @endforeach  
  </ul>
@endforeach
</ul> -->