@section('search_box')
    <form id="search" action="search" method="get">
        @csrf
        <div class="search">
            <div class="search_wrapper">
                <div class="search_title">Search</div>
                <div class="destination_wrapper input_wrapper">
                    <label class="icon_label" for="destination"> <i class="fas fa-map-marker-alt fa-lg"
                            aria-hidden="true"></i></label>
                    <input type="text" id="destination" name="destination" value='{{ $m->destination ?? '' }}'
                        placeholder="where are you travelling to?" class="ui-autocomplete-input bar_box destination_input"
                        autocomplete="off" required="">
                    <input type="hidden" id="lat" name="lat" value='{{ $m->lat ?? '' }}' />
                    <input type="hidden" id="lon" name="lon" value='{{ $m->lon ?? '' }}' />
                </div>
                <div class="dates_wrapper input_wrapper">
                    <label class="icon_label" for="date_range"><i class="fas fa-calendar-alt fa-lg" aria-hidden="true"></i>
                    </label>
                    <input type="text" id="date_range" name="date_range" class="bar_box dates_input"
                        value='{{ $m->date_range ?? '' }}' required readonly />
                    <label class="check_in" for="date_range">Check-in</label>
                    <label class="check_out" for="date_range">Check-out</label>
                </div>

                <div id="nights">{{ isset($m) ? $m->nights_text . ' stay' : '1 night stay' }}</div>

                <div class=" guests_wrapper bar_box">
                    <label class="icon_label"> <i class="fas fa-user-friends fa-lg" aria-hidden="true"></i></label>
                    <span class="box_tittle">Guests</span>
                    <span class="box_content">{{$m->rooms_text}}, {{$m->adults_text}}{{$m->children > 0 ? ", " .$m->children_text : ""}} </span>
                    <div class="guests_selection">
                        <div class="item_selection">
                            <i class="fas fa-minus" data-value=-1></i>
                            <div class="item_text">
                                <span class="item_number">{{$m->rooms}}</span>
                                <span class="item_type">{{$m->rooms == 1 ? "room" : "rooms"}}</span>
                            </div>
                            <i class="fas fa-plus" data-value=1></i>
                            <input type="hidden" id="rooms" name="rooms" value={{$m->rooms}} min=1 max=4 data-singular="room" data-plural="rooms" required>
                        </div>
                        <div class="item_selection">
                            <i class="fas fa-minus" data-value=-1></i>
                            <div class="item_text">
                                <span class="item_number">{{$m->adults}}</span>
                                <span class="item_type">{{$m->adults == 1 ? "adult" : "adults"}}</span>
                            </div>
                            <i class="fas fa-plus" data-value=1></i>
                            <input type="hidden" id="adults" name="adults" value={{$m->adults}} min=1 max=8 data-singular="adult" data-plural="adults" required>
                        </div>
                        <div class="item_selection">
                            <i class="fas fa-minus" data-value=-1></i>
                            <div class="item_text">
                                <span class="item_number">{{$m->children}}</span>
                                <span class="item_type">{{$m->children == 1 ? "child" : "children"}}</span>
                            </div>
                            <i class="fas fa-plus" data-value=1></i>
                            <input type="hidden" id="children" name="children" value={{$m->children}} min=0 max=2 data-singular="child" data-plural="children" required>
                        </div>
                    </div>
                </div>
                <div class="search_button">
                    <button type="submit">Search</button>
                </div>
            </div>
        </div>
    </form>
@endsection
