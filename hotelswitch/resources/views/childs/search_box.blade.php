@section('search_box')
<form id="search" action="search" method="get">
    <div class="search">
        <div class="search_wrapper">
            <div class="search_title">Search</div>
            <div class="search_label">
                <span>Destination</span>
            </div>
            <div class="search_input_destination search_input">
                <input type="text" id="destination" name="destination" value='{{$m->destination ?? "" }}' />
                <input type="hidden" id="destination_id" name="destination_id" />

                <input type="hidden" id="lat" name="lat" value='{{$m->lat ?? "" }}' />
                <input type="hidden" id="lon" name="lon" value='{{$m->lon ?? "" }}' />
            </div>
            <div class="search_label">
                <label for="check-in">Check-in/Check-out</label>
            </div>
            <div class="search_input">
                <input type="text" id="date_range" name="date_range" value='{{$m->date_range ?? "" }}' />
            </div>

            <div id="nights">{{isset($m) ? $m->nights_text . ' stay' : '1 night stay'}}</div>

            <div class="search_select">
                <select type="text" id="adults" name="adults">
                    <option name="adults" value="1" id="1_adult" @isset($m->
                        adults){{ $m->adults == 1 ? 'selected' : ''}}@endisset>
                        1 adult
                    </option>
                    <option name="adults" value="2" id="2_adults" @isset($m->
                        adults){{ $m->adults == 2 ? 'selected' : ''}}@endisset>
                        2 adults
                    </option>
                    <option name="adults" value="3" id="3_adults" @isset($m->
                        adults){{ $m->adults == 3 ? 'selected' : ''}}@endisset>
                        3 adults
                    </option>
                    <option name="adults" value="4" id="4_adults" @isset($m->
                        adults){{ $m->adults == 4 ? 'selected' : ''}}@endisset>
                        4 adults
                    </option>
                </select>
            </div>
            <div class="search_select">
                <select type="text" id="children" name="children">
                    <option value="0" id="no_children" @isset($m->
                        children){{ $m->children == 0 ? 'selected' : ''}}@endisset>
                        No children
                    </option>
                    <option value="1" id="1_child" @isset($m->
                        children){{ $m->children == 1 ? 'selected' : ''}}@endisset>
                        1 child
                    </option>
                    <option value="2" id="2_children" @isset($m->
                        children){{ $m->children == 2 ? 'selected' : ''}}@endisset>
                        2 children
                    </option>
                </select>
                <select type="text" id="rooms" name="rooms">
                    <option value="1" id="1_room" @isset($m->
                        rooms){{ $m->rooms == 1 ? 'selected' : ''}}@endisset>
                        1 room
                    </option>
                    <option value="2" id="2_rooms" @isset($m->
                        rooms){{ $m->rooms == 2 ? 'selected' : ''}}@endisset>
                        2 rooms
                    </option>
                </select>
            </div>
            <div class="search_button">
                <button type="submit">Search</button>
            </div>
        </div>
    </div>
</form>
@endsection
