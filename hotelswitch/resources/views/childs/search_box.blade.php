@section('search_box')
<form id="search" action="results.php" method="get">
    <div class="search">
        <div class="search_wrapper">
            <div class="search_title">Search</div>
            <div class="search_label">
                <span>Destination</span>
            </div>
            <div class="search_input_destination search_input">
                <input type="text" id="destination" name="destination" />
                <input type="hidden" id="destination_id" name="destination_id" />
                <input type="hidden" id="lat" name="lat" />
                <input type="hidden" id="lon" name="lon" />
            </div>
            <div class="search_label">
                <label for="check-in">Check-in/Check-out</label>
            </div>
            <div class="search_input">
                <input type="text" id="date_range" name="date_range" />
            </div>

            <div id="nights">1-night stay</div>

            <div class="search_select">
                <select type="text" id="adults" name="adults">
                    <option name="adults" value="1" id="1_adult">
                        1 adult
                    </option>
                    <option name="adults" value="2" id="2_adults">
                        2 adults
                    </option>
                    <option name="adults" value="3" id="3_adults">
                        3 adults
                    </option>
                    <option name="adults" value="4" id="4_adults">
                        4 adults
                    </option>
                </select>
            </div>
            <div class="search_select">
                <select type="text" id="children" name="children">
                    <option value="0" id="no_children">
                        No children
                    </option>
                    <option value="1" id="1_child">
                        1 child
                    </option>
                    <option value="2" id="2_children">
                        2 children
                    </option>
                </select>
                <select type="text" id="rooms" name="rooms">
                    <option value="1" id="1_room">
                        1 room
                    </option>
                    <option value="2" id="2_rooms">
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
