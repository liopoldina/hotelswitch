@section('search_box')
<form id="search" action="search" method="get">
    @csrf
    <div class="search">
        <div class="search_wrapper">
            <div class="search_title">Search</div>
            <div class="destination_wrapper input_wrapper">
                <label class="icon_label" for="destination"> <i class="fas fa-map-marker-alt fa-lg"
                        aria-hidden="true"></i></label>
                <input type="text" id="destination" name="destination" value='{{$m->destination ?? "" }}'
                    placeholder="where are you travelling to?" class="ui-autocomplete-input bar_box destination_input"
                    autocomplete="off" required="">
                <input type="hidden" id="lat" name="lat" value='{{$m->lat ?? "" }}' />
                <input type="hidden" id="lon" name="lon" value='{{$m->lon ?? "" }}' />
            </div>
            <div class="dates_wrapper input_wrapper">
                <label class="icon_label" for="date_range"><i class="fas fa-calendar-alt fa-lg" aria-hidden="true"></i>
                </label>
                <input type="text" id="date_range" name="date_range" class="bar_box dates_input"
                    value='{{$m->date_range ?? "" }}' required readonly />
                <label class="check_in" for="date_range">Check-in</label>
                <label class="check_out" for="date_range">Check-out</label>
            </div>

            <div id="nights">{{isset($m) ? $m->nights_text . ' stay' : '1 night stay'}}</div>

            <div class=" guests_wrapper bar_box">
                <label class="icon_label"> <i class="fas fa-user-friends fa-lg" aria-hidden="true"></i></label>
                <span class="box_tittle">Guests</span>
                <span class="box_content">1 room, 1 adults </span>
                <input type="hidden" id="adults" name="adults" value="2" required="">
                <input type="hidden" id="children" name="children" value="0" required="">
                <input type="hidden" id="rooms" name="rooms" value="1" required="">
            </div>
            <div class="search_button">
                <button type="submit">Search</button>
            </div>
        </div>
    </div>
</form>
@endsection
